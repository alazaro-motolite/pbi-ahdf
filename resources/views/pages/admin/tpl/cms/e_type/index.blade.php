@extends('pages.admin.layout.default')
	@section('contents')
	<script src="{{ asset('assets/js/cms.js') }}"></script>
    <div class="row">
        <div class="col-md-12">
            <!-- Basic datatable -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Employee Type</h5>
					<div class="heading-elements">
						<button type="button" data-toggle="modal" data-target="#modal_add_emp_type" data-url="{{ config('app.url') }}/cms/employee-type/add" class="btn bg-indigo-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-plus-circle2"></i></b> Add Employee Type</button>
					</div>
				</div>

				<div id="emp_type_data"></div>
			</div>
        </div>
    </div>

    <!-- Add Checklist form modal -->
	<div id="modal_add_emp_type" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Add Employee Type</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelSaveEmployeeType" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnSaveEmployeeType"><b><i class=" icon-database-add"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /new form modal -->

    <!-- Edit Checklist form modal -->
	<div id="modal_edit_emp_type" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Modify Employee Type</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelEditEmployeeType" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnEditEmployeeType"><b><i class=" icon-database-add"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /edit form modal -->

    @endsection

