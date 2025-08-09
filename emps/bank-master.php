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
		            <h3 class="card-title">Edit Bank Details</h3>
		        </div>
		        <form action="actions" method="POST" class="card-body" enctype="multipart/form-data">
		            <?php
		                $getbank = $query->getData("*","bank_details","",array("id"=>"1"),"id","DESC","1")[0];
		            ?>
		            <div class="row">
		                <div class="col-md-3">
		                    <img src="../storage/bank/<?= $getbank['qr_code']; ?>" style="height: auto; width: 100%;" title="Qr Code">
		                </div>
		                <div class="col-md-9">
		                    <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label>Qr Code</label>
    		                        <input type="file" class="form-control" name="qr_code">
    		                    </div>
	                            <div class="col-md-6 form-group mb-3">
	                                <label>UPI Id</label>
                                    <input type="text" class="form-control" name="upid" value="<?= $getbank['upid']; ?>">
                                </div>
	                            <div class="col-md-6 form-group mb-3">
	                                <label>Bank Name</label>
                                    <input type="text" class="form-control" name="b_name" value="<?= $getbank['b_name']; ?>">
                                </div>
	                            <div class="col-md-6 form-group mb-3">
	                                <label>Account Holder</label>
                                    <input type="text" class="form-control" name="ac_holder" value="<?= $getbank['ac_holder']; ?>">
                                </div>
	                            <div class="col-md-6 form-group mb-3">
	                                <label>Account Number</label>
                                    <input type="text" class="form-control" name="ac_number" value="<?= $getbank['ac_number']; ?>">
                                </div>
	                            <div class="col-md-6 form-group mb-3">
	                                <label>IFSC Code</label>
                                    <input type="text" class="form-control" name="ifsc" value="<?= $getbank['ifsc']; ?>">
                                </div>
		                    </div>
		                </div>
                        
		                <div class="row d-flex justify-content-end">
	                        <button class="col-md-2 col-5 btn btn-warning" type="submit" name="saveChangesbankDetails">Save Changes <i class="bi bi-pen-fill"></i></button>
		                </div>
		            </div>
		        </form>
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