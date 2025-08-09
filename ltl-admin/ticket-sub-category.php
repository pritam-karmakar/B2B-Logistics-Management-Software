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
		            <h3 class="card-title">Ticket Sub Categories</h3>
		        </div>
		        <div class="card-body">
		            <div class="row">
	                    <form class="row" action="actions" method="POST">
    		                <div class="col-md-4">
                                <label>Ticket Category</label>
                                <div class="input-group mb-3">
                                    <select class="form-control form-control-sm" name="ticketCategory" required>
                                        <option value="" hidden>Choose Category</option>
                                        <?php
                                            $catarr = array('delete_status'=>'show');
                                            $getreturn = $query->getData('*','ticket_category','',$catarr,'','','');
                                            if($getreturn != 0){
                                                foreach($getreturn as $variable){
                                        ?>
                                                <option value="<?= $variable['id']; ?>"><?= $variable['category']; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
    		                </div>
    		                <div class="col-md-4">
                                <label>Ticket Category</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" name="ticket_subCategory" placeholder="Enter Ticket Sub Category" required>
    								<button class="btn btn-primary btn-sm" type="submit" name="submitTicketSubCategory">Submit</button>
                                </div>
    		                </div>
                        </form>
		            </div>
		        </div>
		        <hr/>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example2" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>Ticket Category</th>
                    				<th>Ticket Sub Category</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $condArr = array('ticket_subcategory`.`delete_status'=>'show');
                    		        $condJoin = array("0"=>array('INNER','ticket_category','ticket_subcategory','categoryId','ticket_category','id'));
                                    $getitems = $query->getData("`ticket_subcategory`.*,`ticket_category`.`category`","ticket_subcategory",$condJoin,$condArr,"","","");
                                    if($getitems != 0){
                                        foreach($getitems as $var){
                    		    ?>
                        			<tr>
                        				<td><?= $var['category']; ?></td>
                        				<td><?= $var['subCategory']; ?></td>
                        				<td>
                        				    <div class="d-flex">
    											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofTicketSubCategory<?= $var['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
    											<form action="actions" method="POST">
                                                    <input type="hidden" name="ticketSubCategoryOwner" value="<?= $var['id']; ?>" readonly>
    											    <button type="submit" name="deleteTicketSubCategory" onclick="return confirm('Are you sure to want to delete this sub category')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
    											</form>
    										</div>
                        				</td>
                        			</tr>
                        			
                        			<!-- Modal -->
                                    <div class="modal fade" id="modalofTicketSubCategory<?= $var['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <form action="actions" method="POST">
                                                <input type="hidden" name="ticketSubCategoryOwner" value="<?= $var['id']; ?>" readonly>
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Category</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label>Ticket Category</label>
                                                        <div class="input-group mb-3">
                                                            <select class="form-control form-control-sm" name="ticketCategory" required>
                                                                <option value="" hidden>Choose Category</option>
                                                                <?php
                                                                    $catarr = array('delete_status'=>'show');
                                                                    $getreturn = $query->getData('*','ticket_category','',$catarr,'','','');
                                                                    if($getreturn != 0){
                                                                        foreach($getreturn as $variable){
                                                                ?>
                                                                        <option value="<?= $variable['id']; ?>" <?php if($variable['id'] == $var['categoryId']){ echo "selected"; } ?>><?= $variable['category']; ?></option>
                                                                <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <label>Ticket Sub Category</label>
                                                        <input type="text" class="form-control form-control-sm" name="ticket_subCategory" value="<?= $var['subCategory']; ?>" placeholder="Enter Ticket Sub Category" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="editTickSubCat" class="btn btn-warning btn-sm">Save changes</button>
                                                    </div>
                                                </div>
                                            </form>
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