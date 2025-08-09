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
		            <h3 class="card-title">States</h3>
		        </div>
		       <!-- <div class="card-body">-->
		       <!--     <div class="row">-->
		       <!--         <div class="col-md-4">-->
		       <!--             <form action="actions.php" method="POST">-->
         <!--                       <label>State</label>-->
         <!--                       <div class="input-group mb-3">-->
         <!--                           <input type="text" class="form-control form-control-sm" name="state" placeholder="Enter State Name" required>-->
									<!--<button class="btn btn-primary btn-sm" type="submit" name="submitState">Submit</button>-->
         <!--                       </div>-->
         <!--                   </form>-->
		       <!--         </div>-->
		       <!--     </div>-->
		       <!-- </div>-->
		        <!--<hr/>-->
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>States</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		      //  $join = array("0"=>array("LEFT","zones","states","zone_id","zones","id"));
                                    $getstates = $query->getData("*","states","","","","","");
                                    foreach($getstates as $var){
                    		    ?>
                        			<tr>
                        				<td><?= $var['state']; ?></td>
                        				<td>
                        				    <div class="d-flex">
    											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofState<?= $var['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
    											<!--<form action="actions" method="POST">-->
    											<!--    <input type="hidden" value="" name="stateId" readonly>-->
    											<!--    <button type="submit" class="btn btn-danger shadow btn-xs sharp" name="deleteState" onclick="return confirm('Are you sure to want to delete this state?')">-->
    											<!--        <i class="fa fa-trash"></i>-->
    											<!--    </button>-->
    											<!--</form>-->
    										</div>
                        				</td>
                        			</tr>
                        			
                        			<!-- Modal -->
                                    <div class="modal fade" id="modalofState<?= $var['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions.php" method="POST">
                                                    <input type="hidden" name="stateId" value="<?= $var['id']; ?>" readonly>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Change Zone</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Update Zone for <?= $var['state']; ?></label>
                                                            <select name="zone" class="form-control form-control-sm">
                                                                <option value="" hidden>Choose Zone</option>
                                                                <?php
                                                                    $getzone = $query->getData("*","zones","","","","","");
                                                                    foreach($getzone as $zone){
                                                                ?>
                                                                    <option value="<?= $zone['id']; ?>" <?php if($zone['id'] == $var['zone_id']){echo "selected";} ?>><?= $zone['zone']; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="changeZone" class="btn btn-warning btn-sm">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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