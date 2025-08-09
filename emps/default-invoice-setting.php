<?php
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row d-flex justify-content-center">
		    <div class="col-md-9">
    		    <div class="card">
    		        <div class="card-header">
    		            <h3 class="card-title">Edit Default Invoice Setting</h3>
    		        </div>
    		        <form action="actions" method="POST" class="card-body" onsubmit="return confirm('Are you sure to want to change the invoice details?')">
    		            <?php
    		                $getInvoice = $query->getData("*","non_serial_invoice_prefix","",array("id"=>"1"),"id","DESC","1")[0];
    		            ?>
    		            <div class="row">
    		                <div class="row d-flex justify-content-start">
                                <div class="col-md-6 form-group mt-3 d-flex justify-content-end align-items-center">
                                    <b style="font-size: 14px;">Update Default Invoice Prefix and Start number of Invoice</b>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label>Invoice Prefix</label>
                                    <input type="text" class="form-control form-control-sm" name="invoice_prefix" value="<?= $getInvoice['invoice_prefix']; ?>" required>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label>Invoice Start Number</label>
                                    <input type="text" class="form-control form-control-sm" name="invoice_start_number" value="<?= $getInvoice['invoice_number']; ?>" required>
                                </div>
    		                </div>
    		                <div class="row d-flex justify-content-end">
    	                        <button class="col-md-2 col-5 btn btn-warning btn-sm" type="submit" name="saveChangeDefaultInvoice">Save Change <i class="bi bi-pen-fill"></i></button>
    		                </div>
    		            </div>
    		        </form>
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