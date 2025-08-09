<?php
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">Add Employee Form</h3>
		        </div>
		        <form action="actions" method="POST" enctype="multipart/form-data" class="card-body">
		            <div class="row">
		                <div class="col-md-4 mb-3">
		                    <label>Employee Name</label>
		                    <input type="text" class="form-control" placeholder="Enter Employee Name" name="employee_name">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Mobile No.</label>
		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile No." name="mobile_no">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Email</label>
		                    <input type="email" class="form-control" placeholder="Enter Email Address" name="email">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Address</label>
		                    <input type="text" class="form-control" placeholder="Enter Address" name="address">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>City</label>
		                    <input type="text" class="form-control" placeholder="Enter City" name="city">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>District</label>
		                    <input type="text" class="form-control" placeholder="Enter District" name="district">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>State</label>
		                    <input type="text" class="form-control" placeholder="Enter State" name="state">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>PIN Code</label>
		                    <input type="text" class="form-control" placeholder="Enter PIN Code" name="pincode">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Designation</label>
		                    <select name="designation" class="form-control">
                                <option value="" hidden>Choose Designation</option>
                                <?php
                                    $getroles = $query->getData("*","roles","","","","","");
                                    foreach($getroles as $role){
                                ?>
                                    <option value="<?= $role['id']; ?>"><?= $role['role_name']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
		                    <!--<input type="text" class="form-control" placeholder="Enter Designation" name="designation">-->
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Aadhaar No.</label>
		                    <input type="number" class="form-control" placeholder="Enter Aadhaar No." name="aadhaar_no">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>PAN Card No.</label>
		                    <input type="text" class="form-control" placeholder="Enter PAN card No." name="pan_no">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Salary</label>
		                    <input type="text" class="form-control" placeholder="Enter Salary" name="salary">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Over Time Rate (Day)</label>
		                    <input type="number" class="form-control" placeholder="Enter Overtime rate day basis" name="ot_day">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Over Time Rate (Hours)</label>
		                    <input type="number" class="form-control" placeholder="Enter Overtime rate Hourly basis" name="ot_hour">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Allowances</label>
		                    <input type="number" class="form-control" placeholder="Enter Allowances" name="allowances">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Casual Leaves</label>
		                    <input type="number" class="form-control" placeholder="Enter CL" name="cl">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Paid Leaves</label>
		                    <input type="number" class="form-control" placeholder="Enter PL" name="pl">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Sick Leaves</label>
		                    <input type="number" class="form-control" placeholder="Enter SL" name="sl">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Bank Name</label>
		                    <input type="text" class="form-control" placeholder="Enter Bank Name" name="bank">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>IFSC</label>
		                    <input type="text" class="form-control" placeholder="Enter IFSC" name="ifsc">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Account No</label>
		                    <input type="number" class="form-control" placeholder="Enter Account Number" name="account_no">
		                </div>
		                <div class="col-md-6 mb-3">
		                    <label>Documents</label>
		                    <input type="file" class="form-control" name="documents[]" multiple>
		                </div>
		                <div class="row d-flex justify-content-end">
	                        <button class="col-md-1 col-5 btn btn-primary" type="submit" name="submitaEmployee">Submit</button>
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