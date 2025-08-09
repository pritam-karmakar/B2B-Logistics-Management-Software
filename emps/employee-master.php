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
		            <h3 class="card-title">All Employees</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>Employee Code</th>
                    				<th>Employee Name</th>
                    				<th>Mobile No.</th>
                    				<th>Email Id</th>
                    				<th>Designation</th>
                    				<th>Action</th>
                    				<th>Status</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $join = array("0"=>array("LEFT","roles","employees","designation","roles","id"));
                    		        $condArr = array("employees`.`delete_status"=>"show");
                    		        $empes = $query->getData("`employees`.*,`roles`.`role_name`","employees",$join,$condArr,"id","DESC","");
                    		        foreach($empes as $getemp){
                    		    ?>
                    				<td><?= $getemp['employee_code']; ?></td>
                    				<td><?= $getemp['employee_name']; ?></td>
                    				<td><?= $getemp['mobile_no']; ?></td>
                    				<td><?= $getemp['email']; ?></td>
                    				<td><?= $getemp['role_name']; ?></td>
                    				<td>
                    				    <div class="d-flex">
                    				        <form action="edit-employee" method="GET">
                    				            <input type="hidden" name="employee" value="<?= $getemp['employee_code']; ?>" readonly>
											    <button type="submit" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></button>
											</form>
                    				        <form action="actions" method="GET">
                    				            <input type="hidden" name="employeeCode" value="<?= $getemp['employee_code']; ?>" readonly>
											    <button type="submit" class="btn btn-danger shadow btn-xs sharp" name="deleteEmp" onclick="return confirm('Are you sure to want to delete this employee?')"><i class="fa fa-trash"></i></button>
											</form>
										</div>
                    				</td>
                    				<td>
                		                <div class="form-group" style="display: flex;">
                                            <input type="checkbox" id="branchwise<?= $getemp['id']; ?>" value="<?= $getemp['id']; ?>" class="checkboxunblock employeeStatus" <?php if($getemp['status'] == 'Unblock'){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                            <label for="branchwise<?= $getemp['id']; ?>" style="cursor: pointer;"></label>
                                        </div>
                    				</td>
                    			</tr>
                    			<?php
                    		        }
                    			?>
                    		</tbody>
                    	</table>
                    </div>
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