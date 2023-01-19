/* ------------------------------------------------------------------------------
 *
 *  # Cms JS code
 *
 *  Place here all your js code.
 *
 *  Author: Igor M. Lucmayon
 * 
 *  Updated: February 18, 2020 @ 9:30 PM
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
            orderable: false
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

    /* ---------------------------------------------
     * FETCH CHECKLIST, POINT OF ENTRY, EMPLOYEE TYPE AND COMPANY TABLE DATA
     * --------------------------------------------- */
    fetchChecklistData();
    fetchCompanyData();
    fetchEntryPointData();
    fetchEmployeeTypeData();

    function fetchChecklistData()
    {
        $.ajax({
            url: webURL + '/cms/checklist/show',
            type: 'GET',
            success: function (response) {
                $('#checklist_data').html(response);
                $('.checklist_data_table').DataTable({
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

    function fetchCompanyData()
    {
        $.ajax({
            url: webURL + '/cms/company/show',
            type: 'GET',
            success: function (response) {
                $('#company_data').html(response);
                $('.company_data_table').DataTable({
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

    function fetchEntryPointData()
    {
        $.ajax({
            url: webURL + '/cms/entry/show',
            type: 'GET',
            success: function (response) {
                $('#entry_data').html(response);
                $('.entry_data_table').DataTable({
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

    function fetchEmployeeTypeData()
    {
        $.ajax({
            url: webURL + '/cms/employee-type/show',
            type: 'GET',
            success: function (response) {
                $('#emp_type_data').html(response);
                $('.emp_type_data_table').DataTable({
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
     * ADD CHECKLIST FORM
     * --------------------------------------------- */
    $('#modal_add_checklist').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * SAVE CHECKLIST
     * --------------------------------------------- */
    $('body').on('click', '#btnSaveChecklist', function(e){
        e.preventDefault();
        let error = false;
        let checkList   = $('#checklist').val();
        let postURL     = $('#postURL').val();

        if(checkList.length == 0)
        {
            error = true;
            $('#checklistError').show();
        }

        if(error == false)
        {
            $('#btnSaveChecklist').attr('disabled', 'disabled');
            $('#cancelSaveChecklist').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('checklist', checkList);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            confirmButtonColor: "#283593"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#modal_add_checklist').modal('hide');
                                $('#btnSaveChecklist').removeAttr('disabled');
                                $('#cancelSaveChecklist').removeAttr('disabled');
                                $('#checklist').val('');
                                fetchChecklistData();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                            confirmButtonColor: "#C62828",
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#btnSaveChecklist').removeAttr('disabled');
                                $('#cancelSaveChecklist').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    /* ---------------------------------------------
     * EDIT CHECKLIST FORM
     * --------------------------------------------- */
    $('#modal_edit_checklist').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url') + $(e.relatedTarget).data('id');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * UPDATE CHECKLIST
     * --------------------------------------------- */
    $('body').on('click', '#btnEditChecklist', function(e){
        e.preventDefault();
        let error = false;
        let checkList   = $('#checklist').val();
        let checklistID = $('#checklistID').val();
        let postURL     = $('#postURL').val();

        if(checkList.length == 0)
        {
            error = true;
            $('#checklistError').show();
        }

        if(error == false)
        {
            $('#btnEditChecklist').attr('disabled', 'disabled');
            $('#cancelEditChecklist').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('checklist', checkList);
            form_data.append('checklistID', checklistID);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            confirmButtonColor: "#283593"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#modal_edit_checklist').modal('hide');
                                $('#btnEditChecklist').removeAttr('disabled');
                                $('#cancelEditChecklist').removeAttr('disabled');
                                $('#checklist').val('');
                                fetchChecklistData();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                            confirmButtonColor: "#C62828",
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#btnEditChecklist').removeAttr('disabled');
                                $('#cancelEditChecklist').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    $('body').on('keyup', '#checklist', function(){
        $('#checklistError').hide();
    });

    /* ---------------------------------------------
     * ACTIVATE/DEACTIVATE CHECKLIST STATUS
     * --------------------------------------------- */
    $('body').on('click', '#btnChecklistStatus', function(){
        let c_ID   = $(this).attr('data-id');
        let status  = $(this).attr('data-status');
        let postURL = $(this).attr('data-url');
        let form_data = new FormData();
        form_data.append('checklistID', c_ID);
        form_data.append('status', status);

        $.ajax({
            url: postURL,
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                if(response.status == 200)
                {
                    swal({
                        title: "Success!",
                        text: response.message,
                        type: "success",
                        confirmButtonColor: "#283593"
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            fetchChecklistData();
                        }
                    });
                }
                else
                {
                    swal({
                        title: "Error!",
                        text: response.message,
                        type: "error",
                        confirmButtonColor: "#C62828",
                    });
                }
            }
        });
    });

    /* ---------------------------------------------
     * ADD COMPANY FORM
     * --------------------------------------------- */
    $('#modal_add_company').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * SAVE COMPANY
     * --------------------------------------------- */
    $('body').on('click', '#btnSaveCompany', function(e){
        e.preventDefault();
        let error = false;
        let company = $('#company').val();
        let postURL = $('#postURL').val();

        if(company.length == 0)
        {
            error = true;
            $('#companyError').show();
        }

        if(error == false)
        {
            $('#btnSaveCompany').attr('disabled', 'disabled');
            $('#cancelSaveCompany').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('company', company);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            confirmButtonColor: "#283593"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#modal_add_company').modal('hide');
                                $('#btnSaveCompany').removeAttr('disabled');
                                $('#cancelSaveCompany').removeAttr('disabled');
                                $('#company').val('');
                                fetchCompanyData();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                            confirmButtonColor: "#C62828",
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#btnSaveCompany').removeAttr('disabled');
                                $('#cancelSaveCompany').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    /* ---------------------------------------------
     * EDIT COMPANY FORM
     * --------------------------------------------- */
    $('#modal_edit_company').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url') + $(e.relatedTarget).data('id');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * UPDATE COMPANY
     * --------------------------------------------- */
    $('body').on('click', '#btnEditCompany', function(e){
        e.preventDefault();
        let error = false;
        let company   = $('#company').val();
        let companyID = $('#companyID').val();
        let postURL   = $('#postURL').val();

        if(company.length == 0)
        {
            error = true;
            $('#companyError').show();
        }

        if(error == false)
        {
            $('#btnEditCompany').attr('disabled', 'disabled');
            $('#cancelEditCompany').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('company', company);
            form_data.append('companyID', companyID);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            confirmButtonColor: "#283593"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#modal_edit_company').modal('hide');
                                $('#btnEditCompany').removeAttr('disabled');
                                $('#cancelEditCompany').removeAttr('disabled');
                                $('#company').val('');
                                fetchCompanyData();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                            confirmButtonColor: "#C62828",
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#btnEditCompany').removeAttr('disabled');
                                $('#cancelEditCompany').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    $('body').on('keyup', '#company', function(){
        $('#companyError').hide();
    });

    /* ---------------------------------------------
     * ACTIVATE/DEACTIVATE COMPANY STATUS
     * --------------------------------------------- */
    $('body').on('click', '#btnCompanyStatus', function(){
        let c_ID    = $(this).attr('data-id');
        let status  = $(this).attr('data-status');
        let postURL = $(this).attr('data-url');
        let form_data = new FormData();
        form_data.append('companyID', c_ID);
        form_data.append('status', status);

        $.ajax({
            url: postURL,
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                if(response.status == 200)
                {
                    swal({
                        title: "Success!",
                        text: response.message,
                        type: "success",
                        confirmButtonColor: "#283593"
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            fetchCompanyData();
                        }
                    });
                }
                else
                {
                    swal({
                        title: "Error!",
                        text: response.message,
                        type: "error",
                        confirmButtonColor: "#C62828",
                    });
                }
            }
        });
    });

    /* ---------------------------------------------
     * ADD POINT OF ENTRY FORM
     * --------------------------------------------- */
    $('#modal_add_entry').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * SAVE POINT OF ENTRY
     * --------------------------------------------- */
    $('body').on('click', '#btnSaveEntryPoint', function(e){
        e.preventDefault();
        let error = false;
        let entryPoint = $('#entryPoint').val();
        let postURL = $('#postURL').val();

        if(entryPoint.length == 0)
        {
            error = true;
            $('#entryPointError').show();
        }

        if(error == false)
        {
            $('#btnSaveEntryPoint').attr('disabled', 'disabled');
            $('#cancelSaveEntryPoint').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('entryPoint', entryPoint);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            confirmButtonColor: "#283593"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#modal_add_entry').modal('hide');
                                $('#btnSaveEntryPoint').removeAttr('disabled');
                                $('#cancelSaveEntryPoint').removeAttr('disabled');
                                $('#entryPoint').val('');
                                fetchEntryPointData();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                            confirmButtonColor: "#C62828",
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#btnSaveEntryPoint').removeAttr('disabled');
                                $('#cancelSaveEntryPoint').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    /* ---------------------------------------------
     * EDIT POINT OF ENTRY FORM
     * --------------------------------------------- */
    $('#modal_edit_entry').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url') + $(e.relatedTarget).data('id');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * UPDATE POINT OF ENTRY
     * --------------------------------------------- */
    $('body').on('click', '#btnEditEntryPoint', function(e){
        e.preventDefault();
        let error = false;
        let entryPoint = $('#entryPoint').val();
        let entryID    = $('#entryID').val();
        let postURL    = $('#postURL').val();

        if(entryPoint.length == 0)
        {
            error = true;
            $('#entryPointError').show();
        }

        if(error == false)
        {
            $('#btnEditEntryPoint').attr('disabled', 'disabled');
            $('#cancelEditEntryPoint').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('entryPoint', entryPoint);
            form_data.append('entryID', entryID);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            confirmButtonColor: "#283593"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#modal_edit_entry').modal('hide');
                                $('#btnEditEntryPoint').removeAttr('disabled');
                                $('#cancelEditEntryPoint').removeAttr('disabled');
                                $('#entryPoint').val('');
                                fetchEntryPointData();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                            confirmButtonColor: "#C62828",
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#btnEditEntryPoint').removeAttr('disabled');
                                $('#cancelEditEntryPoint').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    $('body').on('keyup', '#entryPoint', function(){
        $('#entryPointError').hide();
    });

    /* ---------------------------------------------
     * ACTIVATE/DEACTIVATE POINT OF ENTRY STATUS
     * --------------------------------------------- */
    $('body').on('click', '#btnEntryStatus', function(){
        let entryID = $(this).attr('data-id');
        let status  = $(this).attr('data-status');
        let postURL = $(this).attr('data-url');
        let form_data = new FormData();
        form_data.append('entryID', entryID);
        form_data.append('status', status);

        $.ajax({
            url: postURL,
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                if(response.status == 200)
                {
                    swal({
                        title: "Success!",
                        text: response.message,
                        type: "success",
                        confirmButtonColor: "#283593"
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            fetchEntryPointData();
                        }
                    });
                }
                else
                {
                    swal({
                        title: "Error!",
                        text: response.message,
                        type: "error",
                        confirmButtonColor: "#C62828",
                    });
                }
            }
        });
    });

    /* ---------------------------------------------
     * ADD EMPLOYEE TYPE FORM
     * --------------------------------------------- */
    $('#modal_add_emp_type').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * SAVE EMPLOYEE TYPE
     * --------------------------------------------- */
    $('body').on('click', '#btnSaveEmployeeType', function(e){
        e.preventDefault();
        let error = false;
        let empType = $('#empType').val();
        let postURL = $('#postURL').val();

        if(empType.length == 0)
        {
            error = true;
            $('#empTypeError').show();
        }

        if(error == false)
        {
            $('#btnSaveEmployeeType').attr('disabled', 'disabled');
            $('#cancelSaveEmployeeType').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('type', empType);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            confirmButtonColor: "#283593"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#modal_add_emp_type').modal('hide');
                                $('#btnSaveEmployeeType').removeAttr('disabled');
                                $('#cancelSaveEmployeeType').removeAttr('disabled');
                                $('#empType').val('');
                                fetchEmployeeTypeData();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                            confirmButtonColor: "#C62828",
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#btnSaveEmployeeType').removeAttr('disabled');
                                $('#cancelSaveEmployeeType').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    /* ---------------------------------------------
     * EDIT EMPLOYEE TYPE FORM
     * --------------------------------------------- */
    $('#modal_edit_emp_type').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url') + $(e.relatedTarget).data('id');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * UPDATE EMPLOYEE TYPE
     * --------------------------------------------- */
    $('body').on('click', '#btnEditEmployeeType', function(e){
        e.preventDefault();
        let error = false;
        let empType = $('#empType').val();
        let eID     = $('#eID').val();
        let postURL = $('#postURL').val();

        if(empType.length == 0)
        {
            error = true;
            $('#empTypeError').show();
        }

        if(error == false)
        {
            $('#btnEditEmployeeType').attr('disabled', 'disabled');
            $('#cancelEditEmployeeType').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('type', empType);
            form_data.append('id', eID);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            confirmButtonColor: "#283593"
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#modal_edit_emp_type').modal('hide');
                                $('#btnEditEmployeeType').removeAttr('disabled');
                                $('#cancelEditEmployeeType').removeAttr('disabled');
                                $('#empType').val('');
                                fetchEmployeeTypeData();
                            }
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                            confirmButtonColor: "#C62828",
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $('#btnEditEmployeeType').removeAttr('disabled');
                                $('#cancelEditEmployeeType').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    $('body').on('keyup', '#empType', function(){
        $('#empTypeError').hide();
    });

    /* ---------------------------------------------
     * ACTIVATE/DEACTIVATE POINT OF ENTRY STATUS
     * --------------------------------------------- */
    $('body').on('click', '#btnEmpTypeStatus', function(){
        let eID     = $(this).attr('data-id');
        let status  = $(this).attr('data-status');
        let postURL = $(this).attr('data-url');
        let form_data = new FormData();
        form_data.append('id', eID);
        form_data.append('status', status);

        $.ajax({
            url: postURL,
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                if(response.status == 200)
                {
                    swal({
                        title: "Success!",
                        text: response.message,
                        type: "success",
                        confirmButtonColor: "#283593"
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            fetchEmployeeTypeData();
                        }
                    });
                }
                else
                {
                    swal({
                        title: "Error!",
                        text: response.message,
                        type: "error",
                        confirmButtonColor: "#C62828",
                    });
                }
            }
        });
    });
});