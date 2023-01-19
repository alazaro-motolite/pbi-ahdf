@extends('pages.admin.layout.default')
	@section('contents')
	<script src="{{ asset('assets/js/cms.js') }}"></script>
    <div class="row">
        <div class="col-md-12">
            <!-- Basic datatable -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Company</h5>
					<div class="heading-elements">
						
						<button type="button" data-toggle="modal" data-target="#modal_add_company" data-url="{{ config('app.url') }}/cms/company/add" class="btn bg-indigo-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-plus-circle2"></i></b> Add Company</button>
					</div>
				</div>

				<div id="company_data"></div>
			</div>
        </div>
    </div>

    <!-- Add Company form modal -->
	<div id="modal_add_company" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Add Company</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelSaveCompany" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnSaveCompany"><b><i class=" icon-database-add"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /new form modal -->

    <!-- Edit Company form modal -->
	<div id="modal_edit_company" class="modal fade" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header bg-indigo-800">
					<h5 class="modal-title">Modify Company</h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelEditCompany" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
					<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnEditCompany"><b><i class=" icon-database-add"></i></b> SAVE</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /edit form modal -->

    @endsection

