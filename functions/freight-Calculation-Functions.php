<?php
class freightCalculationFunctions extends query{
    
    public function UsersFreightCalculation($userId,$originPincode,$destinationPincode,$cftType,$paymentMode,$weight,$dimention,$invoiceAmount,$insurance,$pickupType,$qty,$length,$width,$height){
        $userDetails = $this->getData('*','users','',array('id'=>$userId),'id','DESC','1');
        if($userDetails != 0):
            $userDetails = $userDetails[0];
            $getstate1 = $this->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$originPincode),"","","1")[0];
            if(!$getstate1):
                return false;
            endif;
            $getstate2 = $this->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$destinationPincode),"","","1")[0];
            if(!$getstate2):
                return false;
            endif;
            $frightZone = $getstate1['zone']."_to_".$getstate2['zone'];
            if($userDetails['fright_charge'] == "yes"):
                $fright = $this->getData('*','users_fright_master','',array('user_id'=>$userId),'id','DESC','1')[0];
            else:
                $fright = $this->getData('*','default_fright_master','',array('id'=>'1'),'id','DESC','1')[0];
            endif;
            if(!$fright):
                return false;
            endif;
            for($i = 0; $i < count($length); $i++):
                if($dimention == "Centimeter"):
                    $valuematricWeight = $valuematricWeight+((((round($length[$i], 2)*round($width[$i], 2)*round($height[$i], 2))/27000)*str_replace("CFT", "", $cftType))*$qty[$i]);
                elseif($dimention == "Inch"):
                    $valuematricWeight = $valuematricWeight+((((round($length[$i], 2)*round($width[$i], 2)*round($height[$i], 2))/1728)*str_replace("CFT", "", $cftType))*$qty[$i]);
                endif;
                $totalQty = $totalQty+$qty[$i];
            endfor;
            $returnArray = array();
            if($userDetails['freight_type'] == 'Weight'):
                if($valuematricWeight < $weight):
                    $returnArray['frightCharge'] = round($fright[$frightZone]*$weight, 2);
                    $weight = round($weight, 2);
                else:
                    $returnArray['frightCharge'] = round($fright[$frightZone]*$valuematricWeight, 2);
                    $weight = round($valuematricWeight, 2);
                endif;
            elseif($userDetails['freight_type'] == 'Quantity'):
                $weight = ($valuematricWeight > $weight)? round($valuematricWeight, 2) : round($weight, 2);
                $returnArray['frightCharge'] = round($fright[$frightZone]*$totalQty, 2);
            endif;
            $weight = ($weight < $userDetails['min_charge_weight'])? $userDetails['min_charge_weight'] : $weight;
            $returnArray['awb_charge'] = round($userDetails['awb_charge'], 2);
            if($insurance == "No"):
                $returnArray['fob_surcharge'] = round($userDetails['fob_surcharge_minimum'], 2);
            elseif($insurance == "Yes"):
                $new_fob_surcharge = round($invoiceAmount*($userDetails['fob_surcharge_percentage']/100) ,2);
                $returnArray['fob_surcharge'] = ($userDetails['fob_surcharge_minimum'] > $new_fob_surcharge)? round($userDetails['fob_surcharge_minimum'], 2) : $new_fob_surcharge;
            endif;
            $returnArray['fuel_surcharge'] = ($userDetails['fuel_surcharge_type'] == "Fixed")? round($userDetails['fuel_surcharge'], 2) : round($returnArray['frightCharge']*($userDetails['fuel_surcharge']/100), 2);
            $returnArray['handeling_charge'] = ($userDetails['handeling_charge_type'] == "Quantity")? round($userDetails['handeling_charge']*$totalQty, 2) : round($userDetails['handeling_charge']*$weight, 2);
            if($userDetails['damage_surcharge_type'] == "Quantity"):
                $new_damage_surcharge = round($userDetails['damage_surcharge']*$totalQty, 2);
                $returnArray['damage_surcharge'] = ($userDetails['damage_surcharge_min'] < $new_damage_surcharge)? $new_damage_surcharge : round($userDetails['damage_surcharge_min'], 2);
            elseif($userDetails['damage_surcharge_type'] == "Kg"):
                $new_damage_surcharge = round($userDetails['damage_surcharge']*$weight, 2);
                $returnArray['damage_surcharge'] = ($userDetails['damage_surcharge_min'] < $new_damage_surcharge)? $new_damage_surcharge : round($userDetails['damage_surcharge_min'], 2);
            endif;
            if(apiFunctions::pincodeServiceAbilityWithOda($destinationPincode, $cftType)[1] == "true"):
                if($userDetails['oda_surcharge_type'] == "Quantity"):
                    $new_oda_surcharge = round($userDetails['oda_surcharge']*$totalQty, 2);
                    $returnArray['oda_surcharge'] = ($userDetails['oda_surcharge_min'] < $new_oda_surcharge)? $new_oda_surcharge : round($userDetails['oda_surcharge_min'], 2);
                elseif($userDetails['oda_surcharge_type'] == "Kg"):
                    $new_oda_surcharge = round($userDetails['oda_surcharge']*$weight, 2);
                    $returnArray['oda_surcharge'] = ($userDetails['oda_surcharge_min'] < $new_oda_surcharge)? $new_oda_surcharge : round($userDetails['oda_surcharge_min'], 2);
                endif;
            else:
                $returnArray['oda_surcharge'] = 0;
            endif;
            $returnArray['packaging_surcharge'] = ($userDetails['packaging_surcharge_type'] == "Quantity")? round($userDetails['packaging_surcharge']*$totalQty, 2) : round($userDetails['packaging_surcharge']*$weight, 2);
            $returnArray['special_delivery_charge'] = 0;
            if($pickupType == "Self-Drop"):
                $returnArray['pickup_charge'] = ($userDetails['pickup_charge_type'] == "Quantity")? round($userDetails['pickup_charge']*$totalQty, 2) : round($userDetails['pickup_charge']*$weight, 2);
            else:
                $returnArray['pickup_charge'] = 0;
            endif;
            $returnArray['cartage_charge'] = 0;
            if($paymentMode == "CoD" && ($userDetails['cod_charge_enable_disable'] == "enable")):
                if($userDetails['cod_charge_type'] == "Fixed"):
                    $new_cod_charge = round($userDetails['cod_charge'], 2);
                    $returnArray['cod_charge'] = ($userDetails['cod_charge_min'] < $new_cod_charge)? $new_cod_charge : round($userDetails['cod_charge_min'], 2);
                elseif($userDetails['cod_charge_type'] == "Percentage"):
                    $new_cod_charge = round($returnArray['frightCharge']*($userDetails['cod_charge']/100), 2);
                    $returnArray['cod_charge'] = ($userDetails['cod_charge_min'] < $new_cod_charge)? $new_cod_charge : round($userDetails['cod_charge_min'], 2);
                endif;
            else:
                $returnArray['cod_charge'] = 0;
            endif;
            $returnArray['before_gst_total_charge'] = round($returnArray['frightCharge']+$returnArray['awb_charge']+$returnArray['fuel_surcharge']+$returnArray['fob_surcharge']+$returnArray['handeling_charge']+$returnArray['damage_surcharge']+$returnArray['oda_surcharge']+$returnArray['packaging_surcharge']+$returnArray['special_delivery_charge']+$returnArray['pickup_charge']+$returnArray['cartage_charge']+$returnArray['cod_charge'], 2);
            $returnArray['chargedWeight'] = $weight;
            $getGSTCharges = $this->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];
            if($userDetails['igst'] == "not"){
                $returnArray['gst_charge'] = round(($returnArray['before_gst_total_charge']*($getGSTCharges['sgst']/100)+$returnArray['before_gst_total_charge']*($getGSTCharges['cgst']/100)),2);
            }elseif($userDetails['igst'] == "yes"){
                $returnArray['gst_charge'] = round($returnArray['before_gst_total_charge']*($getGSTCharges['igst']/100),2);
            }
            $returnArray['total_charge'] = round($returnArray['before_gst_total_charge']+$returnArray['gst_charge'], 2);
            return $returnArray;
        else:
            return false;
        endif;
    }
    
    public function BranchesFreightCalculation($branchId,$originPincode,$destinationPincode,$cftType,$paymentMode,$weight,$dimention,$invoiceAmount,$insurance,$pickupType,$qty,$length,$width,$height){
        $branchDetails = $this->getData('*','branches','',array('id'=>$branchId),'id','DESC','1');
        if($branchDetails != 0):
            $branchDetails = $branchDetails[0];
            $getstate1 = $this->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$originPincode),"","","1")[0];
            if(!$getstate1):
                return false;
            endif;
            $getstate2 = $this->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$destinationPincode),"","","1")[0];
            if(!$getstate2):
                return false;
            endif;
            $frightZone = $getstate1['zone']."_to_".$getstate2['zone'];
            if($branchDetails['branch_charge'] == "yes"):
                $fright = $this->getData('*','branches_fright_master','',array('branch_id'=>$branchId),'id','DESC','1')[0];
            else:
                $fright = $this->getData('*','default_fright_master','',array('id'=>'1'),'id','DESC','1')[0];
            endif;
            if(!$fright):
                return false;
            endif;
            for($i = 0; $i < count($length); $i++):
                if($dimention == "Centimeter"):
                    $valuematricWeight = $valuematricWeight+((((round($length[$i], 2)*round($width[$i], 2)*round($height[$i], 2))/27000)*str_replace("CFT", "", $cftType))*$qty[$i]);
                elseif($dimention == "Inch"):
                    $valuematricWeight = $valuematricWeight+((((round($length[$i], 2)*round($width[$i], 2)*round($height[$i], 2))/1728)*str_replace("CFT", "", $cftType))*$qty[$i]);
                endif;
                $totalQty = $totalQty+$qty[$i];
            endfor;
            $returnArray = array();
            if($branchDetails['freight_type'] == 'Weight'):
                if($valuematricWeight < $weight):
                    $returnArray['frightCharge'] = round($fright[$frightZone]*$weight, 2);
                    $weight = round($weight, 2);
                else:
                    $returnArray['frightCharge'] = round($fright[$frightZone]*$valuematricWeight, 2);
                    $weight = round($valuematricWeight, 2);
                endif;
            elseif($branchDetails['freight_type'] == 'Quantity'):
                $weight = ($valuematricWeight > $weight)? round($valuematricWeight, 2) : round($weight, 2);
                $returnArray['frightCharge'] = round($fright[$frightZone]*$totalQty, 2);
            endif;
            $weight = ($weight < $branchDetails['min_charge_weight'])? $branchDetails['min_charge_weight'] : $weight;
            $returnArray['awb_charge'] = round($branchDetails['awb_charge'], 2);
            if($insurance == "No"):
                $returnArray['fob_surcharge'] = round($branchDetails['fob_surcharge_minimum'], 2);
            elseif($insurance == "Yes"):
                $new_fob_surcharge = round($invoiceAmount*($branchDetails['fob_surcharge_percentage']/100) ,2);
                $returnArray['fob_surcharge'] = ($branchDetails['fob_surcharge_minimum'] > $new_fob_surcharge)? round($branchDetails['fob_surcharge_minimum'], 2) : $new_fob_surcharge;
            endif;
            $returnArray['fuel_surcharge'] = ($branchDetails['fuel_surcharge_type'] == "Fixed")? round($branchDetails['fuel_surcharge'], 2) : round($returnArray['frightCharge']*($branchDetails['fuel_surcharge']/100), 2);
            $returnArray['handeling_charge'] = ($branchDetails['handeling_charge_type'] == "Quantity")? round($branchDetails['handeling_charge']*$totalQty, 2) : round($branchDetails['handeling_charge']*$weight, 2);
            if($branchDetails['damage_surcharge_type'] == "Quantity"):
                $new_damage_surcharge = round($branchDetails['damage_surcharge']*$totalQty, 2);
                $returnArray['damage_surcharge'] = ($branchDetails['damage_surcharge_min'] < $new_damage_surcharge)? $new_damage_surcharge : round($branchDetails['damage_surcharge_min'], 2);
            elseif($branchDetails['damage_surcharge_type'] == "Kg"):
                $new_damage_surcharge = round($branchDetails['damage_surcharge']*$weight, 2);
                $returnArray['damage_surcharge'] = ($branchDetails['damage_surcharge_min'] < $new_damage_surcharge)? $new_damage_surcharge : round($branchDetails['damage_surcharge_min'], 2);
            endif;
            if(apiFunctions::pincodeServiceAbilityWithOda($destinationPincode, $cftType)[1] == "true"):
                if($branchDetails['oda_surcharge_type'] == "Quantity"):
                    $new_oda_surcharge = round($branchDetails['oda_surcharge']*$totalQty, 2);
                    $returnArray['oda_surcharge'] = ($branchDetails['oda_surcharge_min'] < $new_oda_surcharge)? $new_oda_surcharge : round($branchDetails['oda_surcharge_min'], 2);
                elseif($branchDetails['oda_surcharge_type'] == "Kg"):
                    $new_oda_surcharge = round($branchDetails['oda_surcharge']*$weight, 2);
                    $returnArray['oda_surcharge'] = ($branchDetails['oda_surcharge_min'] < $new_oda_surcharge)? $new_oda_surcharge : round($branchDetails['oda_surcharge_min'], 2);
                endif;
            else:
                $returnArray['oda_surcharge'] = 0;
            endif;
            $returnArray['packaging_surcharge'] = ($branchDetails['packaging_surcharge_type'] == "Quantity")? round($branchDetails['packaging_surcharge']*$totalQty, 2) : round($branchDetails['packaging_surcharge']*$weight, 2);
            $returnArray['special_delivery_charge'] = 0;
            if($pickupType == "Self-Drop"):
                $returnArray['pickup_charge'] = ($branchDetails['pickup_charge_type'] == "Quantity")? round($branchDetails['pickup_charge']*$totalQty, 2) : round($branchDetails['pickup_charge']*$weight, 2);
            else:
                $returnArray['pickup_charge'] = 0;
            endif;
            $returnArray['cartage_charge'] = 0;
            if($paymentMode == "CoD" && ($branchDetails['cod_charge_enable_disable'] == "enable")):
                if($branchDetails['cod_charge_type'] == "Fixed"):
                    $new_cod_charge = round($branchDetails['cod_charge'], 2);
                    $returnArray['cod_charge'] = ($branchDetails['cod_charge_min'] < $new_cod_charge)? $new_cod_charge : round($branchDetails['cod_charge_min'], 2);
                elseif($branchDetails['cod_charge_type'] == "Percentage"):
                    $new_cod_charge = round($returnArray['frightCharge']*($branchDetails['cod_charge']/100), 2);
                    $returnArray['cod_charge'] = ($branchDetails['cod_charge_min'] < $new_cod_charge)? $new_cod_charge : round($branchDetails['cod_charge_min'], 2);
                endif;
            else:
                $returnArray['cod_charge'] = 0;
            endif;
            $returnArray['before_gst_total_charge'] = round($returnArray['frightCharge']+$returnArray['awb_charge']+$returnArray['fuel_surcharge']+$returnArray['fob_surcharge']+$returnArray['handeling_charge']+$returnArray['damage_surcharge']+$returnArray['oda_surcharge']+$returnArray['packaging_surcharge']+$returnArray['special_delivery_charge']+$returnArray['pickup_charge']+$returnArray['cartage_charge']+$returnArray['cod_charge'], 2);
            $returnArray['chargedWeight'] = $weight;
            $getGSTCharges = $this->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];
            if($branchDetails['igst'] == "not"){
                $returnArray['gst_charge'] = round(($returnArray['before_gst_total_charge']*($getGSTCharges['sgst']/100)+$returnArray['before_gst_total_charge']*($getGSTCharges['cgst']/100)),2);
            }elseif($branchDetails['igst'] == "yes"){
                $returnArray['gst_charge'] = round($returnArray['before_gst_total_charge']*($getGSTCharges['igst']/100),2);
            }
            $returnArray['total_charge'] = round($returnArray['before_gst_total_charge']+$returnArray['gst_charge'], 2);
            return $returnArray;
        else:
            return false;
        endif;
    }
    
}