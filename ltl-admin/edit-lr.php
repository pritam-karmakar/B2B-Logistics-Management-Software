<?php
extract($_GET);
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
	    <form action="edit-lr" method="GET" class="row mb-3">
	        <div class="col-xl-4 col-sm-6 form-group">
	            <label>Choose user type</label>
	            <select class="form-control form-control-sm" name="visible" id="LRvisibleType">
	                <option value="" hidden>Choose user type</option>
	                <option value="users" <?php if($visible == "users"){ echo 'selected'; } ?>>User</option>
	                <option value="branches" <?php if($visible == "branches"){ echo 'selected'; } ?>>Branch</option>
	            </select>
			</div>
	        <div class="col-xl-4 col-sm-6 form-group">
	            <label>Choose One</label>
	            <select class="form-control form-control-sm" name="LRuserIs">
	                <option value="" hidden>Choose one</option>
	                <?php
	                    if(!empty($visible)){
    	                    $getType = $query->getData('*',$visible,'','','id','DESC','');
    	                        foreach($getType as $user){
                                    if($visible == "users"){
                                        $name = $user['party_name'];
                                        $username = $user['username'];
                                    }elseif($visible == "branches"){
                                        $name = $user['branch_name'];
                                        $username = $user['branch_user_name'];
                                    }
	                ?>
                                    <option value="<?= $username; ?>" <?php if($username == $LRuserIs){ echo 'selected'; } ?>><?= $name.' (Username: '.$username.') [Mob: '.$user['mobile_no'].']'; ?></option>
	               <?php
    	                    }
	                    }
	                ?>
	            </select>
			</div>
			<?php
                if($visible == 'users'){
                    $typeArr = array('username'=>$LRuserIs,'delete_status'=>'show');
                }elseif($visible == 'branches'){
                    $typeArr = array('branch_user_name'=>$LRuserIs,'delete_status'=>'show');
                }
			?>
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>Choose One LR</label>
	            <select class="form-control form-control-sm" id="single-select" name="lr">
	                <?php
	                    if(!empty($visible) && !empty($LRuserIs) && !empty($lr)){
                            $ID = $query->getData('`id`',$visible,'',$typeArr,'id','DESC','1')[0]['id'];
                            $getlrs = $query->getData('*','orders','',array(array('user_type','=',$visible),array('type_id','=',$ID)),'id','DESC','');
                            if($getlrs != 0){
                    ?> 
        	                <option value="" hidden>Choose one</option>
                    <?php
                                foreach($getlrs as $lrs){
                    ?>
                                    <option <?php if($lrs['lr'] == $lr){ echo 'selected'; } ?>><?= $lrs['lr']; ?></option>
                    <?php
                                }
                            }else{
                                echo '<option>No order found!</option>';
                            }
	                    }else{
	               ?>      
    	                <option value="" hidden>Choose one</option>
	               <?php
	                    }
	                ?>
	            </select>
			</div>
	        <div class="col-xl-1 col-sm-6 form-group d-flex align-items-end mb-1">
	            <button class="btn btn-xs me-1 shadow btn-block" style="background-color: #28a745; color: #fff;">Search</button>
			</div>
	    </form>
	    <?php if(!empty($visible) && !empty($LRuserIs) && !empty($lr)){
                  if($visible == "users"){
                      $visibleusername = "username";
                  }elseif($visible == "branches"){
                      $visibleusername = "branch_user_name";
                  }
                  $showusercond = array('user_type'=>$visible,'type_id'=>$query->getData('`id`',$visible,'',array($visibleusername=>$LRuserIs),'id','DESC','1')[0]['id'],'lr'=>$lr);
                  $orders = $query->getData('*','orders','',$showusercond,'id','DESC','1');
                  if($orders != 0){
                      $orders = $orders[0];
                      $get_consignee_details = $query->getData('*','consignee_details','',array("order_id"=>$orders['order_id']),'','','');
                      $get_box_details = $query->getData('*','box_details','',array("order_id"=>$orders['order_id']),'','','');
                      $getwarehouse = $query->getData('*','warehouses','',array('id'=>$orders['warehouse_id']),'id','DESC','1')[0];
                      $getuser = $query->getData('*',$visible,'',array('id'=>$orders['type_id']),'id','DESC','1')[0];
        ?>
		<div class="row">
		    <form class="card" action="act" method="POST" onsubmit="return confirm('Are you sure to want to update this LR?')">
		        <input type="hidden" readonly name="orderId" value="<?= $orders['order_id'] ?>">
		        <div class="card-header">
		            <h3 class="card-title">Edit <?= trim(trim($visible, "s"), "es").": ".$LRuserIs."'s order for lr number: ".$lr; ?></h3>
		        </div>
		        <div class="card-body">
		            <dl class="d-flex justify-content-end">
                        <dt>Manifested Date & Time: &nbsp;</dt><?= $orders['order_date']." ".$orders['order_time']; ?></dd>
                    </dl>
                    <dt>Pickup From (Warehouse name): &nbsp;</dt><dd class="col-md-3"><input type="text" class="form-control form-control-sm bg-light" value="<?= $getwarehouse['warehouse_name']; ?>" disabled></dd>
                    <dl class="row">
                        <dl class="col-xl-3 col-md-2 col-1"></dl>
                        <dl class="col-xl-9 col-md-12 col-11 row">
                            <span class="col-3"><dt>Pincode: </dt><dd><input type="text" class="form-control form-control-sm bg-light" value="<?= $getwarehouse['pincode']; ?>" disabled></dd></span>
                            <span class="col-3"><dt>City: </dt><dd><input type="text" class="form-control form-control-sm bg-light" value="<?= $getwarehouse['city']; ?>" disabled></dd></span>
                            <span class="col-3"><dt>State: </dt><dd><input type="text" class="form-control form-control-sm bg-light" value="<?= $getwarehouse['state']; ?>" disabled></dd></span>
                            <span class="col-3"><dt>Country: </dt><dd><input type="text" class="form-control form-control-sm bg-light" value="<?= $getwarehouse['country']; ?>" disabled></dd></span>
                            <span class="col-9"><dt>Address: </dt><dd><input type="text" class="form-control form-control-sm bg-light" value="<?= $getwarehouse['address']; ?>" disabled></dd></span>
                        </dl>
                    </dl><hr/>
                    <dt>Deliver To: &nbsp;</dt>
                    <dl class="row">
                        <dl class="col-xl-3 col-md-2 col-1"></dl>
                        <dl class="col-xl-9 col-md-12 col-11 row">
                            <span class="col-3"><dt>Name: </dt><dd><input type="text" class="form-control form-control-sm" name="consignee_name" value="<?= $get_consignee_details[0]['name']; ?>"></dd></span>
                            <span class="col-3"><dt>Company name: </dt><dd><input type="text" class="form-control form-control-sm" name="consignee_company" value="<?= $get_consignee_details[0]['company']; ?>"></dd></span>
                            <span class="col-3"><dt>Pincode: </dt><dd><input type="text" class="form-control form-control-sm" name="consignee_pincode" value="<?= $orders['del_pin']; ?>"></dd></span>
                            <span class="col-3"><dt>City: </dt><dd><input type="text" class="form-control form-control-sm" name="consignee_city" value="<?= $get_consignee_details[0]['city']; ?>"></dd></span>
                            <span class="col-9"><dt>Address: </dt><dd><input type="text" class="form-control form-control-sm" name="consignee_address" value="<?= $get_consignee_details[0]['address']; ?>"></dd></span>
                            <span class="col-3"><dt>State: </dt><dd><input type="text" class="form-control form-control-sm" name="consignee_state" value="<?= $get_consignee_details[0]['state']; ?>"></dd></span>
                            <span class="col-4">
                                <dt>Phone Number: </dt>
                                <dd>
                                    <input type="text" class="form-control form-control-sm txtNumeric" name="consignee_phone" value="<?= $get_consignee_details[0]['phone']; ?>">
                                </dd>
                            </span>
                            <span class="col-4">
                                <dt>Email: </dt>
                                <dd>
                                    <input type="text" class="form-control form-control-sm" name="consignee_email" value="<?= $get_consignee_details[0]['email']; ?>">
                                </dd>
                            </span>
                        </dl>
                    </dl><hr/>
                    <?php
                        if($visible == "branches"):
                            $getConsignerDetails = $query->getData('*','consigner_details','',array('order_id'=>$orders['order_id']),'id','DESC','1')[0];
                    ?>
                        <dt>Consigner Details: &nbsp;</dt>
                        <dl class="row">
                            <dl class="col-xl-3 col-md-2 col-1"></dl>
                            <dl class="col-xl-9 col-md-12 col-11 row">
                                <span class="col-3"><dt>Name: </dt><dd><input type="text" class="form-control form-control-sm" name="consigner_name" value="<?= $getConsignerDetails['name']; ?>"></dd></span>
                                <span class="col-3"><dt>Company name: </dt><dd><input type="text" class="form-control form-control-sm" name="consigner_company" value="<?= $getConsignerDetails['company']; ?>"></dd></span>
                                <span class="col-3"><dt>City: </dt><dd><input type="text" class="form-control form-control-sm" name="consigner_city" value="<?= $getConsignerDetails['city']; ?>"></dd></span>
                                <span class="col-3"><dt>State: </dt><dd><input type="text" class="form-control form-control-sm" name="consigner_state" value="<?= $getConsignerDetails['state']; ?>"></dd></span>
                                <span class="col-12"><dt>Address: </dt><dd><input type="text" class="form-control form-control-sm" name="consigner_address" value="<?= $getConsignerDetails['address']; ?>"></dd></span>
                                <span class="col-4">
                                    <dt>Phone Number: </dt>
                                    <dd>
                                        <input type="text" class="form-control form-control-sm txtNumeric" name="consigner_phone" value="<?= $getConsignerDetails['phone']; ?>">
                                    </dd>
                                </span>
                                <span class="col-4">
                                    <dt>Email: </dt>
                                    <dd>
                                        <input type="text" class="form-control form-control-sm" name="consigner_email" value="<?= $getConsignerDetails['email']; ?>">
                                    </dd>
                                </span>
                            </dl>
                        </dl><hr/>
                    <?php
                        endif;
                    ?>
                    <dt>Invoice Details: &nbsp;</dt>
                    <?php
                        $invquery = $query->getData('*','invoice_details','',array("order_id"=>$orders['order_id']),"","","");
                        foreach($invquery as $invs){
                    ?>
                    <dl class="row">
                        <dl class="col-xl-3 col-md-2 col-1"></dl>
                        <dl class="col-xl-9 col-md-12 col-11 row">
                            <span class="col-4"><dt>E-Waybill: </dt><dd><input type="text" class="form-control form-control-sm" name="ewaybill[]" value="<?= $invs['ewaybill']; ?>"></dd></span>
                            <span class="col-4"><dt>Invoice Amount: </dt><dd><input type="text" class="form-control form-control-sm numeric-decimal" name="n_value[]" value="<?= $invs['n_value']; ?>"></dd></span>
                            <span class="col-4"><dt>Invoice Number: </dt><dd><input type="text" class="form-control form-control-sm" name="inv_no[]" value="<?= $invs['inv_no']; ?>"></dd></span>
                        </dl>
                    </dl><hr/>
                    <?php } ?>
                    <dt class="mb-2">Dimentions: &nbsp;</dt>
                    <?php
                        $boxquery = $query->getData('*','box_details','',array("order_id"=>$orders['order_id']),"","","");
                        $sl = 1;
                        foreach($boxquery as $boxs){
                    ?>
                    <dl class="row">
                        <?php if($sl == 1){ ?>
                        <dl class="col-xl-3 col-md-2 col-1">
                            <span class="col-12">
                                <dt>Dimentions In: </dt>
                                <dd>
                                    <select class="form-control form-control-sm txtNumeric" name="dimention">
                                        <option value="cm" <?php if($boxs['dimention'] == "cm"){ echo 'selected'; } ?>>CM</option>
                                        <option value="inch" <?php if($boxs['dimention'] == "inch"){ echo 'selected'; } ?>>INCH</option>
                                    </select>
                                </dd>
                            </span>
                        </dl>
                        <?php }else{ ?>
                        <dl class="col-xl-3 col-md-2 col-1"></dl>
                        <?php } ?>
                        <dl class="col-xl-9 col-md-12 col-11 row">
                            <span class="col-3"><dt>Qty: </dt><dd><input type="text" class="form-control form-control-sm txtNumeric" name="qty[]" value="<?= $boxs['qty']; ?>"></dd></span>
                            <span class="col-3"><dt>Length: </dt><dd><input type="text" class="form-control form-control-sm numeric-decimal" name="length[]" value="<?= $boxs['length']; ?>"></dd></span>
                            <span class="col-3"><dt>Width: </dt><dd><input type="text" class="form-control form-control-sm numeric-decimal" name="width[]" value="<?= $boxs['width']; ?>"></dd></span>
                            <span class="col-3"><dt>Height: </dt><dd><input type="text" class="form-control form-control-sm numeric-decimal" name="height[]" value="<?= $boxs['height']; ?>"></dd></span>
                        </dl>
                    </dl><hr/>
                    <?php $sl++;} ?>
                    <dl class="row">
                        <dl class="col-xl-12 col-md-12 col-12 row">
                            <span class="col-2"><dt>Weight in Kg: </dt><dd><input type="text" class="form-control form-control-sm numeric-decimal" name="weight" value="<?= $orders['weight']; ?>"></dd></span>
                            <span class="col-2"><dt>Volumatric Weight in Kg: </dt><dd><input type="text" class="form-control form-control-sm numeric-decimal bg-light" readonly value="<?php if(empty($orders['vol_weight'])){ echo 0; }else{ echo $orders['vol_weight']; } ?>"></dd></span>
                            <span class="col-2">
                                <dt>Payment Mode: </dt>
                                <dd>
                                    <select class="form-control form-control-sm" name="lr_payment_mode">
                                        <?php
                                            if($orders['user_type'] == "users"){
                                                if($getuser['party_type'] == "Paid" || $getuser['party_type'] == "All" || $getuser['party_type'] == "TBB"){ ?>
                                                    <option value="Prepaid" <?php if($orders['payment_mode'] == "Prepaid"){ echo 'selected'; } ?>>Prepaid</option>
                                        <?php   } if($getuser['party_type'] == "All" || $getuser['cod_charge_enable_disable'] == "enable"){ ?>
                                                    <option value="CoD" <?php if($orders['payment_mode'] == "CoD"){ echo 'selected'; } ?>>COD</option>
                                        <?php   } if($getuser['party_type'] == "To-Pay" || $getuser['party_type'] == "All"){ ?>
                                                    <option value="To-Pay" <?php if($orders['payment_mode'] == "To-Pay"){ echo 'selected'; } ?>>To-Pay</option>
                                        <?php   } if($getuser['party_type'] == "To-Pay" || $getuser['party_type'] == "All"){ ?>
                                                    <option value="Franchise-ToPay" <?php if($orders['payment_mode'] == "Franchise-ToPay"){ echo 'selected'; } ?>>Franchise-ToPay</option>
                                        <?php   } 
                                            }elseif($orders['user_type'] == "branches"){
                                        ?>
                                                    <option value="Prepaid" <?php if($orders['payment_mode'] == "Prepaid"){ echo 'selected'; } ?>>Prepaid</option>
                                                    <option value="CoD" <?php if($orders['payment_mode'] == "CoD"){ echo 'selected'; } ?>>COD</option>
                                                    <option value="To-Pay" <?php if($orders['payment_mode'] == "To-Pay"){ echo 'selected'; } ?>>To-Pay</option>
                                                    <option value="Franchise-ToPay" <?php if($orders['payment_mode'] == "Franchise-ToPay"){ echo 'selected'; } ?>>Franchise-ToPay</option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </dd>
                            </span>
                            <span class="col-3">
                                <dt>Invoice Value: </dt>
                                <dd>
                                    <input type="text" class="form-control form-control-sm numeric-decimal" name="invoice_amount" value="<?= $orders['invoice_amount']; ?>">
                                </dd>
                            </span>
                            <?php if($getuser['cod_charge_enable_disable'] == "enable"){ ?>
                            <span class="col-3">
                                <dt>COD Amount: </dt>
                                <dd>
                                    <input type="text" class="form-control form-control-sm numeric-decimal bg-light <?php if($orders['payment_mode'] != "CoD"){ echo 'bg-light'; } ?>" name="cod_amount" value="<?php if($orders['cod_amount'] != 0){ echo $orders['cod_amount']; } ?>" <?php if($orders['payment_mode'] != "CoD"){ echo 'disabled'; } ?>>
                                </dd>
                            </span>
                            <?php } ?>
                            <span class="col-3">
                                <dt class="mb-2">Insurance: </dt>
                                <dd>
                                    <div class="form-group" style="display: flex;">
                                        <input type="checkbox" id="insurance" name="checkInsurance" class="branchwise" value="Yes" <?php if($orders['insurance'] == "Yes"){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                        <label for="insurance" style="cursor: pointer;"></label>
                                    </div>
                                </dd>
                            </span>
                            <span class="col-3"><dt>Seller GST TIN: </dt><dd><input type="text" class="form-control form-control-sm txtNumeric" name="seller_gst_tin" value="<?= $orders['seller_gst_tin']; ?>"></dd></span>
                            <span class="col-3"><dt>Consignee GST TIN: </dt><dd><input type="text" class="form-control form-control-sm txtNumeric" name="consignee_gst_tin" value="<?= $orders['consignee_gst_tin']; ?>"></dd></span>
                            <?php if($getuser['party_type'] == "Franchise-ToPay" || $getuser['party_type'] == "All"){ ?>
                            <span class="col-3">
                                <dt>Profit Amount: </dt>
                                <dd>
                                    <input type="text" class="form-control form-control-sm numeric-decimal bg-light <?php if($orders['payment_mode'] != "Franchise-ToPay"){ echo 'bg-light'; } ?>" name="profit_amount" value="<?php if($orders['profit_amount'] != 0){ echo $orders['profit_amount']; } ?>" <?php if($orders['payment_mode'] != "Franchise-ToPay"){ echo 'disabled'; } ?>>
                                </dd>
                            </span>
                            <?php } ?>
                        </dl>
                    </dl><hr/>
                    <dl class="col-xl-12 col-md-12 col-12 row">
                        <span class="col-2"><dt>Previous Charges: </dt><dd></dd></span>
                        <dl class="col-xl-10 col-md-10 col-12 row d-flex" style="justify-content: space-between;">
                            <span class="col-4 d-flex pb-2">
                                <b>Weight Charge : </b> &nbsp;&nbsp;<?= $orders['weight_charge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>Fuel Surcharge : </b> &nbsp;&nbsp;<?= $orders['fuel_surcharge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>COD Charge : </b> &nbsp;&nbsp;<?= $orders['cod_charge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>AWB Charge : </b> &nbsp;&nbsp;<?= $orders['awb_charge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>FOV Charge : </b> &nbsp;&nbsp;<?= $orders['fob_surcharge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>Handeling Charge : </b> &nbsp;&nbsp;<?= $orders['handeling_charge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>Cartage Charge : </b> &nbsp;&nbsp;<?= $orders['cartage_charge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>Damrage Charge : </b> &nbsp;&nbsp;<?= $orders['damage_surcharge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>ODA Surcharge : </b> &nbsp;&nbsp;<?= $orders['oda_surcharge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>Packaging Surcharge : </b> &nbsp;&nbsp;<?= $orders['packaging_surcharge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>Pickup Charge : </b> &nbsp;&nbsp;<?= $orders['pickup_charge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>Special Delivery / Appoint. Surcharge : </b> &nbsp;&nbsp;<?= $orders['special_delivery_charge']; ?>
                            </span>
                            <span class="col-4 d-flex pb-2">
                                <b>GST Charge : </b> &nbsp;&nbsp;<?= round($orders['igst_amount']+$orders['cgst_amount']+$orders['sgst_amount'], 2); ?>
                            </span>
                            <span class="col-12 d-flex justify-content-end" style="font-size: 16px;">
                                <b>Total Charge : </b> &nbsp;&nbsp;<?= $orders['total_charge']; ?>
                            </span>
                        </dl>
                    </dl><hr/>
                    <dl class="row">
                        <dl class="col-xl-12 col-md-12 col-12 row">
                            <span class="col-2"><dt>All Charges: </dt><dd></dd></span>
                            <dl class="col-xl-10 col-md-10 col-12 row">
                                <span class="col-2">
        		                    <label>Weight Charge</label>
        		                    <div class="input-group">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Weight Charge" value="<?= $orders['applied_weight_charge']; ?>" name="applied_weight_charge">
        		                    </div>
                                </span>
                                <span class="col-3">
        		                    <label>Fuel Surcharge</label>
        		                    <div class="input-group">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Fuel Surcharge" value="<?= $orders['applied_fuel_surcharge']; ?>" name="applied_fuel_surcharge">
            		                    <select class="form-control" name="applied_fuel_surcharge_type">
            		                        <option <?php if($orders['applied_fuel_surcharge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>
            		                        <option <?php if($orders['applied_fuel_surcharge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>
            		                    </select>
        		                    </div>
                                </span>
                                <span class="col-5 d-flex" style="padding-right: 14px;">
                                    <div class="col-md-4 mb-3" style="padding-right: 2rem;">
            		                    <label>COD Min.</label>
            		                    <input type="text" class="form-control numeric-decimal" name="applied_cod_charge_min" placeholder="COD Min." value="<?= $orders['applied_cod_charge_min']; ?>">
            		                </div>
            		                <div class="col-md-8 mb-3">
            		                    <label>COD Charge</label>
            		                    <div class="input-group">
                		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter COD Charge" name="applied_cod_charge" value="<?= $orders['applied_cod_charge']; ?>">
                		                    <select class="form-control" name="applied_cod_charge_type">
                		                        <option <?php if($orders['applied_cod_charge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>
                		                        <option <?php if($orders['applied_cod_charge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>
                		                    </select>
            		                    </div>
            		                </div>
                                </span>
                                <span class="col-2">
        		                    <label>AWB Charge</label>
        		                    <div class="input-group">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter AWB Charge" value="<?= $orders['applied_awb_charge']; ?>" name="applied_awb_charge">
        		                    </div>
                                </span>
                                <span class="col-4 mb-3">
        		                    <label>FOV Surcharge</label>
        		                    <div class="input-group">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV Min." value="<?= $orders['applied_fob_surcharge_minimum']; ?>" name="applied_fob_surcharge_minimum">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter FOV in %" value="<?= $orders['applied_fob_surcharge_percentage']; ?>" name="applied_fob_surcharge_percentage">
        		                    </div>
                                </span>
        		                <span class="col-4 mb-3">
        		                    <label>Handeling Charge</label>
        		                    <div class="input-group">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Handeling Charge" value="<?= $orders['applied_handeling_charge']; ?>" name="applied_handeling_charge">
            		                    <select class="form-control" name="applied_handeling_charge_type">
            		                        <option <?php if($orders['applied_handeling_charge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
            		                        <option <?php if($orders['applied_handeling_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
            		                    </select>
        		                    </div>
        		                </span>      
        		                <span class="col-4 mb-3">
        		                    <label>Cartage Charge</label>
        		                    <div class="input-group">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Cartage Charge" value="<?= $orders['applied_cartage_charge']; ?>" name="applied_cartage_charge">
            		                    <select class="form-control" name="applied_cartage_charge_type">
            		                        <option <?php if($orders['applied_cartage_charge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>
            		                        <option <?php if($orders['applied_cartage_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
            		                    </select>
        		                    </div>
        		                </span>
        		                <span class="col-6 d-flex" style="padding-right: 14px;">
        		                    <div class="d-flex" style="flex-direction: column;">
            		                    <label>On/Off</label>
                		                <div class="col-md-1 mb-3 d-flex justify-content-start align-items-end">
                		                    <div class="form-check custom-checkbox mb-3 checkbox-warning check-lg">
    											<input type="checkbox" name="damage_charge_applied" class="form-check-input" id="customCheckBox9" <?php if($orders['damage_charge_applied'] == "Yes"){ echo "checked"; } ?>>
    											<label class="form-check-label" for="customCheckBox9"></label>
    										</div>
                		                </div>
            		                </div>
            		                <div class="col-md-4 mb-3" style="padding-right: 2rem; text-align: end;">
            		                    <label style="font-size: 12px;">Damrage Min.</label>
            		                    <input type="text" class="form-control numeric-decimal" name="applied_damage_surcharge_min" placeholder="Damrage Min." value="<?= $orders['applied_damage_surcharge_min']; ?>">
            		                </div>
            		                <div class="col-md-7 mb-3">
            		                    <label>Damrage Surcharge</label>
            		                    <div class="input-group">
                		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Damage Surcharge" name="applied_damage_surcharge" value="<?= $orders['applied_damage_surcharge']; ?>">
                		                    <select class="form-control" name="applied_damage_surcharge_type">
                		                        <option <?php if($orders['applied_damage_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
                		                        <option <?php if($orders['applied_damage_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
                		                    </select>
            		                    </div>
        		                    </div>
        		                </span>
        		                <span class="col-6 d-flex" style="padding-right: 14px;">
            		                <div class="col-md-4 mb-3" style="padding-right: 2rem;">
            		                    <label>ODA Min.</label>
            		                    <input type="text" class="form-control numeric-decimal" name="applied_oda_surcharge_min" placeholder="ODA Min." value="<?= $orders['applied_oda_surcharge_min']; ?>">
            		                </div>
            		                <div class="col-md-8 mb-3">
            		                    <label>ODA Surcharge</label>
            		                    <div class="input-group">
                		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter ODA Surcharge" name="applied_oda_surcharge" value="<?= $orders['applied_oda_surcharge']; ?>">
                		                    <select class="form-control" name="applied_oda_surcharge_type">
                		                        <option <?php if($orders['applied_oda_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
                		                        <option <?php if($orders['applied_oda_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
                		                    </select>
            		                    </div>
            		                </div>
            		            </span>
        		                <span class="col-3 mb-3">
        		                    <label>Packaging Surcharge</label>
        		                    <div class="input-group">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Packaging Surcharge" name="applied_packaging_surcharge" value="<?= $orders['applied_packaging_surcharge']; ?>">
            		                    <select class="form-control" name="applied_packaging_surcharge_type">
            		                        <option <?php if($orders['applied_packaging_surcharge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
            		                        <option <?php if($orders['applied_packaging_surcharge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
            		                    </select>
        		                    </div>
        		                </span>
        		                <span class="col-6 d-flex" style="padding-right: 14px;">
            		                <div class="col-md-4 mb-3" style="padding-right: 2rem;">
            		                    <label>App Min.</label>
            		                    <input type="text" class="form-control numeric-decimal" name="applied_special_delivery_or_appointment_charge_min" placeholder="App Min." value="<?= $orders['applied_special_delivery_or_appointment_charge_min']; ?>">
            		                </div>
            		                <div class="col-md-8 mb-3">
            		                    <label>Special Delivery / Appointment Surcharge</label>
            		                    <div class="input-group">
                		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Special Delivery / Appointment Charge" name="applied_special_delivery_or_appointment_charge" value="<?= $orders['applied_special_delivery_or_appointment_charge']; ?>">
                		                    <select class="form-control" name="applied_special_delivery_or_appointment_charge_type">
                		                        <option <?php if($orders['applied_special_delivery_or_appointment_charge_type'] == "Fixed"){ echo "selected"; } ?>>Fixed</option>
                		                        <option <?php if($orders['applied_special_delivery_or_appointment_charge_type'] == "Percentage"){ echo "selected"; } ?>>Percentage</option>
                		                    </select>
            		                    </div>
            		                </div>
            		             </span>
        		                <span class="col-3">
        		                    <label>Pickup Charge</label>
        		                    <div class="input-group">
            		                    <input type="text" class="form-control numeric-decimal" placeholder="Pickup Charge" name="applied_pickup_charge" value="<?= $orders['applied_pickup_charge']; ?>">
            		                    <select class="form-control" name="applied_pickup_charge_type">
            		                        <option <?php if($orders['applied_pickup_charge_type'] == "Kg"){ echo "selected"; } ?>>Kg</option>
            		                        <option <?php if($orders['applied_pickup_charge_type'] == "Quantity"){ echo "selected"; } ?>>Quantity</option>
            		                    </select>
        		                    </div>
        		                </div>
                            </dl>
                        </dl>
                    </dl>
		        </div>
                <div class="card-footer d-flex" style="justify-content: space-between;">
                    <a href="" class="col-md-1 col-5 btn btn-sm btn-danger shadow me-1">Reset <i class="bi bi-ban"></i></a>
                    <button class="col-md-2 col-5 btn btn-sm btn-warning shadow me-1" type="submit" name="updateSingleLR">Save to change <i class="bi bi-pen-fill"></i></button>
                </div>
		    </form>
		</div>
		<?php
		    }else{
		        echo '<span class="d-flex justify-content-center">No order found!</span>';
		    }
	    }else{
	        echo '<span class="d-flex justify-content-center">Search here to get order details!</span>';
	    }
	    ?>
	</div>
</div>

<!--**********************************
    Content body end
***********************************-->
<?php
include("assets/footer.php");
?>