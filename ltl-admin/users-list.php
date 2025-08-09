<?php
if(!array_key_exists('visible', $_GET)){
    echo '<script type="text/javascript" language="javascript">window.location="users-list?visible=show";</script>';
}elseif(empty($_GET['visible'])){
    echo '<script>window.location = "users-list?visible=show";</script>';
}elseif($_GET['visible'] != "show" && $_GET['visible'] != "edit"){
    echo '<script>window.location = "users-list?visible=show";</script>';
}else{
    extract($_GET);
}
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
		            <h3 class="card-title">All Users</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th class="text-center">Party Details</th>
                    				<th class="text-center">Contact Details</th>
                    				<th class="text-center">Contact Person</th>
                    				<th class="text-center">Address</th>
                    				<th class="text-center">Wallet Balance</th>
                    				<?php
                    				    if($visible === "edit"){
                    				        echo '<th class="text-center">Main Actions</th>
                    				              <th class="text-center">Other Actions</th>
                            				      <th class="text-center">Status</th>';
                    				    }
                    				?>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $aarrrr = array('users`.`delete_status'=>'show');
                    		        $joinArr = array("0"=>array("LEFT","branches","branches","id","users","branch"));
                    		        $users = $query->getData('`users`.*,`branches`.`branch_name`','users',$joinArr,$aarrrr,'id','DESC','');
                    		        if($users != 0){
                        		        foreach($users as $getusers){
                    		    ?>
                    			<tr>
                    				<td class="text-center"><?= "<b>Name: </b>".$getusers['party_name']."<br/><b>Username: </b>".$getusers['username']; ?></td>
                    				<td class="text-center"><?= "<b>Mobile no.: </b>".$getusers['mobile_no']."<br/><b>Phone no.: </b>".$getusers['phone']."<br/><b>Email Id: </b>".$getusers['email']; ?></td>
                    				<td class="text-center"><?= $getusers['contact_person_name']; ?></td>
                    				<td class="text-center"><?= $getusers['address']; ?></td>
                    				<td class="text-center">₹<?php if(empty($getusers['wallet_balance'])){ echo 0; }else{ echo $getusers['wallet_balance']; } ?></td>
                    				<?php
                    				    if($visible === "edit"){
                    				?>
                    				<td class="text-center">
                    				    <div class="d-flex justify-content-center mb-2">
											<a href="edit-user?usrRef=<?= $getusers['username']; ?>" title="Edit" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                    				        <form action="actions" method="GET">
                    				            <input type="hidden" name="userName" value="<?= $getusers['username']; ?>" readonly>
											    <button type="submit" title="Delete" class="btn btn-danger shadow btn-xs sharp" name="deleteUser" onclick="return confirm('Are you sure to want to delete this user?')">
											        <i class="bi bi-trash-fill"></i>
											    </button>
											</form>
										</div>
                    				</td>
                    				<td class="text-center">
                    				    <div class="d-flex justify-content-center mb-2">
											<a href="ledger?visible=users&UsersorBranches=<?= $getusers['username']; ?>" title="Ledger" class="btn btn-info shadow btn-xs sharp me-1" style="margin-left: 4px;"><i class="bi bi-repeat"></i>
											</a>
											<a href="#" class="btn btn-success shadow btn-xs sharp me-1" title="Credit" data-bs-toggle="modal" data-bs-target="#modalofStationaryCredit<?= $getusers['username']; ?>">
											    <i class="fas fa-arrow-up"></i>
										    </a>
										    <a href="#" class="btn btn-danger shadow btn-xs sharp me-1" title="Debit" data-bs-toggle="modal" data-bs-target="#modalofStationaryDebit<?= $getusers['username']; ?>">
											    <i class="fas fa-arrow-down"></i>
										    </a>
										    <a href="#" class="btn shadow btn-primary btn-xs sharp me-1" title="Change Password" data-bs-toggle="modal" data-bs-target="#modalofChangePassword<?= $getusers['username']; ?>">
											    <i class="bi bi-key-fill"></i>
										    </a>
									        <button onclick="window.open('act?openAccUsernameFor=<?= $getusers['username']; ?>&openAccUsertype=users', '_blank')" class="btn shadow btn-xs sharp me-1" target="_blank" style="background: #f44103; color: #fff;" title="Direct login for : <?= $getusers['party_name']; ?>">
											    <i class="fas fa-sign-out-alt"></i>
										    </button>
										</div>
                    				</td>
                    				<td class="text-center">
                		                <div class="d-flex justify-content-center form-group" style="display: flex;">
                                            <input type="checkbox" id="branchwise<?= $getusers['id']; ?>" value="<?= $getusers['id']; ?>" class="checkboxunblock userStatus" <?php if($getusers['status'] == 'Unblock'){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                            <label for="branchwise<?= $getusers['id']; ?>" style="cursor: pointer;"></label>
                                        </div>
                    				</td>
                    			</tr>
                    			
                    			<!-- Credit Modal -->
                                <div class="modal fade" id="modalofStationaryCredit<?= $getusers['username']; ?>">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="actions" method="POST">
                                                <input type="hidden" name="user_type" value="users" readonly>
                                                <input type="hidden" name="username" value="<?= $getusers['username']; ?>" readonly>
                                                <div class="modal-header bg-success">
                                                    <h5 class="modal-title text-white">Credit For User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Amount <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-sm numeric-decimal" name="credit_amount" placeholder="Enter credit amount" required>
                                                    </div>
                                                    <div class="form-group pt-2">
                                                        <label>Description <span class="text-danger">*</span></label>
                                                        <textarea class="form-control form-control-sm" name="description" placeholder="Enter transaction details" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex" style="justify-content: space-between;">
                                                    <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="addCredit" class="btn btn-sm" style="background-color: #28a745; color: #fff;">Credit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Debit Modal -->
                                <div class="modal fade" id="modalofStationaryDebit<?= $getusers['username']; ?>">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="actions" method="POST">
                                                <input type="hidden" name="user_type" value="users" readonly>
                                                <input type="hidden" name="username" value="<?= $getusers['username']; ?>" readonly>
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title text-white">Debit For User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Amount <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-sm numeric-decimal" name="debit_amount" placeholder="Enter debit amount" required>
                                                    </div>
                                                    <div class="form-group pt-2">
                                                        <label>Description <span class="text-danger">*</span></label>
                                                        <textarea class="form-control form-control-sm" name="description" placeholder="Enter transaction details" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex" style="justify-content: space-between;">
                                                    <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="addDebit" class="btn btn-sm" style="background-color: #28a745; color: #fff;">Debit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                    			
                                <!-- Change Password Modal -->
                                <div class="modal fade" id="modalofChangePassword<?= $getusers['username']; ?>">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="actions" method="POST">
                                                <input type="hidden" name="user_type" value="users" readonly>
                                                <input type="hidden" name="username" value="<?= $getusers['username']; ?>" readonly>
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title text-white">Change Password For User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group position-relative">
                                                        <label>Password <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control form-control-sm itspassword" minlength="6" name="password" placeholder="Enter password" required>
                                                        <span class="show-pass eye" style="right: 12px; top: 33px;">
                                                            <i class="bi bi-eye-slash-fill" style="font-size: 14px;"></i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group position-relative mt-2">
                                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control form-control-sm itspassword" minlength="6" name="confirmPassword" placeholder="Enter confirm password" required>
                                                        <span class="show-pass eye" style="right: 12px; top: 33px;">
                                                            <i class="bi bi-eye-slash-fill" style="font-size: 14px;"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex" style="justify-content: space-between;">
                                                    <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="saveChangesofPassword" class="btn btn-warning btn-sm">Save Changes <i class="bi bi-pen-fill"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                				<?php
                        				    }
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