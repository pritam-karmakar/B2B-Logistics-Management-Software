<?php
    include("assets/header.php");
    include("assets/sidebar.php");
?>

<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">Bank Details Form</h3>
		        </div>
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-6">
		                    <div class="mt-4">
                                <label for="">UPI ID</label>
                                <input type="text" class="form-control" value="<?php echo $result['upid']; ?>" name="upid">
                            </div>
                            <div class="mt-4">
                                <label for="">QR Code</label>
                                <input type="hidden"  class="form-control" value=""  id="qr_code-old" > 
                                <input type="file" class="form-control" name="qr_code" id="qr_code">
                            </div>
                            <div class="mt-4">
                                <label for="">Bank Name</label>
                                <input type="text" class="form-control" value="<?php echo $result['b_name']; ?>" name="b_name">
                            </div>
                            <div class="mt-4">
                                <label for="">A/C Holder</label>
                                <input type="text" class="form-control" value="<?php echo $result['ac_holder']; ?>" name="ac_holder">
                            </div>
                            <div class="mt-4">
                                <label for="">A/C Number</label>
                                <input type="text" class="form-control" value="<?php echo $result['ac_number']; ?>" name="ac_number">
                            </div>
                            <div class="mt-4">
                                <label for="">IFSC</label>
                                <input type="text" class="form-control" value="<?php echo $result['ifscod']; ?>" name="ifscod">
                            </div>
		                </div>
		                <div class="col-md-6 text-center">
                            <img src="images/qr_code/barcode.jpeg" name="qr_code" class="img-fluid barcode"  id="qr_code">
                        </div>
		            </div>
	                <div class="row d-flex justify-content-end">
                        <button class="col-md-1 col-5 btn btn-primary">Update</button>
	                </div>
		        </div>
		    </div>
		</div>
	</div>
</div>

<?php
    include("assets/footer.php");
?>