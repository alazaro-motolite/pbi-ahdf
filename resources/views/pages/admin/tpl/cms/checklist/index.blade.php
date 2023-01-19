@extends('pages.admin.layout.default')
	@section('contents')
	<script src="{{ asset('assets/js/cms.js') }}"></script>
    <div class="row">
        <div class="col-md-12">
            <!-- Basic datatable -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Symptoms Checklist</h5>
					<div class="heading-elements">
						<button type="button" data-toggle="modal" data-target="#modal_add_checklist" data-url="{{ config('app.url') }}/cms/checklist/add" class="btn bg-indigo-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-plus-circle2"></i></b> Add Checklist</button>
					</div>
				</div>

				<div id="checklist_data"></div>
			</div>
        </div>
    </div>

    <!-- Add Checklist form modal -->
	<div id="modal_add_checklist" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Add Symptoms Checklist</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelSaveChecklist" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnSaveChecklist"><b><i class=" icon-database-add"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /new form modal -->

    <!-- Edit Checklist form modal -->
	<div id="modal_edit_checklist" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Modify Symptoms Checklist</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelEditChecklist" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnEditChecklist"><b><i class=" icon-database-add"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /edit form modal -->

    @endsection

