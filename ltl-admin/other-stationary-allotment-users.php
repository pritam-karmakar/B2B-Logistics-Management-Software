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
		            <h3 class="card-title">Stationary Invoice Allotment for Users</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th class="text-center">User Name</th>
                    				<th class="text-center">Party Name</th>
                    				<th class="text-center">Contact Person</th>
                    				<th class="text-center">Mobile No.</th>
                    				<th class="text-center">Email Id</th>
                    				<th class="text-center">Address</th>
                    				<th class="text-center">Credit Action</th>
                    				<th class="text-center">Debit Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $users = $query->getData("*",'users','',array("users`.`delete_status"=>"show"),'id','DESC','');
                    		        if($users != 0){
                        		        foreach($users as $getusers){
                        		            $getCredit = $query->getData('`credit_stationary_allotments`.*,`other_stationaries`.`stationary_name`','credit_stationary_allotments',[array('LEFT','other_stationaries','other_stationaries','id','credit_stationary_allotments','other_stationary_id')],array('credit_stationary_allotments`.`user_type'=>'users','credit_stationary_allotments`.`type_id'=>$getusers['id'],'other_stationaries`.`stationary_name'=>'Credit'),'credit_stationary_allotments`.`id','DESC','')[0];
                        		            $getDebit = $query->getData('`debit_stationary_allotments`.*,`other_stationaries`.`stationary_name`','debit_stationary_allotments',[array('LEFT','other_stationaries','other_stationaries','id','debit_stationary_allotments','other_stationary_id')],array('debit_stationary_allotments`.`user_type'=>'users','debit_stationary_allotments`.`type_id'=>$getusers['id'],'other_stationaries`.`stationary_name'=>'Debit'),'debit_stationary_allotments`.`id','DESC','')[0];
                    		    ?>
                    			<tr>
                    				<td class="text-center"><?= $getusers['username']; ?></td>
                    				<td class="text-center"><?= $getusers['party_name']; ?></td>
                    				<td class="text-center"><?= $getusers['contact_person_name']; ?></td>
                    				<td class="text-center"><?= $getusers['mobile_no']; ?></td>
                    				<td class="text-center"><?= $getusers['email']; ?></td>
                    				<td class="text-center"><?= $getusers['address']; ?></td>
                    				<td class="text-center">
                    				    <div class="d-flex justify-content-center">
											<a href="#" class="btn btn-success shadow btn-xs sharp me-1" title="Credit" data-bs-toggle="modal" data-bs-target="#modalofStationaryCredit<?= $getusers['id']; ?>">
											    <i class="fas fa-arrow-up"></i>
										    </a>
										    <a href="previous-others-allotments?other=credit&visible=users&username=<?= $getusers['username']; ?>" class="btn btn-info shadow btn-xs sharp me-1"><i class="bi bi-view-list"></i></a>
										</div>
                    				</td>
                    				<td class="text-center">
                    				    <div class="d-flex justify-content-center">
											<a href="#" class="btn btn-danger shadow btn-xs sharp me-1" title="Debit" data-bs-toggle="modal" data-bs-target="#modalofStationaryDebit<?= $getusers['id']; ?>">
											    <i class="fas fa-arrow-down"></i>
										    </a>
										    <a href="previous-others-allotments?other=debit&visible=users&username=<?= $getusers['username']; ?>" class="btn btn-info shadow btn-xs sharp me-1"><i class="bi bi-view-list"></i></a>
										</div>
                    				</td>
                    				<!-- Modal -->
                                    <div class="modal fade" id="modalofStationaryCredit<?= $getusers['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions" method="POST">
                                                    <input type="hidden" name="stationary_type" value="credit" readonly>
                                                    <input type="hidden" name="user_type" value="users" readonly>
                                                    <input type="hidden" name="type_id" value="<?= $getusers['id']; ?>" readonly>
                                                    <div class="modal-header bg-success">
                                                        <h5 class="modal-title text-white">Change Credit Stationary</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Update Credit Stationary <span class="text-danger">*</span></label>
                                                            <select name="stationary" class="form-control form-control-sm" required>
                                                                <option value="" hidden>Choose Stationary</option>
                                                                <?php
                                                                    $getstn = $query->getData("*","other_stationaries","",array("stationary_name"=>"Credit","delete_status"=>"show"),"","","");
                                                                    foreach($getstn as $stn){
                                                                ?>
                                                                <option value="<?= $stn['id']; ?>" <?php if($stn['id'] == $getCredit['other_stationary_id']){echo "selected";} ?>><?= "{$stn['stationary_name']} - ({$stn['stationary_prefix']})"; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="row pt-2">
                                                            <div class="col-5 form-group">
                                                                <label>Start Allotment No. <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm txtNumeric" placeholder="Enter number" name="start_allotment_no" required>
                                                            </div>
                                                            <span class="col-1 d-flex align-items-center pt-4">to</span>
                                                            <div class="col-6 form-group">
                                                                <label>End Allotment No. <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm txtNumeric" placeholder="Enter number" name="end_allotment_no" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="allotOtherStationary" class="btn btn-sm" style="background-color: #28a745; color: #fff;">Allot Credit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                    				<!-- Modal -->
                                    <div class="modal fade" id="modalofStationaryDebit<?= $getusers['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions" method="POST">
                                                    <input type="hidden" name="stationary_type" value="debit" readonly>
                                                    <input type="hidden" name="user_type" value="users" readonly>
                                                    <input type="hidden" name="type_id" value="<?= $getusers['id']; ?>" readonly>
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white">Change Debit Stationary</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Update Stationary <span class="text-danger">*</span></label>
                                                            <select name="stationary" class="form-control form-control-sm" required>
                                                                <option value="" hidden>Choose Debit Stationary</option>
                                                                <?php
                                                                    $getstn = $query->getData("*","other_stationaries","",array("stationary_name"=>"Debit","delete_status"=>"show"),"","","");
                                                                    foreach($getstn as $stn){
                                                                ?>
                                                                <option value="<?= $stn['id']; ?>" <?php if($stn['id'] == $getDebit['other_stationary_id']){echo "selected";} ?>><?= "{$stn['stationary_name']} - ({$stn['stationary_prefix']})"; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="row pt-2">
                                                            <div class="col-5 form-group">
                                                                <label>Start Allotment No. <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm txtNumeric" placeholder="Enter number" name="start_allotment_no" required>
                                                            </div>
                                                            <span class="col-1 d-flex align-items-center pt-4">to</span>
                                                            <div class="col-6 form-group">
                                                                <label>End Allotment No. <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm txtNumeric" placeholder="Enter number" name="end_allotment_no" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="allotOtherStationary" class="btn btn-sm" style="background-color: #28a745; color: #fff;">Allot Debit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                				<?php
                        		        }
                    		        }
                				?>
                    			</tr>
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