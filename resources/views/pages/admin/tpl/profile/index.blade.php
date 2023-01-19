@extends('pages.admin.layout.default')
		@section('contents')
		<script src="{{ asset('assets/js/employee.js') }}"></script>
			<!-- Basic datatable -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Employee</h5>
					<div class="heading-elements">

						<button type="button" id="btnExport" class="btn bg-success-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-database-export"></i></b> Extract</button>

						<button type="button" id="btnImportForm" data-toggle="modal" data-target="#modal_import" data-url="{{ config('app.url') }}/employee/import" class="btn bg-primary-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-database-upload"></i></b> Import</button>

						<button type="button" id="btnAddNew" data-toggle="modal" data-target="#modal_new_employee" data-url="{{ config('app.url') }}/employee/add" class="btn bg-indigo-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-user-plus"></i></b> New Employee</button>
					</div>
				</div>

				<div id="employee_data">
					<table class="table table-sm employee_data_table">
						<thead>
							<tr>
								<th class="col-md-1">Profile #</th>
								<th>Name</th>
								<th>Birth Date</th>
								<th>Gender</th>
								<th>Address</th>
								<th>Mobile No.</th>
								<th>Company</th>
								<th>Employee Type</th>
								<th class="col-md-1 text-center">Status</th>
								<th class="col-md-1 text-center">Actions</th>
							</tr>
						</thead>
						<tbody
							@php
							foreach($employee as $row) :
								$badge  = ($row->is_active == 1) ? 'label label-success' : 'label label-danger';
								$text   = ($row->is_active == 1) ? 'ACTIVE' : 'INACTIVE';
								$status = ($row->is_active == 1) ? 'deactivate' : 'activate';
								$icon   = ($row->is_active == 1) ? 'icon-close2' : 'icon-checkmark-circle2';
							@endphp
							<tr>
								<td>{{ $row->profile_no }}</td>
								<td>{{ $row->last_name }}, {{  $row->first_name }} {{ $row->middle_name }}</td>
								<td>{{ $row->birth_date }}</td>
								<td>{{ $row->gender }}</td>
								<td>{{ $row->address }}</td>
								<td>{{ $row->mobile_no }}</td>
								<td>{{ $row->company_name }}</td>
								<td>{{ $row->employee_type }}</td>
								<td class="col-md-1 text-center"><span class="{{ $badge }}">{{ $text }}</span></td>
								<td class="col-md-1 text-center">
									<ul class="icons-list">
										<li>
											<a data-toggle="modal" data-target="#modal_edit_employee" data-id="{{ $row->id }}" data-url="{{ config('app.url') }}/employee/edit/" data-popup="tooltip" title="Edit" data-placement="left"><i class="icon-pencil"></i></a>
										</li>
										<li>
											<a id="btnStatus" data-url="{{ config('app.url') }}/employee/status" data-id="{{ $row->id }}" data-status="{{ $status }}"><i class="{{ $icon }}" data-popup="tooltip" title="{{ ucfirst($status) }}" data-placement="left"></i></a>
										</li>
									</ul>
								</td>
							</tr>
							@php
							endforeach;
							@endphp
						</tbody>
					</table>
				</div>
			</div>
			<!-- /basic datatable -->     

			<!-- New form modal -->
			<div id="modal_new_employee" class="modal fade" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header bg-indigo-800">
							<h5 class="modal-title">Add Employee</h5>
						</div>
						<div class="modal-body"></div>
						<div class="modal-footer">
							<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelSave" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
							<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnSave"><b><i class=" icon-database-add"></i></b> SAVE</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /new form modal -->

			<!-- Edit form modal -->
			<div id="modal_edit_employee" class="modal fade" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header bg-indigo-800">
							<h5 class="modal-title">Modify Employee</h5>
						</div>
						<div class="modal-body"></div>
						<div class="modal-footer">
							<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelUpdate" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
							<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnUpdate"><b><i class=" icon-database-edit2"></i></b> UPDATE</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /edit form modal -->
			
			<!-- New form modal -->
			<div id="modal_import" class="modal fade" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header bg-indigo-800">
							<h5 class="modal-title">Import Data</h5>
						</div>
						<div class="modal-body"></div>
						<div class="modal-footer">
							<button type="button" class="btn bg-danger-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="cancelImport" data-dismiss="modal"><b><i class="icon-x"></i></b> CANCEL</button>
							<button type="button" class="btn bg-indigo-800 btn-sm btn-raised btn-labeled btn-labeled-right" id="btnImport"><b><i class=" icon-database-upload"></i></b> Import</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /new form modal -->
		@endsection