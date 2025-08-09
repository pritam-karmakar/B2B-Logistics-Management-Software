<?php
include('menu/header.php');
include('menu/navbar.php');
?>
    
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Add Cashbook</span></h4>
            <div class="card">
                <!--<div class="card-header">-->
                <!--    <h3>Add Cashbook</h3>-->
                <!--</div>-->
                <div class="card-body">
                    <form action="action.php" method="POST" class="row">
                        <input type="hidden" name="branch_id" class="form-control" value="<?= $user_id; ?>">
                        <div class="col-md-6 form-group mb-3">
                            <label for="defaultInput" class="form-label">LR No.<span> *</span></label>
                            <input  id="defaultInput" type="text" class="form-control txtNumeric" name="lr_no" placeholder="Enter LR Number" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label  class="form-label">Amount<span> *</span></label>
                            <input type="text" class="form-control numeric-decimal" name="amount" placeholder="Enter the Amount" required>
                        </div>
                        <div class="col-12 form-group mb-3">
                            <label class="form-label">Reference No.<span> *</span></label>
                            <input type="text" class="form-control" name="ref_no" placeholder="Reference Number" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" onclick="return confirm('Are you sure to create Cashbook Request')" name="createCashbookRequest" class="btn btn-label-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<?php
include('menu/footer.php');
?>