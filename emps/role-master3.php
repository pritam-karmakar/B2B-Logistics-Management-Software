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
		            <h3 class="card-title">Role Master</h3>
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
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $aarrrr = array('delete_status'=>'show');
                    		        $employee = $query->getData('*','employees','',$aarrrr,'id','DESC','');
                    		        if($employee != 0){
                        		        foreach($employee as $getemp){
                    		    ?>
                    			<tr>
                    				<td><?= $getemp['employee_code']; ?></td>
                    				<td><?= $getemp['employee_name']; ?></td>
                    				<td><?= $getemp['mobile_no']; ?></td>
                    				<td><?= $getemp['email']; ?></td>
                    				<td><?= $getemp['designation']; ?></td>
                    				<td>
                    				    <div class="d-flex justify-content-start">
											<a href="#" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg<?= $getemp['id']; ?>" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
										</div>
                    				</td>
                    			</tr>
                    			
                    			<div class="modal fade bd-example-modal-lg<?= $getemp['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <form action="actions" method="POST">
                                            <input type="hidden" value="<?= $getemp['employee_code']; ?>" name="empCode">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit role master for <?= $getemp['employee_name']; ?> (<?= $getemp['employee_code'];  ?>)</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <h4><b>My Orders</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="View all orders" name="roles[]" class="branchwise" <?php if(in_array("View all orders", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>View all orders
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Create new order" name="roles[]" class="branchwise" <?php if(in_array("Create new order", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Create new order
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Bulk create order" name="roles[]" class="branchwise" <?php if(in_array("Bulk create order", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Bulk create order
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>Manage Exceptions</b></h4>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Request Pickup" name="roles[]" class="branchwise" <?php if(in_array("Request Pickup", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Request Pickup
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Self Drop" name="roles[]" class="branchwise" <?php if(in_array("Self Drop", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Self Drop
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>Helpdesk</b></h4>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Ticket" name="roles[]" class="branchwise" <?php if(in_array("Ticket", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Ticket
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Task" name="roles[]" class="branchwise" <?php if(in_array("Task", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Task
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>Delivery Preferences</b></h4>
                                                        <div class="col-12 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Manage Appointment" name="roles[]" class="branchwise" <?php if(in_array("Manage Appointment", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Manage Appointment
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>Pre-Order Enquiry</b></h4>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Check Serviceability" name="roles[]" class="branchwise" <?php if(in_array("Check Serviceability", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Check Serviceability
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Freight Estimator" name="roles[]" class="branchwise" <?php if(in_array("Freight Estimator", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Freight Estimator
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>Update Documents</b></h4>
                                                        <div class="col-12 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Update Documents" name="roles[]" class="branchwise" <?php if(in_array("Update Documents", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Update Documents
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>My Facilities</b></h4>
                                                        <div class="col-12 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Manage Warehouses" name="roles[]" class="branchwise" <?php if(in_array("Manage Warehouses", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Manage Warehouses
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>Wallet</b></h4>
                                                        <div class="col-12 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Wallet" name="roles[]" class="branchwise" <?php if(in_array("Wallet", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Wallet
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>Pending Tasks</b></h4>
                                                        <div class="col-12 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Document Missing" name="roles[]" class="branchwise" <?php if(in_array("Document Missing", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Document Missing
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <h4><b>Performance Dashboard</b></h4>
                                                        <div class="col-12 d-flex">
                                                            <input type="checkbox" id="branchwise" value="Performance Dashboard" name="roles[]" class="branchwise" <?php if(in_array("Performance Dashboard", explode(",",$getemp['roles']))){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Performance Dashboard
                                                        </div>
                                                    </div>
                                                </div>
                                		        <div class="modal-footer d-flex" style="justify-content: space-between;">
                                		            <button class="btn btn-danger btn-sm" type="reset">Reset <i class="bi bi-repeat"></i></button>
                                		            <button class="btn btn-warning btn-sm" type="submit" name="submitEmpRoles">Save Changes <i class="bi bi-pen-fill"></i></button>
                                		        </div>
                                            </div>
                                        </form>
                    		        </div>
                		        </div>
                    			
                    			<?php
                        		        }
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