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
						<a class="nav-link active" href="<?php echo base_url()."admin/timerecords";?>">Time Records</a>
					</li> 
          <?php
        $udata = $this->session->userdata('UserSession');
        if($udata['user_type'] == 1){ ?> 
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url()."admin/employees";?>">Employees</a>
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
 ?> 
 <section class="mt-5">
		<div class="container">
			<div class="row justify-content-center mb-5">
				<div class="col-md-8 col-12">
					<nav class="nav nav-pills nav-fill">
						<div class="nav-link active bg-dark" id="v-pills-home-tab">Time Record List</div>
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
										<th scope="col">#</th>
										<th scope="col">Employee</th>
										<th scope="col">Time In</th>
										<th scope="col">Time Out</th>
										<th scope="col">Admin User</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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
					'url': 'fetchTimeRecords',
					'type': 'post',
				},
				"columnDefs": [{
					"orderable": false
				}]
			});
		});
	</script>
</body>

</html>