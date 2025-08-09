<?php
    include("assets/header.php");
    include("assets/sidebar.php");
?>

<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">Send Commission in Bulk to Agent</h3>
		        </div>
		        <form action="act" method="POST">
    		        <div class="card-body">
    		            <div class="row">
                            <!--<div class="col-md-12 d-flex justify-content-end">Wallet Balance: ₹<span id="walletBal"><?//= $getusers['wallet_balance']; ?></span>/-</div>-->
                	        <div class="col-xl-6 col-sm-6 form-group mb-3">
                	            <label>Choose One</label>
                	            <select class="form-control form-control-sm" id="single-select" name="broker" required>
                	                <?php
                                        $getch = $query->getData('*','branches','',array('type'=>'agent','delete_status'=>'show'),'','','');
                                        if($getch != 0){
                                            echo '<option value="" hidden>Choose one</option>';
                                            foreach($getch as $getall){
                                                $name = $getall['branch_name'];
                                                $username = $getall['branch_user_name'];
                                    ?>
                                              <option value="<?= $username; ?>"><?= $name.' (Username: '.$username.') [Mob: '.$getall['mobile_no'].']'; ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                	            </select>
                			</div>
                	        <div class="col-xl-4 col-sm-6 form-group mb-3">
                	            <label>Choose COD Remittance Pending LR</label>
                	            <select class="form-control form-control-sm multi-select" id="commissionLR" name="commissionLRs[]" multiple="multiple" required>
                	            </select>
                			</div>
                	        <div class="col-xl-2 col-sm-6 form-group d-flex align-items-end" style="margin-bottom: 17px;">
                	            <button class="btn btn-xs me-1 shadow btn-block" type="button" name="getCommissionAmount" style="background-color: #28a745; color: #fff;">Get amount</button>
                			</div>
                            <div class="col-xl-4 col-sm-6 form-group mb-3">
                                <label>Commission Amount</label>
                                <input type="text" class="form-control form-control-sm numeric-decimal" name="commissionAmount" readonly required>
                            </div>
                            <div class="col-xl-4 col-sm-6 form-group">
                                <label>Transaction Id</label>
                                <input type="text" class="form-control form-control-sm" name="transactionId" placeholder="Enter Transaction Id" required>
                            </div>
                        </div>
    		        </div>
                    <div class="card-footer d-flex" style="justify-content: space-between;">
                        <button class="btn btn-danger btn-sm" type="reset">Clear <i class="bi bi-slash-circle"></i></button>
                        <button class="btn btn-success btn-sm" type="submit" name="payCommissionToAgent">Deposit Now <i class="bi bi-patch-check-fill"></i></button>
                    </div>
                </form>
		    </div>
		</div>
	</div>
</div>

<?php
    include("assets/footer.php");
?>