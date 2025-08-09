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
		   
		    <div class="col-md-5 card">
    		   <div class="card-body pb-0">
        		   <ul class="nav nav-pills justify-content-center mb-4">
                    	<li class="nav-item">
                    		<a style="cursor: pointer;" id="navpills1-tab" class="nav-link addus-link active"><i class="fas fa-user"></i>&nbsp; General</a>
                    	</li>
                    	<li class="nav-item">
                    		<a style="cursor: pointer;" id="navpills2-tab" class="nav-link addus-link"><span style="font-weight: 900; line-height: 1; font-size: 1rem;">₹</span>&nbsp; Finance</a>
                    	</li>
                    	<li class="nav-item">
                    		<a style="cursor: pointer;" id="navpills3-tab" class="nav-link addus-link"><i class="fas fa-phone"></i>&nbsp; Contact</a>
                    	</li>
                    </ul>
                </div>
            </div>
            
            <form action="actions" id="useraddForm" method="POST" enctype="multipart/form-data">
                <div class="tab-content">
                	<div id="navpills1" class="tab-pane active">
            			<div class="col-md-12">
                		    <div class="row card">
                			    <div class="card-header">
                			        General Information
                			    </div>
                			    <div class="card-body">
                			        <div class="row m-3">
                			            <div class="col-md-4 mb-3">
                		                    <label>Party Name</label>
                		                    <input type="text" class="form-control" placeholder="Enter Party Name" name="party_name" >
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Contact Person</label>
                		                    <input type="text" class="form-control" placeholder="Enter Contact Person Name" name="contact_person_name">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Booking Agent</label>
                		                    <select class="form-control" name="booking_agent" >
                		                        <option hidden value="">Choose Agent</option>
                		                        <?php
                		                            $agentarr = array("type"=>"agent");
                                                    $selbranch = $query->getData('*','branches','',$agentarr,'','','');
                                                    if($selbranch != 0){
                                                        foreach($selbranch as $var){
                                                            echo '<option value="'.$var["id"].'">'.$var["branch_name"].'</option>';
                                                        }
                                                    }
                		                        ?>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Address</label>
                		                    <input type="text" class="form-control" placeholder="Enter Address" name="address">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Mobile No.</label>
                		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile No." name="mobile_no">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Fuel Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Fuel Surcharge" name="fuel_surcharge">
                    		                    <select class="form-control" name="fuel_surcharge_type">
                    		                        <option>Fixed</option>
                    		                        <option>Percentage</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Pin Code</label>
                		                    <input type="text" class="form-control txtNumeric" maxlength="6" placeholder="Enter Pin Code" name="pincode">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Party Type</label>
                		                    <select class="form-control" name="party_type" required>
                		                        <option hidden value="">Choose party type</option>
                		                        <option>All</option>
                		                        <option>Franchise-ToPay</option>
                		                        <option>To-Pay</option>
                		                        <option>Paid</option>
                		                        <option>TBB</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-1 mb-3">
                		                    <label>COD Min.</label>
                		                    <input type="text" class="form-control numeric-decimal" name="cod_charge_min" placeholder="COD Min.">
                		                </div>
                		                <div class="col-md-3 mb-3">
                		                    <label>COD Charge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter COD Charge" name="cod_charge">
                    		                    <select class="form-control" name="cod_charge_type">
                    		                        <option>Fixed</option>
                    		                        <option>Percentage</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>PAN</label>
                		                    <input type="text" class="form-control" placeholder="Enter PAN" name="pan">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Branch</label>
                		                    <select class="form-control" name="branch">
                		                        <option hidden value="">Choose Branch</option>
                		                        <?php
                		                            $brancharr = array("type"=>"branch");
                                                    $selbranch = $query->getData('*','branches','',$brancharr,'','','');
                                                    if($selbranch != 0){
                                                        foreach($selbranch as $var2){
                                                            echo '<option value="'.$var2["id"].'">'.$var2["branch_name"].'</option>';
                                                        }
                                                    }
                		                        ?>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>CFT</label>
                		                    <input type="text" class="form-control" placeholder="Enter CFT" name="cft">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Freight Type</label>
                		                    <select class="form-control" name="freight_type" required>
                		                        <option hidden value="">Choose freight type</option>
                		                        <option>Quantity</option>
                		                        <option>Weight</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>TDS</label>
                		                    <select class="form-control" name="tds" >
                		                        <option hidden value="">Choose one</option>
                		                        <option>Yes</option>
                		                        <option>No</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>GST Type</label>
                		                    <select class="form-control" name="gst_type">
                		                        <option hidden value="">GST Type</option>
                		                        <option>Regular</option>
                		                        <option>Unregistered</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>GST No.</label>
                		                    <input type="text" class="form-control" placeholder="Enter GST No." name="gst_number">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Taxes Paid By</label>
                		                    <select class="form-control" name="taxes_paid_by">
                		                        <option hidden value="">Choose one</option>
                		                        <option>Transporter</option>
                		                        <option>Consigner</option>
                		                        <option>Consignee</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>3PL</label>
                		                    <select class="form-control" name="threepl" required>
                		                        <option hidden value="">Choose 3PL</option>
                		                        <?php
                                                    $sel3pl = $query->getData('*','3pls','','','','','');
                                                    if($sel3pl != 0){
                                                        foreach($sel3pl as $var3){
                                                            echo '<option value="'.$var3["id"].'">'.$var3["api_token_name"].'</option>';
                                                        }
                                                    }
                		                        ?>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Min. Charge Weight</label>
                		                    <input type="text" class="form-control numeric-decimal" maxlength="5" placeholder="Enter min. charge weight" name="min_charge_weight">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Delivery Type</label>
                		                    <select class="form-control" name="delivery_type">
                		                        <option hidden value="">Choose delivery type</option>
                		                        <option>GoDown Delivery</option>
                		                        <option>Door Delivery</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Phone No.</label>
                		                    <input type="text" class="form-control txtNumeric" maxlength="12" placeholder="Enter Phone No." name="phone">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Email</label>
                		                    <input type="email" class="form-control" placeholder="Enter Email" name="email">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>State</label>
                		                    <select class="form-control" name="state" required>
                		                        <option hidden value="">Choose one</option>
                		                        <?php
                                                    $selstate = $query->getData('*','states','','','','','');
                                                    if($selstate != 0){
                                                        foreach($selstate as $varstate){
                                                            echo '<option value="'.$varstate["id"].'">'.$varstate["state"].'</option>';
                                                        }
                                                    }
                		                        ?>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>AWB Charge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter AWB Charge" name="awb_charge">
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>FOV Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Surcharge Minimum" name="fob_surcharge_minimum">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Surcharge in %" name="fob_surcharge_percentage">
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Handeling Charge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Handeling Charge" name="handeling_charge">
                    		                    <select class="form-control" name="handeling_charge_type">
                    		                        <option>Kg</option>
                    		                        <option>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-1 mb-3">
                		                    <label style="font-size: 12px;">Damrage Min.</label>
                		                    <input type="text" class="form-control numeric-decimal" name="damage_surcharge_min" placeholder="Damrage Min.">
                		                </div>
                		                <div class="col-md-3 mb-3">
                		                    <label>Damrage Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Damrage Surcharge" name="damage_surcharge">
                    		                    <select class="form-control" name="damage_surcharge_type">
                    		                        <option>Kg</option>
                    		                        <option>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-1 mb-3">
                		                    <label>ODA Min.</label>
                		                    <input type="text" class="form-control numeric-decimal" name="oda_surcharge_min" placeholder="ODA Min.">
                		                </div>
                		                <div class="col-md-3 mb-3">
                		                    <label>ODA Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter ODA Surcharge" name="oda_surcharge">
                    		                    <select class="form-control" name="oda_surcharge_type">
                    		                        <option>Kg</option>
                    		                        <option>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Packaging Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Packaging Surcharge" name="packaging_surcharge">
                    		                    <select class="form-control" name="packaging_surcharge_type">
                    		                        <option>Kg</option>
                    		                        <option>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-1 mb-3">
                		                    <label>App Min.</label>
                		                    <input type="text" class="form-control numeric-decimal" name="special_delivery_or_appointment_charge_min" placeholder="App Min.">
                		                </div>
                		                <div class="col-md-3 mb-3">
                		                    <label>Special Delivery / Appointment Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Special Delivery / Appointment Charge" name="special_delivery_or_appointment_charge">
                    		                    <select class="form-control" name="special_delivery_or_appointment_charge_type">
                    		                        <option>Fixed</option>
                    		                        <option>Percentage</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Pickup Charge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Pickup Charge" name="pickup_charge">
                    		                    <select class="form-control" name="pickup_charge_type">
                    		                        <option>Kg</option>
                    		                        <option>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3" id="credit_limit">
                		                    
                		                </div>
                		                <div class="row mt-3 mb-3">
                    		                <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">
                        		                <div class="form-group" style="display: flex;">
                                                    <input type="checkbox" id="printigst" name="igst" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                    <label for="printigst" style="cursor: pointer;">Print IGST on Bill</label>
                                                </div>
                                            </div>
                    		                <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">
                        		                <div class="form-group" style="display: flex;">
                                                    <input type="checkbox" id="codenable" name="cod_enable" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                    <label for="codenable" style="cursor: pointer;">COD Enable</label>
                                                </div>
                                            </div>
                    		                <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">
                        		                <div class="form-group" style="display: flex;">
                                                    <input type="checkbox" id="userwisecharge" name="userwise_charge" class="branchwise">&nbsp;&nbsp;&nbsp;
                                                    <label for="userwisecharge" style="cursor: pointer;">Userwise Charge</label>
                                                </div>
                                            </div>
                                        </div>
                			        </div>
                			    </div>
        		                <div class="card-footer d-flex justify-content-end">
        	                        <button class="col-md-1 col-5 btn btn-sm btn-primary" type="submit" id="navpills1-btn">Next <i class="fas fa-angle-right"></i></button>
        		                </div>
                			</div>
                		</div>
                	</div>
                	<div id="navpills2" class="tab-pane">
            			<div class="col-md-12">
                		    <div class="row card">
                			    <div class="card-header">
                			        Finance & Logistic
                			    </div>
                			    <div class="card-body">
                			        <div class="row">
                    			        <div class="col-md-6">
                    			            <div class="row m-3">
                        			            <h5>Finance Depertment</h5><hr>
                        			            <div class="col-md-6 mb-3">
                        		                    <label>Account Head</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Account Head" name="account_head">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Mobile Number</label>
                        		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile Number" name="finance_mobile_number">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Bank</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Bank" name="bank">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Branch Address</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Branch Address" name="finance_branch_address">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Account No.</label>
                        		                    <input type="text" class="form-control txtNumeric" placeholder="Enter Account No." name="account_no">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>IFSC Code</label>
                        		                    <input type="text" class="form-control" placeholder="Enter IFSC Code" name="ifsc_code">
                        		                </div>
                    			            </div>
                    		            </div>
                    			        <div class="col-md-6">
                    			            <div class="row m-3">
                    			                <h5>Logistic Depertment</h5><hr>
                        			            <div class="col-md-6 mb-3">
                        		                    <label>Logistic Head</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Logistic Head" name="logistic_head">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Mobile Number</label>
                        		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile Number" name="logistic_mobile_number">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Email of Dispatch</label>
                        		                    <input type="email" class="form-control" placeholder="Enter Email of Dispatch" name="email_of_dispatch">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Branch Address</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Branch Address" name="logistic_branch_address">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Industry Type</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Industry Type" name="industry_type">
                        		                </div>
                    			            </div>
                    		            </div>
                		            </div>
                			    </div>
        		                <div class="card-footer d-flex" style="justify-content: space-between;">
        	                        <button class="col-md-1 col-5 btn btn-sm btn-primary" type="button" id="navpills2-prevbtn"><i class="fas fa-angle-left"></i> Prev</button>
        	                        <button class="col-md-1 col-5 btn btn-sm btn-primary" type="submit" id="navpills2-btn">Next <i class="fas fa-angle-right"></i></button>
        		                </div>
                			</div>
                		</div>
                	</div>
                	<div id="navpills3" class="tab-pane">
            			<div class="col-md-12">
                		    <div class="row card">
                			    <div class="card-header">
                			        Contact Upload
                			    </div>
                			    <div class="card-body">
                			        <div class="row m-3">
                			            <div class="col-md-12 mb-3">
        								    <label for="formFileMultiple">Choose multiple files</label>
        								    <input class="form-control" type="file" id="formFileMultiple" multiple name="files[]">
                			            </div>
                			            <div class="col-md-12 mb-3">
                			                <label>Remarks</label>
                			                <textarea class="form-control" cols="10" rows="4" placeholder="Enter remarks" name="remarks"></textarea>
                			            </div>
                			        </div>
                			    </div>
        		                <div class="card-footer d-flex" style="justify-content: space-between;">
        	                        <button class="col-md-1 col-5 btn btn-sm btn-primary" type="button" id="navpills3-prevbtn"><i class="fas fa-angle-left"></i> Prev</button>
        	                        <button class="col-md-1 col-5 btn btn-sm btn-primary" type="submit" name="add_user_submit">Submit <i class="fas fa-check"></i></button>
        		                </div>
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