<?php
    include("assets/header.php");
    include("assets/sidebar.php");
?>
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<!-- row -->
				<div class="row">
					<div class="col-xl-12 col-lg-12">
						<div class="card profile-card card-bx m-b30">
							<div class="card-header">
								<h6 class="title">Admin Profile</h6>
							</div>
							<form action="actions.php" method="POST">
								<div class="card-body">
									<div class="row">
										<input type="hidden" class="form-control" name="id" value="<?= $getdetails[0]['id']; ?>">
										<div class="col-sm-12 m-b30">
											<label class="form-label">Name</label>
											<input type="text" class="form-control" name="name" value="<?= $getdetails[0]['name']; ?>">
										</div>
										<div class="col-sm-6 m-b30">
											<label class="form-label">Mobile</label>
											<input type="number" class="form-control" name="mobile" value="<?= $getdetails[0]['mobile']; ?>">
										</div>
										<div class="col-sm-6 m-b30">
											<label class="form-label">Email</label>
											<input type="text" class="form-control" name="email" value="<?= $getdetails[0]['email']; ?>">
										</div>
										<div class="col-sm-12 m-b30">
											<label class="form-label">Address</label>
											<input type="text" class="form-control" name="address" value="<?= $getdetails[0]['address']; ?>">
										</div>
										<!--<div class="col-sm-6 m-b30">-->
										<!--	<label class="form-label">Gender</label>-->
										<!--	<select class="default-select form-control" id="validationCustom05">-->
										<!--		<option data-display="Select">Please select</option>-->
										<!--		<option value="html">Male</option>-->
										<!--		<option value="css">Female</option>-->
										<!--		<option value="javascript">Other</option>-->
										<!--	</select>-->
										<!--</div>-->
										<!--<div class="col-sm-6 m-b30">-->
										<!--	<label class="form-label">Birth</label>-->
										<!--	<div class="input-hasicon mb-xl-0 mb-3">-->
										<!--		<input class="form-control mb-xl-0 mb-3 bt-datepicker" type="text" id="datepicker">-->
										<!--		<div class="icon"><i class="far fa-calendar"></i></div>-->
										<!--	</div>-->
										<!--</div>-->
										<!--<div class="col-sm-6 m-b30">-->
										<!--	<label class="form-label">Country</label>-->
										<!--	<select class="default-select form-control" id="validationCustom01">-->
										<!--		<option data-display="Select">Please select</option>-->
										<!--		<option value="russia">Russia</option>-->
										<!--		<option value="canada">Canada</option>-->
										<!--		<option value="china">China</option>-->
										<!--		<option value="india">India</option>-->
										<!--	</select>-->
										<!--</div>-->
										<!--<div class="col-sm-6 m-b30">-->
										<!--	<label class="form-label">City</label>-->
										<!--	<select class="default-select form-control" id="validationCustom02">-->
										<!--		<option data-display="Select">Please select</option>-->
										<!--		<option>Krasnodar</option>-->
										<!--		<option>Tyumen</option>-->
										<!--		<option>Chelyabinsk</option>-->
										<!--		<option>Moscow</option>-->
										<!--	</select>-->
										<!--</div>-->
									</div>
								</div>
								<div class="card-footer">
									<button type="submit" class="btn btn-primary" name="updateProfile">Update</button>
									<!--<a href="page-forgot-password.html" class="btn-link">Forgot your password?</a>-->
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
<?php
    include("assets/footer.php");
?>