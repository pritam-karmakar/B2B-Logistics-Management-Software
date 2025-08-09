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
		            <h3 class="card-title">Roles</h3>
		        </div>
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-4">
		                    <form id="submitRoleForm" action="actions.php" method="POST">
                                <label>Role</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" name="roleName" placeholder="Enter Role" required>
									<button class="btn btn-primary btn-sm" type="submit" name="opModSub">Submit</button>
                                </div>
                                
                                <button data-bs-toggle="modal" class="openRoleMod" data-bs-target=".bd-example-modal-lg" style="display: none;"></button>
                                <!-- modal -->
                    			<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <form action="actions" method="POST">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add roles</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">MAIN MENU</h2></div>
                                                    <div class="row">
                                                        <h4><b>Dashboard</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Dashboard" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Dashboard
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Users</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Add user" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Add user
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Users list" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Users list
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Branches</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Add branch" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Add branch
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Branches list" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Branches list
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>My Orders</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="View all orders" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>View all orders
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Edit LR" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Edit LR
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Bulk update LR weight" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Bulk update LR weight
                                                        </div>
                                                    </div>
                                                    <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">USER CONTROL</h2></div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Branch Control" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Branch Control
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Stationary Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Stationary Master
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Stationary Allotment" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Stationary Allotment
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Ref. Number Allotment" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Ref. Number Allotment
                                                        </div>
                                                    </div>
                                                    <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">ACCOUNTS</h2></div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Ledger" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Ledger
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Billing" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Billing
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Credit Control" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Credit Control
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Cash Book" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Cash Book
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Salary" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Salary
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Franchise To Pay Remittance" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Franchise To Pay Remittance
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="COD Remittance" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>COD Remittance
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Bulk Broker Commission" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Bulk Broker Commission
                                                        </div>
                                                    </div>
                                                    <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">REPORT</h2></div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Booking Report" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Booking Report
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Bill Report" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Bill Report
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="TDS Report" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>TDS Report
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Outstanding Report" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Outstanding Report
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Branch Report" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Branch Report
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Broker Report" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Broker Report
                                                        </div>
                                                    </div>
                                                    <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">Company Master</h2></div>
                                                    <div class="row">
                                                        <h4><b>Company Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Company Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Company Master
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Employee Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Add employee" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Add employee
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Employees list" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Employees list
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Role Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Role Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Role Master
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Fright Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Fright Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Fright Master
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Item Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Item Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Item Master
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Ware House Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Ware House Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Ware House Master
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Party Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Party Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Party Master
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Bank Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Bank Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Bank Master
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Zone Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="States" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>States
                                                        </div>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="PIN Codes" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>PIN Codes
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Tax Rate Master</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Tax Rate Master" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Tax Rate Master
                                                        </div>
                                                    </div>
                                                    <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">OTHER FEATURES</h2></div>
                                                    <div class="row">
                                                        <h4><b>Add Money Requests</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Add Money Requests" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Add Money Requests
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Tasks</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Tasks" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Tasks
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Apointments</b></h4>
                                                        <div class="row">
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Appointment Users" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Appointment Users
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Appointment Branches" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Appointment Branches
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Ticket Category</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Ticket Category" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Ticket Category
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Ticket Sub Category</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Ticket Sub Category" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Ticket Sub Category
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <h4><b>Support Tickets</b></h4>
                                                        <div class="col-md-4 col-6 d-flex mb-4">
                                                            <input type="checkbox" id="branchwise" value="Support Tickets" name="roles[]" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                            <label for="branchwise" style="cursor: pointer;"></label>Support Tickets
                                                        </div>
                                                    </div>
                                                </div>
                                		        <div class="modal-footer d-flex" style="justify-content: space-between;">
                                		            <button class="btn btn-danger btn-sm" type="reset">Reset <i class="bi bi-repeat"></i></button>
                                		            <button class="btn btn-sm" type="submit" name="submitEmpRoles" style="background-color: #28a745; color: #fff;">Submit <i class="bi bi-patch-check-fill"></i></button>
                                		        </div>
                                            </div>
                                        </form>
                    		        </div>
                		        </div>
                		        <!-- /.modal -->
                                
                            </form>
		                </div>
		            </div>
		        </div>
		        <hr/>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>Item</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $condArr = array('delete_status'=>'show');
                                    $getitems = $query->getData("*","roles","",$condArr,"","","");
                                    if($getitems != 0){
                                        foreach($getitems as $var){
                                            $rolearray = explode(",",$var['roles']);
                    		    ?>
                        			<tr>
                        				<td><?= $var['role_name']; ?></td>
                        				<td>
                        				    <div class="d-flex">
    											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target=".modalofrolemaster<?= $var['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
    											<form action="actions" method="POST">
    											    <input type="hidden" value="<?= $var['id']; ?>" name="orderItemOwner" readonly>
    											    <button type="submit" class="btn btn-danger shadow btn-xs sharp" name="deleteOrderItem" onclick="return confirm('Are you sure to want to delete this item?')"><i class="fa fa-trash"></i></button>
    											</form>
    										</div>
                        				</td>
                        			</tr>
                        			
                                    <!-- modal -->
                        			<div class="modal fade modalofrolemaster<?= $var['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <form action="actions" method="POST">
                                                <input type="hidden" value="<?= $var['role_name']; ?>" name="roleIs">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add roles</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row col-md-4">
                                                            <label>Role</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control form-control-sm" name="roleName" placeholder="Enter Role" value="<?= $var['role_name']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">MAIN MENU</h2></div>
                                                        <div class="row">
                                                            <h4><b>Dashboard</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Dashboard" name="roles[]" class="branchwise" <?php if(in_array("Dashboard", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Dashboard
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Users</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Add user" name="roles[]" class="branchwise" <?php if(in_array("Add user", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Add user
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Users list" name="roles[]" class="branchwise" <?php if(in_array("Users list", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Users list
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Branches</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Add branch" name="roles[]" class="branchwise" <?php if(in_array("Add branch", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Add branch
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Branches list" name="roles[]" class="branchwise" <?php if(in_array("Branches list", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Branches list
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>My Orders</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="View all orders" name="roles[]" class="branchwise" <?php if(in_array("View all orders", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>View all orders
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Edit LR" name="roles[]" class="branchwise" <?php if(in_array("Edit LR", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Edit LR
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Bulk update LR weight" name="roles[]" class="branchwise" <?php if(in_array("Bulk update LR weight", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Bulk update LR weight
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">USER CONTROL</h2></div>
                                                        <div class="row">
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Branch Control" name="roles[]" class="branchwise" <?php if(in_array("Branch Control", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Branch Control
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Stationary Master" name="roles[]" class="branchwise" <?php if(in_array("Stationary Master", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Stationary Master
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Stationary Allotment" name="roles[]" class="branchwise" <?php if(in_array("Stationary Allotment", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Stationary Allotment
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">ACCOUNTS</h2></div>
                                                        <div class="row">
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Ledger" name="roles[]" class="branchwise" <?php if(in_array("Ledger", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Ledger
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Billing" name="roles[]" class="branchwise" <?php if(in_array("Billing", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Billing
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Branch Control" name="roles[]" class="branchwise" <?php if(in_array("Branch Control", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Branch Control
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Cash Book" name="roles[]" class="branchwise" <?php if(in_array("Cash Book", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Cash Book
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Salary" name="roles[]" class="branchwise" <?php if(in_array("Salary", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Salary
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">REPORT</h2></div>
                                                        <div class="row">
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Booking Report" name="roles[]" class="branchwise" <?php if(in_array("Booking Report", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Booking Report
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Bill Report" name="roles[]" class="branchwise" <?php if(in_array("Bill Report", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Bill Report
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="TDS Report" name="roles[]" class="branchwise" <?php if(in_array("TDS Report", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>TDS Report
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Outstanding Report" name="roles[]" class="branchwise" <?php if(in_array("Outstanding Report", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Outstanding Report
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Branch Report" name="roles[]" class="branchwise" <?php if(in_array("Branch Report", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Branch Report
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Broker Report" name="roles[]" class="branchwise" <?php if(in_array("Broker Report", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Broker Report
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">Company Master</h2></div>
                                                        <div class="row">
                                                            <h4><b>Employee Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Add employee" name="roles[]" class="branchwise" <?php if(in_array("Add employee", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Add employee
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Employees list" name="roles[]" class="branchwise" <?php if(in_array("Employees list", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Employees list
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Role Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Role Master" name="roles[]" class="branchwise" <?php if(in_array("Role Master", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Role Master
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Fright Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Fright Master" name="roles[]" class="branchwise" <?php if(in_array("Fright Master", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Fright Master
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Item Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Item Master" name="roles[]" class="branchwise" <?php if(in_array("Item Master", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Item Master
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Ware House Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Ware House Master" name="roles[]" class="branchwise" <?php if(in_array("Ware House Master", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Ware House Master
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Party Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Party Master" name="roles[]" class="branchwise" <?php if(in_array("Party Master", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Party Master
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Bank Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Bank Master" name="roles[]" class="branchwise" <?php if(in_array("Bank Master", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Bank Master
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Zone Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="States" name="roles[]" class="branchwise" <?php if(in_array("States", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>States
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Cities" name="roles[]" class="branchwise" <?php if(in_array("Cities", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Cities
                                                            </div>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="PIN Codes" name="roles[]" class="branchwise" <?php if(in_array("PIN Codes", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>PIN Codes
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Tax Rate Master</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Tax Rate Master" name="roles[]" class="branchwise" <?php if(in_array("Tax Rate Master", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Tax Rate Master
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex" style="text-align: center;"><h2 style="font-weight: bold;">OTHER FEATURES</h2></div>
                                                        <div class="row">
                                                            <h4><b>Add Money Requests</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Add Money Requests" name="roles[]" class="branchwise" <?php if(in_array("Add Money Requests", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Add Money Requests
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Tasks</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Tasks" name="roles[]" class="branchwise" <?php if(in_array("Tasks", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Tasks
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Apointments</b></h4>
                                                            <div class="row">
                                                                <div class="col-md-4 col-6 d-flex mb-4">
                                                                    <input type="checkbox" id="branchwise" value="Appointment Users" name="roles[]" class="branchwise" <?php if(in_array("Appointment Users", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                    <label for="branchwise" style="cursor: pointer;"></label>Appointment Users
                                                                </div>
                                                                <div class="col-md-4 col-6 d-flex mb-4">
                                                                    <input type="checkbox" id="branchwise" value="Appointment Branches" name="roles[]" class="branchwise" <?php if(in_array("Appointment Branches", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                    <label for="branchwise" style="cursor: pointer;"></label>Appointment Branches
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Ticket Category</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Ticket Category" name="roles[]" class="branchwise" <?php if(in_array("Ticket Category", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Ticket Category
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Ticket Sub Category</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Ticket Sub Category" name="roles[]" class="branchwise" <?php if(in_array("Ticket Sub Category", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Ticket Sub Category
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h4><b>Support Tickets</b></h4>
                                                            <div class="col-md-4 col-6 d-flex mb-4">
                                                                <input type="checkbox" id="branchwise" value="Support Tickets" name="roles[]" class="branchwise" <?php if(in_array("Support Tickets", $rolearray)){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                                <label for="branchwise" style="cursor: pointer;"></label>Support Tickets
                                                            </div>
                                                        </div>
                                                    </div>
                                    		        <div class="modal-footer d-flex" style="justify-content: space-between;">
                                    		            <button class="btn btn-danger btn-sm" type="reset">Reset <i class="bi bi-repeat"></i></button>
                                    		            <button class="btn btn-warning btn-sm" type="submit" name="updateEmpRoles">Save Changes <i class="bi bi-pen-fill"></i></button>
                                    		        </div>
                                                </div>
                                            </form>
                        		        </div>
                    		        </div>
                    		        <!-- /.modal -->
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