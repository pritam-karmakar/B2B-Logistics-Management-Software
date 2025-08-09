<?php
if(isset($_GET['employee'])){
    extract($_GET);
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
    		    <?php
    		        $arrCond = array('employee_code'=>$employee);
    		        $getemp = $query->getData('*','employees','',$arrCond,'id','DESC','')[0];
    		    ?>
		        <div class="card-header">
		            <h3 class="card-title">Edit <?= $getemp['designation']; ?> - <?= $getemp['employee_name']; ?> (<?= $getemp['employee_code'];  ?>)</h3>
		        </div>
		        <form action="actions" method="POST" class="card-body" enctype="multipart/form-data">
		            <input type="hidden" name="employee" value="<?= $getemp['employee_code']; ?>" readonly>
		            <div class="row">
		                <div class="col-md-4 mb-3">
		                    <label>Employee Name</label>
		                    <input type="text" class="form-control" placeholder="Enter Employee Name" name="employee_name" value="<?= $getemp['employee_name']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Mobile No.</label>
		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile No." name="mobile_no" value="<?= $getemp['mobile_no']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Email</label>
		                    <input type="email" class="form-control" placeholder="Enter Email Address" name="email" value="<?= $getemp['email']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Address</label>
		                    <input type="text" class="form-control" placeholder="Enter Address" name="address" value="<?= $getemp['address']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>City</label>
		                    <input type="text" class="form-control" placeholder="Enter City" name="city" value="<?= $getemp['city']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>District</label>
		                    <input type="text" class="form-control" placeholder="Enter District" name="district" value="<?= $getemp['district']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>State</label>
		                    <input type="text" class="form-control" placeholder="Enter State" name="state" value="<?= $getemp['state']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Pin Code</label>
		                    <input type="text" class="form-control" placeholder="Enter Pin Code" name="pincode" value="<?= $getemp['pincode']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Designation</label>
		                    <select name="designation" class="form-control">
                                <option value="" hidden>Choose Designation</option>
                                <?php
                                    $getroles = $query->getData("*","roles","","","","","");
                                    foreach($getroles as $role){
                                ?>
                                    <option value="<?= $role['id']; ?>" <?php if($role['id'] == $getemp['designation']){echo "selected";} ?>><?= $role['role_name']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
		                    <!--<input type="text" class="form-control" placeholder="Enter Designation" name="designation" value="<?= $getemp['designation']; ?>">-->
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Aadhaar No.</label>
		                    <input type="number" class="form-control" placeholder="Enter Aadhaar No." name="aadhaar_no" value="<?= $getemp['aadhaar_no']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Pan card No.</label>
		                    <input type="text" class="form-control" placeholder="Enter Pan card No." name="pan_no" value="<?= $getemp['pan_no']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Salary</label>
		                    <input type="text" class="form-control" placeholder="Enter Salary" name="salary" value="<?= $getemp['salary']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Over Time Rate (Day)</label>
		                    <input type="number" class="form-control" placeholder="Enter Overtime rate day basis" name="ot_day" value="<?= $getemp['ot_day']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Over Time Rate (Hours)</label>
		                    <input type="number" class="form-control" placeholder="Enter Overtime rate Hourly basis" name="ot_hour" value="<?= $getemp['ot_hour']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Allowances</label>
		                    <input type="number" class="form-control" placeholder="Enter Allowances" name="allowances" value="<?= $getemp['allowances']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Casual Leaves</label>
		                    <input type="number" class="form-control" placeholder="Enter CL" name="cl" value="<?= $getemp['cl']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Paid Leaves</label>
		                    <input type="number" class="form-control" placeholder="Enter PL" name="pl" value="<?= $getemp['pl']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Sick Leaves</label>
		                    <input type="number" class="form-control" placeholder="Enter SL" name="sl" value="<?= $getemp['sl']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Bank Name</label>
		                    <input type="text" class="form-control" placeholder="Enter Bank Name" name="bank" value="<?= $getemp['bank']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>IFSC</label>
		                    <input type="text" class="form-control" placeholder="Enter IFSC" name="ifsc" value="<?= $getemp['ifsc']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Account No</label>
		                    <input type="number" class="form-control" placeholder="Enter Account Number" name="account_no" value="<?= $getemp['account_no']; ?>">
		                </div>
		                <div class="col-md-6 mb-3">
		                    <label>Documents</label>
		                    <input type="file" class="form-control" name="documents[]" multiple>
		                </div>
		                <div class="col-md-12 row mb-3 mt-3">
		                    <?php
		                        $doms = explode("|", $getemp['documents']);
		                        for($i = 0; $i < count($doms); $i++):
		                            echo "<div class='col-md-2'><a href='../storage/employees/".$doms[$i]."' target='_blank' style='background-color: #222b40; color: #fff; padding: 7px 26px; border-radius: 8px; margin: 0px 16px;'>Image ".($i+1)."</a><input type='hidden' name='oldFiles[]' value='".$doms[$i]."'><button type='button' name='crossForImg' class='btn btn-outline-danger btn-xs sharp me-1'><i class='bi bi-x-circle-fill'></i></button></div>";
		                        endfor;
		                    ?>
		                </div>
		                <div class="row d-flex justify-content-end">
	                        <button class="col-md-2 col-5 btn btn-warning" type="submit" name="updateaEmployee">Save Changes <i class="bi bi-pen-fill"></i></button>
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
}else{
    header('location:employee-master');
}
?>