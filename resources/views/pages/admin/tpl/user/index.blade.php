	@extends('pages.admin.layout.default')
		@section('contents')      
		<script src="{{ asset('assets/js/user.js') }}"></script>  
			<!-- Basic datatable -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">User</h5>
					<div class="heading-elements">
						<button type="button" data-toggle="modal" data-target="#modal_new_user" data-url="{{ config('app.url') }}/user/add" class="btn bg-indigo-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-user-plus"></i></b> New User</button>
					</div>
				</div>

				<div id="user_data"></div>
			</div>
			<!-- /basic datatable -->  

			<!-- New form modal -->
			<div id="modal_new_user" class="modal fade" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-xs">
					<div class="modal-content">
						<div class="modal-header bg-indigo-800">
							<h5 class="modal-title">Add User</h5>
						</div>
						<div class="modal-body"></div>
						<div class="modal-footer">
							<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelSaveUser" data-dismiss="modal"><b><i class="icon-x position-left"></i></b> CANCEL</button>
							<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnSaveUser"><b><i class=" icon-database-add position-left"></i></b> SAVE</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /new form modal -->

			<!-- New form modal -->
			<div id="modal_edit_user" class="modal fade" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-xs">
					<div class="modal-content">
						<div class="modal-header bg-indigo-800">
							<h5 class="modal-title">Modify User</h5>
						</div>
						<div class="modal-body"></div>
						<div class="modal-footer">
							<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelUpdateUser" data-dismiss="modal"><b><i class="icon-x position-left"></i></b> CANCEL</button>
							<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnUpdateUser"><b><i class=" icon-database-edit2 position-left"></i></b> UPDATE</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /new form modal -->
		@endsection