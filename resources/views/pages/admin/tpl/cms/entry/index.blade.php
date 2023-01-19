@extends('pages.admin.layout.default')
	@section('contents')
	<script src="{{ asset('assets/js/cms.js') }}"></script>
    <div class="row">
        <div class="col-md-12">
            <!-- Basic datatable -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Point of Entry</h5>
					<div class="heading-elements">
						<button type="button" data-toggle="modal" data-target="#modal_add_entry" data-url="{{ config('app.url') }}/cms/entry/add" class="btn bg-indigo-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-plus-circle2"></i></b> Add Point of Entry</button>
					</div>
				</div>

				<div id="entry_data"></div>
			</div>
        </div>
    </div>

    <!-- Add Checklist form modal -->
	<div id="modal_add_entry" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Add Point of Entry</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelSaveEntryPoint" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnSaveEntryPoint"><b><i class=" icon-database-add"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /new form modal -->

    <!-- Edit Checklist form modal -->
	<div id="modal_edit_entry" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Modify Point of Entry</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelEditEntryPoint" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnEditEntryPoint"><b><i class=" icon-database-add"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /edit form modal -->

    @endsection

