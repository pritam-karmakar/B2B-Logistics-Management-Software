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
		            <h3 class="card-title">Order Items</h3>
		        </div>
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-4">
		                    <form action="actions.php" method="POST">
                                <label>Item</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" name="orderItem" placeholder="Enter Item" required>
									<button class="btn btn-primary btn-sm" type="submit" name="submitItem">Submit</button>
                                </div>
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
                                    $getitems = $query->getData("*","order_items","",$condArr,"","","");
                                    if($getitems != 0){
                                        foreach($getitems as $var){
                    		    ?>
                        			<tr>
                        				<td><?= $var['item']; ?></td>
                        				<td>
                        				    <div class="d-flex">
    											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofOrderItem<?= $var['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
    											<form action="actions" method="POST">
    											    <input type="hidden" value="<?= $var['id']; ?>" name="orderItemOwner" readonly>
    											    <button type="submit" class="btn btn-danger shadow btn-xs sharp" name="deleteOrderItem" onclick="return confirm('Are you sure to want to delete this item?')"><i class="fa fa-trash"></i></button>
    											</form>
    										</div>
                        				</td>
                        			</tr>
                        			
                        			<!-- Modal -->
                                    <div class="modal fade" id="modalofOrderItem<?= $var['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions.php" method="POST">
                                                    <input type="hidden" name="orderItemOwner" value="<?= $var['id']; ?>" readonly>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Item</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label>Item</label>
                                                        <input type="text" class="form-control form-control-sm" name="orderItem" value="<?= $var['item']; ?>" placeholder="Enter Item" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="editOrderItem" class="btn btn-warning btn-sm">Save changes</button>
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