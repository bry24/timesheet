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
						<a class="nav-link" href="<?php echo base_url()."admin/employees";?>">Employees</a>
					</li> 
          <li class="nav-item">
						<a class="nav-link active" href="<?php echo base_url()."admin/users";?>">Users</a>
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
						<button class="nav-link border border-primary active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Users List</button>
						<button class="nav-link border border-primary" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Add User</button>
					</nav>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-12 col-md-8">
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active table-responsive-sm" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
							<table class="table table-striped" id="userTable">
								<thead class="table-dark">
									<tr>
										<th scope="col"></th>
										<th scope="col">#</th>
										<th scope="col">Username</th>
										<th scope="col">Type</th>
										<th scope="col">Date Created</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<button type="submit" class="btn btn-danger d-none bulk-delete" id="bulkDelete">Bulk Delete</button>
						</div>
						<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
							<div class="row justify-content-center">
								<div class="col-12 col-md-6">
									<div class="card">
										<div class="card-header bg-dark text-white fw-bold"> Add User </div>
										<div class="card-body">
											<form method="post" autocomplete="off" action="<?=base_url('admin/addUser');?>">
												<div class="mb-3">
													<label for="username" class="form-label">Username</label>
													<input type="text" name="username" class="form-control" id="username" required>
												</div>
												<div class="mb-3">
													<label for="password" class="form-label w-100">Password <small class="float-end text-grey"><a class="gen-pass-btn" data-id="2" href="javascript:;">Click here to generate password</a></small></label>
													<input type="password" name="password" class="form-control" id="password2" data-id="2" required>
													<div class=""><input type="checkbox" onclick="togglePassword(2)"> Show password</div>
													<p class="text-danger d-none" id="passwordChecker2">Password mush contain a lowercase, uppercase, number, special character and minimum of 10 characters.</p>
												</div>
												<div class="mb-3">
													<label for="usertype" class="form-label">User Type</label>
													<select name="usertype" class="form-select" aria-label="Default select example" required>
														<option selected>User Type</option>
														<option value="2" selected>Admin</option>
														<option value="1">Super Admin</option>
													</select>
												</div>
                        <div class="row">
                          <div class="col-6">
												      <button type="reset" class="btn btn-secondary w-100">Reset</button> 
                          </div>
                          <div class="col-6">
												    <button type="submit" id="submit2" class="btn btn-primary w-100">Submit</button> 
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
			</div>
		</div>
	</section>
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="updateUser" method="post" autocomplete="off" action="<?=base_url('admin/updateUser');?>">
					<div class="modal-header bg-dark text-white">
						<h5 class="modal-title fw-bold" id="editModalLabel">Edit User</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label for="username" class="form-label">Username</label>
							<input type="text" name="username" class="form-control" id="username" required>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label w-100">Password <small class="float-end text-grey"><a class="gen-pass-btn" data-id="1" href="javascript:;">Click here to generate password</a></small></label>
							<input type="password" name="password" class="form-control" id="password1" placeholder="Optional" data-id="1">
							<div class=""><input type="checkbox" onclick="togglePassword(1)"> Show password</div>
							<p class="text-danger d-none" id="passwordChecker1">Password mush contain a lowercase, uppercase, number, special character and minimum of 10 characters.</p>
						</div>
						<div class="mb-3">
							<label for="usertype" class="form-label">User Type</label>
							<select name="usertype" class="form-select" id="usertype" required>
								<option value="2">Admin</option>
								<option value="1">Super Admin</option>
							</select>
						</div>
						<input type="hidden" name="id" id="id" value="">
						<input type="hidden" name="trid" id="trid" value=""> <?php
          if($this->session->flashdata('success')) {	?> <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p> <?php } ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" id="submit1" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="deleteUser" method="post" autocomplete="off" action="<?=base_url('admin/deleteUser');?>">
					<div class="modal-header bg-dark text-white">
						<h5 class="modal-title fw-bold" id="deleteModalLabel">Delete</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<p>Are you sure you want to delete this user: <span id="user_name" class="fw-bold"></span></p>
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
	<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="deleteUsers" method="post" autocomplete="off" action="<?=base_url('admin/deleteUser?multiDelete=1');?>">
					<div class="modal-header bg-dark text-white">
						<h5 class="modal-title fw-bold" id="bulkDeleteModalModalLabel">Delete</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<p>Are you sure you want to delete these users?</p>
						</div>
						<input type="hidden" name="user_ids" id="user_ids" value="">
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
	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
	<script>
		$(document).ready(function() {
			$('#userTable').DataTable({
				"fnCreatedRow": function(nRow, aData, iDataIndex) {
					$(nRow).attr('id', aData[0]);
				},
				// 'serverSide': 'true',
				'processing': 'true',
				'paging': 'true',
				'order': [],
				'ajax': {
					'url': 'fetchUsers',
					'type': 'post',
				},
				"columnDefs": [{
					"orderable": false
				}]
			});
		});
		$('#userTable').on('click', '.editbtn ', function(event) {
			var trid = $(this).closest('tr').attr('id');
			var id = $(this).data('id');
			$('#editModal').modal('show');
			var d = {
				id: id,
			};
			$.post('fetchSingleUser', d, function(result) {
				var result = $.parseJSON(result);
				$('#updateUser #username').val(result.user_name);
				$('#updateUser #usertype').val(result.user_type);
				$('#updateUser #password1').val('');
				$('#updateUser #id').val(id);
				$('#updateUser #trid').val(trid);
			});
		});
		$('#userTable').on('click', '.deleteBtn ', function(event) {
			var trid = $(this).closest('tr').attr('id');
			var id = $(this).data('id');
			$('#deleteModal').modal('show');
			var d = {
				id: id,
			};
			$.post('fetchSingleUser', d, function(result) {
				var result = $.parseJSON(result);
				$('#deleteUser #id').val(id);
				$('#deleteUser #user_name').html(result.user_name);
				$('#deleteUser #trid').val(trid);
			});
		});
		$('.gen-pass-btn').click(function() {
			var id = $(this).data('id');
			var password = generatePassword();
			$("#password" + id).val(password);
		});
		$("#password1, #password2").keyup(function() {
			var password_id = $(this).attr('id');
			var id = $(this).data('id');
			var password = $("#" + password_id).val();
			var isvalidpassword = validatePassword(password);
			if (isvalidpassword) {
				$("#passwordChecker" + id).addClass('d-none');
			} else {
				$("#passwordChecker" + id).removeClass('d-none');
			}
      var password = $(this).val();
      if(password){
        if(isvalidpassword){
          $('#submit'+id).removeAttr('disabled');
        }
        else{
          $('#submit'+id).attr('disabled','disabled');
        }
      }
      else{
        if(id == 1){
          $('#submit'+id).removeAttr('disabled');
        }
      }
		});
    $('#userTable').on('click', '.checkboxes ', function() {
			var displayBultDelete = false;
			var user_ids = new Array();
			$('.checkboxes').each(function(k) {
				var isChecked = $(this).prop('checked');
				var id = $(this).data('id');
				if(isChecked || displayBultDelete){
					$('#bulkDelete').removeClass('d-none');
					displayBultDelete = true;
					if(isChecked){
						user_ids.push(id);
					}
				}
				else{
					$('#bulkDelete').addClass('d-none');
				}
			});
			$('#user_ids').val(user_ids);
		});
		$('#bulkDelete').on('click',  function(event) {
			var ids = $('#user_ids').val();
			$('#bulkDeleteModal').modal('show');
			var d = {
				ids: ids,
			};
		});
		function togglePassword(id) {
			var x = $("#password" + id).attr('type');
			var type = "";
			if (x === "password") {
				type = "text";
			} else {
				type = "password";
			}
			$("#password" + id).attr('type', type);
		}

		function validatePassword(password) {
			var hasLower = /[a-z]/.test(password);
			var hasUpper = /[A-Z]/.test(password);
			var hasNumber = /\d/.test(password);
			var hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
			var hasLength = password.length >= 10;
			return hasLower && hasUpper && hasNumber && hasSpecial && hasLength;
		}

		function generatePassword() {
			const lowercase = 'abcdefghijklmnopqrstuvwxyz';
			const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			const numbers = '0123456789';
			const specials = '!@#$%^&*()_-+=[]{};:\'"\|,.<>/?';
			const allChars = lowercase + uppercase + numbers + specials;
			let password = '';
			password += lowercase.charAt(Math.floor(Math.random() * lowercase.length));
			password += uppercase.charAt(Math.floor(Math.random() * uppercase.length));
			password += numbers.charAt(Math.floor(Math.random() * numbers.length));
			password += specials.charAt(Math.floor(Math.random() * specials.length));
			for (let i = 4; i < 10; i++) {
				password += allChars.charAt(Math.floor(Math.random() * allChars.length));
			}
			return password;
		}
	</script>
</body>

</html>