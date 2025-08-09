<?php
if(isset($_GET['username'])){
    extract($_GET);
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
    		    <?php
    		        $arrCond = array('branch_user_name'=>$username);
    		        $getbranches = $query->getData('*','branches','',$arrCond,'id','DESC','')[0];
    		        if($getbranches['branch_charge'] == "yes"){
                        echo '<script type="text/javascript" language="javascript">
                                setTimeout(onOpen, 1000);
                                function onOpen() {
                                    $("button[name=branchChargeButton]").click();
                                }
                              </script>';
                    }
    		    ?>
		        <div class="card-header">
		            <h3 class="card-title">Edit <?= $getbranches['branch_name']; ?> (<?= $getbranches['branch_user_name'];  ?>) Branch</h3>
		        </div>
		        <form action="actions" method="POST" class="card-body card-normal">
		            <div class="row">
		                <input type="hidden" value="<?= $getbranches['branch_user_name']; ?>" name="branch_user_name">
		                <div class="col-md-4 mb-3">
		                    <label>Branch Name</label>
		                    <input type="text" class="form-control" placeholder="Enter Branch" name="branch_name" value="<?= $getbranches['branch_name']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Contact Person</label>
		                    <input type="text" class="form-control" placeholder="Enter Contact Person Name" name="contact_person" value="<?= $getbranches['contact_person']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>GST Trade Name</label>
		                    <input type="text" class="form-control" placeholder="Enter GST Trade Name" name="gst_trade_name" value="<?= $getbranches['gst_trade_name']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Address</label>
		                    <input type="text" class="form-control" placeholder="Enter Address" name="address" value="<?= $getbranches['address']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Phone No.</label>
		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Phone No." name="phone_no" value="<?= $getbranches['phone_no']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>EWB Transporter Id</label>
		                    <input type="text" class="form-control" placeholder="Enter EWB Transporter Id" name="ewb_transporter_id" value="<?= $getbranches['ewb_transporter_id']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>City</label>
		                    <input type="text" class="form-control" placeholder="Enter City" name="city" value="<?= $getbranches['city']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Mobile No.</label>
		                    <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile No." name="mobile_no" value="<?= $getbranches['mobile_no']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>District</label>
		                    <input type="text" class="form-control" placeholder="Enter District" name="district" value="<?= $getbranches['district']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Email</label>
		                    <input type="email" class="form-control" placeholder="Enter Email Address" name="email" value="<?= $getbranches['email']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>State</label>
		                    <select class="form-control" name="state">
		                    <?php
                                $selstate = $query->getData('*','states','','','','','');
                                if($selstate != 0){
                                    foreach($selstate as $varstate){
                            ?>
                                <option value="<?= $varstate["id"]; ?>" <?php if($varstate["id"] == $getbranches['state']){ echo 'selected'; } ?>><?= $varstate["state"]; ?></option>
                            <?php
                                    }
                                }
	                        ?>
	                        </select>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Pin Code</label>
		                    <input type="text" class="form-control" placeholder="Enter Pin Code" name="pincode" value="<?= $getbranches['pincode']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Type</label>
		                    <select class="form-control" name="type">
		                        <option value="" hidden>Choose</option>
		                        <option value="branch" <?php if($getbranches['type'] == "branch"){ echo 'selected'; } ?>>Branch</option>
		                        <option value="agent" <?php if($getbranches['type'] == "agent"){ echo 'selected'; } ?>>Agent</option>
		                    </select>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Credit Type</label>
		                    <select class="form-control" name="credit_type">
		                        <option value="" hidden>Choose</option>
		                        <option value="Regular" <?php if($getbranches['credit_type'] == "Regular"){ echo 'selected'; } ?>>Regular</option>
		                        <option value="TBB" <?php if($getbranches['credit_type'] == "TBB"){ echo 'selected'; } ?>>TBB</option>
		                    </select>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Min Charge Weight</label>
		                    <input type="text" class="form-control" placeholder="Enter Min Charge Weight" name="min_charge_weight" value="<?= $getbranches['min_charge_weight']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Freight Type</label>
		                    <select class="form-control" name="freight_type" required>
		                        <option hidden value="">Choose freight type</option>
		                        <option <?php if($getbranches['freight_type'] == "Quantity"){ echo 'selected'; } ?>>Quantity</option>
		                        <option <?php if($getbranches['freight_type'] == "Weight"){ echo 'selected'; } ?>>Weight</option>
		                    </select>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>TDS</label>
		                    <select class="form-control" name="tds" required>
		                        <option hidden value="">Choose one</option>
		                        <option <?php if($getbranches['tds'] == "yes"){ echo 'selected'; } ?>>Yes</option>
		                        <option <?php if($getbranches['tds'] == "no"){ echo 'selected'; } ?>>No</option>
		                    </select>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>3PL</label>
		                    <select class="form-control" name="threepl" required>
		                        <option hidden value="">Choose 3PL</option>
		                        <option value="all" <?php if($getbranches['threepl'] == 'all'){echo "selected";} ?>>All</option>
		                        <?php
                                    $sel3pl = $query->getData('*','3pls','','','','','');
                                    if($sel3pl != 0){
                                        foreach($sel3pl as $var3){
                                ?>
                                <option value="<?= $var3["id"]; ?>" <?php if($var3['id'] == $getbranches['threepl']){echo "selected";} ?>><?= $var3["api_token_name"]; ?></option>
                                <?php
                                        }
                                    }
		                        ?>
		                    </select>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Broker Commission</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal <?php if($getbranches['type'] == "branch"){ echo 'bg-light'; } ?>" placeholder="Enter Broker Commission" name="broker_commission" <?php if($getbranches['type'] == "branch"){ echo 'disabled'; }else{ echo 'value="'.$getbranches["broker_commission"].'"'; } ?>>
    		                    <select class="form-control <?php if($getbranches['type'] == "branch"){ echo 'bg-light'; } ?>" name="broker_commission_type" <?php if($getbranches['type'] == "branch"){ echo 'disabled'; }?>>
    		                        <option value="" hidden>Choose one</option>
    		                        <option <?php if($getbranches['type'] == "agent" && $getbranches['broker_commission_type'] == "Kg"){ echo 'selected'; } ?>>Kg</option>
    		                        <option <?php if($getbranches['type'] == "agent" && $getbranches['broker_commission_type'] == "Percentage"){ echo 'selected'; } ?>>Percentage</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Ser. Tax. No.</label>
		                    <input type="text" class="form-control" placeholder="Enter Ser. Tax. No." name="service_tax_no" value="<?= $getbranches['service_tax_no']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Nature</label>
		                    <input type="text" class="form-control" placeholder="Enter Nature" name="nature" value="<?= $getbranches['nature']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Weight Round Off</label>
		                    <input type="text" class="form-control" placeholder="Enter Weight Round Off" name="weight_round_off" value="<?= $getbranches['weight_round_off']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Pan No.</label>
		                    <input type="text" class="form-control" placeholder="Enter Pan No." name="pan_no" value="<?= $getbranches['pan_no']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>GST No.</label>
		                    <input type="text" class="form-control" placeholder="Enter GST No." name="gst_no" value="<?= $getbranches['gst_no']; ?>">
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Fuel Surcharge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Fuel Surcharge" name="fuel_surcharge" value="<?= $getbranches['fuel_surcharge']; ?>">
    		                    <select class="form-control" name="fuel_surcharge_type">
    		                        <option <?php if($getbranches['fuel_surcharge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>
    		                        <option <?php if($getbranches['fuel_surcharge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-1 mb-3">
		                    <label>COD Min.</label>
		                    <input type="text" class="form-control numeric-decimal" name="cod_charge_min" value="<?= $getbranches['cod_charge_min']; ?>" placeholder="COD Min.">
		                </div>
		                <div class="col-md-3 mb-3">
		                    <label>COD Charge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter COD Charge" name="cod_charge" value="<?= $getbranches['cod_charge']; ?>">
    		                    <select class="form-control" name="cod_charge_type">
    		                        <option <?php if($getbranches['cod_charge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>
    		                        <option <?php if($getbranches['cod_charge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>AWB Charge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter AWB Charge" name="awb_charge" value="<?= $getbranches['awb_charge']; ?>">
		                    </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>FOB Surcharge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Surcharge Minimum" name="fob_surcharge_minimum" value="<?= $getbranches['fob_surcharge_minimum']; ?>">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Surcharge in %" name="fob_surcharge_percentage" value="<?= $getbranches['fob_surcharge_percentage']; ?>">
		                    </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Handeling Charge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Handeling Charge" name="handeling_charge" value="<?= $getbranches['handeling_charge']; ?>">
    		                    <select class="form-control" name="handeling_charge_type">
    		                        <option <?php if($getbranches['handeling_charge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
    		                        <option <?php if($getbranches['handeling_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Cartage Charge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Cartage Charge" name="cartage_charge" value="<?= $getbranches['cartage_charge']; ?>">
    		                    <select class="form-control" name="cartage_charge_type">
    		                        <option <?php if($getbranches['cartage_charge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>
    		                        <option <?php if($getbranches['cartage_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-1 mb-3">
		                    <label style="font-size: 12px;">Damrage Min.</label>
		                    <input type="text" class="form-control numeric-decimal" name="damage_surcharge_min" value="<?= $getbranches['damage_surcharge_min']; ?>" placeholder="Damrage Min.">
		                </div>
		                <div class="col-md-3 mb-3">
		                    <label>Damrage Surcharge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Damage Surcharge" name="damage_surcharge" value="<?= $getbranches['damage_surcharge']; ?>">
    		                    <select class="form-control" name="damage_surcharge_type">
    		                        <option <?php if($getbranches['damage_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
    		                        <option <?php if($getbranches['damage_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-1 mb-3">
		                    <label>ODA Min.</label>
		                    <input type="text" class="form-control numeric-decimal" name="oda_surcharge_min" placeholder="ODA Min." value="<?= $getbranches['oda_surcharge_min']; ?>">
		                </div>
		                <div class="col-md-3 mb-3">
		                    <label>ODA Surcharge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter ODA Surcharge" name="oda_surcharge" value="<?= $getbranches['handeling_charge']; ?>">
    		                    <select class="form-control" name="oda_surcharge_type">
    		                        <option <?php if($getbranches['oda_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
    		                        <option <?php if($getbranches['oda_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Packaging Surcharge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Packaging Surcharge" name="packaging_surcharge" value="<?= $getbranches['packaging_surcharge']; ?>">
    		                    <select class="form-control" name="packaging_surcharge_type">
    		                        <option <?php if($getbranches['packaging_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
    		                        <option <?php if($getbranches['packaging_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-1 mb-3">
		                    <label>App Min.</label>
		                    <input type="text" class="form-control numeric-decimal" name="special_delivery_or_appointment_charge_min" placeholder="App Min." value="<?= $getbranches['special_delivery_or_appointment_charge_min']; ?>">
		                </div>
		                <div class="col-md-3 mb-3">
		                    <label>Special Delivery / Appointment Surcharge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Special Delivery / Appointment Charge" name="special_delivery_or_appointment_charge" value="<?= $getbranches['special_delivery_or_appointment_charge']; ?>">
    		                    <select class="form-control" name="special_delivery_or_appointment_charge_type">
    		                        <option <?php if($getbranches['pickup_charge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>
    		                        <option <?php if($getbranches['pickup_charge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-4 mb-3">
		                    <label>Pickup Charge</label>
		                    <div class="input-group">
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Pickup Charge" name="pickup_charge" value="<?= $getbranches['pickup_charge']; ?>">
    		                    <select class="form-control" name="pickup_charge_type">
    		                        <option <?php if($getbranches['pickup_charge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
    		                        <option <?php if($getbranches['pickup_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
    		                    </select>
		                    </div>
		                </div>
		                <div class="col-md-4 mb-3" id="credit_limit">
		                    <?php if($getbranches['credit_type'] == "TBB"){ ?>
    		                    <label>Credit Limit</label>
    		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Credit Limit" name="credit_limit" value="<?= $getbranches['credit_limit']; ?>">
		                    <?php } ?>
		                </div>
		                <div class="row mt-3 mb-3">
    		                <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">
        		                <div class="form-group" style="display: flex;">
                                    <input type="checkbox" id="printigst" name="igst" class="branchwise" <?php if($getbranches['igst'] == "yes"){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                    <label for="printigst" style="cursor: pointer;">Print IGST on Bill</label>
                                </div>
                            </div>
    		                <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">
        		                <div class="form-group" style="display: flex;">
                                    <input type="checkbox" id="branchwise" name="branch_charge" value="charge branchwise" <?php if($getbranches['branch_charge'] == "yes"){ echo 'checked'; } ?> class="branchwise">&nbsp;&nbsp;&nbsp;
                                    <label for="branchwise" style="cursor: pointer;">Charge Batchwise</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- modal -->
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" name="branchChargeButton" data-bs-target=".bd-example-modal-lg" style="display: none;"></button>
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit default fright master for <?= $getbranches['branch_name']; ?> (<?= $getbranches['branch_user_name'];  ?>)</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                		    <?php
                                		        $frights = $query->getData('*','branches_fright_master','',array("branch_id"=>$getbranches['id']),'','','')[0];
                                		    ?>
                            		        <div class="">
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">Zones</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">N1</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">N2</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">E</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">NE</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">W1</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">W2</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">S1</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">S2</strong>
                            		                </div>
                            		                <div class="col-1 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">Central</strong>
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">N1</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_n1" value="<?= $frights['n1_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_n2" value="<?= $frights['n1_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_e" value="<?= $frights['n1_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_ne" value="<?= $frights['n1_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_w1" value="<?= $frights['n1_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_w2" value="<?= $frights['n1_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_s1" value="<?= $frights['n1_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_s2" value="<?= $frights['n1_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n1_to_central" value="<?= $frights['n1_to_central']; ?>">
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">N2</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_n1" value="<?= $frights['n2_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_n2" value="<?= $frights['n2_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_e" value="<?= $frights['n2_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_ne" value="<?= $frights['n2_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_w1" value="<?= $frights['n2_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_w2" value="<?= $frights['n2_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_s1" value="<?= $frights['n2_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_s2" value="<?= $frights['n2_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="n2_to_central" value="<?= $frights['n2_to_central']; ?>">
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">E</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_n1" value="<?= $frights['e_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_e" value="<?= $frights['e_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_ne" value="<?= $frights['e_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_w1" value="<?= $frights['e_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_w2" value="<?= $frights['e_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_s1" value="<?= $frights['e_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_s2" value="<?= $frights['e_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="e_to_central" value="<?= $frights['e_to_central']; ?>">
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">NE</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_n1" value="<?= $frights['ne_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_n2" value="<?= $frights['ne_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_e" value="<?= $frights['ne_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_ne" value="<?= $frights['ne_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_w1" value="<?= $frights['ne_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_w2" value="<?= $frights['ne_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_s1" value="<?= $frights['ne_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_s2" value="<?= $frights['ne_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="ne_to_central" value="<?= $frights['ne_to_central']; ?>">
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">W1</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_n2" value="<?= $frights['w1_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_e" value="<?= $frights['w1_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_ne" value="<?= $frights['w1_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_w1" value="<?= $frights['w1_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_w2" value="<?= $frights['w1_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_s1" value="<?= $frights['w1_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_s2" value="<?= $frights['w1_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w1_to_central" value="<?= $frights['w1_to_central']; ?>">
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">W2</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_n1" value="<?= $frights['w2_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_n2" value="<?= $frights['w2_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_e" value="<?= $frights['w2_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_ne" value="<?= $frights['w2_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_w1" value="<?= $frights['w2_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_w2" value="<?= $frights['w2_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_s1" value="<?= $frights['w2_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_s2" value="<?= $frights['w2_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="w2_to_central" value="<?= $frights['w2_to_central']; ?>">
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">S1</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_n1" value="<?= $frights['s1_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_n2" value="<?= $frights['s1_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_e" value="<?= $frights['s1_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_ne" value="<?= $frights['s1_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_w1" value="<?= $frights['s1_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_w2" value="<?= $frights['s1_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_s1" value="<?= $frights['s1_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_s2" value="<?= $frights['s1_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s1_to_central" value="<?= $frights['s1_to_central']; ?>">
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">S2</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_n1" value="<?= $frights['s2_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_n2" value="<?= $frights['s2_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_e" value="<?= $frights['s2_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_ne" value="<?= $frights['s2_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_w1" value="<?= $frights['s2_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_w2" value="<?= $frights['s2_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_s1" value="<?= $frights['s2_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_s2" value="<?= $frights['s2_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="s2_to_central" value="<?= $frights['s2_to_central']; ?>">
                            		                </div>
                            		            </div>
                            		            <div class="row mb-2">
                            		                <div class="col-2 d-flex justify-content-center align-items-center">
                            		                    <strong style="font-size: large;">Central</strong>
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_n1" value="<?= $frights['central_to_n1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_n2" value="<?= $frights['central_to_n2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_e" value="<?= $frights['central_to_e']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_ne" value="<?= $frights['central_to_ne']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_w1" value="<?= $frights['central_to_w1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_w2" value="<?= $frights['central_to_w2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_s1" value="<?= $frights['central_to_s1']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_s2" value="<?= $frights['central_to_s2']; ?>">
                            		                </div>
                            		                <div class="col-1">
                            		                    <input type="text" class="form-control numeric-decimal" name="central_to_central" value="<?= $frights['central_to_central']; ?>">
                            		                </div>
                            		            </div>
                                    		</div>
                                		</div>
                                    </div>
                    		        <div class="modal-footer d-flex" style="justify-content: space-between;">
                    		            <button class="btn btn-danger btn-sm" type="reset">Reset <i class="bi bi-repeat"></i></button>
                    		            <button class="btn btn-warning btn-sm" type="button" data-bs-dismiss="modal">Save Changes <i class="bi bi-pen-fill"></i></button>
                    		        </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal -->
                        
		                <div class="row d-flex justify-content-end">
	                        <button class="col-md-2 col-5 btn btn-warning" type="submit" name="saveChangesBranch">Save Changes <i class="bi bi-pen-fill"></i></button>
		                </div>
		            </div>
		        </form>
          <!--      <form action="actions" method="POST" class="card-body card-mobile">-->
		        <!--    <div class="row">-->
		        <!--        <input type="hidden" value="<?= $getbranches['branch_user_name']; ?>" name="branch_user_name">-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Branch Name</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Branch" name="branch_name" value="<?= $getbranches['branch_name']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Contact Person</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Contact Person Name" name="contact_person" value="<?= $getbranches['contact_person']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>GST Trade Name</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter GST Trade Name" name="gst_trade_name" value="<?= $getbranches['gst_trade_name']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Address</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Address" name="address" value="<?= $getbranches['address']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Phone No.</label>-->
		        <!--            <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Phone No." name="phone_no" value="<?= $getbranches['phone_no']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>EWB Transporter Id</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter EWB Transporter Id" name="ewb_transporter_id" value="<?= $getbranches['ewb_transporter_id']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>City</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter City" name="city" value="<?= $getbranches['city']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Mobile No.</label>-->
		        <!--            <input type="text" class="form-control txtNumeric" maxlength="10" placeholder="Enter Mobile No." name="mobile_no" value="<?= $getbranches['mobile_no']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>District</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter District" name="district" value="<?= $getbranches['district']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Email</label>-->
		        <!--            <input type="email" class="form-control" placeholder="Enter Email Address" name="email" value="<?= $getbranches['email']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>State</label>-->
		        <!--            <select class="form-control" name="state">-->
	         <!--               </select>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Pin Code</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Pin Code" name="pincode" value="<?= $getbranches['pincode']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Type</label>-->
		        <!--            <select class="form-control" name="type">-->
		        <!--                <option value="" hidden>Choose</option>-->
		        <!--                <option value="branch" <?php if($getbranches['type'] == "branch"){ echo 'selected'; } ?>>Branch</option>-->
		        <!--                <option value="agent" <?php if($getbranches['type'] == "agent"){ echo 'selected'; } ?>>Agent</option>-->
		        <!--            </select>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <select class="form-control" name="credit_type">-->
		        <!--                <option value="" hidden>Choose</option>-->
		        <!--                <option value="Regular" <?php if($getbranches['credit_type'] == "Regular"){ echo 'selected'; } ?>>Regular</option>-->
		        <!--                <option value="TBB" <?php if($getbranches['credit_type'] == "TBB"){ echo 'selected'; } ?>>TBB</option>-->
		        <!--            </select>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Min Charge Weight</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Min Charge Weight" name="min_charge_weight" value="<?= $getbranches['min_charge_weight']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Freight Type</label>-->
		        <!--            <select class="form-control" name="freight_type" required>-->
		        <!--                <option hidden value="">Choose freight type</option>-->
		        <!--                <option <?php if($getbranches['freight_type'] == "Quantity"){ echo 'selected'; } ?>>Quantity</option>-->
		        <!--                <option <?php if($getbranches['freight_type'] == "Weight"){ echo 'selected'; } ?>>Weight</option>-->
		        <!--            </select>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>TDS</label>-->
		        <!--            <select class="form-control" name="tds" required>-->
		        <!--                <option hidden value="">Choose one</option>-->
		        <!--                <option <?php if($getbranches['tds'] == "yes"){ echo 'selected'; } ?>>Yes</option>-->
		        <!--                <option <?php if($getbranches['tds'] == "no"){ echo 'selected'; } ?>>No</option>-->
		        <!--            </select>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>3PL</label>-->
		        <!--            <select class="form-control" name="threepl" required>-->
		        <!--                <option hidden value="">Choose 3PL</option>-->
		        <!--                <option value="all" <?php if($getbranches['threepl'] == 'all'){echo "selected";} ?>>All</option>-->
		        <!--            </select>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Broker Commission</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal <?php if($getbranches['type'] == "branch"){ echo 'bg-light'; } ?>" placeholder="Enter Broker Commission" name="broker_commission" <?php if($getbranches['type'] == "branch"){ echo 'disabled'; }else{ echo 'value="'.$getbranches["broker_commission"].'"'; } ?>>-->
    		    <!--                <select class="form-control <?php if($getbranches['type'] == "branch"){ echo 'bg-light'; } ?>" name="broker_commission_type" <?php if($getbranches['type'] == "branch"){ echo 'disabled'; }?>>-->
    		    <!--                    <option value="" hidden>Choose one</option>-->
    		    <!--                    <option <?php if($getbranches['type'] == "agent" && $getbranches['broker_commission_type'] == "Kg"){ echo 'selected'; } ?>>Kg</option>-->
    		    <!--                    <option <?php if($getbranches['type'] == "agent" && $getbranches['broker_commission_type'] == "Percentage"){ echo 'selected'; } ?>>Percentage</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Ser. Tax. No.</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Ser. Tax. No." name="service_tax_no" value="<?= $getbranches['service_tax_no']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Nature</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Nature" name="nature" value="<?= $getbranches['nature']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Weight Round Off</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Weight Round Off" name="weight_round_off" value="<?= $getbranches['weight_round_off']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Pan No.</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter Pan No." name="pan_no" value="<?= $getbranches['pan_no']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>GST No.</label>-->
		        <!--            <input type="text" class="form-control" placeholder="Enter GST No." name="gst_no" value="<?= $getbranches['gst_no']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Fuel Surcharge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter Fuel Surcharge" name="fuel_surcharge" value="<?= $getbranches['fuel_surcharge']; ?>">-->
    		    <!--                <select class="form-control" name="fuel_surcharge_type">-->
    		    <!--                    <option <?php if($getbranches['fuel_surcharge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>-->
    		    <!--                    <option <?php if($getbranches['fuel_surcharge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-1 mb-3">-->
		        <!--            <label>COD Min.</label>-->
		        <!--            <input type="text" class="form-control numeric-decimal" name="cod_charge_min" value="<?= $getbranches['cod_charge_min']; ?>" placeholder="COD Min.">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-3 mb-3">-->
		        <!--            <label>COD Charge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter COD Charge" name="cod_charge" value="<?= $getbranches['cod_charge']; ?>">-->
    		    <!--                <select class="form-control" name="cod_charge_type">-->
    		    <!--                    <option <?php if($getbranches['cod_charge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>-->
    		    <!--                    <option <?php if($getbranches['cod_charge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>AWB Charge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter AWB Charge" name="awb_charge" value="<?= $getbranches['awb_charge']; ?>">-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>FOB Surcharge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Surcharge Minimum" name="fob_surcharge_minimum" value="<?= $getbranches['fob_surcharge_minimum']; ?>">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Surcharge in %" name="fob_surcharge_percentage" value="<?= $getbranches['fob_surcharge_percentage']; ?>">-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Handeling Charge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter Handeling Charge" name="handeling_charge" value="<?= $getbranches['handeling_charge']; ?>">-->
    		    <!--                <select class="form-control" name="handeling_charge_type">-->
    		    <!--                    <option <?php if($getbranches['handeling_charge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>-->
    		    <!--                    <option <?php if($getbranches['handeling_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Cartage Surcharge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter Cartage Surcharge" name="cartage_charge" value="<?= $getbranches['cartage_charge']; ?>">-->
    		    <!--                <select class="form-control" name="cartage_charge_type">-->
    		    <!--                    <option <?php if($getbranches['cartage_charge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>-->
    		    <!--                    <option <?php if($getbranches['cartage_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-1 mb-3">-->
		        <!--            <label style="font-size: 12px;">Damrage Min.</label>-->
		        <!--            <input type="text" class="form-control numeric-decimal" name="damage_surcharge_min" value="<?= $getbranches['damage_surcharge_min']; ?>" placeholder="Damrage Min.">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-3 mb-3">-->
		        <!--            <label>Damrage Surcharge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter Damage Surcharge" name="damage_surcharge" value="<?= $getbranches['damage_surcharge']; ?>">-->
    		    <!--                <select class="form-control" name="damage_surcharge_type">-->
    		    <!--                    <option <?php if($getbranches['damage_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>-->
    		    <!--                    <option <?php if($getbranches['damage_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-1 mb-3">-->
		        <!--            <label>ODA Min.</label>-->
		        <!--            <input type="text" class="form-control numeric-decimal" name="oda_surcharge_min" placeholder="ODA Min." value="<?= $getbranches['oda_surcharge_min']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-3 mb-3">-->
		        <!--            <label>ODA Surcharge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter ODA Surcharge" name="oda_surcharge" value="<?= $getbranches['handeling_charge']; ?>">-->
    		    <!--                <select class="form-control" name="oda_surcharge_type">-->
    		    <!--                    <option <?php if($getbranches['oda_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>-->
    		    <!--                    <option <?php if($getbranches['oda_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Packaging Surcharge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter Packaging Surcharge" name="packaging_surcharge" value="<?= $getbranches['packaging_surcharge']; ?>">-->
    		    <!--                <select class="form-control" name="packaging_surcharge_type">-->
    		    <!--                    <option <?php if($getbranches['packaging_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>-->
    		    <!--                    <option <?php if($getbranches['packaging_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-1 mb-3">-->
		        <!--            <label>App Min.</label>-->
		        <!--            <input type="text" class="form-control numeric-decimal" name="special_delivery_or_appointment_charge_min" placeholder="App Min." value="<?= $getbranches['special_delivery_or_appointment_charge_min']; ?>">-->
		        <!--        </div>-->
		        <!--        <div class="col-md-3 mb-3">-->
		        <!--            <label>Special Delivery / Appointment Surcharge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter Special Delivery / Appointment Charge" name="special_delivery_or_appointment_charge" value="<?= $getbranches['special_delivery_or_appointment_charge']; ?>">-->
    		    <!--                <select class="form-control" name="special_delivery_or_appointment_charge_type">-->
    		    <!--                    <option <?php if($getbranches['pickup_charge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>-->
    		    <!--                    <option <?php if($getbranches['pickup_charge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3">-->
		        <!--            <label>Pickup Charge</label>-->
		        <!--            <div class="input-group">-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Pickup Charge" name="pickup_charge" value="<?= $getbranches['pickup_charge']; ?>">-->
    		    <!--                <select class="form-control" name="pickup_charge_type">-->
    		    <!--                    <option <?php if($getbranches['pickup_charge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>-->
    		    <!--                    <option <?php if($getbranches['pickup_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>-->
    		    <!--                </select>-->
		        <!--            </div>-->
		        <!--        </div>-->
		        <!--        <div class="col-md-4 mb-3" id="credit_limit">-->
		        <!--            <?php if($getbranches['credit_type']=="TBB"){ ?>-->
    		    <!--                <label>Credit Limit</label>-->
    		    <!--                <input type="text" class="form-control numeric-decimal" placeholder="Enter Credit Limit" name="credit_limit" value="<?= $getbranches['credit_limit']; ?>">-->
		        <!--            <?php } ?>-->
		        <!--        </div>-->
		        <!--        <div class="row mt-3 mb-3">-->
    		    <!--            <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">-->
        		<!--                <div class="form-group" style="display: flex;">-->
          <!--                          <input type="checkbox" id="printigst" name="igst" class="branchwise" <?php if($getbranches['igst'] == "yes"){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;-->
          <!--                          <label for="printigst" style="cursor: pointer;">Print IGST on Bill</label>-->
          <!--                      </div>-->
          <!--                  </div>-->
    		    <!--            <div class="col-md-2" style="display: flex; flex-direction: row; justify-content: start; align-items: end;">-->
        		<!--                <div class="form-group" style="display: flex;">-->
          <!--                          <input type="checkbox" id="branchwise" name="branch_charge" value="charge branchwise" <?php if($getbranches['branch_charge'] == "yes"){ echo 'checked'; } ?> class="branchwise">&nbsp;&nbsp;&nbsp;-->
          <!--                          <label for="branchwise" style="cursor: pointer;">Charge Batchwise</label>-->
          <!--                      </div>-->
          <!--                  </div>-->
          <!--              </div>-->
                        
                        <!-- modal -->
          <!--              <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" name="branchChargeButton" data-bs-target=".bd-example-modal-lg" style="display: none;"></button>-->
          <!--              <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">-->
          <!--                  <div class="modal-dialog modal-xl">-->
          <!--                      <div class="modal-content">-->
          <!--                          <div class="modal-header">-->
          <!--                              <h5 class="modal-title">Edit default fright master for <?= $getbranches['branch_name']; ?> (<?= $getbranches['branch_user_name'];  ?>)</h5>-->
          <!--                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>-->
          <!--                          </div>-->
          <!--                          <div class="modal-body">-->
          <!--                              <div class="row">-->
          <!--                  		        <div class="">-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : N1</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_n1" value="<?= $frights['n1_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_n2" value="<?= $frights['n1_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_e" value="<?= $frights['n1_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_ne" value="<?= $frights['n1_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_w1" value="<?= $frights['n1_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_w2" value="<?= $frights['n1_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_s1" value="<?= $frights['n1_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_s2" value="<?= $frights['n1_to_s2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n1_to_central" value="<?= $frights['n1_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		            <hr style="margin: 30px 0px;"/>-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : N2</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_n1" value="<?= $frights['n2_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_n2" value="<?= $frights['n2_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_e" value="<?= $frights['n2_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_ne" value="<?= $frights['n2_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_w1" value="<?= $frights['n2_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_w2" value="<?= $frights['n2_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_s1" value="<?= $frights['n2_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_s2" value="<?= $frights['n2_to_s2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="n2_to_central" value="<?= $frights['n2_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		            <hr style="margin: 30px 0px;"/>-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : E</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_n1" value="<?= $frights['e_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_e" value="<?= $frights['e_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_ne" value="<?= $frights['e_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_w1" value="<?= $frights['e_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_w2" value="<?= $frights['e_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_s1" value="<?= $frights['e_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="e_to_central" value="<?= $frights['e_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		            <hr style="margin: 30px 0px;"/>-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : NE</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_n1" value="<?= $frights['ne_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_n2" value="<?= $frights['ne_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_e" value="<?= $frights['ne_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_ne" value="<?= $frights['ne_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_w1" value="<?= $frights['ne_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_w2" value="<?= $frights['ne_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_s1" value="<?= $frights['ne_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_s2" value="<?= $frights['ne_to_s2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="ne_to_central" value="<?= $frights['ne_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		            <hr style="margin: 30px 0px;"/>-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : W1</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_n2" value="<?= $frights['w1_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_e" value="<?= $frights['w1_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_ne" value="<?= $frights['w1_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_w1" value="<?= $frights['w1_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_w2" value="<?= $frights['w1_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_s1" value="<?= $frights['w1_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_s2" value="<?= $frights['w1_to_s2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w1_to_central" value="<?= $frights['w1_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		            <hr style="margin: 30px 0px;"/>-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : W2</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_n1" value="<?= $frights['w2_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_n2" value="<?= $frights['w2_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_e" value="<?= $frights['w2_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_ne" value="<?= $frights['w2_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_w1" value="<?= $frights['w2_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_w2" value="<?= $frights['w2_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_s1" value="<?= $frights['w2_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_s2" value="<?= $frights['w2_to_s2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="w2_to_central" value="<?= $frights['w2_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		            <hr style="margin: 30px 0px;"/>-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : S1</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_n1" value="<?= $frights['s1_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_n2" value="<?= $frights['s1_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_e" value="<?= $frights['s1_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_ne" value="<?= $frights['s1_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_w1" value="<?= $frights['s1_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_w2" value="<?= $frights['s1_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_s1" value="<?= $frights['s1_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_s2" value="<?= $frights['s1_to_s2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s1_to_central" value="<?= $frights['s1_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		            <hr style="margin: 30px 0px;"/>-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : S2</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_n1" value="<?= $frights['s2_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_n2" value="<?= $frights['s2_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_e" value="<?= $frights['s2_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_ne" value="<?= $frights['s2_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_w1" value="<?= $frights['s2_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_w2" value="<?= $frights['s2_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_s1" value="<?= $frights['s2_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_s2" value="<?= $frights['s2_to_s2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="s2_to_central" value="<?= $frights['s2_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		            <hr style="margin: 30px 0px;"/>-->
          <!--                  	                <div class="row">-->
          <!--                  	                    <strong style="font-size: large;">From Zones : Central</strong>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  	                    <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_n1" value="<?= $frights['central_to_n1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">N2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_n2" value="<?= $frights['central_to_n2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">E</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_e" value="<?= $frights['central_to_e']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">NE</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_ne" value="<?= $frights['central_to_ne']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-3">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_w1" value="<?= $frights['central_to_w1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">W2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_w2" value="<?= $frights['central_to_w2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S1</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_s1" value="<?= $frights['central_to_s1']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">S2</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_s2" value="<?= $frights['central_to_s2']; ?>">-->
          <!--                  		                </div>-->
          <!--                  	                </div>-->
          <!--                  		            <div class="row mb-2">-->
          <!--                  		                <div class="col-3">-->
          <!--                                              <strong style="font-size: large;">Central</strong>-->
          <!--                  		                    <input type="text" class="form-control numeric-decimal" name="central_to_central" value="<?= $frights['central_to_central']; ?>">-->
          <!--                  		                </div>-->
          <!--                  		            </div>-->
          <!--                  		        </div>-->
          <!--                      		</div>-->
          <!--                          </div>-->
          <!--          		        <div class="modal-footer d-flex" style="justify-content: space-between;">-->
          <!--          		            <button class="btn btn-danger btn-sm" type="reset">Reset <i class="bi bi-repeat"></i></button>-->
          <!--          		            <button class="btn btn-warning btn-sm" type="button" data-bs-dismiss="modal">Save Changes <i class="bi bi-pen-fill"></i></button>-->
          <!--          		        </div>-->
          <!--                      </div>-->
          <!--                  </div>-->
          <!--              </div>-->
                        <!-- modal -->
                        
		        <!--        <div class="row d-flex justify-content-end">-->
	         <!--               <button class="col-md-2 col-5 btn btn-warning" type="submit" name="saveChangesBranch">Save Changes <i class="bi bi-pen-fill"></i></button>-->
		        <!--        </div>-->
		        <!--    </div>-->
		        <!--</form>-->
		    </div>
		</div>
	</div>
</div>

<!--**********************************
    Content body end
***********************************-->
<?php
include("assets/footer.php");
}else{
    header('location:branches-list');
}
?>