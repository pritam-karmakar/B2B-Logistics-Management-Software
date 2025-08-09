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
		            <h3 class="card-title">Cities</h3>
		        </div>
		        <form action="actions.php" method="POST" enctype="multipart/form-data">
		            <div class="card-body">
		                <div class="row">
    		                <div class="col-md-4">
    		                    <label>Select State</label>
    		                    <div class="input-group">
                                    <select name="state" class="form-control form-control-sm" required>
                                        <option value="" hidden>Choose State</option>
                                        <?php
                                            $getstate = $query->getData("*","states","","","","","");
                                            foreach($getstate as $state){
                                        ?>
                                            <option value="<?= $state['id']; ?>"><?= $state['state']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
    	                        </div>
    	                    </div>
    		                <div class="col-md-4">
                                <label>City File</label>
                                <div class="input-group">
                                    <input type="file" class="form-control form-control-sm" name="city" required>
                                    <button class="btn btn-primary btn-sm" type="submit" name="submitCity">Submit</button>
                                </div>
		                    </div>
		                </div>
		            </div>
                </form>
		        <hr/>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>City</th>
                    				<th>State</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $joinState = array("0"=>array("LEFT","states","cities","state_id","states","id"));
                    		        $condArr = array('delete_status'=>'show');
                                    $getcities = $query->getData("`cities`.*,`states`.`state`","cities",$joinState,$condArr,"","","");
                                    if($getcities != 0){
                                        foreach($getcities as $var){
                    		    ?>
                        			<tr>
                        				<td><?= $var['city']; ?></td>
                        				<td><?= $var['state']; ?></td>
                        				<td>
                        				    <div class="d-flex">
    											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofCity<?= $var['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
    											<form action="actions" method="POST">
    											    <input type="hidden" value="<?= $var['id']; ?>" name="cityId" readonly>
    											    <button type="submit" class="btn btn-danger shadow btn-xs sharp" name="deleteCity" onclick="return confirm('Are you sure to want to delete this city?')">
    											        <i class="fa fa-trash"></i>
    											    </button>
    											</form>
    										</div>
                        				</td>
                        			</tr>
                        			
                        			<!-- Modal -->
                                    <div class="modal fade" id="modalofCity<?= $var['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions.php" method="POST">
                                                    <input type="hidden" name="cityId" value="<?= $var['id']; ?>" readonly>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Change State and City Name</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Update State</label>
                                                            <select name="state" class="form-control form-control-sm">
                                                                <option value="" hidden>Choose State</option>
                                                                <?php
                                                                    $getstate = $query->getData("*","states","","","","","");
                                                                    foreach($getstate as $state){
                                                                ?>
                                                                    <option value="<?= $state['id']; ?>" <?php if($state['id'] == $var['state_id']){echo "selected";} ?>><?= $state['state']; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label>Update City Name</label>
                                                            <input type="text" name="city" class="form-control form-control-sm" value="<?= $var['city']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="changeState" class="btn btn-warning btn-sm">Save Changes</button>
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