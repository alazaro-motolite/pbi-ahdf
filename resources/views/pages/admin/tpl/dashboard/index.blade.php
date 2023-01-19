@extends('pages.admin.layout.default')
		@section('contents')
		<script src="{{ asset('assets/js/dashboard.js') }}"></script>
			<!-- Basic datatable -->
			<div class="panel panel-flat">
				@if(in_array(Session::get('groupID'), [2, 3]))
				<div class="panel-body">
					<form action="{{ config('app.url') }}/dashboard/export" method="POST" class="form-horizontal" id="formExport">
						@csrf
						<div class="row">
							<div class="form-group col-md-3" style="margin-bottom: 0px;">
								<label class="col-md-4 control-label text-semibold">Date From :</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="startDate" id="startDate">
								</div>
							</div>

							<div class="form-group col-md-3" style="margin-bottom: 0px;">
								<label class="col-md-4 control-label text-semibold">Date To :</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="endDate" id="endDate">
								</div>
							</div>
							<div class="col-md-2">
								<button type="submit" id="btnExport" class="btn bg-indigo-800 btn-raised btn-labeled btn-labeled-right btn-sm"><b><i class="icon-download7"></i></b>Extract Report</button>
							</div>
						</div>
					</form>
				</div>
				@endif

				<div id="dashboard_data"></div>
			</div>
			<!-- /basic datatable -->     

			<!-- New form modal -->
			<div id="modal_view_answer" class="modal fade" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header bg-indigo-800">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h5 class="modal-title">Checklist Answer</h5>
						</div>
						<div class="modal-body"></div>
					</div>
				</div>
			</div>
			<!-- /new form modal -->
		@endsection