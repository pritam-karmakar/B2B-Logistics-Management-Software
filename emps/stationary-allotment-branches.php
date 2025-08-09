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
		            <h3 class="card-title">Stationary Invoice Allotment for Branches</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>User Name</th>
                    				<th>Branch Name</th>
                    				<th>Contact Person</th>
                    				<th>Mobile No.</th>
                    				<th>Email Id</th>
                    				<th>Address</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $branches = $query->getData("`branches`.*,`stationary_invoice_allotments`.`stationary_invoice_id`,`stationary_invoice_allotments`.`start_allotment_no`,`stationary_invoice_allotments`.`end_allotment_no`,`stationary_invoice_allotments`.`id` as 'stationary_allotment_id'",'branches',[array('LEFT','stationary_invoice_allotments','stationary_invoice_allotments','type_id','branches','id')],array("branches`.`delete_status"=>"show"),'branches`.`id','DESC','');
                    		        if($branches != 0){
                        		        foreach($branches as $getbranches){
                    		    ?>
                    			<tr>
                    				<td><?= $getbranches['branch_user_name']; ?></td>
                    				<td><?= $getbranches['branch_name']; ?></td>
                    				<td><?= $getbranches['contact_person_name']; ?></td>
                    				<td><?= $getbranches['mobile_no']; ?></td>
                    				<td><?= $getbranches['email']; ?></td>
                    				<td><?= $getbranches['address']; ?></td>
                    				<td>
                    				    <div class="d-flex">
											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofStationary<?= $getbranches['id']; ?>">
											    <i class="fas fa-pencil-alt"></i>
										    </a>
										    <a href="previous-invoice-allotments?visible=branches&username=<?= $getbranches['branch_user_name']; ?>" class="btn btn-info shadow btn-xs sharp me-1"><i class="bi bi-view-list"></i></a>
										</div>
                    				</td>
                    				<!-- Modal -->
                                    <div class="modal fade" id="modalofStationary<?= $getbranches['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions" method="POST">
                                                    <input type="hidden" name="user_type" value="branches" readonly>
                                                    <input type="hidden" name="type_id" value="<?= $getbranches['id']; ?>" readonly>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Change Stationary Prefix</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Update Stationary <span class="text-danger">*</span></label>
                                                            <select name="stationary" class="form-control form-control-sm" required>
                                                                <option value="" hidden>Choose Stationary</option>
                                                                <?php
                                                                    $Arr = array("delete_status"=>"show");
                                                                    $getstn = $query->getData("*","stationaries","",$Arr,"","","");
                                                                    foreach($getstn as $stn){
                                                                ?>
                                                                <option value="<?= $stn['id']; ?>" <?php if($stn['id'] == $getbranches['stationary_invoice_id']){echo "selected";} ?>><?= "{$stn['stationary_name']} - ({$stn['stationary_prefix']})"; ?></option>
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
                                                        <button type="submit" name="changeStationary" class="btn btn-warning btn-sm">Save Changes</button>
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