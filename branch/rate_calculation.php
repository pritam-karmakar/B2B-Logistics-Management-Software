<?php
    session_start();
    include("../database/db.php");
    include("../functions/all-functions.php");
    $user_id = $_SESSION['user_id'];
    $newfunc = new allfunctions();
    $query = new query();
    date_default_timezone_set("Asia/Kolkata");
    
    // freight cost create order for particular one cft 
    if(isset($_POST['pick_pin']) && isset($_POST['del_pin'])  && isset($_POST['type']) && isset($_POST['type_id']) && isset($_POST['volweight']))
    {
        $pick_pin = $_POST['pick_pin'];
        $del_pin = $_POST['del_pin'];
        
        $type = $_POST['type'];
        $type_id = $_POST['type_id'];
        $weight = $_POST['volweight'];
        
        $pick_cond = array("pincode"=>$pick_pin);
        $fetch_pick_details = $query->getData("*","pincodes","",$pick_cond,"","","");
        $pick_state_id = $fetch_pick_details[0]['state_id'];
        
        $state_cond = array("id"=>$pick_state_id);
        $get_pick_state = $query->getData("*","states","",$state_cond,"","","");
        $pick_zone_id = $get_pick_state[0]['zone_id'];
        
        $zone_cond = array("id"=>$pick_zone_id);
        $get_pick_zone = $query->getData("*","zones","",$zone_cond,"","","");
        $pick_zone = $get_pick_zone[0]['zone'];
        
        $del_cond = array("pincode"=>$del_pin);
        $fetch_del_details = $query->getData("*","pincodes","",$del_cond,"","","");
        $del_state_id = $fetch_del_details[0]['state_id'];
        
        $state_del_cond = array("id"=>$del_state_id);
        $get_del_state = $query->getData("*","states","",$state_del_cond,"","","");
         $del_zone_id = $get_del_state[0]['zone_id'];
        
        $zone_del_cond = array("id"=>$del_zone_id);
        $get_del_zone = $query->getData("*","zones","",$zone_del_cond,"","","");
        $del_zone = $get_del_zone[0]['zone'];
        
        if(!empty($pick_zone) && !empty($del_zone)){
            $freight_zone=$pick_zone.'_to_'.$del_zone;

            $get_type_details = $query->getData('*',"branches","",array("id"=>$type_id),"","","")[0];
            
            if($get_type_details['branch_charge'] == 'yes')
            {
                $get_freight_zone = $query->getData($freight_zone,"branches_fright_master","",array("branch_id"=>$type_id),"","","");
            }
            else
            {
                $get_freight_zone = $query->getData($freight_zone,"default_fright_master","","","","","");
            }

            $freight_cost =  $get_freight_zone[0][$freight_zone];
            $freight_cost_with_weight = round(($freight_cost*$weight),2);
            
            $min_charge_weight = $get_type_details['min_charge_weight'];
            if($min_charge_weight > $freight_cost_with_weight) 
            {
                $f_cost = $min_charge_weight;
            } 
            else 
            {
                $f_cost = $freight_cost_with_weight;
            }
            echo $f_cost;
        }else{
            echo 'N';
        }
        
    }
    
    
    // freight cost create order for particular all cft 
    if(isset($_POST['pick_pin']) && isset($_POST['del_pin'])  && isset($_POST['type']) && isset($_POST['type_id']) && isset($_POST['sixcft_volweight']) && isset($_POST['eightcft_volweight']) 
    && isset($_POST['tencft_volweight']))
    {
        $pick_pin = $_POST['pick_pin'];
        $del_pin = $_POST['del_pin'];
        
        $type = $_POST['type'];
        $type_id = $_POST['type_id'];
        $sixcft_volweight = $_POST['sixcft_volweight'];
        $eightcft_volweight = $_POST['eightcft_volweight'];
        $tencft_volweight = $_POST['tencft_volweight'];
        
        $pick_cond = array("pincode"=>$pick_pin);
        $fetch_pick_details = $query->getData("*","pincodes","",$pick_cond,"","","");
        $pick_state_id = $fetch_pick_details[0]['state_id'];
        
        $state_cond = array("id"=>$pick_state_id);
        $get_pick_state = $query->getData("*","states","",$state_cond,"","","");
        $pick_zone_id = $get_pick_state[0]['zone_id'];
        
        $zone_cond = array("id"=>$pick_zone_id);
        $get_pick_zone = $query->getData("*","zones","",$zone_cond,"","","");
        $pick_zone = $get_pick_zone[0]['zone'];
        
        $del_cond = array("pincode"=>$del_pin);
        $fetch_del_details = $query->getData("*","pincodes","",$del_cond,"","","");
        $del_state_id = $fetch_del_details[0]['state_id'];
        
        $state_del_cond = array("id"=>$del_state_id);
        $get_del_state = $query->getData("*","states","",$state_del_cond,"","","");
         $del_zone_id = $get_del_state[0]['zone_id'];
        
        $zone_del_cond = array("id"=>$del_zone_id);
        $get_del_zone = $query->getData("*","zones","",$zone_del_cond,"","","");
        $del_zone = $get_del_zone[0]['zone'];
        
        if(!empty($pick_zone) && !empty($del_zone)){
            $freight_zone=$pick_zone.'_to_'.$del_zone;
            
            $get_type_details = $query->getData('*',"branches","",array("id"=>$type_id),"","","")[0];
            
            if($get_type_details['branch_charge'] == 'yes')
            {
                $get_freight_zone = $query->getData($freight_zone,"branches_fright_master","",array("branch_id"=>$type_id),"","","");
            }
            else
            {
                $get_freight_zone = $query->getData($freight_zone,"default_fright_master","","","","","");
            }

            $freight_cost =  $get_freight_zone[0][$freight_zone];
            $freight_cost_sixcft_volweight = round(($freight_cost*$sixcft_volweight),2);
            $freight_cost_eightcft_volweight = round(($freight_cost*$eightcft_volweight),2);
            $freight_cost_tencft_volweight = round(($freight_cost*$tencft_volweight),2);
            
            $min_charge_weight = $get_type_details['min_charge_weight'];
            
            if($min_charge_weight > $freight_cost_sixcft_volweight) 
            {
                $f_cost_six = $min_charge_weight;
            } 
            else 
            {
                $f_cost_six = $freight_cost_sixcft_volweight;
            }
            
            if($min_charge_weight > $freight_cost_eightcft_volweight) 
            {
                $f_cost_eight = $min_charge_weight;
            } 
            else 
            {
                $f_cost_eight = $freight_cost_eightcft_volweight;
            }
            
            if($min_charge_weight > $freight_cost_tencft_volweight) 
            {
                $f_cost_ten = $min_charge_weight;
            } 
            else 
            {
                $f_cost_ten = $freight_cost_tencft_volweight;
            }
            
            $f_cost_array = array($f_cost_six,$f_cost_eight,$f_cost_ten);
            echo json_encode($f_cost_array);
            
        }else{
            echo 'N';
        }
        
    }
    
    // freight cost create order by Qty.
    if(isset($_POST['pick_pin']) && isset($_POST['del_pin'])  && isset($_POST['type']) && isset($_POST['type_id']) && isset($_POST['totalQty']))
    {
        $pick_pin = $_POST['pick_pin'];
        $del_pin = $_POST['del_pin'];
        
        $type = $_POST['type'];
        $type_id = $_POST['type_id'];
        $weight = $_POST['totalQty'];
        
        $pick_cond = array("pincode"=>$pick_pin);
        $fetch_pick_details = $query->getData("*","pincodes","",$pick_cond,"","","");
        $pick_state_id = $fetch_pick_details[0]['state_id'];
        
        $state_cond = array("id"=>$pick_state_id);
        $get_pick_state = $query->getData("*","states","",$state_cond,"","","");
        $pick_zone_id = $get_pick_state[0]['zone_id'];
        
        $zone_cond = array("id"=>$pick_zone_id);
        $get_pick_zone = $query->getData("*","zones","",$zone_cond,"","","");
        $pick_zone = $get_pick_zone[0]['zone'];
        
        $del_cond = array("pincode"=>$del_pin);
        $fetch_del_details = $query->getData("*","pincodes","",$del_cond,"","","");
        $del_state_id = $fetch_del_details[0]['state_id'];
        
        $state_del_cond = array("id"=>$del_state_id);
        $get_del_state = $query->getData("*","states","",$state_del_cond,"","","");
         $del_zone_id = $get_del_state[0]['zone_id'];
        
        $zone_del_cond = array("id"=>$del_zone_id);
        $get_del_zone = $query->getData("*","zones","",$zone_del_cond,"","","");
        $del_zone = $get_del_zone[0]['zone'];
        
        if(!empty($pick_zone) && !empty($del_zone)){
            $freight_zone=$pick_zone.'_to_'.$del_zone;
            
            $get_type_details = $query->getData('*',"branches","",array("id"=>$type_id),"","","")[0];
            
            if($get_type_details['branch_charge'] == 'yes')
            {
                $get_freight_zone = $query->getData($freight_zone,"branches_fright_master","",array("branch_id"=>$type_id),"","","");
            }
            else
            {
                $get_freight_zone = $query->getData($freight_zone,"default_fright_master","","","","","");
            }
            
            $freight_cost =  $get_freight_zone[0][$freight_zone];
            $freight_cost_with_weight = round(($freight_cost*$weight),2);
            
            $min_charge_weight = $get_type_details['min_charge_weight'];
            if($min_charge_weight > $freight_cost_with_weight) 
            {
                $f_cost = $min_charge_weight;
            } 
            else 
            {
                $f_cost = $freight_cost_with_weight;
            }
            echo $f_cost;
            
        }else{
            echo 'N';
        }
        
    }
    
    
    
    // search zone for manual rate add
    if(isset($_POST['pickup_pincode']) && isset($_POST['delivery_pincode']))
    {
        $pick_pin = $_POST['pickup_pincode'];
        $del_pin = $_POST['delivery_pincode'];
        
        $pick_cond = array("pincode"=>$pick_pin);
        $fetch_pick_details = $query->getData("*","pincodes","",$pick_cond,"","","");
        $pick_state_id = $fetch_pick_details[0]['state_id'];
        
        $state_cond = array("id"=>$pick_state_id);
        $get_pick_state = $query->getData("*","states","",$state_cond,"","","");
        $pick_zone_id = $get_pick_state[0]['zone_id'];
        
        $zone_cond = array("id"=>$pick_zone_id);
        $get_pick_zone = $query->getData("*","zones","",$zone_cond,"","","");
        $pick_zone = $get_pick_zone[0]['zone'];
        
        $del_cond = array("pincode"=>$del_pin);
        $fetch_del_details = $query->getData("*","pincodes","",$del_cond,"","","");
        $del_state_id = $fetch_del_details[0]['state_id'];
        
        $state_del_cond = array("id"=>$del_state_id);
        $get_del_state = $query->getData("*","states","",$state_del_cond,"","","");
         $del_zone_id = $get_del_state[0]['zone_id'];
        
        $zone_del_cond = array("id"=>$del_zone_id);
        $get_del_zone = $query->getData("*","zones","",$zone_del_cond,"","","");
        $del_zone = $get_del_zone[0]['zone'];
        
        if(!empty($pick_zone) && !empty($del_zone)){
            echo 'Enter Rate For '.$pick_zone.' To '.$del_zone;
        }else{
            echo 'N';
        }
        
    }
?>