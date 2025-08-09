<?php
include("assets/header.php");
include("assets/sidebar.php");
$getcharges = $query->getData("*","charges","",array("id"=>"1"),"id","DESC","1")[0];
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">Update All Charges</h3>
		        </div>
		        <form action="actions" method="POST" class="card-body">
		            <div class="row">
		                <div class="col-md-4 mb-3">
		                    <label>IGST</label>
		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter IGST" name="igst" value="<?= $getcharges['igst']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>SGST</label>
		                    <input type="text" class="form-control numeric-decimal" maxlength="10" placeholder="Enter SGST" name="sgst" value="<?= $getcharges['sgst']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>CGST</label>
		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter CGST" name="cgst" value="<?= $getcharges['cgst']; ?>">
		                </div>
		                <div class="row d-flex justify-content-end">
	                        <button class="col-md-2 col-5 btn btn-warning btn-xs" type="submit" name="saveTaxRate">Save Changes <i class="bi bi-pen-fill"></i></button>
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