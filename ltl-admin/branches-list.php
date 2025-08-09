<?php
if(!array_key_exists('visible', $_GET)){
    echo '<script type="text/javascript" language="javascript">window.location="branches-list?visible=view";</script>';
}elseif(empty($_GET['visible'])){
    echo '<script>window.location = "branches-list?visible=view";</script>';
}elseif($_GET['visible'] != "view" && $_GET['visible'] != "control"){
    echo '<script>window.location = "branches-list?visible=view";</script>';
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
		            <h3 class="card-title">All Branches</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th class="text-center">Branch Details</th>
                    				<th class="text-center">Contact Details</th>
                    				<th class="text-center">Contact Person</th>
                    				<th class="text-center">Address</th>
                    				<th class="text-center">Wallet Balance</th>
                    				<th class="text-center">Type</th>
                    				<?php
                    				    if($visible === "control"){
                    				        echo '<th class="text-center">Main Actions</th>
                        				          <th class="text-center">Other Actions</th>
                                				  <th class="text-center">Status</th>';
                    				    }
                    				?>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $condArr = array('delete_status'=>'show');
                    		        $branches = $query->getData('*','branches','',$condArr,'id','DESC','');
                    		        foreach($branches as $getbranches){
                    		    ?>
                    			<tr>
                    				<td class="text-center"><?= "<b>Name: </b>".$getbranches['branch_name']."<br/><b>Username: </b>".$getbranches['branch_user_name']; ?></td>
                    				<td class="text-center"><?= "<b>Mobile no.: </b>".$getbranches['mobile_no']."<br/><b>Phone no.: </b>".$getbranches['phone']."<br/><b>Email Id: </b>".$getbranches['email']; ?></td>
                    				<td class="text-center"><?= $getbranches['contact_person']; ?></td>
                    				<td class="text-center"><?= $getbranches['address']; ?></td>
                    				<td class="text-center">₹<?= $getbranches['wallet_balance']; ?></td>
                    				<td class="text-center"><?= ucwords($getbranches['type']); ?></td>
                    				<?php
                    				    if($visible === "control"){
                    				?>
                    				<td class="text-center">
                    				    <div class="d-flex justify-content-center">
                    				        <form action="edit-branch" method="GET">
                    				            <input type="hidden" name="username" value="<?= $getbranches['branch_user_name']; ?>" readonly>
											    <button type="submit" class="btn btn-warning shadow btn-xs sharp me-1" title="Edit Branch"><i class="fas fa-pencil-alt"></i></button>
											</form>
                    				        <form action="actions" method="GET">
                    				            <input type="hidden" name="branchbranch_user_name" value="<?= $getbranches['branch_user_name']; ?>" readonly>
											    <button type="submit" class="btn btn-danger shadow btn-xs sharp" title="Delete Branch" name="deleteBranch" onclick="return confirm('Are you sure to want to delete this branch?')"><i class="fa fa-trash"></i></button>
											</form>
										</div>
                    				</td>
                    				<td class="text-center">
                    				    <div class="d-flex justify-content-center">
											<a href="ledger?visible=branches&UsersorBranches=<?= $getbranches['branch_user_name']; ?>" title="Ledger" class="btn btn-info shadow btn-xs sharp me-1" style="margin-left: 4px;"><i class="bi bi-repeat"></i></a>
											<a href="#" class="btn btn-success shadow btn-xs sharp me-1" title="Credit" data-bs-toggle="modal" data-bs-target="#modalofStationaryCredit<?= $getbranches['branch_user_name']; ?>">
											    <i class="fas fa-arrow-up"></i>
										    </a>
										    <a href="#" class="btn btn-danger shadow btn-xs sharp me-1" title="Debit" data-bs-toggle="modal" data-bs-target="#modalofStationaryDebit<?= $getbranches['branch_user_name']; ?>">
											    <i class="fas fa-arrow-down"></i>
										    </a>
										    <a href="#" class="btn shadow btn-primary btn-xs sharp me-1" title="Change Password" data-bs-toggle="modal" data-bs-target="#modalofChangePassword<?= $getbranches['branch_user_name']; ?>">
											    <i class="bi bi-key-fill"></i>
										    </a>
    										<button onclick="window.open('act?openAccUsernameFor=<?= $getbranches['branch_user_name']; ?>&openAccUsertype=branches', '_blank')" class="btn shadow btn-xs sharp me-1" target="_blank" style="background: #f44103; color: #fff;" title="Direct login for : <?= $getbranches['branch_name']; ?>">
											    <i class="fas fa-sign-out-alt"></i>
										    </button>
										</div>
                    				</td>
                    				<td class="text-center">
                		                <div class="d-flex justify-content-center form-group" style="display: flex;">
                                            <input type="checkbox" id="branchwise<?= $getbranches['id']; ?>" value="<?= $getbranches['id']; ?>" class="checkboxunblock branchStatus" <?php if($getbranches['status'] == 'Unblock'){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                            <label for="branchwise<?= $getbranches['id']; ?>" style="cursor: pointer;"></label>
                                        </div>
                    				</td>
                    			</tr>
                                
                                <!-- Credit Modal -->
                                <div class="modal fade" id="modalofStationaryCredit<?= $getbranches['branch_user_name']; ?>">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="actions" method="POST">
                                                <input type="hidden" name="user_type" value="branches" readonly>
                                                <input type="hidden" name="username" value="<?= $getbranches['branch_user_name']; ?>" readonly>
                                                <div class="modal-header bg-success">
                                                    <h5 class="modal-title text-white">Credit For Branch</h5>
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
                                <div class="modal fade" id="modalofStationaryDebit<?= $getbranches['branch_user_name']; ?>">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="actions" method="POST">
                                                <input type="hidden" name="user_type" value="branches" readonly>
                                                <input type="hidden" name="username" value="<?= $getbranches['branch_user_name']; ?>" readonly>
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title text-white">Debit For Branch</h5>
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
                                <div class="modal fade" id="modalofChangePassword<?= $getbranches['branch_user_name']; ?>">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="actions" method="POST">
                                                <input type="hidden" name="user_type" value="branches" readonly>
                                                <input type="hidden" name="username" value="<?= $getbranches['branch_user_name']; ?>" readonly>
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title text-white">Change Password For Branch</h5>
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