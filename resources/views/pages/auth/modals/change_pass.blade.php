<form id="changeUserPasswordForm">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold">OLD PASSWORD :</label>
                <input type="password" name="oldPassword" id="oldPassword" class="form-control" />
                <label class="error" id="oldPasswordError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Old password is required.</label>
            </div>

            <div class="form-group">
                <label class="text-semibold">NEW PASSWORD :</label>
                <input type="password" name="newPassword" id="newPassword" class="form-control" />
                <label class="error" id="newPasswordError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* New password is required.</label>
            </div>

            <div class="form-group">
                <label class="text-semibold">CONFIRM NEW PASSWORD :</label>
                <input type="password" name="confirmPass" id="confirmPass" class="form-control" />
                <label class="error" id="confirmPassError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Password doesn't match.</label>
            </div>

        </div>
    </div>
    <input type="hidden" id="userID" value="{{ Session::get('userID') }}">
    <input type="hidden" id="postURL" value="{{ config('app.url') }}/update-password">
</form>