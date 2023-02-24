<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<title>Timesheet</title>
	<style>
		.contant-tabs:not(.active) {
			display: none;
		}

		.nav-link {
			border: 1px solid #0d6efd !important;
		}
	</style>
</head>

<body>
	<section class="mt-5">
		<div class="container">
		</div>
	</section>
	<section class="mt-5">
		<div class="container">
			<div id="tabs-2" class="contant-tabs active"> 
				<div class="row justify-content-center">
				<div class="col-12 col-md-4">
				<div class="card mt-5">
					<div class="card-header"> Login </div>
					<div class="card-body">
						<form method="post" autocomplete="off" action="<?=base_url('admin/loginUser');?>">
							<div class="mb-3">
								<label for="username" class="form-label">Username</label>
								<input type="text" name="username" class="form-control" id="username">
							</div>
							<div class="mb-3">
								<label for="password" class="form-label">Password</label>
								<input type="password" name="password" class="form-control" id="password">
							</div>
							<button type="submit" class="btn btn-primary w-100">Submit</button> <?php
									if($this->session->flashdata('success')) {	?> <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p> <?php } ?>
						</form>
					</div>
				</div>
				</div>
				</div>
			</div>
		</div>
		</div>
		</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
	<!-- Optional JavaScript; choose one of the two! -->
	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
	<script>
		$('.tab-nav').on('click', function() {
			$('.tab-nav').each(function() {
				$(this).removeClass('active');
			});
			$('.contant-tabs').each(function() {
				$(this).removeClass('active');
			});
			var ct = $(this).data('opentab');
			$(this).addClass('active');
			$("#tabs-" + ct).addClass('active');
		});
	</script>
</body>

</html>