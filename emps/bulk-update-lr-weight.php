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
            
            <form action="act" id="bulkUpdateForm" method="POST" enctype="multipart/form-data">
            	<div class="row d-flex justify-content-center">
        			<div class="col-md-6">
            		    <div class="card">
            			    <div class="card-header d-flex p-3" style="justify-content: space-between;">
            			        <h3 class="card-title">Bulk weight upload for</h3>
            			        <a class="col-md-3 col-5 btn btn-sm btn-info shadow me-1" download href="../dyfiles/samples/bulk_update_lr_weight_sample.xlsx">Download Sample <i class="bi bi-download"></i></a>
            			    </div>
            			    <div class="card-body">
            			        <div class="row m-3">
            			            <div class="col-md-12 mb-3">
    								    <label for="formFile">Upload Excel File</label>
    								    <input class="form-control" type="file" id="formFile" name="lrWeightFiles" required>
            			            </div>
            			        </div>
            			    </div>
    		                <div class="card-footer d-flex" style="justify-content: space-between;">
    	                        <button class="col-md-2 col-5 btn btn-sm btn-danger shadow me-1" type="reset">Reset <i class="bi bi-ban"></i></button>
    	                        <button class="col-md-3 col-5 btn btn-sm btn-warning shadow me-1" type="submit" name="bulkLRWeightSave">Save to change <i class="bi bi-pen-fill"></i></button>
    		                </div>
            			</div>
            		</div>
            	</div>
            </form>
            
		</div>
	</div>
</div>

<!--**********************************
    Content body end
***********************************-->
<?php
include("assets/footer.php");
?>