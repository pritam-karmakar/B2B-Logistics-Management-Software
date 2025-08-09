<?php
include("assets/header.php");
include("assets/sidebar.php");
if(isset($_GET['usrRef'])){
    $usrRef = $_GET['usrRef'];
    $condition = array("username"=>$usrRef);
    $getUser = $query->getData("*","users","",$condition,"","","");
}else{
    echo "<script type='text/javascript' language='javascript'>
            window.location = 'users-list?visible=edit';
    	  </script>";
}
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
                		            <input type="hidden" class="form-control" name="id" value="<?= $getUser[0]['id']; ?>">
                			        <div class="row m-3">
                			            <div class="col-md-4 mb-3">
                		                    <label>Party Name</label>
                		                    <input type="text" class="form-control" placeholder="Enter Party Name" name="party_name" value="<?= $getUser[0]['party_name']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Contact Person</label>
                		                    <input type="text" class="form-control" placeholder="Enter Contact Person Name" name="contact_person_name" value="<?= $getUser[0]['contact_person_name']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Booking Agent</label>
                		                    <select class="form-control" name="booking_agent">
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
                		                    <input type="text" class="form-control" placeholder="Enter Address" name="address" value="<?= $getUser[0]['address']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Mobile No.</label>
                		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile No." name="mobile_no" value="<?= $getUser[0]['mobile_no']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Fuel Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Fuel Surcharge" name="fuel_surcharge" value="<?= $getUser[0]['fuel_surcharge']; ?>">
                    		                    <select class="form-control" name="fuel_surcharge_type">
                    		                        <option <?php if($getUser[0]['fuel_surcharge_type']=="Fixed"){echo "selected";} ?>>Fixed</option>
                    		                        <option <?php if($getUser[0]['fuel_surcharge_type']=="Percentage"){echo "selected";} ?>>Percentage</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Pin Code</label>
                		                    <input type="text" class="form-control txtNumeric" maxlength="6" placeholder="Enter Pin Code" name="pincode" value="<?= $getUser[0]['pincode']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Party Type</label>
                		                    <select class="form-control" name="party_type">
                		                        <option hidden value="">Choose party type</option>
                		                        <option <?php if($getUser[0]['party_type']=="All"){echo "selected"; } ?>>All</option>
                		                        <option <?php if($getUser[0]['party_type']=="Paid"){echo "selected"; } ?>>Paid</option>
                		                        <option <?php if($getUser[0]['party_type']=="Franchise-ToPay"){echo "selected"; } ?>>Franchise-ToPay</option>
                		                        <option <?php if($getUser[0]['party_type']=="To-Pay"){echo "selected"; } ?>>To-Pay</option>
                		                        <option <?php if($getUser[0]['party_type']=="TBB"){echo "selected"; } ?>>TBB</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-1 mb-3">
                		                    <label>COD Min.</label>
                		                    <input type="text" class="form-control numeric-decimal" name="cod_charge_min" value="<?= $getUser[0]['cod_charge_min']; ?>" placeholder="COD Min.">
                		                </div>
                		                <div class="col-md-3 mb-3">
                		                    <label>COD Charge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter COD Charge" name="cod_charge" value="<?= $getUser[0]['cod_charge']; ?>">
                    		                    <select class="form-control" name="cod_charge_type">
                    		                        <option <?php if($getUser[0]['cod_charge_type']=="Fixed"){echo "selected"; } ?>>Fixed</option>
                    		                        <option <?php if($getUser[0]['cod_charge_type']=="Percentage"){echo "selected"; } ?>>Percentage</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>PAN</label>
                		                    <input type="text" class="form-control" placeholder="Enter PAN" name="pan" value="<?= $getUser[0]['pan']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Branch</label>
                		                    <select class="form-control" name="branch">
                		                        <option hidden value="">Choose Branch</option>
                		                        <?php
                		                            $brancharr = array("type"=>"branch");
                                                    $selbranch = $query->getData('*','branches','',$brancharr,'','','');
                                                    foreach($selbranch as $var2){
                                                ?>
                                                    <option value="<?= $var2['id']; ?>" <?php if($var2['id'] == $getUser[0]['branch']){echo "selected";} ?>><?= $var2["branch_name"]; ?></option>
                                                <?php
                                                    }
                		                        ?>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>CFT</label>
                		                    <input type="text" class="form-control" placeholder="Enter CFT" name="cft" value="<?= $getUser[0]['cft']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Freight Type</label>
                		                    <select class="form-control" name="freight_type" required>
                		                        <option hidden value="">Choose freight type</option>
                		                        <option <?php if($getUser[0]['freight_type'] == "Quantity"){ echo 'selected'; } ?>>Quantity</option>
                		                        <option <?php if($getUser[0]['freight_type'] == "Weight"){ echo 'selected'; } ?>>Weight</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>TDS</label>
                		                    <select class="form-control" name="tds" required>
                		                        <option hidden value="">Choose one</option>
                		                        <option <?php if($getUser[0]['tds'] == "yes"){ echo 'selected'; } ?>>Yes</option>
                		                        <option <?php if($getUser[0]['tds'] == "no"){ echo 'selected'; } ?>>No</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>GST Type</label>
                		                    <select class="form-control" name="gst_type">
                		                        <option hidden value="">GST Type</option>
                		                        <option <?php if($getUser[0]['gst_type']=="Regular"){echo "selected"; } ?>>Regular</option>
                		                        <option <?php if($getUser[0]['gst_type']=="Unregistered"){echo "selected"; } ?>>Unregistered</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>GST No.</label>
                		                    <input type="text" class="form-control" placeholder="Enter GST No." name="gst_number" value="<?= $getUser[0]['gst_number']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Taxes Paid By</label>
                		                    <select class="form-control" name="taxes_paid_by">
                		                        <option hidden value="">Choose one</option>
                		                        <option <?php if($getUser[0]['taxes_paid_by']=="Transporter"){echo "selected"; } ?>>Transporter</option>
                		                        <option <?php if($getUser[0]['taxes_paid_by']=="Consigner"){echo "selected"; } ?>>Consigner</option>
                		                        <option <?php if($getUser[0]['taxes_paid_by']=="Consignee"){echo "selected"; } ?>>Consignee</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>3PL</label>
                		                    <select class="form-control" name="threepl">
                		                        <option hidden value="">Choose 3PL</option>
                		                        <option value="all" <?php if( $getUser[0]['threepl'] == 'all'){echo "selected";} ?>>All</option>
                		                        <?php
                                                    $sel3pl = $query->getData('*','3pls','','','','','');
                                                    if($sel3pl != 0){
                                                        foreach($sel3pl as $var3){
                                                ?>
                                                    <option value="<?= $var3["id"]; ?>" <?php if($var3['id'] == $getUser[0]['threepl']){echo "selected";} ?>><?= $var3["api_token_name"]; ?></option>
                                                <?php
                                                        }
                                                    }
                		                        ?>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Min. Charge Weight</label>
                		                    <input type="text" class="form-control numeric-decimal" maxlength="5" placeholder="Enter min. charge weight" value="<?= $getUser[0]['min_charge_weight'] ?>" name="min_charge_weight">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Delivery Type</label>
                		                    <select class="form-control" name="delivery_type">
                		                        <option hidden value="">Choose delivery type</option>
                		                        <option <?php if($getUser[0]['delivery_type']=="GoDown Delivery"){echo "selected"; } ?>>GoDown Delivery</option>
                		                        <option <?php if($getUser[0]['delivery_type']=="Door Delivery"){echo "selected"; } ?>>Door Delivery</option>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Phone No.</label>
                		                    <input type="text" class="form-control txtNumeric" maxlength="12" placeholder="Enter Phone No." name="phone" value="<?= $getUser[0]['phone']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Email</label>
                		                    <input type="email" class="form-control" placeholder="Enter Email" name="email" value="<?= $getUser[0]['email']; ?>">
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>State</label>
                		                    <select class="form-control" name="state" required>
                		                        <option hidden value="">Choose one</option>
                		                        <?php
                                                    $selstate = $query->getData('*','states','','','','','');
                                                    if($selstate != 0){
                                                        foreach($selstate as $varstate){
                                                ?>
                                                    <option value="<?= $varstate["id"]; ?>" <?php if($varstate["id"] == $getUser[0]['state']){ echo 'selected'; } ?>><?= $varstate["state"]; ?></option>
                                                <?php
                                                        }
                                                    }
                		                        ?>
                		                    </select>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>AWB Charge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter AWB Charge" name="awb_charge" value="<?= $getUser[0]['awb_charge']; ?>">
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>FOV Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Surcharge" name="fob_surcharge_minimum" value="<?= $getUser[0]['fob_surcharge_minimum']; ?>">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Surcharge in %" name="fob_surcharge_percentage" value="<?= $getUser[0]['fob_surcharge_percentage']; ?>">
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Handeling Charge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Handeling Charge" name="handeling_charge" value="<?= $getUser[0]['handeling_charge']; ?>">
                    		                    <select class="form-control" name="handeling_charge_type">
                    		                        <option <?php if($getUser[0]['handeling_charge_type']=="Kg"){echo "selected"; } ?>>Kg</option>
                    		                        <option <?php if($getUser[0]['handeling_charge_type']=="Quantity"){echo "selected"; } ?>>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-1 mb-3">
                		                    <label style="font-size: 12px;">Damrage Min.</label>
                		                    <input type="text" class="form-control numeric-decimal" name="damage_surcharge_min" value="<?= $getUser[0]['damage_surcharge_min']; ?>" placeholder="Damrage Min.">
                		                </div>
                		                <div class="col-md-3 mb-3">
                		                    <label>Damage Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Damage Surcharge" name="damage_surcharge" value="<?= $getUser[0]['damage_surcharge']; ?>">
                    		                    <select class="form-control" name="damage_surcharge_type">
                    		                        <option <?php if($getUser[0]['damage_surcharge_type']=="Kg"){echo "selected"; } ?>>Kg</option>
                    		                        <option <?php if($getUser[0]['damage_surcharge_type']=="Quantity"){echo "selected"; } ?>>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-1 mb-3">
                		                    <label>ODA Min.</label>
                		                    <input type="text" class="form-control numeric-decimal" name="oda_surcharge_min" placeholder="ODA Min." value="<?= $getUser[0]['oda_surcharge_min']; ?>">
                		                </div>
                		                <div class="col-md-3 mb-3">
                		                    <label>ODA Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter ODA Surcharge" name="oda_surcharge" value="<?= $getUser[0]['oda_surcharge']; ?>">
                    		                    <select class="form-control" name="oda_surcharge_type">
                    		                        <option <?php if($getUser[0]['oda_surcharge_type']=="Fixed"){echo "Kg"; } ?>>Kg</option>
                    		                        <option <?php if($getUser[0]['oda_surcharge_type']=="Quantity"){echo "selected"; } ?>>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Packaging Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Packaging Surcharge" name="packaging_surcharge" value="<?= $getUser[0]['packaging_surcharge']; ?>">
                    		                    <select class="form-control" name="packaging_surcharge_type">
                    		                        <option <?php if($getUser[0]['packaging_surcharge_type']=="Kg"){echo "selected"; } ?>>Kg</option>
                    		                        <option <?php if($getUser[0]['packaging_surcharge_type']=="Quantity"){echo "selected"; } ?>>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-1 mb-3">
                		                    <label>App Min.</label>
                		                    <input type="text" class="form-control numeric-decimal" name="special_delivery_or_appointment_charge_min" placeholder="App Min." value="<?= $getUser[0]['special_delivery_or_appointment_charge_min']; ?>">
                		                </div>
                		                <div class="col-md-3 mb-3">
                		                    <label>Special Delivery / Appointment Surcharge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Special Delivery / Appointment Charge" name="special_delivery_or_appointment_charge" value="<?= $getUser[0]['special_delivery_or_appointment_charge']; ?>">
                    		                    <select class="form-control" name="special_delivery_or_appointment_charge_type">
                    		                        <option <?php if($getUser[0]['special_delivery_or_appointment_charge_type']=="Fixed"){echo "selected"; } ?>>Fixed</option>
                    		                        <option <?php if($getUser[0]['special_delivery_or_appointment_charge_type']=="Percentage"){echo "selected"; } ?>>Percentage</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3">
                		                    <label>Pickup Charge</label>
                		                    <div class="input-group">
                    		                    <input type="text" class="form-control numeric-decimal" placeholder="Pickup Charge" name="pickup_charge" value="<?= $getUser[0]['pickup_charge']; ?>">
                    		                    <select class="form-control" name="pickup_charge_type">
                    		                        <option <?php if($getUser[0]['pickup_charge_type']=="Kg"){echo "selected"; } ?>>Kg</option>
                    		                        <option <?php if($getUser[0]['pickup_charge_type']=="Quantity"){echo "selected"; } ?>>Quantity</option>
                    		                    </select>
                		                    </div>
                		                </div>
                		                <div class="col-md-4 mb-3" id="credit_limit">
                		                    <?php if($getUser[0]['party_type']=="TBB"){ ?>
                		                    <label>Credit Limit</label>
                		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Credit Limit" name="credit_limit" value="<?= $getUser[0]['credit_limit']; ?>">
                		                    <?php } ?>
                		                </div>
                		                <div class="row mt-3 mb-3">
                    		                <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">
                        		                <div class="form-group" style="display: flex;">
                                                    <input type="checkbox" id="printigst" name="igst" class="branchwise" <?php if($getUser[0]['igst']=="yes"){echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="printigst" style="cursor: pointer;">Print IGST on Bill</label>
                                                </div>
                                            </div>
                    		                <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">
                        		                <div class="form-group" style="display: flex;">
                                                    <input type="checkbox" id="codenable" name="cod_enable" class="branchwise" <?php if($getUser[0]['cod_charge_enable_disable']=="enable"){echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="codenable" style="cursor: pointer;">COD Enable</label>
                                                </div>
                                            </div>
                    		                <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">
                        		                <div class="form-group" style="display: flex;">
                                                    <input type="checkbox" id="userwisecharge" name="userwise_charge" class="branchwise" <?php if($getUser[0]['fright_charge']=="yes"){echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;
                                                    <label for="userwisecharge" style="cursor: pointer;">Charge userwise</label>
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
                        		                    <input type="text" class="form-control" placeholder="Enter Account Head" name="account_head" value="<?= $getUser[0]['account_head']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Mobile Number</label>
                        		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile Number" name="finance_mobile_number" value="<?= $getUser[0]['finance_mobile_number']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Bank</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Bank" name="bank" value="<?= $getUser[0]['bank']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Branch Address</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Branch Address" name="finance_branch_address" value="<?= $getUser[0]['finance_branch_address']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Account No.</label>
                        		                    <input type="text" class="form-control txtNumeric" placeholder="Enter Account No." name="account_no" value="<?= $getUser[0]['account_no']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>IFSC Code</label>
                        		                    <input type="text" class="form-control" placeholder="Enter IFSC Code" name="ifsc_code" value="<?= $getUser[0]['ifsc_code']; ?>">
                        		                </div>
                    			            </div>
                    		            </div>
                    			        <div class="col-md-6">
                    			            <div class="row m-3">
                    			                <h5>Logistic Depertment</h5><hr>
                        			            <div class="col-md-6 mb-3">
                        		                    <label>Logistic Head</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Logistic Head" name="logistic_head" value="<?= $getUser[0]['logistic_head']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Mobile Number</label>
                        		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile Number" name="logistic_mobile_number" value="<?= $getUser[0]['logistic_mobile_number']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Email of Dispatch</label>
                        		                    <input type="email" class="form-control" placeholder="Enter Email of Dispatch" name="email_of_dispatch" value="<?= $getUser[0]['email_of_dispatch']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Branch Address</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Branch Address" name="logistic_branch_address" value="<?= $getUser[0]['logistic_branch_address']; ?>">
                        		                </div>
                        		                <div class="col-md-6 mb-3">
                        		                    <label>Industry Type</label>
                        		                    <input type="text" class="form-control" placeholder="Enter Industry Type" name="industry_type" value="<?= $getUser[0]['industry_type']; ?>">
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
                			            <div class="col-md-12 mb-3 row">
                                        <?php
                			                if(!empty($getUser[0]['files'])){
                			                    $arrFiles = explode(",", $getUser[0]['files']);
                			                    $limit = count($arrFiles);
                                                for($i=0; $i<$limit; $i++){
                                        ?>
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <a href="images/dynamic-images/<?= $arrFiles[$i]; ?>" target="_blank">
                                                    <img src="images/dynamic-images/<?= $arrFiles[$i]; ?>" width="100%" height="200px">
                                                </a>
                                                <input type="hidden" name="oldFiles[]" value="<?= $arrFiles[$i]; ?>">
                                                <button type="button" class="btn btn-danger shadow btn-xs sharp me-1 imgDel"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        <?php
                                                }
                                            }
                                        ?>
                			            </div>
                			            <div class="col-md-12 mb-3">
        								    <label for="formFileMultiple">Choose multiple files</label>
        								    <input class="form-control" type="file" id="formFileMultiple" multiple name="files[]">
                			            </div>
                			            <div class="col-md-12 mb-3">
                			                <label>Remarks</label>
                			                <textarea class="form-control" cols="10" rows="4" placeholder="Enter remarks" name="remarks"><?= $getUser[0]['remarks']; ?></textarea>
                			            </div>
                			        </div>
                			    </div>
        		                <div class="card-footer d-flex" style="justify-content: space-between;">
        	                        <button class="col-md-1 col-5 btn btn-sm btn-primary" type="button" id="navpills3-prevbtn"><i class="fas fa-angle-left"></i> Prev</button>
        	                        <button class="col-md-1 col-5 btn btn-sm btn-primary" type="submit" name="edit_user_submit">Submit <i class="fas fa-check"></i></button>
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