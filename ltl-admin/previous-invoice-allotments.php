<?php
extract($_GET);
include("assets/header.php");
include("assets/sidebar.php");
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="card">
	        <div class="card-header">
	            <h3 class="card-title">All Previous Invoice Allotments <?php if(!empty($username)){ ?><span style="text-transform: lowercase;"> of <?= $visible."</span> (".$username.")"; ?><?php } ?></h3>
	        </div>
	        <div class="card-body">
	            <div class="table-responsive">
                	<table id="example3" class="display" style="width:100%">
                		<thead>
                			<tr>
                				<th class="text-center">User Type</th>
                				<th class="text-center">User Details</th>
                				<th class="text-center">Start Allotment No.</th>
                				<th class="text-center">End Allotment No.</th>
                				<th class="text-center">Invoice Status</th>
                				<th class="text-center">Action</th>
                			</tr>
                		</thead>
                		<tbody>
                		    <?php
                		        if($visible == "users"){
                                    $user_name_type = 'username';
                                }elseif($visible == "branches"){
                                    $user_name_type = 'branch_user_name';
                                }
                		        $type_id = $query->getData('*',$visible,'',array($user_name_type=>$username),'id','DESC','1')[0]['id'];
                		        $arr = array('user_type'=>$visible,'type_id'=>$type_id);
                		        $allots = $query->getData('*','stationary_invoice_allotments','',$arr,'id','DESC','');
                		        if($allots != 0){
                    		        foreach($allots as $getallots){
                    		            $getusers = $query->getData('*',$getallots['user_type'],'',array('id'=>$getallots['type_id']),'id','DESC','1')[0];
                    		            if($getallots['user_type'] == "users"){
        	                                $uName = $getusers['username'];
        	                                $pName = $getusers['party_name'];
        	                            }elseif($getallots['user_type'] == "branches"){
        	                                $uName = $getusers['branch_user_name'];
        	                                $pName = $getusers['branch_name'];
        	                            }
                		    ?>
                    			<tr>
                    			    <td class="text-center"><?= ucwords(trim(trim($getallots['user_type'], 's'), 'es')); ?></td>
                    				<td class="text-center"><?= "<b>Name: </b>".$pName."<br/><b>Username: </b>".$uName; ?></td>
                    				<td class="text-center"><?= $getallots['start_allotment_no']; ?></td>
                    				<td class="text-center"><?= $getallots['end_allotment_no']; ?></td>
                    				<td class="text-center">
                    				    <?php if($getallots['number_status'] == "Not Started"):
                    				              echo '<span class="badge badge-sm bg-warning">Not Started</span>';
                    				          elseif($getallots['number_status'] == "Running"):
                    				              echo '<span class="badge badge-sm bg-success">Running</span>';
                    				          elseif($getallots['number_status'] == "End"):
                        				          echo '<span class="badge badge-sm bg-danger">Ended!</span>';
                    				    endif; ?>
                				    </td>
                    				<td class="text-center">
                    				    <div class="d-flex justify-content-center">
                        				    <?php if($getallots['number_status'] != "End"): ?>
                            				          <button class="btn btn-warning btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofStationary<?= $getallots['id']; ?>"><i class="bi bi-pen-fill"></i></button>
                        				    <?php endif;
                        				          if($getallots['number_status'] == "Not Started"): ?>
                            				        <form action="act" method="POST" onclick="return confirm('Are you sure to delete this alloted numbers?')">
                            				            <input type="text" hidden name="allotedNumbers" value="<?= $getallots['id']; ?>" />
                                    				    <button type="submit" name="delPrevInvAllot" class="btn btn-danger btn-xs sharp me-1"><i class="bi bi-trash3-fill"></i></button>
                                    			    </form>
                        				    <?php endif;
                        				          if($getallots['number_status'] == "End"): ?>
                        				              <span class="text-muted">No Action Available!</span>
                        				    <?php endif;
                        				    ?>
                        				</div>
                				    </td>
                    			</tr>
                    			<?php if($getallots['number_status'] != "End"): ?>
                            			<!-- Modal -->
                                        <div class="modal fade" id="modalofStationary<?= $getallots['id']; ?>">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="act" method="POST">
                                                        <input type="hidden" name="allotedNumbers" value="<?= $getallots['id']; ?>" readonly>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Change Stationary Allotment</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Update Stationary <span class="text-danger">*</span></label>
                                                                <select <?php if($getallots['number_status'] == "Not Started"){ ?> name="stationary" <?php }else{ ?> disabled <?php } ?> class="form-control form-control-sm" required>
                                                                    <option value="" hidden>Choose Stationary</option>
                                                                    <?php
                                                                        $Arr = array("delete_status"=>"show");
                                                                        $getstn = $query->getData("*","stationaries","",$Arr,"","","");
                                                                        foreach($getstn as $stn){
                                                                    ?>
                                                                    <option value="<?= $stn['id']; ?>" <?php if($stn['id'] == $getallots['stationary_invoice_id']){echo "selected";} ?>><?= "{$stn['stationary_name']} - ({$stn['stationary_prefix']})"; ?></option>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="row pt-2">
                                                                <div class="col-5 form-group">
                                                                    <label>Start Allotment No. <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control form-control-sm txtNumeric" placeholder="Enter number" value="<?= $getallots['start_allotment_no']; ?>" <?php if($getallots['number_status'] == "Not Started"): ?> name="start_allotment_no" <?php else: ?> style="cursor: no-drop;" disabled <?php endif; ?> required>
                                                                </div>
                                                                <span class="col-1 d-flex align-items-center pt-4">to</span>
                                                                <div class="col-6 form-group">
                                                                    <label>End Allotment No. <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control form-control-sm txtNumeric" placeholder="Enter number" value="<?= $getallots['end_allotment_no']; ?>" name="end_allotment_no" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="changeInvoiceStationary" class="btn btn-warning btn-sm">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                        endif;
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
<?php
include("assets/footer.php");
?>