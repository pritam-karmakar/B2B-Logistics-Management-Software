<?php
if(!array_key_exists('visible', $_GET)){
    echo '<script type="text/javascript" language="javascript">window.location="credit-control?visible=users";</script>';
}elseif(empty($_GET['visible'])){
    echo '<script>window.location = "credit-control?visible=users";</script>';
}elseif($_GET['visible'] != "users" && $_GET['visible'] != "branches"){
    echo '<script>window.location = "credit-control?visible=users";</script>';
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
		            <h3 class="card-title">TBB <?= ucwords($visible); ?></h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th class="text-center">User Name</th>
                    				<th class="text-center"><?= ($visible == "users")? "Party" : "Branch"; ?> Name</th>
                    				<th class="text-center">Contact Person</th>
                    				<th class="text-center">Mobile No.</th>
                    				<th class="text-center">Email Id</th>
                    				<th class="text-center">Address</th>
                    				<th class="text-center">Credit Amount</th>
                    				<th class="text-center">Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $creditShowFor = ($visible == "users")? "party_type" : "credit_type";
                    		        $aarrrr = array($visible.'`.`delete_status'=>'show',$creditShowFor=>'TBB');
                    		        $users = $query->getData('*',$visible,'',$aarrrr,'id','DESC','');
                    		        if($users != 0){
                        		        foreach($users as $getusers){
                    		    ?>
                    			<tr>
                    				<td class="text-center"><?= ($visible == "users")? $getusers['username'] : $getusers['branch_user_name']; ?></td>
                    				<td class="text-center"><?= ($visible == "users")? $getusers['party_name'] : $getusers['branch_name']; ?></td>
                    				<td class="text-center"><?= ($visible == "users")? $getusers['contact_person_name'] : $getusers['contact_person']; ?></td>
                    				<td class="text-center"><?= $getusers['mobile_no']; ?></td>
                    				<td class="text-center"><?= $getusers['email']; ?></td>
                    				<td class="text-center"><?= $getusers['address']; ?></td>
                    				<td class="text-center">₹<?= $getusers['credit_limit']; ?></td>
                    				<td class="text-center">
                    				    <div class="d-flex">
                        				    <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" title="Add Credit" data-bs-toggle="modal" data-bs-target="#modalofCreditControl<?= $getusers['id']; ?>"><i class="bi bi-pen-fill"></i></a>
                        				    <form action="credit-transactions" method="GET">
                        				        <input type="hidden" name="type" value="<?= $visible; ?>">
                        				        <input type="hidden" name="typeIs" value="<?= ($visible == "users")? $getusers['username'] : $getusers['branch_user_name']; ?>">
                        				        <button type="submit" class="btn btn-info shadow btn-xs sharp me-1" title="View Credit Transactions"><i class="bi bi-view-list"></i></button>
                        				    </form>
                    				    </div>
                    				</td>
                    			</tr>
                    			
                    			<!-- Modal -->
                                <div class="modal fade" id="modalofCreditControl<?= $getusers['id']; ?>">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="actions" method="POST">
                        				        <input type="hidden" name="type" value="<?= $visible; ?>">
                                                <input type="hidden" value="<?= ($visible == "users")? $getusers['username'] : $getusers['branch_user_name']; ?>" name="username">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Credit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="text" class="form-control" name="creditControl" placeholder="Enter Credit" value="<?= $getusers['credit_limit']; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="editCredit" class="btn btn-warning btn-sm">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /. Modal -->
                    			
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