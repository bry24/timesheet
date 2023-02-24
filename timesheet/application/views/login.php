<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<title>Timesheet</title>
</head>

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-4">
				<div class="card">
					<div class="card-header"> Login </div>
					<div class="card-body">
						<form method="post" autocomplete="off" action="<?=base_url('admin/loginNow');?>">
							<div class="mb-3">
								<label for="exampleInputEmail1" class="form-label">Username</label>
								<input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1" class="form-label">Password</label>
								<input type="password" name="password" class="form-control" id="exampleInputPassword1">
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
							
							<?php
							if($this->session->flashdata('success')) {	?>
							<p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p>
							<?php } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Optional JavaScript; choose one of the two! -->
	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>