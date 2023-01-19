/* ------------------------------------------------------------------------------
 *
 *  # Auth JS code
 *
 *  Place here all your js code.
 *
 *  Author: Igor M. Lucmayon
 * 
 *  Updated: February 17, 2020 @ 6:45 PM
 * ---------------------------------------------------------------------------- */

$(function() {

    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    let profileGroup = $("#hdForm input[name='profileGroup']:checked").val();
    
    if(profileGroup === undefined) 
    {
        $('.input-emp-no').show();
        $('.input-guest-no').hide();
        $('.input-guest-email').hide();
        $('#inpCompany').hide();
        $('#help-text').hide();
        $('#optCompany').show();
    }
    else 
    {
        if(profileGroup == 'employee') 
        {
            let empNo = $('#empNum').val();
            $('.input-emp-no').show();
            $('.input-guest-no').hide();
            $('.input-guest-email').hide();
            $('#inpCompany').hide();
            $('#help-text').hide();
            $('#optCompany').show();
            profileDetailsByEmpNo(empNo, profileGroup);
        }
        else 
        {
            $('.input-emp-no').hide();
            $('.input-guest-no').show();
            $('.input-guest-email').show();
            $('#inpCompany').show();
            $('#help-text').show();
            $('#optCompany').hide();
        }
    }

    function generateQrCode(url)
    {
        let form_data = new FormData();
        form_data.append('url', url);
        $.ajax({
            url: webURL + '/generate/qr-code',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                $(".showQRCode").html(response); 
            }
        });
    } 

    function profileDetailsByEmpNo(empNo, profileGroup)
    {
        let error = false;

        if(empNo.length < 4)
        {
            $('#empNumError').show();
            console.log('test');
            error = true;
            $('#empNumError').html('* Invalid employee number.');
            $('#empNumError').show();
        }
        
        if(error == false)
        {
            let form_data = new FormData();
            form_data.append('empNo', empNo);
            form_data.append('group', profileGroup);
            $.ajax({
                url: webURL + '/profile/details',
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    if(response.status == 400)
                    {
                        $('#messageErrorText').html(response.message);
                        $('#messageError').show();
                        $('#lastName').prop('disabled', true);
                        $('#firstName').prop('disabled', true);
                        $('#midName').prop('disabled', true);
                        $('#optCompany').prop("selected", true);
                        $('#birthDate').prop('disabled', true);
                        $('#address').prop('disabled', true);
                        $('#mobileNo').prop('disabled', true);
                        /*
                        $('#lastName').val('');
                        $('#firstName').val('');
                        $('#midName').val('');
                        $('#optCompany option[value=""]').prop("selected", true);
                        $('#birthDate').val('');
                        $('#address').val('');
                        $('#mobileNo').val('');*/
                        $('#newRegistration').val('Yes');
                        $('#isExist').val(0);
                    }
                    else 
                    {
                        $('#messageError').hide();
                        $('#lastName').val(response.data['lastName']);
                        $('#firstName').val(response.data['firstName']);
                        $('#midName').val(response.data['midName']);
                        $('#optCompany option[value="'+ response.data['company'] +'"]').prop("selected", true);
                        $('#optCompany').attr('disabled', 'disabled');
                        $('#birthDate').val(response.data['birthDate']);
                        $('#address').val(response.data['address']);
                        $('#mobileNo').val(response.data['mobile']);
                        $('#newRegistration').val('No');
                        $('#isExist').val(response.data['profileLog']);
                        $('#lastName').prop('disabled', false);
                        $('#firstName').prop('disabled', false);
                        $('#midName').prop('disabled', false);
                        $('#optCompany').prop("selected", false);
                        $('#birthDate').prop('disabled', false);
                        $('#address').prop('disabled', false);
                        $('#mobileNo').prop('disabled', false);

                        if(response.data['profileLog'] == 1)
                        {
                            $('.input-bday').hide();
                            $('.input-address').hide();
                            $('.input-mobile').hide();
                        }
                        else 
                        {
                            $('.input-bday').show();
                            $('.input-address').show();
                            $('.input-mobile').show();
                        }
                    }
                }
            });
        }
    }

    function profileDetailsByGuestNo(guestNo, profileGroup)
    {
        let form_data = new FormData();
        form_data.append('guestNo', guestNo);
        form_data.append('group', profileGroup);
        $.ajax({
            url: webURL + '/profile/details',
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                if(response.status == 400)
                {
                    $('#messageErrorText').html(response.message);
                    $('#messageError').show();
                    $('#email').val('');
                    $('#lastName').val('');
                    $('#firstName').val('');
                    $('#midName').val('');
                    $('#inpCompany').val('');
                    $('#birthDate').val('');
                    $('#address').val('');
                    $('#mobileNo').val('');
                    $('#newRegistration').val('Yes');
                }
                else 
                {
                    $('#messageError').hide();
                    $('#email').val(response.data['email']);
                    $('#lastName').val(response.data['lastName']);
                    $('#firstName').val(response.data['firstName']);
                    $('#midName').val(response.data['midName']);
                    $('#inpCompany').val(response.data['company']);
                    $('#birthDate').val(response.data['birthDate']);
                    $('#address').val(response.data['address']);
                    $('#mobileNo').val('0' + response.data['mobile']);
                    $('#newRegistration').val('No');
                }
            }
        });
    }

    $('body').on('click', '#profileGroup', function(){
        $('#messageError').hide();
        if($(this).val() == 'guest')
        {
            $('.input-emp-no').hide();
            $('.input-guest-no').show();
            $('.input-guest-email').show();
            $('#inpCompany').show();
            $('#help-text').show();
            $('#optCompany').hide();
            $('#empNum').val('');
            $('#guestNum').val('');
            $('#email').val();
            $('#lastName').val('');
            $('#firstName').val('');
            $('#midName').val('');
            $('#optCompany').val('').change();
            $('#optCompany').prop('disabled', false);
            $('#inpCompany').val('');
            $('#birthDate').val('');
            $('#address').val('');
            $('#mobileNo').val('');
            $('.input-bday').show();
            $('.input-address').show();
            $('.input-mobile').show();
        }
        else
        {
            $('.input-emp-no').show();
            $('.input-guest-no').hide();
            $('.input-guest-email').hide();
            $('#inpCompany').hide();
            $('#help-text').hide();
            $('#optCompany').show();
            $('#empNum').val('');
            $('#guestNum').val('');
            $('#email').val();
            $('#lastName').val('');
            $('#firstName').val('');
            $('#midName').val('');
            $('#optCompany').val('').change();
            $('#optCompany').prop('disabled', false);
            $('#inpCompany').val('');
            $('#birthDate').val('');
            $('#address').val('');
            $('#mobileNo').val('');
            $('.input-bday').show();
            $('.input-address').show();
            $('.input-mobile').show();
        }
        
        $('#empNumError').hide();
        $('#emailError').hide();
        $('#lastNameError').hide();
        $('#firstNameError').hide();
        $('#midNameError').hide();
        $('#companyError').hide();
        $('#birthDateError').hide();
        $('#addressError').hide();
        $('#mobileNoError').hide();
        $('#confirmationError').hide();
        $('#checklistError').hide();
        $('#chkPrivacyError').hide();
    });

    $('body').on('keyup', '#empNum', function(){
        profileDetailsByEmpNo($(this).val(), $("#hdForm input[name='profileGroup']:checked").val());
    });

    $('body').on('change', '#guestNum', function(){
        profileDetailsByGuestNo($(this).val(), $("#hdForm input[name='profileGroup']:checked").val());
    });

    $('body').on('change', '#birthDate', function(){
        $('#guestNum').val('');
        let form_data = new FormData();
        form_data.append('guestNo', $('#guestNum').val());
        form_data.append('lastName', $('#lastName').val());
        form_data.append('firstName', $('#firstName').val());
        form_data.append('midName', $('#midName').val());
        form_data.append('birthDate', $(this).val());
        form_data.append('group', $("#hdForm input[name='profileGroup']:checked").val());
        $.ajax({
            url: webURL + '/profile/details',
            type: 'POST',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                if(response.status == 400)
                {
                    $('#messageErrorText').html(response.message);
                    $('#messageError').show();
                    $('#newRegistration').val('Yes');
                }
                else 
                {
                    $('#messageError').hide();
                    $('#guestNum').val(response.data['guestNo']);
                    $('#email').val(response.data['email']);
                    $('#lastName').val(response.data['lastName']);
                    $('#firstName').val(response.data['firstName']);
                    $('#midName').val(response.data['midName']);
                    $('#inpCompany').val(response.data['company']);
                    $('#birthDate').val(response.data['birthDate']);
                    $('#address').val(response.data['address']);
                    $('#mobileNo').val('0' + response.data['mobile']);
                    $('#newRegistration').val('No');
                }
            }
        });
    });

    $('body').on('click', '#btnSave', function(e){

        e.preventDefault();
        let error = false;
        let profileGroup = $('#hdForm input[name="profileGroup"]:checked').val();
        let empNo       = $('#empNum').val();
        let lastName    = $('#lastName').val();
        let firstName   = $('#firstName').val();
        let midName     = $('#midName').val();
        let optCompany  = $('#optCompany').val();
        let inpCompany  = $('#inpCompany').val();
        let birthDate   = $('#birthDate').val();
        let address     = $('#address').val();
        let mobileNo    = $('#mobileNo').val();
        let mobileRegex = /^\d{11}$/;
        let answer      = $('#hdForm input[name="confirmation"]:checked').val();
        let chkPrivacy  = $('#hdForm input[name="chkPrivacy"]').prop('checked');
        let cIDs        = $('#cIDs').val();
        let count       = validateChecklist(cIDs);
        let refNum      = $('#refNum').val();
        let postURL     = $(this).attr('data-url');
        let company     = (profileGroup == 'guest') ? inpCompany : optCompany;
        let guestNo     = $('#guestNum').val();
        let email       = $('#email').val();
        let emailReg    =  /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        let newReg      = $('#newRegistration').val();
        let isExist     = $('#isExist').val();
        let isExpose    = $('#hdForm input[name="isExpose"]:checked').val();
        let optEntryPoint  = $('#optEntryPoint').val();
        let lastVisit   = $('#lastVisit').val();
  
        if(profileGroup === undefined)
        {
            error = true;
            $('#profileGroupError').show();
        }

        if(profileGroup != 'guest')
        {
            if(empNo.length == 0)
            {
                error = true;
                $('#empNumError').show();
            }
            else 
            {   
                if(empNo.length < 4)
                {
                    error = true;
                    $('#empNumError').html('* Invalid employee number.');
                    $('#empNumError').show();
                }
            }
        }
        else
        {
            if(email.length != 0)
            {
                if(!emailReg.test(email))
                {
                    error = true;
                    $('#emailError').show();
                }
            }
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
                $('#birthDateError').text('* Invalid Birthday format: MM-DD-YYYY');
                $('#birthDateError').show();
            }
        }

        if(profileGroup != 'guest')
        {
            if(optCompany.length == 0)
            {
                error = true;
                $('#companyError').show();
            }
        }
        else 
        {
            if(inpCompany.length == 0)
            {
                error = true;
                $('#companyError').text('* Company is required.');
                $('#companyError').show();
            }
        }

        if(address.length == 0)
        {
            error = true;
            $('#addressError').show();
        }

        if(mobileNo.length == 0)
        {
            error = true;
            $('#mobileNoError').show();
        }
        else 
        {
            if(!mobileNo.match(mobileRegex))
            {
                error = true;
                $('#mobileNoError').text('* Invalid cellphone number.');
                $('#mobileNoError').show();
            }
            else 
            {
                let checkPhone = mobileNo.substring(0, 2);
                if(checkPhone != '09')
                {
                    error = true;
                    $('#mobileNoError').text('* Invalid cellphone number.');
                    $('#mobileNoError').show();
                }
            }
        }

        if(optEntryPoint.length == 0)
        {
            error = true;
            $('#optEntryPointError').show();
        }

        if(lastVisit.length == 0)
        {
            error = true;
            $('#lastVisitError').show();
        }

        if(isExpose === undefined)
        {
            error = true;
            $('#exposedError').show();
        }

        if(answer === undefined)
        {
            error = true;
            $('#confirmationError').show();
        }

        if(count > 0)
        {
            error = true;
            $('#checklistError').show();
        }

        if(!chkPrivacy)
        {
            error = true;
            $('#chkPrivacyError').show();
        }

        if(error == false)
        {
            $('#messageErrorText').hide();
            $('#btnSave').attr('disabled', 'disabled');
            $('#btnSave').html('<b><i class="icon-spinner4 spinner"></i></b> Please wait...');
            let form_data = new FormData();
            let genGuestNum = birthDate.replace(/-/g, '') + lastName.charAt(0) + firstName.charAt(0) + midName.charAt(0);
            let guestNumber = (guestNo.length == 0) ? genGuestNum : guestNo;
            form_data.append('group', profileGroup);
            form_data.append('empNo', empNo);
            form_data.append('lastName', lastName);
            form_data.append('firstName', firstName);
            form_data.append('midName', midName);
            form_data.append('company', company);
            form_data.append('birthDate', birthDate);
            form_data.append('address', address);
            form_data.append('mobileNo', mobileNo);
            form_data.append('answer', answer);
            form_data.append('checklist', checklistValue(cIDs));
            form_data.append('refNum', refNum);
            form_data.append('guestNo', guestNumber);
            form_data.append('email', email);
            form_data.append('logs', isExist);
            form_data.append('isExpose', isExpose);
            form_data.append('entryPoint', optEntryPoint);
            form_data.append('lastVisit', lastVisit);
            
            if(profileGroup == 'guest' && newReg == 'Yes')
            {
                let url = $('#url');
                generateQrCode(url);
                swal({
                    title: "<h5 class='text-semibold'>Guest Number : "+ guestNumber +"</h5><div class='col-md-12 showQRCode' style='margin-bottom: 5px;'></div>",
                    text: "<div class='col-md-12 text-semibold'>You may keep this Guest Number or QR Code for your next visit.</div>",
                    type: "info",
                    html: true,
                    confirmButtonColor: "#283593",
                    confirmButtonText: "PROCEED"
                },
                function(isConfirm){
                    if (isConfirm) {
                        saveData(form_data, postURL, email, genGuestNum);
                    }
                });
            }
            else
            {
                saveData(form_data, postURL, email, guestNumber);
            }
        }
    });

    $('body').on('click', '#profileGroup', function(){
        $('#profileGroupError').hide();
    });

    $('body').on('change', '#empNum', function(){
        $('#empNumError').hide();
    });

    $('body').on('keyup', '#email', function(){
        $('#emailError').hide();
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

    $('body').on('change', '#optCompany', function(){
        $('#companyError').hide();
    });
    $('body').on('keyup', '#inpCompany', function(){
        $('#companyError').hide();
    });

    $('body').on('keyup', '#birthDate', function(){
        $('#birthDateError').hide();
    });

    $('body').on('keyup', '#address', function(){
        $('#addressError').hide();
    });

    $('body').on('keyup', '#mobileNo', function(){
        $('#mobileNoError').hide();
    });

    $('body').on('change', '#optEntryPoint', function(){
        $('#optEntryPointError').hide();
    });

    $('body').on('keyup', '#lastVisit', function(){
        $('#lastVisitError').hide();
    });

    $('body').on('click', '#isExpose', function(){
        $('#exposedError').hide();
    });
    
    $('body').on('click', '#confirmation', function(){
        $('#confirmationError').hide();
        $('#checklistError').hide();
        let answer = $(this).val();
        let ids    = $('#cIDs').val();
        let arrID  = ids.split(',');
        
        $.each(arrID , function(i, val) { 
            let radName = 'answer_'+ val +'_No';

            if(answer == 'No')
            {
                $('#'+ radName).prop('checked', true);
            }
            else
            {
                $('#'+ radName).prop('checked', false);
            }
        }); 
    });

    $('body').on('change', '#hdForm input[name^="answer_"]', function(){
        let answerCount = validateChecklist($('#cIDs').val());

        if(answerCount == 0)
        {
            $('#checklistError').hide();
        }
    });

    $('body').on('click', '#chkPrivacy', function(){
        $('#chkPrivacyError').hide();
    });

    // Checkboxes, radios
    $(".styled").uniform({ radioClass: 'choice' });

    function sendNotification(email, guestNo)
    {
        let form_data = new FormData();
        form_data.append('email', email);
        form_data.append('guestNo', guestNo);

        $.ajax({
            url: webURL + '/send',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                console.log(response)
            }
        });
    }

    function saveData(form_data, postURL, email, guestNo)
    {
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
                    if(email.length != 0)
                    {
                        sendNotification(email, guestNo);
                    }; 
        
                    swal({
                        title: response.title,
                        text: response.text,
                        type: 'success',
                        html: true,
                        confirmButtonColor: "#283593"
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $(window.location).attr('href', '/form');
                        }
                    });
                }
                else
                {
                    swal({
                        title: response.title,
                        text: response.text,
                        type: "warning",
                        confirmButtonColor: "#C62828",
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $('#btnSave').removeAttr('disabled');
                            $('#btnSave').html('<b><i class="icon-database-add"></i></b> Submit Form');
                        }
                    });
                }
            } 
        }); 
    }

    function isValidDate(dateString)
    {
        let regEx = /^(0[1-9]|1[0-2])\-(0[1-9]|1\d|2\d|3[01])\-(19|20)\d{2}$/;

        return dateString.match(regEx) != null;
    }

    function validateChecklist(cIDs)
    {
        let arrID = cIDs.split(',');
        let count = 0;

        $.each(arrID , function(i, val) { 
            let radName = 'answer_'+ val;

            if (!$("input[name='"+ radName +"']").is(':checked')) {
                count += 1;
            }
        }); 

        return count;
    }

    function checklistValue(cIDs)
    {
        let arrID = cIDs.split(',');
        let arrVal = [];

        $.each(arrID , function(i, val) { 
            let radName = 'answer_'+ val;
            let value = $("#hdForm input[name='"+ radName +"']:checked").val() +'&'+val;

            arrVal.push(value);
        }); 

        return arrVal;
    }

});