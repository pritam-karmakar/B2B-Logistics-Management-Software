<?php
    include("assets/header.php");
    include("assets/sidebar.php");
    $id = 1;
    $condition = array("id"=>$id);
    $getAdmin = $query->getData("*","admin_login","",$condition,"","","");
?>
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<!-- row -->
				<div class="row">
					<div class="col-xl-8 col-lg-8">
						<div class="card profile-card card-bx m-b30">
							<div class="card-header">
								<h6 class="title">Change Password</h6>
							</div>
							<form action="actions.php" method="POST">
								<div class="card-body">
									<div class="row">
										<input type="hidden" class="form-control" name="id" value="<?= $getAdmin[0]['id']; ?>">
										<div class="col-sm-8 m-b30">
											<label class="form-label">Password</label>
											<input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password" autofocus required/>
										</div>
										<div class="col-sm-8 m-b30">
											<label class="form-label">Confirm Password</label>
											<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" autofocus required/>
                                            <span id="message"></span>
										</div>
										
									</div>
								</div>
								<div class="card-footer">
									<button type="submit" class="btn btn-primary" name="changePassword">Update</button>
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