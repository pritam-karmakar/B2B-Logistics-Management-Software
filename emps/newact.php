<?php
session_start();
include("../database/db.php");
include("../functions/all-functions.php");
if(isset($_SESSION['ltl_admin_id']) && !empty($_SESSION['ltl_admin_id']) && isset($_SESSION['ltl_admin_username']) && !empty($_SESSION['ltl_admin_username'])){
    $ltl_admin_id = $_SESSION['ltl_admin_id'];
}else{
    header("location:index");
}
$newquery = new query();
$newfunc = new allfunctions();
date_default_timezone_set("Asia/Kolkata");
$charges = $newquery->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];


// edit single lr
if(isset($_POST['updateSingleLR'])){
    extract($_POST);
    // $newfunc->pre($_POST);
    $getorder = $newquery->getData('*','orders','',array('order_id'=>$orderId),'id','DESC','1')[0];
    $get_user_details = $newquery->getData('*',$getorder['user_type'],'',array('id'=>$getorder['type_id']),'id','DESC','1')[0];
    $getstate1 = $newquery->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$getorder['pick_pin']),"","","1")[0];
    $getstate2 = $newquery->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$getorder['del_pin']),"","","1")[0];
    $frightZone = $getstate1['zone']."_to_".$getstate2['zone'];
    if($getorder['user_type'] == "users"){
        $FC = 'fright_charge';
    }elseif($getorder['user_type'] == "branches"){
        $FC = 'branch_charge';
    }
    if($get_user_details[$FC] == "yes"){
        $fright = $newquery->getData('*',$getorder['user_type'].'_fright_master','',array('user_id'=>$getorder['type_id']),'id','DESC','1')[0];
    }else{
        $fright = $newquery->getData('*','default_fright_master','',array('id'=>'1'),'id','DESC','1')[0];
    }
    for($i = 0; $i < count($length); $i++){
        if($dimention == "cm"){
            $valuematricWeight = $valuematricWeight+(((($length[$i]*$width[$i]*$height[$i])/27000)*str_replace("CFT", "", $getorder['cft_type']))*$qty[$i]);
        }elseif($dimention == "inch"){
            $valuematricWeight = $valuematricWeight+(((($length[$i]*$width[$i]*$height[$i])/1728)*str_replace("CFT", "", $getorder['cft_type']))*$qty[$i]);
        }
        $totalQty = $totalQty+$qty[$i];
    }
    if($get_user_details['freight_type'] == "Weight"){
        if($valuematricWeight < $weight){
            $frightCharge = round(($fright[$frightZone]*$weight), 2);
            $calweight = $weight;
        }else{
            $frightCharge = round(($fright[$frightZone]*$valuematricWeight), 2);
            $calweight = $valuematricWeight;
        }
    }elseif($get_user_details['freight_type'] == "Quantity"){
        $frightCharge = round(($fright[$frightZone]*$weight), 2);
        if($valuematricWeight < $weight){
            $calweight = $weight;
        }else{
            $calweight = $valuematricWeight;
        }
    }
    $lr = $getorder['lr'];
    $calweight = round($calweight, 2);
    // awb charge
    if(!empty($new_awb_charge)){
        $awb_charge = $new_awb_charge;
    }else{
        $awb_charge = $getorder['awb_charge'];
    }
    // awb charge end
    
    // fob surcharge
    if(!empty($new_fob_surcharge_percentage)){
        $fob_surcharge_percentage = $new_fob_surcharge_percentage;
    }else{
        $fob_surcharge_percentage = $getorder['fob_surcharge_percentage'];
    }
    if(!empty($new_fob_surcharge_minimum)){
        $fob_surcharge_minimum = $new_fob_surcharge_minimum;
    }else{
        $fob_surcharge_minimum = $getorder['fob_surcharge_minimum'];
    }
    if(in_array("checkInsurance", $_POST)){
        $insurance = 'Yes';
        if(round($invoice_amount*($fob_surcharge_percentage/100),2) > $fob_surcharge_minimum){
            $fob_surcharge = round($invoice_amount*($fob_surcharge_percentage/100),2);
        }else{
            $fob_surcharge = $fob_surcharge_minimum;
        }
    }else{
        $insurance = 'No';
        $fob_surcharge = $fob_surcharge_minimum;
    }
    // fob surcharge end
    
    // handeling charge
    $apply_handeling_charge = !empty($new_handeling_charge)? $new_handeling_charge : $getorder['handeling_charge'];
    $apply_handeling_charge_type = !empty($new_handeling_charge_type)? $new_handeling_charge_type : $getorder['handeling_charge_type'];
    if($apply_handeling_charge_type == "Quantity"){
        $handeling_charge = round(($apply_handeling_charge*$totalQty), 2);
    }elseif($apply_handeling_charge_type == "Kg"){
        $handeling_charge = round(($apply_handeling_charge*$calweight), 2);
    }
    // handeling charge end
    
    // cartage charge
    $apply_cartage_charge = !empty($new_cartage_charge)? $new_cartage_charge : $getorder['cartage_charge'];
    $apply_cartage_charge_type = !empty($new_cartage_charge_type)? $new_cartage_charge_type : $getorder['cartage_charge_type'];
    if($apply_cartage_charge_type == "Quantity"){
        $cartage_charge = round(($apply_cartage_charge*$totalQty), 2);
    }elseif($apply_cartage_charge_type == "Kg"){
        $cartage_charge = round(($apply_cartage_charge*$calweight), 2);
    }
    // cartage charge end
    
    // damrage surcharge
    $apply_damage_surcharge_min = !empty($new_damage_surcharge_min)? $new_damage_surcharge_min : $getorder['damage_surcharge_min'];
    $apply_damage_surcharge = !empty($new_damage_surcharge)? $new_damage_surcharge : $getorder['damage_surcharge'];
    $apply_damage_surcharge_type = !empty($new_damage_surcharge_type)? $new_damage_surcharge_type : $getorder['damage_surcharge_type'];
    if($apply_damage_surcharge_type == "Quantity"){
        $actual_damage_surcharge = round(($apply_damage_surcharge*$totalQty), 2);
    }elseif($apply_damage_surcharge_type == "Kg"){
        $actual_damage_surcharge = round(($apply_damage_surcharge*$calweight), 2);
    }
    $damage_surcharge = $apply_damage_surcharge_min < $actual_damage_surcharge? $actual_damage_surcharge : $apply_damage_surcharge_min;
    // damrage surcharge end
    
    // oda surcharge
    $apply_oda_surcharge_min = !empty($new_oda_surcharge_min)? $new_oda_surcharge_min : $getorder['oda_surcharge_min'];
    $apply_oda_surcharge = !empty($new_oda_surcharge)? $new_oda_surcharge : $getorder['oda_surcharge'];
    $apply_oda_surcharge_type = !empty($new_oda_surcharge_type)? $new_oda_surcharge_type : $getorder['oda_surcharge_type'];
    if($apply_oda_surcharge_type == "Quantity"){
        $actual_oda_surcharge = round(($apply_oda_surcharge*$totalQty), 2);
    }elseif($apply_oda_surcharge_type == "Kg"){
        $actual_oda_surcharge = round(($apply_oda_surcharge*$calweight), 2);
    }
    $oda_surcharge = $apply_oda_surcharge_min < $actual_oda_surcharge? $actual_oda_surcharge : $apply_oda_surcharge_min;
    // oda surcharge end
    
    // packaging surcharge
    $apply_packaging_surcharge = !empty($new_packaging_surcharge)? $new_packaging_surcharge : $getorder['packaging_surcharge'];
    $apply_packaging_surcharge_type = !empty($new_handeling_charge_type)? $new_handeling_charge_type : $getorder['packaging_surcharge_type'];
    if($apply_packaging_surcharge_type == "Quantity"){
        $handeling_charge = round(($apply_packaging_surcharge*$totalQty), 2);
    }elseif($apply_packaging_surcharge_type == "Kg"){
        $handeling_charge = round(($apply_packaging_surcharge*$calweight), 2);
    }
    // packaging surcharge end
    
    // special delivery and appointment charge
    $apply_special_delivery_or_appointment_charge_min = !empty($new_special_delivery_or_appointment_charge_min)? $new_special_delivery_or_appointment_charge_min : $getorder['special_delivery_or_appointment_charge_min'];
    $apply_special_delivery_or_appointment_charge = !empty($new_special_delivery_or_appointment_charge)? $new_special_delivery_or_appointment_charge : $getorder['special_delivery_or_appointment_charge'];
    $apply_special_delivery_or_appointment_charge_type = !empty($new_special_delivery_or_appointment_charge_type)? $new_special_delivery_or_appointment_charge_type : $getorder['special_delivery_or_appointment_charge_type'];
    if($apply_special_delivery_or_appointment_charge_type == "Percentage"){
        $actual_special_delivery_or_appointment_charge = round(($frightCharge*($apply_special_delivery_or_appointment_charge/100)), 2);
    }elseif($apply_special_delivery_or_appointment_charge_type == "Fixed"){
        $actual_special_delivery_or_appointment_charge = $apply_special_delivery_or_appointment_charge;
    }
    $special_delivery_charge = $apply_special_delivery_or_appointment_charge_min < $actual_special_delivery_or_appointment_charge? $actual_special_delivery_or_appointment_charge : $apply_special_delivery_or_appointment_charge_min;
    // special delivery and appointment charge end
    
    // pickup charge
    $apply_pickup_charge = !empty($new_pickup_charge)? $new_pickup_charge : $getorder['pickup_charge'];
    $apply_pickup_charge_type = !empty($new_pickup_charge_type)? $new_pickup_charge_type : $getorder['pickup_charge_type'];
    if($apply_pickup_charge_type == "Quantity"){
        $handeling_charge = round(($apply_pickup_charge*$totalQty), 2);
    }elseif($apply_pickup_charge_type == "Kg"){
        $handeling_charge = round(($apply_pickup_charge*$calweight), 2);
    }
    // pickup charge end

    // fuel surcharge
    $apply_fuel_surcharge = !empty($new_fuel_surcharge)? $new_fuel_surcharge : $getorder['fuel_surcharge'];
    $apply_fuel_surcharge_type = !empty($new_pickup_charge_type)? $new_pickup_charge_type : $getorder['pickup_charge_type'];
    if($apply_fuel_surcharge_type == "Fixed"){
        $fuel_surcharge = $apply_fuel_surcharge;
    }elseif($apply_fuel_surcharge_type == "Percentage"){
        $fuel_surcharge = round(($frightCharge*($apply_fuel_surcharge/100)), 2);
    }
    // fuel surcharge end
    
    
    $cod_charge = 0;
    if($lr_payment_mode == "CoD"){
        if($get_user_details['cod_charge_enable_disable'] == "enable"){
            if($get_user_details['cod_charge_type'] == "Fixed"){
                $new_cod_charge = $get_user_details['cod_charge'];
                if($get_user_details['cod_charge_min'] < $new_cod_charge){
                    $cod_charge = $new_cod_charge;
                }else{
                    $cod_charge = $get_user_details['cod_charge_min'];
                }
            }elseif($get_user_details['cod_charge_type'] == "Percentage"){
                $new_cod_charge = $frightCharge*($get_user_details['cod_charge']/100);
                if($get_user_details['cod_charge_min'] < $new_cod_charge){
                    $cod_charge = $new_cod_charge;
                }else{
                    $cod_charge = $get_user_details['cod_charge_min'];
                }
            }
        }
    }
    $before_gst_total_charge = ($frightCharge+$awb_charge+$fuel_surcharge+$fob_surcharge+$handeling_charge+$damage_surcharge+$oda_surcharge+$packaging_surcharge+$special_delivery_charge+$pickup_charge+$cod_charge+$cartage_charge);
    $getGSTCharges = $newquery->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];
    if($get_user_details['igst'] == "not"){
        $gst_charge = round((floatval($before_gst_total_charge*($getGSTCharges['sgst']/100))+floatval($before_gst_total_charge*($getGSTCharges['cgst']/100))),2);
        $sgst_amount = round(floatval($before_gst_total_charge*($getGSTCharges['sgst']/100)),2);
        $cgst_amount = round(floatval($before_gst_total_charge*($getGSTCharges['cgst']/100)),2);
        $igst_amount = 0;
    }elseif($get_user_details['igst'] == "yes"){
        $gst_charge = round(floatval($before_gst_total_charge*($getGSTCharges['igst']/100)),2);
        $igst_amount = round(floatval($before_gst_total_charge*($getGSTCharges['sgst']/100)),2);
        $cgst_amount = 0;
        $sgst_amount = 0;
    }
    $total_charge = round(($before_gst_total_charge+$gst_charge), 2);
    $volweight = $calweight;
    if($lr_payment_mode != "CoD"){
        $cod_amount = 0;
    }
    if($lr_payment_mode != "Franchise-ToPay"){
        $profit_amount = 0;
    }
    $chargeArr = array("weight"=>$weight,"vol_weight"=>$volweight,"cod_charge"=>$cod_charge,"fuel_surcharge"=>$fuel_surcharge,"awb_charge"=>$awb_charge,"fob_surcharge"=>$fob_surcharge,"handeling_charge"=>$handeling_charge,"damage_surcharge"=>$damage_surcharge,"oda_surcharge"=>$oda_surcharge,"packaging_surcharge"=>$packaging_surcharge,"special_delivery_charge"=>$special_delivery_charge,"gst_charge"=>$gst_charge,"weight_charge"=>$frightCharge,"total_charge"=>$total_charge,'payment_mode'=>$lr_payment_mode,'insurance'=>$insurance,'invoice_amount'=>$invoice_amount,'seller_gst_tin'=>$seller_gst_tin,'consignee_gst_tin'=>$consignee_gst_tin,'cod_amount'=>$cod_amount,'profit_amount'=>$profit_amount,"igst_per"=>$charges['igst'],"sgst_per"=>$charges['igst'],"cgst_per"=>$charges['igst'],"igst_amount"=>$igst_amount,"cgst_amount"=>$cgst_amount,"sgst_amount"=>$sgst_amount);
    $chargeArr['cartage_charge'] = $cartage_charge;
    if($total_charge != $getorder['total_charge']){
        $updateOrder = $newquery->updateData('orders',$chargeArr,'lr',$lr);
        if($updateOrder){
            $boxIds = $newquery->getData('`id`','box_details','',array('order_id'=>$orderId),'','','');
            for($b = 0; $b < count($boxIds); $b++){
                $newquery->updateData('box_details',array('qty'=>$qty[$b],'dimention'=>$dimention,'length'=>$length[$b],'width'=>$width[$b],'height'=>$height[$b]),'id',$boxIds[$b]['id']);
            }
            $invIds = $newquery->getData('`id`','invoice_details','',array('order_id'=>$orderId),'','','');
            for($c = 0; $c < count($invIds); $c++){
                $newquery->updateData('invoice_details',array('ewaybill'=>$ewaybill[$c],'n_value'=>$n_value[$c],'inv_no'=>$inv_no[$c]),'id',$invIds[$c]['id']);
            }
            $consigneeUpd = $newquery->updateData('consignee_details',array('name'=>$consignee_name,'company'=>$company,'address'=>$address,'phone'=>$phone,'email'=>$email),'order_id',$orderId);
            if($consigneeUpd){
                if($getorder['payment_mode'] == "Prepaid" || $getorder['payment_mode'] == "CoD"){
                    $refundCharge = $getorder['total_charge'];
                }else{
                    $refundCharge = 0;
                }
                $getprevTrans = $newquery->getData('*','transactions','',array('txn_id_type'=>'serial'),'id','DESC','1');
              	if($getprevTrans != 0){
                    $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
                }else{
                    $merchantTransactionId = 'KINGFISH100000';
                }
                $new_bal = floatval($get_user_details['wallet_balance'] + $refundCharge);
  	            $tdate = date('Y-m-d H:i:s');
  	            $desc = str_replace("'", "\'", "LR No.: ".$lr."'s order charge refunded");
  	            $transsArr = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>$refundCharge,"balance"=>$new_bal,"type"=>"Manual","details"=>$desc,"txn_id"=>$merchantTransactionId,"status"=>"Credit");
  	            $insert_transaction = $newquery->insertData('transactions',$transsArr);
  	            if($insert_transaction){
                    $up_wall = $newquery->updateData($getorder['user_type'],array("wallet_balance"=>$new_bal),'id',$get_user_details['id']);
  	                $get_user_detailsN = $newquery->getData('*',$getorder['user_type'],'',array('id'=>$getorder['type_id']),'id','DESC','1')[0];
                    if($lr_payment_mode == "Prepaid" || $lr_payment_mode == "CoD"){
                        $new_bal2 = floatval($get_user_detailsN['wallet_balance'] - $total_charge);
          	            $desc2 = str_replace("'", "\'", "LR No.: ".$lr."'s weight updated charge deducted");
          	            $getprevTrans2 = $newquery->getData('*','transactions','',array('txn_id_type'=>'serial'),'id','DESC','1');
                      	if($getprevTrans2 != 0){
                            $merchantTransactionId2 = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans2[0]['txn_id'])+1);
                        }else{
                            $merchantTransactionId2 = 'KINGFISH100000';
                        }
      		            $transsArr2 = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>$total_charge,"balance"=>$new_bal2,"type"=>"Manual","details"=>$desc2,"txn_id"=>$merchantTransactionId2);
          	            $insert_transaction2 = $newquery->insertData('transactions',$transsArr2);
                        if($insert_transaction2){
                            $up_wall2 = $newquery->updateData($getorder['user_type'],array("wallet_balance"=>$new_bal2),'id',$get_user_details['id']);
                            if($up_wall2){
                                $newfunc->alertRedirect("You have successfully updated the LR details",$_SERVER['HTTP_REFERER']);
                            }
                        }else{
                            $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                        }
                    }elseif($lr_payment_mode == "To-Pay"){
                        $getprevTransTP = $newquery->getData('*','transactions','',array('txn_id_type'=>'serial'),'id','DESC','1');
                      	if($getprevTransTP != 0){
                            $merchantTransactionIdTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransTP[0]['txn_id'])+1);
                        }else{
                            $merchantTransactionIdTP = 'KINGFISH100000';
                        }
                        $descTP = str_replace("'", "\'", "LR No.: ".$lr."'s weight updated charge deducted with to pay");
                        $transsArrTP = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>'0',"balance"=>$get_user_detailsN['wallet_balance'],"type"=>"Manual","details"=>$descTP,"txn_id"=>$merchantTransactionIdTP);
          	            $insert_transactionTP = $newquery->insertData('transactions',$transsArrTP);
          	            if($insert_transactionTP){
                            $newfunc->alertRedirect("You have successfully updated the LR details",$_SERVER['HTTP_REFERER']);
          	            }else{
          	                $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
          	            }
                    }elseif($lr_payment_mode == "Franchise-ToPay"){
                        $getprevTransFTP = $newquery->getData('*','transactions','',array('txn_id_type'=>'serial'),'id','DESC','1');
                      	if($getprevTransFTP != 0){
                            $merchantTransactionIdFTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransFTP[0]['txn_id'])+1);
                        }else{
                            $merchantTransactionIdFTP = 'KINGFISH100000';
                        }
                        $descFTP = str_replace("'", "\'", "LR No.: ".$lr."'s weight updated charge deducted with franchise to pay");
                        $transsArrFTP = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>'0',"balance"=>$get_user_detailsN['wallet_balance'],"type"=>"Manual","details"=>$descFTP,"txn_id"=>$merchantTransactionIdFTP);
          	            $insert_transactionFTP = $newquery->insertData('transactions',$transsArrFTP);
          	            if($insert_transactionFTP){
                            $newfunc->alertRedirect("You have successfully updated the LR details","edit-lr");
          	            }else{
                            $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
          	            }
                    }else{
                        $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                    }
  	            }else{
                    $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
            }
        }else{
            $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("Nothing has not been updated on LR No. $lr",$_SERVER['HTTP_REFERER']);
    }
}