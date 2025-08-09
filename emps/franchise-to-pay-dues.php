<?php
    include("assets/header.php");
    include("assets/sidebar.php");
?>

<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">Franchise To-Pay Clearance</h3>
		        </div>
		        <form action="actions" method="POST">
    		        <div class="card-body">
    		            <div class="row mb-3">
                            <div class="col-md-12 d-flex justify-content-end">Wallet Balance: ₹<span id="walletBal"><?= $getusers['wallet_balance']; ?></span>/-</div>
                            <div class="col-xl-4 col-sm-6 form-group mb-3">
                	            <label>Choose user type</label>
                	            <select class="form-control form-control-sm" name="visible" id="franToPayvisibleType">
                	                <option value="" hidden>Choose user type</option>
                	                <option value="users">User</option>
                	                <option value="branches">Branch</option>
                	            </select>
                			</div>
                	        <div class="col-xl-4 col-sm-6 form-group mb-3">
                	            <label>Choose One</label>
                	            <select class="form-control form-control-sm" id="single-select" name="franToPayUsersorBranches" required>
                	                <option value="" hidden>Choose one</option>
                	            </select>
                			</div>
                            <div class="col-xl-4 col-sm-6 form-group mb-3">
                                <label>Due Amount</label>
                                <input type="text" class="form-control form-control-sm txtNumeric" name="franToPayDueAm" readonly required>
                            </div>
                            <div class="col-xl-4 col-sm-6 form-group">
                                <label>Clear Amount</label>
                                <input type="text" class="form-control form-control-sm txtNumeric" name="franToPayClearAm" placeholder="Enter Clear Amount" required>
                            </div>
                            <div class="col-xl-4 col-sm-6 form-group">
                                <label>Rest of the due amount</label>
                                <input type="text" class="form-control form-control-sm txtNumeric" name="franToPayRestAm" readonly required>
                            </div>
                            <div class="col-xl-4 col-sm-6 form-group">
                                <label>Transaction Id</label>
                                <input type="text" class="form-control form-control-sm" name="transactionId" placeholder="Enter Transaction Id" required>
                            </div>
                        </div>
    		        </div>
                    <div class="card-footer d-flex" style="justify-content: space-between;">
                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="clearFranToPayDue" class="btn btn-warning btn-sm">Clear Due</button>
                    </div>
		    </div>
		</div>
	</div>
</div>

<?php
    include("assets/footer.php");
?>