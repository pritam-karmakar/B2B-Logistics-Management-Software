<?php
include("assets/header.php");
include("assets/sidebar.php");
$getEmails = $query->getData('*','company_master','',array('id'=>'1'),'id','DESC','1')[0];
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">Update Company Details</h3>
		        </div>
		        <form action="actions" method="POST" class="card-body">
		            <div class="row">
		                <div class="col-md-6 mb-3">
		                    <label>6CFT Password</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control bg-light" value="KINGFISHLOGB2BC" disabled>
    		                    <input type="password" class="form-control itspassword" placeholder="Enter New Password" name="passwordOf6CFT">
                                <span class="input-group-text"><i class="bi bi-eye-slash-fill"></i></span>
    		                </div>
		                </div>
		                <div class="col-md-6 mb-3">
		                    <label>8CFT Password</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control bg-light" value="KINGFISHLOGISTIC08B2BC" disabled>
    		                    <input type="password" class="form-control itspassword" placeholder="Enter New Password" name="passwordOf8CFT">
                                <span class="input-group-text"><i class="bi bi-eye-slash-fill"></i></span>
    		                </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>10CFT Password</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control bg-light" value="KINGFISH10B2BC" disabled>
    		                    <input type="password" class="form-control itspassword" placeholder="Enter New Password" name="passwordOf10CFT">
                                <span class="input-group-text"><i class="bi bi-eye-slash-fill"></i></span>
    		                </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Email Id</label>
		                    <input type="text" class="form-control" placeholder="Enter Email Address" name="emailAddress" value="<?= $getEmails['email_id']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Email Id's Password</label>
		                    <div class="input-group">
    		                    <input type="password" class="form-control itspassword" placeholder="Enter Email Address Password" name="passwordOfemailAddress">
                                <span class="input-group-text"><i class="bi bi-eye-slash-fill"></i></span>
                            </div>
		                </div>
		                <div class="row d-flex justify-content-end">
	                        <button class="col-md-2 col-5 btn btn-warning btn-xs" type="submit" name="saveCompanyMaster">Save Changes <i class="bi bi-pen-fill"></i></button>
		                </div>
		            </div>
		        </form>
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