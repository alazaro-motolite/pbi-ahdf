<form id="addChecklistForm">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-semibold">SYMPTOMS CHECKLIST :</label>
                <input type="text" name="checklist" id="checklist" class="form-control" />
                <label class="error" id="checklistError" style="margin-top: 7px; color: red; font-size: 11px; font-style: italic; display: none;">* Checklist/Symptoms is required.</label>
            </div>
        </div>
    </div>
    <input type="hidden" id="postURL" value="{{ config('app.url') }}/cms/checklist/save">
</form>