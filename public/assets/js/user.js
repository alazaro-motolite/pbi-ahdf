/* ------------------------------------------------------------------------------
 *
 *  # User JS code
 *
 *  Place here all your js code.
 *
 *  Author: Igor M. Lucmayon
 * 
 *  Updated: February 9, 2020 @ 10:00 AM
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
     * FETCH USER TABLE DATA
     * --------------------------------------------- */
    fetchUserData();

    function fetchUserData()
    {
        $.ajax({
            url: webURL + '/user/show',
            type: 'GET',
            success: function (response) {
                $('#user_data').html(response);
                $('.user_data_table').DataTable({
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
     * ADD USER FORM
     * --------------------------------------------- */
    $('#modal_new_user').on('show.bs.modal', function(e) {
        let remoteLink = $(e.relatedTarget).data('url');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * SAVE USER
     * --------------------------------------------- */
    $('body').on('click', '#btnSaveUser', function(e){
        e.preventDefault();
        let error = false;
        let userGroup   = $('#userGroup').val();
        let userName    = $('#userName').val();
        let email       = $('#email').val();
        let emailReg    = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        let password    = $('#password').val();
        let confirmPass = $('#confirmPass').val();
        let postURL     = $('#postURL').val();

        if(userGroup.length == 0)
        {
            error = true;
            $('#userGroupError').show();
        }

        if(userName.length == 0)
        {
            error = true;
            $('#userNameError').show();
        }

        if(email.length == 0)
        {
            error = true;
            $('#emailError').show();
        }
        else 
        {
            if(!emailReg.test(email))
            {
                error = true;
                $('#emailError').text('* Invalid email address.');
                $('#emailError').show();
            }
        }

        if(password.length == 0)
        {
            error = true;
            $('#passwordError').show();
        } 
        else
        {
            if(confirmPass != password)
            {
                error = true;
                $('#confirmPassError').show();
            }
        }

        if(error == false)
        {
            $('#btnSaveUser').attr('disabled', 'disabled');
            $('#cancelSaveUser').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('userGroup', userGroup);
            form_data.append('name', userName);
            form_data.append('email', email);
            form_data.append('password', password);

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
                                $('#modal_new_user').modal('hide');
                                $('#btnSaveUser').removeAttr('disabled');
                                $('#cancelSaveUser').removeAttr('disabled');
                                $('#userGroup').val('').change();
                                $('#userName').val('');
                                $('#email').val('');
                                $('#password').val('');
                                $('#confirmPass').val('');
                                fetchUserData();
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
                                $('#btnSaveUser').removeAttr('disabled');
                                $('#cancelSaveUser').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    /* ---------------------------------------------
     * EDIT USER FORM
     * --------------------------------------------- */
    $('#modal_edit_user').on('show.bs.modal', function(e) {
        let remoteLink = $(e.relatedTarget).data('url') + $(e.relatedTarget).data('id');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * UPDATE USER
     * --------------------------------------------- */
    $('body').on('click', '#btnUpdateUser', function(e){
        e.preventDefault();
        let error = false;
        let userGroup   = $('#userGroup').val();
        let userName    = $('#userName').val();
        let email       = $('#email').val();
        let emailReg    = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        let userID      = $('#userID').val();
        let postURL     = $('#postURL').val();

        if(userGroup.length == 0)
        {
            error = true;
            $('#userGroupError').show();
        }

        if(userName.length == 0)
        {
            error = true;
            $('#userNameError').show();
        }

        if(email.length == 0)
        {
            error = true;
            $('#emailError').show();
        }
        else 
        {
            if(!emailReg.test(email))
            {
                error = true;
                $('#emailError').text('* Invalid email address.');
                $('#emailError').show();
            }
        }

        if(error == false)
        {
            $('#btnUpdateUser').attr('disabled', 'disabled');
            $('#cancelUpdateUser').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('userGroup', userGroup);
            form_data.append('name', userName);
            form_data.append('email', email);
            form_data.append('userID', userID);

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
                                $('#modal_edit_user').modal('hide');
                                $('#btnUpdateUser').removeAttr('disabled');
                                $('#cancelUpdateUser').removeAttr('disabled');
                                $('#userGroup').val('').change();
                                $('#userName').val('');
                                $('#email').val('');
                                fetchUserData();
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
                                $('#btnUpdateUser').removeAttr('disabled');
                                $('#cancelUpdateUser').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        }
    });

    $('body').on('change', '#userGroup', function(){
        $('#userGroupError').hide();
    });

    $('body').on('keyup', '#userName', function(){
        $('#userNameError').hide();
    });

    $('body').on('keyup', '#email', function(){
        $('#emailError').hide();
    });

    $('body').on('keyup', '#password', function(){
        $('#passwordError').hide();
    });

    $('body').on('keyup', '#confirmPass', function(){
        $('#confirmPassError').hide();
    });

    /* ---------------------------------------------
     * CHANGE USER PASSWORD FORM
     * --------------------------------------------- */
    $('#modal_current_user_change_password').on('show.bs.modal', function(e) {
        let remoteLink = $(e.relatedTarget).data('url');
        $(this).find('.modal-body').load(remoteLink, function() {});
    });

    /* ---------------------------------------------
     * RESET USER PASSWORD
     * --------------------------------------------- */
    $('body').on('click', '#btnResetPassword', function() {
        let usrID   = $(this).attr('data-id');
        let postURL = $(this).attr('data-url');
        let form_data = new FormData();
        form_data.append('userID', usrID);
        

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
                            fetchUserData();
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
     * ACTIVATE/DEACTIVATE USER STATUS
     * --------------------------------------------- */
    $('body').on('click', '#btnStatus', function(){
        let usrID   = $(this).attr('data-id');
        let status  = $(this).attr('data-status');
        let postURL = $(this).attr('data-url');
        let form_data = new FormData();
        form_data.append('userID', usrID);
        form_data.append('userStatus', status);

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
                            fetchUserData();
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
     * UPDATE USER PASSWORD
     * --------------------------------------------- */
    $('body').on('click', '#btnUserChangePassword', function(e){
        e.preventDefault();
        let error = false;
        let oldPass = $('#oldPassword').val();
        let newPass = $('#newPassword').val();
        let rePass  = $('#confirmPass').val();
        let userID  = $('#userID').val();
        let postURL = $('#postURL').val();

        if(oldPass.length == 0)
        {
            error = true;
            $('#oldPasswordError').show();
        }

        if(newPass.length == 0)
        {
            error = true;
            $('#newPasswordError').show();
        }
        else 
        {
            if(rePass != newPass)
            {
                error = true;
                $('#confirmPassError').show();
            }
        }

        if(error == false)
        {
            $('#btnUserChangePassword').attr('disabled', 'disabled');
            $('#cancelUserChangePassword').attr('disabled', 'disabled');
            let form_data = new FormData();
            form_data.append('oldPass', oldPass);
            form_data.append('newPass', newPass);
            form_data.append('userID', userID);

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
                                $(window.location).attr('href', '/logout');
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
                                $('#btnUserChangePassword').removeAttr('disabled');
                                $('#cancelUserChangePassword').removeAttr('disabled');
                            }
                        });
                    }
                }
            }); 
            
        }
    });

    $('body').on('keyup', '#oldPassword', function(){
        $('#oldPasswordError').hide();
    });

    $('body').on('keyup', '#newPassword', function(){
        $('#newPasswordError').hide();
    });

    $('body').on('keyup', '#confirmPass', function(){
        $('#confirmPassError').hide();
    });

});