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
		            <h3 class="card-title">Other Stationaries</h3>
		        </div>
		        <div class="card-body">
		            <form action="actions" method="POST">
    		            <div class="row">
    		                <div class="col-md-4">
                                <label>Stationary</label>
                                <select class="form-control form-control-sm" name="stationary_name">
                                    <option value="" hidden>Choose one</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Credit">Credit</option>
                                </select>
    		                </div>
    		                <div class="col-md-4">
                                <label>Prefix</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" name="stationary_prefix" placeholder="Enter Prefix" required>
									<button class="btn btn-primary btn-sm" type="submit" name="submitOtherStationary">Submit</button>
                                </div>
    		                </div>
    		            </div>
                    </form>
		        </div>
		        <hr/>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>Name</th>
                    				<th>Prefix</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $whr = array('delete_status'=>'show');
                                    $getstationaries = $query->getData("*","other_stationaries","",$whr,"","","");
                                    if($getstationaries != 0){
                                        foreach($getstationaries as $var){
                    		    ?>
                        			<tr>
                        				<td><?= $var['stationary_name']; ?></td>
                        				<td><?= $var['stationary_prefix']; ?></td>
                        				<td>
                        				    <div class="d-flex">
    											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofStationary<?= $var['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
    											<form action="actions" method="POST">
    											    <input type="hidden" value="<?= $var['id']; ?>" name="id" readonly>
    											    <button type="submit" class="btn btn-danger shadow btn-xs sharp" name="deleteOtherStationary" onclick="return confirm('Are you sure to want to delete this item?')"><i class="fa fa-trash"></i></button>
    											</form>
    										</div>
                        				</td>
                        			</tr>
                        			
                        			<!-- Modal -->
                                    <div class="modal fade" id="modalofStationary<?= $var['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions" method="POST">
                                                    <input type="hidden" name="id" value="<?= $var['id']; ?>" readonly>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Stationary</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label>Stationary Name</label>
                                                        <input type="text" class="form-control form-control-sm" name="stationary_name" value="<?= $var['stationary_name']; ?>" placeholder="Enter Item" required>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label>Stationary Prefix</label>
                                                        <input type="text" class="form-control form-control-sm" name="stationary_prefix" value="<?= $var['stationary_prefix']; ?>" placeholder="Enter Item" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="editOtherStationary" class="btn btn-warning btn-sm">Save changes</button>
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