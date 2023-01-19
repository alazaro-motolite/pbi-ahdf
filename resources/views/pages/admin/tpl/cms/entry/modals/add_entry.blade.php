<form id="addChecklistForm">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold">POINT OF ENTRY :</label>
                <input type="text" name="entryPoint" id="entryPoint" class="form-control" />
                <label class="error" id="entryPointError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Point of entry is required.</label>
            </div>
        </div>
    </div>
    <input type="hidden" id="postURL" value="{{ config('app.url') }}/cms/entry/save">
</form>