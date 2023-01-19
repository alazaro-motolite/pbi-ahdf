<form id="addCompanyForm">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold">COMPANY :</label>
                <input type="text" name="company" id="company" class="form-control" />
                <label class="error" id="companyError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Company is required.</label>
            </div>
        </div>
    </div>
    <input type="hidden" id="postURL" value="{{ config('app.url') }}/cms/company/save">
</form>