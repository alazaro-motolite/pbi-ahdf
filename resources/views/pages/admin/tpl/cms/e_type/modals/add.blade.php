<form id="addEmpTypeForm">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold">EMPLOYEE TYPE :</label>
                <input type="text" name="empType" id="empType" class="form-control" />
                <label class="error" id="empTypeError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Employee type is required.</label>
            </div>
        </div>
    </div>
    <input type="hidden" id="postURL" value="{{ config('app.url') }}/cms/employee-type/save">
</form>