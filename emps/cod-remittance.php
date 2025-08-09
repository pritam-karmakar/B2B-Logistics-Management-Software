<?php
    include("assets/header.php");
    include("assets/sidebar.php");
?>

<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">COD Remittance</h3>
		        </div>
		        <form action="actions" method="POST">
    		        <div class="card-body">
    		            <div class="row">
                            <!--<div class="col-md-12 d-flex justify-content-end">Wallet Balance: ₹<span id="walletBal"><?//= $getusers['wallet_balance']; ?></span>/-</div>-->
                            <div class="col-xl-2 col-sm-6 form-group mb-3">
                	            <label>Choose user type</label>
                	            <select class="form-control form-control-sm" name="visible" id="codVisibleType">
                	                <option value="" hidden>Choose user type</option>
                	                <option value="users">User</option>
                	                <option value="branches">Branch</option>
                	            </select>
                			</div>
                	        <div class="col-xl-4 col-sm-6 form-group mb-3">
                	            <label>Choose One</label>
                	            <select class="form-control form-control-sm" id="single-select" name="codUsersorBranches" required>
                	                <option value="" hidden>Choose one</option>
                	            </select>
                			</div>
                	        <div class="col-xl-4 col-sm-6 form-group mb-3">
                	            <label>Choose COD Remittance Pending LR</label>
                	            <select class="form-control form-control-sm multi-select" id="codlR" name="codLR[]" multiple="multiple" required>
                	            </select>
                			</div>
                	        <div class="col-xl-2 col-sm-6 form-group d-flex align-items-end" style="margin-bottom: 17px;">
                	            <button class="btn btn-xs me-1 shadow btn-block" type="button" name="getCODTotalAmount" style="background-color: #28a745; color: #fff;">Get amount</button>
                			</div>
                            <div class="col-xl-4 col-sm-6 form-group mb-3">
                                <label>COD Amount</label>
                                <input type="text" class="form-control form-control-sm txtNumeric" name="codAmount" readonly required>
                            </div>
                            <div class="col-xl-4 col-sm-6 form-group">
                                <label>Transaction Id</label>
                                <input type="text" class="form-control form-control-sm" name="transactionId" placeholder="Enter Transaction Id" required>
                            </div>
                        </div>
    		        </div>
                    <div class="card-footer d-flex" style="justify-content: space-between;">
                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="payCODamount" class="btn btn-warning btn-sm">Pay COD amount</button>
                    </div>
		    </div>
		</div>
	</div>
</div>

<?php
    include("assets/footer.php");
?>