<form id="editUserForm">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold">USER GROUP :</label>
                <select name="userGroup" id="userGroup" class="form-control">
                    <option value="">CHOOSE ONE</option> 
                    @foreach ($group as $row)
                    <option value="{{ $row->id }}" {{ ($detail[0]->group_id == $row->id) ? 'selected=selected' : '' }}>{{ strtoupper($row->group_name) }}</option>    
                    @endforeach
                </select>
                <label class="error" id="userGroupError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please select user group.</label>
            </div>

            <div class="form-group">
                <label class="text-semibold">NAME :</label>
                <input type="text" name="userName" id="userName" class="form-control" value='{{ $detail[0]->name }}'/>
                <label class="error" id="userNameError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Name is required.</label>
            </div>

            <div class="form-group">
                <label class="text-semibold">EMAIL ADDRESS :</label>
                <input type="text" name="email" id="email" class="form-control" value='{{ $detail[0]->email }}' />
                <label class="error" id="emailError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Email address is required.</label>
            </div>
            <input type="hidden" name="userID" id="userID" value="{{ $detail[0]->id }}" />
            <input type="hidden" id="postURL" value="{{ config('app.url') }}/user/update">
        </div>
    </div>

</form>