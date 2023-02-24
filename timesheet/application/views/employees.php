<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous">
	<title>Timesheet</title>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand fw-bold" href="#">Dashboard</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url()."admin/logbook";?>">Logbook</a>
					</li> 
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url()."admin/timerecords";?>">Time Records</a>
					</li> 
          <?php
        $udata = $this->session->userdata('UserSession');
        if($udata['user_type'] == 1){ ?> 
					<li class="nav-item">
						<a class="nav-link active" href="<?php echo base_url()."admin/employees";?>">Employees</a>
					</li> 
          <li class="nav-item">
						<a class="nav-link" href="<?php echo base_url()."admin/users";?>">Users</a>
					</li> 
        <?php } ?> 
          <li class="nav-item">
						<a class="nav-link" href="<?=base_url('admin/logout')?>">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav> <?php 
if(!$this->session->userdata('UserSession')) //$udata = $this->session->userdata('UserSession');
{
    redirect(base_url('admin'));
}
 ?> <section class="mt-5">
		<div class="container">
			<div class="row justify-content-center mb-5">
				<div class="col-md-8 col-12">
					<nav class="nav nav-pills nav-fill">
						<button class="nav-link border border-primary active " id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Employee List</button>
						<button class="nav-link border border-primary" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Add Employee</button>
					</nav>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-12 col-md-8">
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active table-responsive-sm" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
							<table class="table table-striped" id="employeeTable">
								<thead class="table-dark">
									<tr>
										<th scope="col"></th>
										<th scope="col">#</th>
										<th scope="col">Employee</th>
										<th scope="col">Created By</th>
										<th scope="col">Date Created</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
								</tfoot>
							</table>
							<button type="submit" class="btn btn-danger d-none bulk-delete" id="bulkDelete">Bulk Delete</button>
						</div>
						<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
							<div class="card">
								<div class="card-header bg-dark text-white fw-bold"> Add Employee </div>
								<div class="card-body">
									<form method="post" autocomplete="off" action="<?=base_url('admin/addEmployee');?>">
										<div class="mb-3">
											<label for="first_name" class="form-label">First Name</label>
											<input type="text" name="first_name" class="form-control" id="first_name" required>
										</div>
										<div class="mb-3">
											<label for="last_name" class="form-label">Last Name</label>
											<input type="text" name="last_name" class="form-control" id="last_name" required>
										</div>
										<div class="row">
											<div class="col-6">
												<button type="reset" class="btn btn-secondary w-100">Reset</button> 
											</div>
											<div class="col-6">
												<button type="submit" class="btn btn-primary w-100">Submit</button> 
											</div>
										</div>
										
										<?php
									if($this->session->flashdata('success')) {	?> <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p> <?php } ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="updateEmployee" method="post" autocomplete="off" action="<?=base_url('admin/updateEmployee');?>">
					<div class="modal-header bg-dark text-white">
						<h5 class="modal-title fw-bold" id="editModalLabel">Edit Employee</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label for="first_name" class="form-label">First Name</label>
							<input type="text" name="first_name" class="form-control" id="first_name" required>
						</div>
						<div class="mb-3">
							<label for="last_name" class="form-label">Last Name</label>
							<input type="last_name" name="last_name" class="form-control" id="last_name">
						</div>
						<input type="hidden" name="id" id="id" value="">
						<input type="hidden" name="trid" id="trid" value=""> <?php
          if($this->session->flashdata('success')) {	?> <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p> <?php } ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="deleteEmployee" method="post" autocomplete="off" action="<?=base_url('admin/deleteEmployee');?>">
					<div class="modal-header bg-dark text-white">
						<h5 class="modal-title fw-bold" id="deleteModalLabel">Delete</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<p>Are you sure you want to delete this employee: <span id="employee_name" class="fw-bold"></span></p>
						</div>
						<input type="hidden" name="id" id="id" value="">
						<input type="hidden" name="trid" id="trid" value=""> 
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-dark text-white">
					<h5 class="modal-title fw-bold" id="qrModalLabel">Employee QR code</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3 text-center" id="QRCodeDiv">
						<img id="qr_url" src="" download>
						<br><a href="" id="id_url" class="btn btn-sm btn-outline-primary" download>Download QR code</a>
					</div>
					<div class="mb-3">
						<label for="first_name" class="form-label">First Name</label>
						<input type="text" name="first_name" class="form-control" id="first_name" readonly>
					</div>
					<div class="mb-3">
						<label for="last_name" class="form-label">Last Name</label>
						<input type="last_name" name="last_name" class="form-control" id="last_name" readonly>
					</div>
					<input type="hidden" name="id" id="id" value="">
					<input type="hidden" name="trid" id="trid" value=""> <?php
          if($this->session->flashdata('success')) {	?> <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p> <?php } ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="deleteEmployees" method="post" autocomplete="off" action="<?=base_url('admin/deleteEmployee?multiDelete=1');?>">
					<div class="modal-header bg-dark text-white">
						<h5 class="modal-title fw-bold" id="bulkDeleteModalModalLabel">Delete</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<p>Are you sure you want to delete these employees?</p>
						</div>
						<input type="hidden" name="employee_ids" id="employee_ids" value="">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Optional JavaScript; choose one of the two! -->
	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous"></script>
	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
	<script>
		$(document).ready(function() {
			$('#employeeTable').DataTable({
				"fnCreatedRow": function(nRow, aData, iDataIndex) {
					$(nRow).attr('id', aData[0]);
				},
				// 'serverSide': 'true',
				'processing': 'true',
				'paging': 'true',
				'order': [],
				'ajax': {
					'url': 'fetchEmployees',
					'type': 'post',
				},
				"columnDefs": [{
					"orderable": false
				}]
			});
		});
		$('#employeeTable').on('click', '.editbtn ', function(event) {
			var table = $('#employeeTable').DataTable();
			var trid = $(this).closest('tr').attr('id');
			// console.log(selectedRow);
			var id = $(this).data('id');
			$('#editModal').modal('show');
			var d = {
				id: id,
			};
			$.post('fetchSingleEmployee', d, function(result) {
				var result = $.parseJSON(result);
				$('#updateEmployee #first_name').val(result.first_name);
				$('#updateEmployee #last_name').val(result.last_name);
				$('#updateEmployee #id').val(id);
				$('#updateEmployee #trid').val(trid);
			});
		});
		$('#employeeTable').on('click', '.deleteBtn ', function(event) {
			var table = $('#employeeTable').DataTable();
			var trid = $(this).closest('tr').attr('id');
			// console.log(selectedRow);
			var id = $(this).data('id');
			$('#deleteModal').modal('show');
			var d = {
				id: id,
			};
			$.post('fetchSingleEmployee', d, function(result) {
				var result = $.parseJSON(result);
				$('#deleteEmployee #employee_name').html(result.last_name + ", " + result.first_name);
				$('#deleteEmployee #id').val(id);
				$('#deleteEmployee #trid').val(trid);
			});
		});
		$('#employeeTable').on('click', '.qrbtn ', function(event) {
			var table = $('#employeeTable').DataTable();
			var trid = $(this).closest('tr').attr('id');
			// console.log(selectedRow);
			var id = $(this).data('id');
			$('#qrModal').modal('show');
			var d = {
				id: id,
			};
			$.post('fetchSingleEmployee', d, function(result) {
				var result = $.parseJSON(result);
				$('#qrModal #id_url').attr('href', result.id_url);
				$('#qrModal #qr_url').attr('src', result.qr_url);
				$('#qrModal #first_name').val(result.first_name);
				$('#qrModal #last_name').val(result.last_name);
				$('#qrModal #id').val(id);
				$('#qrModal #trid').val(trid);
			});
		});
		$('#downloadQR').on('click', function() { //QRCode
			var c = $("#QRCodeDiv");
			var t = c.getContext('2d');
			window.open('', document.getElementById('QRCode').toDataURL());
		});
		$('#employeeTable').on('click', '.checkboxes ', function() {
			var displayBultDelete = false;
			var employee_ids = new Array();
			$('.checkboxes').each(function(k) {
				var isChecked = $(this).prop('checked');
				var id = $(this).data('id');
				if(isChecked || displayBultDelete){
					$('#bulkDelete').removeClass('d-none');
					displayBultDelete = true;
					if(isChecked){
						employee_ids.push(id);
					}
				}
				else{
					$('#bulkDelete').addClass('d-none');
				}
				
			});
			$('#employee_ids').val(employee_ids);
		});
		$('#bulkDelete').on('click',  function(event) {
			var ids = $('#employee_ids').val();
			$('#bulkDeleteModal').modal('show');
			var d = {
				ids: ids,
			};
		});
	</script>
</body>

</html>