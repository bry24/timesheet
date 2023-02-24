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
						<a class="nav-link active" href="<?php echo base_url()."admin/logbook";?>">Logbook</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url()."admin/timerecords";?>">Time Records</a>
					</li> <?php
        $udata = $this->session->userdata('UserSession');
        if($udata['user_type'] == 1){ ?> <li class="nav-item">
						<a class="nav-link" href="<?php echo base_url()."admin/employees";?>">Employees</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url()."admin/users";?>">Users</a>
					</li> <?php } ?> <li class="nav-item">
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
			<div class="row justify-content-center">
				<div class="col-12 col-md-8">
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active table-responsive-sm" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
							<form id="validateEmployee" method="post" autocomplete="off" onsubmit="return false;">
								<div class="card">
									<div class="card-header"> Record Log </div>
									<div class="card-body">
										<div>
											<div class="text-center">
												<div for="id" class="form-label ">Scan employee QR code</div>
												<div class="row mb-3">
													<div class="col-12">
														<button id="QRmachine" class="btn btn-primary " data-bs-toggle="tooltip" data-bs-title="Sample QR machine trigger"> Enter employee ID for automatic action record and skip button validate </button>
													</div>
												</div>
												<div for="id" class="form-label"> or</div>
												<label for="id" class="form-label">Enter your employee ID:</label>
												<input type="text" name="id" class="form-control" id="id" required>
												<div class="row">
													<div class="col-12 col-md-6">
														<button type="reset" id="reset" class="btn btn-secondary w-100 mt-3">Reset</button>
													</div>
													<div class="col-12 col-md-6">
														<button type="submit" id="validate" class="btn btn-primary w-100 mt-3">Validate</button>
													</div>
												</div>
											</div>
											<input type="hidden" name="id" id="id" value="">
											<input type="hidden" name="trid" id="trid" value=""> <?php
          if($this->session->flashdata('success')) {	?> <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p> <?php } ?>
										</div>
										<div class="row justify-content-center d-none mt-5" id="timeAction">
											<div class="col-12 welcome-note text-center">
												<h4 class="fw-bold">Hi <span id="employeeName"></span>!</h4>
												<p>Please select your time record action:</p>
											</div>
											<div class="col-6" id="timeIn">
												<div class="d-grid gap-2">
													<button class="btn btn-success btn-lg py-4" id="btnTimeIn" type="button">Time In</button>
												</div>
											</div>
											<div class="col-6" id="timeOut">
												<div class="d-grid gap-2">
													<button class="btn btn-danger btn-lg py-4" id="btnTimeOut" type="button">Time Out</button>
												</div>
											</div>
										</div>
										<div class="row my-5">
											<div class="col-12 record-success d-none">
												<p class="text-primary h1 text-center fw-bold"><span id="timeRecord"></span> successful!</p>
											</div>
										</div>
									</div>
								</div>
						</div>
						</form>
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
		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
		$('#reset').on('click', function() {
			$('#timeAction').addClass('d-none');
			$('.welcome-note').addClass('d-none');
		});
		$('#btnTimeOut').on('click', function() {
			var id = $("#btnTimeOut").data('id');
			var d = {
				id: id,
			};
			$.post('employeeTimeOut', d, function(result) {
				var result = $.parseJSON(result);
				if (result != false) {
					$('#validateEmployee #id').val("");
					$('.welcome-note').addClass('d-none');
					$('#timeOut').addClass('d-none');
					$('#timeRecord').html('Time out');
					$('.record-success').removeClass('d-none');
				} else {
					$('#timeAction').addClass('d-none');
				}
			});
		});
		$('#btnTimeIn').on('click', function() {
			var id = $("#validateEmployee #id").val();
			var d = {
				id: id,
			};
			$.post('employeeTimeIn', d, function(result) {
				var result = $.parseJSON(result);
				if (result != false) {
					$('#validateEmployee #id').val("");
					$('.welcome-note').addClass('d-none');
					$('#timeIn').addClass('d-none');
					$('#timeRecord').html('Time In');
					$('.record-success').removeClass('d-none');
				} else {
					$('#timeAction').addClass('d-none');
				}
			});
		});
		$('#validateEmployee').on('click', '#validate ', function(event) {
			$('.record-success').addClass('d-none');
			$('.welcome-note').removeClass('d-none');
			var id = $("#validateEmployee #id").val();
			var d = {
				id: id,
			};
			$.post('fetchEmployeeTimeRecord', d, function(result) {
				var result = $.parseJSON(result);
				if (result != false) {
					$('#employeeName').html(result.first_name + ', ' + result.last_name);
					$('#btnTimeIn').data('id', result.employee_id);
					$('#btnTimeOut').data('id', result.time_record_id);
					if (!result.time_in) {
						$('#timeIn').removeClass('d-none');
					}
					if (result.time_in) {
						$('#timeIn').addClass('d-none');
					} else {
						$('#timeIn').removeClass('d-none');
					}
					if (result.time_out) {
						$('#timeOut').addClass('d-none');
					} else {
						$('#timeOut').removeClass('d-none');
					}
					if (result.time_in && result.time_out) {
						$('#timeIn').removeClass('d-none')
					}
					$('#timeAction').removeClass('d-none');
				} else {
					$('#timeAction').addClass('d-none');
				}
			});
			$('#timeAction').addClass('d-none');
		});
		$('#QRmachine').on('click', function() {
			var id = $("#validateEmployee #id").val();
			if (!id) {
				alert('Please enter employee ID.');
				return false;
			}
			var d = {
				id: id,
			};
			$.post('employeeTimeRecord', d, function(result) {
				var result = $.parseJSON(result);
				if (result != false) {
					$('#validateEmployee #id').val("");
					$('.welcome-note').addClass('d-none');
					$('#timeAction').addClass('d-none');
					$('#timeRecord').html(result['time_record_type']);
					$('.record-success').removeClass('d-none');
				} else {
					$('#timeAction').addClass('d-none');
				}
			});
		});
	</script>
</body>

</html>