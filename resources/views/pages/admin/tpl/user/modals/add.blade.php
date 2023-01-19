<form id="addUserForm">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold">USER GROUP :</label>
                <select name="userGroup" id="userGroup" class="form-control">
                    <option value="">CHOOSE ONE</option> 
                    @foreach ($group as $row)
                    <option value="{{ $row->id }}">{{ strtoupper($row->group_name) }}</option>    
                    @endforeach
                </select>
                <label class="error" id="userGroupError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please select user group.</label>
            </div>

            <div class="form-group">
                <label class="text-semibold">NAME :</label>
                <input type="text" name="userName" id="userName" class="form-control" />
                <label class="error" id="userNameError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Name is required.</label>
            </div>

            <div class="form-group">
                <label class="text-semibold">EMAIL ADDRESS :</label>
                <input type="text" name="email" id="email" class="form-control" />
                <label class="error" id="emailError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Email address is required.</label>
            </div>

            <div class="form-group">
                <label class="text-semibold">PASSWORD :</label>
                <input type="text" name="password" id="password" class="form-control" />
                <label class="error" id="passwordError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Password is required.</label>
            </div>

            <div class="form-group">
                <label class="text-semibold">CONFIRM PASSWORD :</label>
                <input type="text" name="confirmPass" id="confirmPass" class="form-control" />
                <label class="error" id="confirmPassError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Password doesn't match.</label>
            </div>

        </div>
    </div>
    <input type="hidden" id="postURL" value="{{ config('app.url') }}/user/save">
</form>