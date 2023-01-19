<form id="importForm" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="display-block text-semibold">SELECT FILE:</label>
                <input type="file" name="docFile" id="docFile" class="file-styled">
                <span class="help-block">Accepted formats: xlsx only.</span>
                <label class="error" id="fileError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Select file to import.</label>
            </div>
        </div>
    </div>
    <input type="hidden" id="postURL" value="{{ config('app.url') }}/employee/import">
</form>
