/* ------------------------------------------------------------------------------
 *
 *  # Employee JS code
 *
 *  Place here all your js code.
 *
 *  Author: Igor M. Lucmayon
 * 
 *  Updated: February 18, 2020 @ 6:30 PM
 * ---------------------------------------------------------------------------- */

$(function() {

    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        scrollX: true,
        columnDefs: [{ 
            orderable: false,
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
     * FETCH EMPLOYEE TABLE DATA
     * --------------------------------------------- */
    //fetchEmployeeData();
	
	$('.employee_data_table').DataTable({
        bSort: false,
        scrollX: true
    });

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');


    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });

    function fetchEmployeeData()
    {
        $.ajax({
            url: webURL + '/employee/show',
            type: 'GET',
            success: function (response) {
                $('#employee_data').html(response);
                $('.employee_data_table').DataTable({
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
     * ADD STUDENT FORM
     * --------------------------------------------- */
    $('#modal_new_employee').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * SAVE EMPLOYEE
     * --------------------------------------------- */
    $('body').on('click', '#btnSave', function(e){
        e.preventDefault();
        let error = false;
        let empNum     = $('#empNum').val();
        let lastName   = $('#lastName').val();
        let firstName  = $('#firstName').val();
        let midName    = $('#midName').val();
        let birthDate  = $('#birthDate').val();
        let gender     = $('#gender').val();
        let contactNum = $('#contactNum').val();
        let mobileRegex = /^\d{11}$/;
        let empType    = $('#empType').val();
        let company    = $('#company').val();
        let address    = $('#homeAddress').val();
        let postURL    = $('#postURL').val();

        if(empNum.length == 0)
        {
            error = true;
            $('#empNumError').show();
        }

        if(lastName.length == 0)
        {
            error = true;
            $('#lastNameError').show();
        }

        if(firstName.length == 0)
        {
            error = true;
            $('#firstNameError').show();
        }

        if(midName.length == 0)
        {
            error = true;
            $('#midNameError').show();
        }

        if(birthDate.length == 0)
        {
            error = true;
            $('#birthDateError').show();
        }
        else 
        {
            let validate = isValidDate(birthDate);

            if(validate == false)
            {
                error = true;
                $('#birthDateError').text('* Invalid birthday: MM-DD-YYYY');
                $('#birthDateError').show();
            }
        }

        if(gender.length == 0)
        {
            error = true;
            $('#genderError').show();
        }

        if(contactNum.length == 0)
        {
            error = true;
            $('#contactNumError').show();
        }
        else 
        {
            if(!contactNum.match(mobileRegex))
            {
                error = true;
                $('#contactNumError').text('* Invalid cellphone number.');
                $('#contactNumError').show();
            }
			else 
            {
                let checkPhone = contactNum.substring(0, 2);
                if(checkPhone != '09')
                {
                    error = true;
                    $('#contactNumError').text('* Invalid cellphone number.');
                    $('#contactNumError').show();
                }
            }
        }

        if(empType.length == 0)
        {
            error = true;
            $('#empTypeError').show();
        }
        
        if(company.length == 0)
        {
            error = true;
            $('#companyError').show();
        }

        if(address.length == 0)
        {
            error = true;
            $('#homeAddressError').show();
        }

        if(error == false)
        {
            $('#btnSave').attr('disabled', 'disabled');
            $('#cancelSave').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('empNo', empNum);
            form_data.append('lastName', lastName);
            form_data.append('firstName', firstName);
            form_data.append('midName', midName);
            form_data.append('birthDate', birthDate);
            form_data.append('gender', gender);
            form_data.append('mobileNo', contactNum);
            form_data.append('type', empType);
            form_data.append('company', company);
            form_data.append('address', address);

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
                                $('#modal_new_employee').modal('hide');
                                $('#btnSave').removeAttr('disabled');
                                $('#cancelSave').removeAttr('disabled');
                                $('#empNum').val('');
                                $('#lastName').val('');
                                $('#firstName').val('');
                                $('#midName').val('');
                                $('#birthDate').val('');
                                $('#contactNum').val('');
                                $('#company').val('').change();
                                $('#address').val('');
								$(window.location).attr('href', '/employee');
                                //fetchEmployeeData();
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
                                $('#btnSave').removeAttr('disabled');
                                $('#cancelSave').removeAttr('disabled');
                            }
                        });
                    }
                }
            }); 
        }
    });

    /* ---------------------------------------------
     * EDIT EMPLOYEE FORM
     * --------------------------------------------- */
    $('#modal_edit_employee').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url') + $(e.relatedTarget).data('id');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * UPDATE EMPLOYEE
     * --------------------------------------------- */
    $('body').on('click', '#btnUpdate', function(e){
        e.preventDefault();
        let error = false;
        let empNum     = $('#empNum').val();
        let lastName   = $('#lastName').val();
        let firstName  = $('#firstName').val();
        let midName    = $('#midName').val();
        let birthDate  = $('#birthDate').val();
        let gender     = $('#gender').val();
        let contactNum = $('#contactNum').val();
        let mobileRegex = /^\d{11}$/;
        let empType    = $('#empType').val();
        let company    = $('#company').val();
        let address    = $('#homeAddress').val();
        let profileID  = $('#profileID').val();
        let postURL    = $('#postURL').val();

        if(empNum.length == 0)
        {
            error = true;
            $('#empNumError').show();
        }

        if(lastName.length == 0)
        {
            error = true;
            $('#lastNameError').show();
        }

        if(firstName.length == 0)
        {
            error = true;
            $('#firstNameError').show();
        }

        if(midName.length == 0)
        {
            error = true;
            $('#midNameError').show();
        }

        if(birthDate.length == 0)
        {
            error = true;
            $('#birthDateError').show();
        }
        else 
        {
            let validate = isValidDate(birthDate);

            if(validate == false)
            {
                error = true;
                $('#birthDateError').text('* Invalid birthday: MM-DD-YYYY');
                $('#birthDateError').show();
            }
        }

        if(gender.length == 0)
        {
            error = true;
            $('#genderError').show();
        }

        if(contactNum.length == 0)
        {
            error = true;
            $('#contactNumError').show();
        }
        else 
        {
            if(!contactNum.match(mobileRegex))
            {
                error = true;
                $('#contactNumError').text('* Invalid cellphone number.');
                $('#contactNumError').show();
            }
            else 
            {
                let checkPhone = contactNum.substring(0, 2);
                if(checkPhone != '09')
                {
                    error = true;
                    $('#contactNumError').text('* Invalid cellphone number.');
                    $('#contactNumError').show();
                }
            }
        }
        
        if(empType.length == 0)
        {
            error = true;
            $('#empTypeError').show();
        }

        if(company.length == 0)
        {
            error = true;
            $('#companyError').show();
        }

        if(address.length == 0)
        {
            error = true;
            $('#homeAddressError').show();
        }

        if(error == false)
        {
            $('#btnUpdate').attr('disabled', 'disabled');
            $('#cancelUpdate').attr('disabled', 'disabled');
            var form_data = new FormData();
            form_data.append('empNo', empNum);
            form_data.append('lastName', lastName);
            form_data.append('firstName', firstName);
            form_data.append('midName', midName);
            form_data.append('birthDate', birthDate);
            form_data.append('gender', gender);
            form_data.append('mobileNo', contactNum);
            form_data.append('type', empType);
            form_data.append('company', company);
            form_data.append('address', address);
            form_data.append('profileID', profileID);

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
                                $('#modal_edit_employee').modal('hide');
                                $('#btnUpdate').removeAttr('disabled');
                                $('#cancelUpdate').removeAttr('disabled');
                                $('#empNum').val('');
                                $('#lastName').val('');
                                $('#firstName').val('');
                                $('#midName').val('');
                                $('#birthDate').val('');
                                $('#contactNum').val('');
                                $('#company').val('').change();
                                $('#address').val('');
                                //fetchEmployeeData();
								$(window.location).attr('href', '/employee');
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
                                $('#btnUpdate').removeAttr('disabled');
                                $('#cancelUpdate').removeAttr('disabled');
                            }
                        });
                    }
                }
            }); 
        }
    });

    $('body').on('keyup', '#empNum', function(){
        $('#empNumError').hide();
    });

    $('body').on('keyup', '#lastName', function(){
        $('#lastNameError').hide();
    });

    $('body').on('keyup', '#firstName', function(){
        $('#firstNameError').hide();
    });

    $('body').on('keyup', '#midName', function(){
        $('#midNameError').hide();
    });

    $('body').on('keyup', '#birthDate', function(){
        $('#birthDateError').hide();
    });

    $('body').on('keyup', '#contactNum', function(){
        $('#contactNumError').hide();
    });

    $('body').on('change', '#company', function(){
        $('#companyError').hide();
    });

    $('body').on('keyup', '#homeAddress', function(){
        $('#homeAddressError').hide();
    });

    /* ---------------------------------------------
     * IMPORT DATA FORM
     * --------------------------------------------- */
    $('#modal_import').on('show.bs.modal', function(e) {
        var remoteLink = $(e.relatedTarget).data('url');
        $(this).find('.modal-body').load(remoteLink, function() {
            // File input
		    $(".file-styled").uniform({
                fileButtonClass: 'action btn bg-brown-800'
            });
        });
    });

    /* ---------------------------------------------
     * IMPORT DATA
     * --------------------------------------------- */
    $('body').on('click', '#btnImport', function(e){
        e.preventDefault();
        let error = false;
        let docFile = $('#docFile')[0].files;
        let allowedExtension = ['xlsx'];
        let postURL = $('#postURL').val();

        if(docFile.length == 0)
        {
            error = true;
            $('#fileError').show();
        }
        else
        {
            let ext  = docFile[0].name.split('.').pop().toLowerCase();
            if($.inArray(ext, allowedExtension) === -1)
            {
                error = true;
                $('#fileError').text('* Selected file is not allowed.');
                $('#fileError').show();
            }
        }

        if(error == false)
        { 
            $('#btnImport').attr('disabled', 'disabled');
			$('#btnImport').html('<b><i class="icon-spinner4 spinner"></i></b> Processing request...');
            $('#cancelImport').attr('disabled', 'disabled');
            var form_data = new FormData();
            form_data.append('files', docFile[0]);

            $.ajax({
                url: postURL,
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    swal({
                        title: "Success!",
                        text: response.message,
                        type: "success",
                        confirmButtonColor: "#283593"
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $('#modal_import').modal('hide');
                            $('#btnImport').removeAttr('disabled');
							$('#btnImport').html('<b><i class="icon-database-upload"></i></b> Import');
                            $('#cancelImport').removeAttr('disabled');
                            $('#docFile').val('').change();
                            //fetchEmployeeData();
							$(window.location).attr('href', '/employee');
                        }
                    });
                }
            });
        }
    });

    /* ---------------------------------------------
     * ACTIVATE/DEACTIVATE EMPLOYEE STATUS
     * --------------------------------------------- */
    $('body').on('click', '#btnStatus', function(){
        let profileID = $(this).attr('data-id');
        let status    = $(this).attr('data-status');
        let postURL   = $(this).attr('data-url');
        let form_data = new FormData();
        form_data.append('id', profileID);
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
                            $(window.location).attr('href', '/employee');
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
     * EXPORT DATA
     * --------------------------------------------- */
    $("#btnExport").click(function(){
        $('#btnExport').attr('disabled', 'disabled');
        $('#btnImportForm').attr('disabled', 'disabled');
        $('#btnAddNew').attr('disabled', 'disabled');
        $('#btnExport').html('<b><i class="icon-spinner4 spinner"></i></b> Extracting data...');
        $(window.location).attr('href', '/employee/export');

        setTimeout(function() {
            $('#btnExport').removeAttr('disabled', 'disabled');
            $('#btnImportForm').removeAttr('disabled', 'disabled');
            $('#btnAddNew').removeAttr('disabled', 'disabled');
            $('#btnExport').html('<b><i class="icon-download7"></i></b> Extract');
        }, 5000);
    });

    /* ---------------------------------------------
     * REMOVE DATA
     * --------------------------------------------- */
    /*
    $("#btnRemove").click(function(){
        let postURL = $(this).attr('data-url');
        let empIDs  = employeeToRemove();
        let form_data = new FormData();
        form_data.append('ids', empIDs);

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
                            $(window.location).attr('href', '/employee');
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


    $('body').on('change', '#empID', function(){
        let count = btnRemoveActivation();
        
        if(count > 0)
        {
            $('#btnRemove').removeAttr('disabled', 'disabled');
        }
        else 
        {
            $('#btnRemove').attr('disabled', 'disabled');
        }
    });

    function employeeToRemove()
    {
        let empIDs = [];
        let oTable = $('.employee_data_table').DataTable();
        let chckBox = oTable.$('#empID:checked', {'page': 'all'});
        chckBox.each(function(i, elem){
            empIDs.push(parseInt($(elem).val()));
        });

        return empIDs;
    }

    function btnRemoveActivation()
    {
        let count = 0;
        if ($("input[name='empID']").is(':checked'))
        {
            count += 1;
        }; 

        return count;
    }
*/
    function isValidDate(dateString)
    {
        let regEx = /^(0[1-9]|1[0-2])\-(0[1-9]|1\d|2\d|3[01])\-(19|20)\d{2}$/

        return dateString.match(regEx) != null;
    }

});