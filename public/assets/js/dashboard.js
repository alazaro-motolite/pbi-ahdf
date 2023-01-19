/* ------------------------------------------------------------------------------
 *
 *  # Dashboard JS code
 *
 *  Place here all your js code.
 *
 *  Author: Igor M. Lucmayon
 * 
 *  Updated: February 19, 2020 @ 11:30 AM
 * ---------------------------------------------------------------------------- */

$(function() {

    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{ 
            orderable: true
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

    $('#startDate, #endDate').daterangepicker({ 
        singleDatePicker: true
    });

    /* ---------------------------------------------
     * FETCH DASHBOARD TABLE DATA
     * --------------------------------------------- */
    fetchDashboardData();

    function fetchDashboardData()
    {
        $.ajax({
            url: webURL + '/dashboard/show',
            type: 'GET',
            success: function (response) {
                $('#dashboard_data').html(response);
                $('.dashboard_data_table').DataTable({
                    bSort: false
                });

                // Add placeholder to the datatable filter option
                $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');


                // Enable Select2 select for the length option
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: Infinity,
                    width: 'auto'
                });
            }
        });
    }

    /* ---------------------------------------------
     * VIEW ANSWER
     * --------------------------------------------- */
    $('#modal_view_answer').on('show.bs.modal', function(e) {
        let remoteLink = $(e.relatedTarget).data('url') + $(e.relatedTarget).data('refno');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });
	
	/* ---------------------------------------------
     * EXPORT DATA
     * --------------------------------------------- */
    $("#formExport").submit(function(){
        $('#btnExport').attr('disabled', 'disabled');
        $('#btnExport').html('<b><i class="icon-spinner4 spinner"></i></b> Exporting data...');

        setTimeout(function() {
            $('#btnExport').removeAttr('disabled', 'disabled');
            $('#btnExport').html('<b><i class="icon-download7"></i></b> Extract Report');
        }, 15000);
    });
});