/* ------------------------------------------------------------------------------
 *
 *  # Auth JS code
 *
 *  Place here all your js code.
 *
 *  Author: Igor M. Lucmayon
 * 
 *  Updated: February 8, 2020 @ 8:30 AM
 * ---------------------------------------------------------------------------- */

$(function() {

    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    /* ---------------------------------------------
     * USER LOGIN
     * --------------------------------------------- */
    $('body').on('click', '#btnLogin', function(e){
        e.preventDefault();
        let error = false;
        let email    = $('#email').val();
        let emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        let pass     = $('#password').val();
        let postURL  = $(this).attr('data-url');

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

        if(pass.length == 0)
        {
            error = true;
            $('#passwordError').show();
        }

        if(error == false)
        {
            $('#btnLogin').attr('disabled', 'disabled');
            $('#btnLogin').html('<b><i class="icon-spinner4 spinner"></i></b> Verifying user account...');
            
            let form_data = new FormData();
            form_data.append('email', email);
            form_data.append('password', pass);

            $.ajax({
                url:  postURL + '/verify',
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 200)
                    {
                        $(window.location).attr('href', response.url);
                    }
                    else
                    {
                        $('#loginError').show();
                        $('#loginErrorText').html(response.message);
                        $('#btnLogin').removeAttr('disabled', 'disabled');
                        $('#btnLogin').html('<b><i class="icon-key"></i></b> Login In');
                    }
                }
            });
        }
    });

    $('body').on('change', '#email', function(){
        $('#emailError').hide();
    });

    $('body').on('change', '#password', function(){
        $('#passwordError').hide();
    });

    
});