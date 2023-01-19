<form id="newEmployeeForm">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="text-semibold">EMPLOYEE NO. :</label>
                <input type="text" name="empNum" id="empNum" class="form-control" />
                <label class="error" id="empNumError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Employee no. is required.</label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="text-semibold">LAST NAME :</label>
                <input type="text" name="lastName" id="lastName" class="form-control" />
                <label class="error" id="lastNameError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Last name is required.</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="text-semibold">FIRST NAME :</label>
                <input type="text" name="firstName" id="firstName" class="form-control" />
                <label class="error" id="firstNameError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* First name is required.</label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="text-semibold">MIDDLE NAME :</label>
                <input type="text" name="midName" id="midName" class="form-control" />
                <label class="error" id="midNameError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Middle name is required.</label>
            </div>
        </div>
    </div>

    <div class="row">        
        <div class="col-md-6">
            <div class="form-group">
                <label class="text-semibold">DATE OF BIRTH :</label>
                <input type="text" name="birthDate" id="birthDate" class="form-control" placeholder="e.g. 07-22-1990" />
                <label class="error" id="birthDateError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Birth date is required.</label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="display-block text-semibold">GENDER :</label>
                <select name="gender" id="gender" class="form-control">
                    <option value="">SELECT ONE</option> 
                    <option value="MALE">MALE</option>
                    <option value="FEMALE">FEMALE</option>
                </select>
                <label class="error display-block" id="genderError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Gender is required.</label>
            </div>
        </div>
    </div>
    <div class="row">  
        <div class="col-md-6">
            <div class="form-group">
                <label class="text-semibold">MOBILE NO. :</label>
                <input type="text" name="contactNum" id="contactNum" maxlength="11" class="form-control" />
                <label class="error" id="contactNumError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Mobile number is required.</label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="text-semibold">EMPLOYEE TYPE :</label>
                <select name="empType" id="empType" class="form-control">
                    <option value="">SELECT ONE</option> 
                    @foreach ($type as $t)
                    <option value="{{ strtoupper($t->type_name) }}">{{ strtoupper($t->type_name) }}</option>
                    @endforeach
                </select>
                <label class="error" id="empTypeError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Select employee type.</label>
            </div>
        </div>
    </div>

    <div class="row">        
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold d-block">COMPANY :</label>
                <select name="company" id="company" class="form-control">
                    <option value="">SELECT ONE</option> 
                    @foreach ($company as $row)
                    <option value="{{ strtoupper($row->company) }}">{{ strtoupper($row->company) }}</option>
                    @endforeach
                </select>
                <label class="error" id="companyError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Please select company.</label>
            </div>
        </div>
    </div>
    
    <div class="row">        
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold">ADDRESS :</label>
                <textarea name="homeAddress" id="homeAddress" class="form-control"></textarea>
                <label class="error" id="homeAddressError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Address is required.</label>
            </div>
        </div>
    </div>

    <input type="hidden" id="postURL" value="{{ config('app.url') }}/employee/save">
</form>