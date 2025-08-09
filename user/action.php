<?php
    session_start();
    include("../database/db.php");
    include("../functions/all-functions.php");
    include("../functions/api-Functions.php");
    $newfunc = new allfunctions();
    $query = new query();
    date_default_timezone_set("Asia/Kolkata");
    if(!empty($_SESSION['username']) && !empty($_SESSION['user_id'])){
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];
        $getUserDetails = $query->getData('*','users','',array('id'=>$user_id),'id','DESC','1')[0];
    }else{
        header("location:../");
    }
    
    
    // multiple copy waybill and labels
    if(isset($_POST['multipleWaybill']) || isset($_POST['multipleLabelA4']) || isset($_POST['multipleLabel4*2']) || isset($_POST['multipleLabel4*2d5']) || isset($_POST['multipleLabel3*2'])){
        extract($_POST);
        if(!empty($lrs)):
            foreach($lrs as $lr):
                if(!empty($lr)):
                    $getlrs = $getlrs.",".$lr;
                endif;
            endforeach;
            $getlrs = trim($getlrs, ",");
            if(isset($_POST['multipleWaybill'])):
                $copyType = "waybill/waybill";
            elseif(isset($_POST['multipleLabelA4'])):
                $copyType = "label/A4";
            elseif(isset($_POST['multipleLabel4*2'])):
                $copyType = "label/sm";
            elseif(isset($_POST['multipleLabel4*2d5'])):
                $copyType = "label/md";
            elseif(isset($_POST['multipleLabel3*2'])):
                $copyType = "label/std";
            endif;
            header("location: $copyType?lr=$getlrs");
        else:
            $newfunc->alertRedirect("No LR Found!", $_SERVER['HTTP_REFERER']);
        endif;
    }
    
    
    // Add request cashbook
    if(isset($_POST['submitCashbookReq']))
    {   
        extract($_POST);
        $req_no = 'CSHRQ'.time();
        $create_date = date('Y-m-d H:i:s');
        $condition = array("entity_id"=>$user_id,"req_no"=>$req_no,"lr_no"=>$lr_no,"amount"=>$amount,"ref_no"=>$ref_no,"updated_at"=>$create_date);
        if($query->insertData("cashbook",$condition))
        {
            echo '<script type="text/javascript" language="javascript">
                    alert("Cashbook Requested Successfully !!");
                    window.location = "cashbook_request";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "cashbook_request";
                  </script>';
        }
    }
    
    // add money
    if(isset($_POST['add_money_manual']))
    {
        $date = date("Y-m-d");
        extract($_POST);
        $conditionArr = array("type"=>"users","type_id"=>$user_id,"amount"=>$amount,"date"=>$date,"txn_id"=>$txn_id);
        if($query->insertData('add_money_requests',$conditionArr))
        {
            echo '<script type="text/javascript" language="javascript">
                    alert("Add Money Requested Successfully !!");
                    window.location = "add_money";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "add_money";
                  </script>';
        }
    }
    
    // subcategory finder
    if(isset($_POST['ticket_category']))
    {
        $cat_id = $_POST['ticket_category'];
        $cond = array("categoryId"=>$cat_id);
        $getTicketsubcat = $query->getData("*","ticket_subcategory","",$cond,"","","");
        foreach($getTicketsubcat as $subcat)
        {
            $option = "<option value=". $subcat['id'].">". $subcat['subCategory']."</option>";
            echo $option;
        }
    }
    
    // ticket search
    if(isset($_POST['data']) && isset($_POST['type']) && isset($_POST['type_id']))
    {
        $data = $_POST['data'];
        $type = $_POST['type'];
        $type_id = $_POST['type_id'];
        $cond = array("type"=>$type,"type_id"=>$type_id,"status"=>$data);
        $join= array('0'=>array('LEFT','ticket_category','tickets','ticket_category','ticket_category','id'),
                     '1'=>array('LEFT','ticket_subcategory','tickets','ticket_sub_category','ticket_subcategory','id'));
        $get_ticket_detals = $query->getData("`tickets`.*,`ticket_category`.`category`,`ticket_subcategory`.`subCategory`","tickets",$join,$cond,"tickets`.`id","DESC","");
        if($get_ticket_detals != 0)
        {
            foreach($get_ticket_detals as $ticket_details)
            {
                $tr ='<tr>
                        <td class="text-center">'.$ticket_details['ticket_code'].'</td>
                        <td class="text-center">'.$ticket_details['category'].' & '.$ticket_details['subCategory'].'</td>
                        <td class="text-center">'.$ticket_details['created_on'].'</td>
                        <td class="text-center">'.$ticket_details['last_update'].'</td>
                        <td class="text-center">'.$ticket_details['status'].'</td>
                        <td class="text-center"><a href="ticket_details?id='.$ticket_details['id'].'" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                    </tr>';
                echo $tr;
            }
        }
        else
        {
            $tr ='<tr>
                    <td class="text-center text-secondary" colspan="6">No data available in table</td>
                </tr>';
            echo $tr;
        }
    }
    
    // change password
    if(isset($_POST['change_password']))
    {
        $us_id = $_POST['user_id'];
        $password = md5($_POST['password']);
        $cond = array("password"=>$password);
        if($updPassword = $query->updateData('users',$cond,'id',$us_id))
        {
            echo '<script type="text/javascript" language="javascript">
                    alert("Password Changed Successfully !!");
                    window.location = "change_password";
                  </script>';
        }
        else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "change_password";
                  </script>';
        }
    }
    
    // edit user profile
    if(isset($_POST['updateProfile'])){
        extract($_POST);
        $dataArr = array("party_name"=>$party_name,"contact_person_name"=>$contact_person_name,"email"=>$email,"mobile_no"=>$mobile_no,"address"=>$address);
        if($query->updateData('users',$dataArr,'id',$id)){
            echo '<script type="text/javascript" language="javascript">
                    alert("Profile Updated Successfully");
                    window.location = "my_profile";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "my_profile";
                  </script>';
        }
    }
    
    // warehouse existing
    if(isset($_POST['w_name']) && isset($_POST['w_pin']) && isset($_POST['w_type']) && isset($_POST['w_type_id']))
    {
        $name = trim($_POST['w_name']," ");
        $data = $_POST['w_pin'];
        $type = $_POST['w_type'];
        $type_id = $_POST['w_type_id'];
        $cond = array("warehouse_name"=>$name);
        $get_warehouse = $query->getData("*","warehouses","",$cond,"","","");
        if($get_warehouse != 0)
        {
           echo '1';
        }
        else
        {
            echo '0';
        }
    }
    
    // retrieve warehouse from pickup pin
    if(isset($_POST['pin']) && isset($_POST['type']) && isset($_POST['type_id']))
    {
        $data = $_POST['pin'];
        $type = $_POST['type'];
        $type_id = $_POST['type_id'];
        $cond = array("type"=>$type,"type_id"=>$type_id,"pincode"=>$data,"status"=>"Unblock");
        $get_warehouse = $query->getData("*","warehouses","",$cond,"","","");
        if($get_warehouse != 0)
        {
            $option = '<option value="" hidden>Choose Warehouse</option>';
            foreach ($get_warehouse as $warehouse) {
                $option .= '<option value="' . $warehouse['id'] . '">' . $warehouse['warehouse_name'] . '</option>';
            }
            
            echo $option;
        }
        else
        {
            echo'no_ware';
        }
    }
    
    
    // pincode finder 
    if(isset($_POST['pin_w']) && isset($_POST['type_w']) && isset($_POST['type_id_w']) && isset($_POST['cft']) )
    {
        $pincode = $_POST['pin_w'];
        $type = 'users';
        $type_id = $user_id;
        $cft = $_POST['cft'];
        if($cft == 'all')
        {
           $cond =array("id"=>'3');
        }
        else
        {
            $cond =array("id"=>$cft);
        }
        $get_3pl = $query->getData("*","3pls","",$cond,"","","")[0];
        
        $registered_name = $get_3pl['registered_name'];
        $token = $get_3pl['api_token'];
        $password = $get_3pl['password'];
        
        
        $loginFields = array(
            "username" => $registered_name,
            "password" => $password
        );
        $cs = curl_init();
        curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
        curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
        curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($cs, CURLOPT_CONNECTTIMEOUT ,0); 
            curl_setopt($cs, CURLOPT_TIMEOUT, 400);
        curl_setopt($cs, CURLOPT_HTTPHEADER, array(
            "accept: application/json",
            "cache-control: no-cache",
            "content-type: application/json"
        ));
        $responselg = curl_exec($cs);
        $errorlg = curl_error($cs);
        curl_close($cs);
        if($errorlg){
            echo $errorlg;
        }
        else
        {
            $jwt = json_decode($responselg)->jwt;
            if(!empty($jwt)){
                $cf = curl_init();
                curl_setopt($cf, CURLOPT_URL, "https://ltl-serviceability.delhivery.com/serviceability/$pincode/details/?pincode=$pincode");
                curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);  
                    curl_setopt($cf, CURLOPT_CONNECTTIMEOUT ,0); 
                    curl_setopt($cf, CURLOPT_TIMEOUT, 400);
                curl_setopt($cf, CURLOPT_HTTPHEADER, array(
                    "Authorization: Bearer $jwt",
                    "accept: application/json",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ));
                $response = curl_exec($cf);
                $error = curl_error($cf);
                curl_close($cf);
                if($error){
                    echo $error;
                }
                else
                {
                    $resp = json_decode($response);
                    if($resp->success == 1)
                    {
                        echo'Y';
                    }
                    else
                    {
                        echo'N';
                    }
                }
            }else{
                echo 'NTR';
            }
        }
    }
    
    
    // delivery pincode validation
    if(isset($_POST['del_pin']) && isset($_POST['type_d']) && isset($_POST['type_id_d']) && isset($_POST['cft']))
    {
        $pin = $_POST['del_pin'];
        $type = 'users';
        $type_id = $user_id;
        $cft  = $_POST['cft'];
        if($cft == 'all')
        {
           $cond =array("id"=>'3');
        }
        else
        {
            $cond =array("id"=>$cft);
        }
        $get_3pl = $query->getData("*","3pls","",$cond,"","","")[0];
        
        $registered_name = $get_3pl['registered_name'];
        $token = $get_3pl['api_token'];
        $password = $get_3pl['password'];
        
        
        $loginFields = array(
            "username" => $registered_name,
            "password" => $password
        );
        $cs = curl_init();
        curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
        curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
        curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($cs, CURLOPT_CONNECTTIMEOUT ,0); 
            curl_setopt($cs, CURLOPT_TIMEOUT, 400);
        curl_setopt($cs, CURLOPT_HTTPHEADER, array(
            "accept: application/json",
            "cache-control: no-cache",
            "content-type: application/json"
        ));
        $response = curl_exec($cs);
        $error = curl_error($cs);
        curl_close($cs);
        if($error){
            echo $error;
        }
        else
        {
            $resp = json_decode($response);
            $jwt = $resp->jwt;
            $cf = curl_init();
            curl_setopt($cf, CURLOPT_URL, "https://ltl-serviceability.delhivery.com/serviceability/$pin/details/?pincode=$pin");
            curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);  
                curl_setopt($cf, CURLOPT_CONNECTTIMEOUT ,0); 
                curl_setopt($cf, CURLOPT_TIMEOUT, 400);
            curl_setopt($cf, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer $jwt",
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"
            ));
            $response = curl_exec($cf);
            $error = curl_error($cf);
            curl_close($cf);
            if($error){
                echo $error;
            }
            else
            {
                $resp = json_decode($response);
                // print_r($resp);
                if($resp->success == 1)
                {
                    $cf = curl_init();
                    curl_setopt($cf, CURLOPT_URL, "https://ltl-retail.delhivery.com/v3/retail/pincode-mapping/$pin?oda_config=DLV");
                    curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);  
                        curl_setopt($cf, CURLOPT_CONNECTTIMEOUT ,0); 
                        curl_setopt($cf, CURLOPT_TIMEOUT, 400);
                    curl_setopt($cf, CURLOPT_HTTPHEADER, array(
                        "Authorization: Bearer $jwt",
                        "accept: application/json",
                        "cache-control: no-cache",
                        "content-type: application/json"
                    ));
                    $oda_response = curl_exec($cf);
                    $oda_error = curl_error($cf);
                    curl_close($cf);
                    if($oda_error){
                        echo $oda_error;
                    }
                    else
                    {
                        $state = $resp->data[0]->state;
                        $city = $resp->data[0]->city;
                        $oda = $oda_response;
                        $response_arr_result = array(
                            'state' => $state,
                            'city' => $city,
                            'oda' => $oda
                        );
                        echo json_encode($response_arr_result);
                    }
                }
            }
        }
        
        
                
            
            
        
    }
    
    
    // add money redirect
    if(isset($_POST['add_money'])){
        foreach($_POST as $key => $value):
            $key = ($key == "add_money")? "get_add_money" : $key;
            $urlParams = $urlParams.'&'.$key.'='.$value;
        endforeach;
        $urlParams = '&'.$urlParams.'&redirect='.$_SERVER['HTTP_REFERER'];
        header('location:https://kingfishlogistics.in/b2b/user/addmoney?'.$urlParams);
    }
    
    
    // deliverY appointemnt
    if(isset($_POST['submitAppointment'])){
        extract($_POST);
        $appointArray["user_type"] = "users";
        $appointArray["type_id"] = $user_id;
        foreach($_POST as $varkey => $varvalue){
            $appointArray[$varkey] = trim($varvalue, " ");
        }
        unset($appointArray['submitAppointment']);
        $appointArray["appointment_date"] = date_format(date_create($appointment_date), "d-m-Y");
        $insAppoint = $query->insertData('appointments',$appointArray);
        if($insAppoint){
            echo "<script type='text/javascript' language='text/javascript'>
                    alert('You are successfully sent an appointment request');
                    window.location = 'delivery_appointment';
                  </script>";
        }else{
            echo "<script type='text/javascript' language='text/javascript'>
                    alert('Something went wrong! Please! contact with administrator');
                    window.location = 'delivery_appointment';
                  </script>";
        }
    }
    
    // add Order
    if(isset($_POST['add_Order']))
    {
        $newPost = array();
        foreach($_POST as $postkey => $postval):
            $newPost[$postkey] = str_replace("'","\'",$postval);
        endforeach;
        unset($_POST);
        $_POST = $newPost;
        extract($_POST);
        $cond = array("api_token_name"=>$cft_type);
        $get_3pl = $query->getData("*","3pls","",$cond,"","","")[0];
        
        $cftregistered_name = $get_3pl['registered_name'];
        $cfttoken = $get_3pl['api_token'];
        $cftpassword = $get_3pl['password'];
        
        $user_cond=array("id"=>$user_id);
        $check_user_details = $query->getData("*","users","",$user_cond,"","","");
        $party_type = $check_user_details[0]['party_type'];
        $credit_limt= $check_user_details[0]['credit_limit'];
        $wallet_balance = $check_user_details[0]['wallet_balance'];
        
        $zone1 = $query->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$pin),"","","1")[0]['zone'];
        $zone2 = $query->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$del_pin),"","","1")[0]['zone'];
        $frightZone = $zone1."_to_".$zone2;
        if($getUserDetails['fright_charge'] == "no"):
            $applied_weight_charge = $query->getData('*','default_fright_master','',array('id'=>'1'),'id','DESC','1')[0][$frightZone];
        elseif($getUserDetails['fright_charge'] == "yes"):
            $applied_weight_charge = $query->getData('*','users_fright_master','',array('user_id'=>$getUserDetails['id']),'id','DESC','1')[0][$frightZone];
        endif;
        
        $order_done = 1;
        if($payment_mode == "CoD" && ($check_user_details[0]['cod_charge_enable_disable'] == "enable")){
           $payment_mode = "CoD";
        }elseif($check_user_details[0]['party_type'] == "Paid"){
           $payment_mode = "Prepaid";
        }elseif($check_user_details[0]['party_type'] == "To-Pay"){
           $payment_mode = "To-Pay";
        }elseif($check_user_details[0]['party_type'] == "Franchise-ToPay"){
           $payment_mode = "Franchise-ToPay";
        }
        
        if ($cft_type == "6CFT") {
            $cod_charge = $_POST['cod_charge_6cft'];
            $fuel_surcharge = $_POST['fuel_surcharge_6cft'];
            $awb_charge = $_POST['awb_charge_6cft'];
            $fob_surcharge = $_POST['fob_surcharge_6cft'];
            $handeling_charge = $_POST['handeling_charge_6cft'];
            $pickup_charge = $_POST['pickup_charge_6cft'];
            $damage_surcharge = $_POST['damage_surcharge_6cft'];
            $oda_surcharge = $_POST['oda_surcharge_6cft'];
            $packaging_surcharge = $_POST['packaging_surcharge_6cft'];
            $special_delivery_charge = $_POST['special_delivery_charge_6cft'];
            $weight_charge = $_POST['weight_charge_6cft'];
            $total_charge = $_POST['total_charge_6cft'];
            $vol_weight = $_POST['sixcft_volweight'];
            $igst_amount = $_POST['igst_6cft'];
            $cgst_amount = $_POST['cgst_6cft'];
            $sgst_amount = $_POST['sgst_6cft'];
            
        } elseif ($cft_type == "8CFT") {
            $cod_charge = $_POST['cod_charge_8cft'];
            $fuel_surcharge = $_POST['fuel_surcharge_8cft'];
            $awb_charge = $_POST['awb_charge_8cft'];
            $fob_surcharge = $_POST['fob_surcharge_8cft'];
            $handeling_charge = $_POST['handeling_charge_8cft'];
            $pickup_charge = $_POST['pickup_charge_8cft'];
            $damage_surcharge = $_POST['damage_surcharge_8cft'];
            $oda_surcharge = $_POST['oda_surcharge_8cft'];
            $packaging_surcharge = $_POST['packaging_surcharge_8cft'];
            $special_delivery_charge = $_POST['special_delivery_charge_8cft'];
            $weight_charge = $_POST['weight_charge_8cft'];
            $total_charge = $_POST['total_charge_8cft'];
            $vol_weight = $_POST['eightcft_volweight'];
            $igst_amount = $_POST['igst_6cft'];
            $cgst_amount = $_POST['cgst_6cft'];
            $sgst_amount = $_POST['sgst_6cft'];
            
        } elseif ($cft_type == "10CFT") {
            $cod_charge = $_POST['cod_charge_10cft'];
            $fuel_surcharge = $_POST['fuel_surcharge_10cft'];
            $awb_charge = $_POST['awb_charge_10cft'];
            $fob_surcharge = $_POST['fob_surcharge_10cft'];
            $handeling_charge = $_POST['handeling_charge_10cft'];
            $pickup_charge = $_POST['pickup_charge_10cft'];
            $damage_surcharge = $_POST['damage_surcharge_10cft'];
            $oda_surcharge = $_POST['oda_surcharge_10cft'];
            $packaging_surcharge = $_POST['packaging_surcharge_10cft'];
            $special_delivery_charge = $_POST['special_delivery_charge_10cft'];
            $weight_charge = $_POST['weight_charge_10cft'];
            $total_charge = $_POST['total_charge_10cft'];
            $vol_weight = $_POST['tencft_volweight'];
            $igst_amount = $_POST['igst_6cft'];
            $cgst_amount = $_POST['cgst_6cft'];
            $sgst_amount = $_POST['sgst_6cft'];
        }
        
        if($payment_mode == 'Prepaid' || $payment_mode == "CoD")
        {
            if($total_charge > $wallet_balance)
            {
                if($party_type == "TBB" && $credit_limt >= round(($total_charge - $wallet_balance), 2)){
                    $order_done = 10;
                    if($total_charge >= ($total_charge - $wallet_balance)){
                        $creditUse = round(($total_charge - $wallet_balance),2);
                    }else{
                        $creditUse = $total_charge;
                    }
                }else{
                    $order_done = 0;
                }
            }
        }
        else
        {
            $order_done = 1;
        }
        if($order_done == 0){
            echo'<script type="text/javascript" language="javascript">alert("Sorry!!Order not created due to unsufficient balance.");window.location="add_money";</script>';
        }else{
            $pick_cond = array("id"=>$warehouse_id);
            $get_pick_details = $query->getData("*","warehouses","",$pick_cond,"","","");
            
            $pickup_location = $get_pick_details[0]['warehouse_name'];
            $r_address =  $get_pick_details[0]['r_address'];
            $r_pin =  $get_pick_details[0]['r_pin'];
            $r_city =  $get_pick_details[0]['r_city'];
            $phone_number = $get_pick_details[0]['phone_number'];
            
            $gramweight = round(($weight*1000),2);
            $cod_amnt = 0;
            if($payment_mode == "CoD")
            {
                $cod_amnt = round(($cod_amount),2);
                $payment_type = "CoD";
            }
            elseif($payment_mode == "To-Pay")
            {
                $cod_amnt = round(($total_charge),2);
                $payment_type = "CoD";
            }
            elseif($payment_mode == "Franchise-ToPay")
            {
                $cod_amnt = round(($total_charge+$profit_amount),2);
                $payment_type = "CoD";
            }
            else
            {
                $payment_type = "Prepaid";
            }
            
            $dimensions = [];
            for($i=0;$i<count($qty);$i++)
            {
                $dimensions[] = array(
                    "length" => floatval($length[$i]),
                    "width" => floatval($width[$i]),
                    "height" => floatval($height[$i]),
                    "count" => intval($qty[$i])
                );
                $count_suborders = $count_suborders+intval($qty[$i]);
            }
            
            $invoices = [];
            for($k=0;$k<count($n_value);$k++)
            {
                
                $invoices[] = array(
                     "ident" => $inv[$k],
                     "n_value" => floatval($n_value[$k]),
                     "ewaybill" => $ewaybill[$k]
                );
            }
            if($ref_no =='')
            {
                $subident = "KING".rand(100000,999999);
            }
            else
            {
                $subident = $ref_no;
            }
            $rov_insurance = ($insurance === 'Yes') ? True : False;
            $loginFields = array(
                    "username" => $cftregistered_name,
                    "password" => $cftpassword
                );
            $sb = curl_init();
            curl_setopt($sb, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
            curl_setopt($sb, CURLOPT_POSTFIELDS, json_encode($loginFields));
            curl_setopt($sb, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($sb, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($sb, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($sb, CURLOPT_CONNECTTIMEOUT ,0); 
            curl_setopt($sb, CURLOPT_TIMEOUT, 400);
            curl_setopt($sb, CURLOPT_HTTPHEADER, array(
              "accept: application/json",
              "cache-control: no-cache",
              "content-type: application/json"
            ));
            $response = curl_exec($sb);
            $error = curl_error($sb);
            curl_close($sb);
            if($error){
                echo '<script>alert("System can\'t not create order right now! Please! try again later.");window.location="create_order";</script>';
            }else{
                $jwt = json_decode($response)->jwt;
                if(!empty($jwt)){
                    $fields = array(
                          "ident" => $lr,
                          "pickup_location" => $pickup_location,
                          "dropoff_location" => array(
                            "consignee" => $name,
                            "address" => $address,
                            "city" => $city,
                            "zip" => $del_pin,
                            "region" => $state,
                            "phone" => $phone,
                            "email" => $email
                        ),
                        "return_address" => array(
                          "address" => $r_address,
                          "zip" => $r_pin,
                          "name" => $pickup_location,
                          "city" => $r_city,
                          "phone" => $phone_number
                        ),
                        "d_mode"=> $payment_type,
                        "amount"=> $cod_amnt,
                        "rov_insurance"=> False,
                        "weight"=> $gramweight,
                        "invoices" => $invoices,
                        "suborders" => [
                            array(
                                "ident" => $subident,
                                "count" => $count_suborders,
                                "description" => $description,
                                "master" => false
                            )
                        ],
                        "dimensions" =>  $dimensions
                    );
                    $lb = curl_init();
                    curl_setopt($lb, CURLOPT_URL, "https://btob.api.delhivery.com/v3/manifest");
                    curl_setopt($lb, CURLOPT_POSTFIELDS, json_encode($fields));
                    curl_setopt($lb, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($lb, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($lb, CURLOPT_SSL_VERIFYHOST, false);  
                        curl_setopt($lb, CURLOPT_CONNECTTIMEOUT ,0); 
                        curl_setopt($lb, CURLOPT_TIMEOUT, 400);
                    curl_setopt($lb, CURLOPT_HTTPHEADER, array(
                      "Authorization: Bearer $jwt",
                      "accept: application/json",
                      "cache-control: no-cache",
                      "content-type: application/json"
                    ));
                    $response_j = curl_exec($lb);
                    $error_j = curl_error($lb);
                    curl_close($lb);
                    if($error_j){
                      echo $error_j;
                    }
                    else{
                        $response_arr =  json_decode($response_j);
                        if(isset($response_arr->job_id) && !empty($response_arr->job_id))
                        {
                            $job_id = $response_arr->job_id;
                            
                            $origins = explode("--", getCenterandCity($pin,$cftregistered_name,$cftpassword));
                            $destinations = explode("--", getCenterandCity($del_pin,$cftregistered_name,$cftpassword));
                            
                            $order_date = date('Y-m-d');
                            $order_time = date('h:i:sa');
                            
                            if($payment_mode == "To-Pay")
                            {
                                $cod_amnt = 0;
                            }
                            elseif($payment_mode == "Franchise-ToPay")
                            {
                                $cod_amnt = 0;
                            }
                            $getOrderid = $query->getData('*','orders','','','id','DESC','1');
                          	if($getOrderid != 0){
                                $order_id = "ORD".(str_replace("ORD","",$getOrderid[0]['order_id'])+1);
                            }else{
                                $order_id = 'ORD100000000';
                            }
                            
                            $orderArr = array("user_type"=>"users","type_id"=>$user_id,"order_id"=>$order_id,"order_date"=>$order_date,"order_time"=>$order_time,"warehouse_id"=>$warehouse_id,"pick_pin"=>$pin,"del_pin"=>$del_pin,"weight"=>$weight,"vol_weight"=>$vol_weight,"payment_mode"=>$payment_mode,"cod_amount"=>$cod_amnt,"profit_amount"=>$profit_amount,"invoice_amount"=>$invoice_amount,"insurance"=>$insurance,"ltype"=>$ltype,"lr"=>$lr,"description"=>$description,"job_id"=>$job_id,"hsn"=>$hsn,"oda"=>$oda,"cod_charge"=>$cod_charge,"fuel_surcharge"=>$fuel_surcharge,"awb_charge"=>$awb_charge,"fob_surcharge"=>$fob_surcharge,"handeling_charge"=>$handeling_charge,"pickup_charge"=>$pickup_charge,"damage_surcharge"=>$damage_surcharge,"oda_surcharge"=>$oda_surcharge,"packaging_surcharge"=>$packaging_surcharge,"special_delivery_charge"=>$special_delivery_charge,"gst_charge"=>$gst_charge,"weight_charge"=>$weight_charge,"total_charge"=>$total_charge,"channel"=>"Delhivery","item_type"=>$item,"seller_gst_tin"=>$seller_gst_tin,"consignee_gst_tin"=>$consignee_gst_tin,"status"=>"Created","cft_type"=>$cft_type,"subident"=>$subident,"origin_center"=>$origins[0],"destination_center"=>$destinations[0],"origin_city"=>$origins[1],"destination_city"=>$destinations[1],"igst_per"=>$igst_per,"sgst_per"=>$sgst_per,"cgst_per"=>$cgst_per,"igst_amount"=>$igst_amount,"cgst_amount"=>$cgst_amount,"sgst_amount"=>$sgst_amount,"applied_weight_charge"=>$applied_weight_charge,"applied_fuel_surcharge"=>$applied_fuel_surcharge,"applied_fuel_surcharge_type"=>$applied_fuel_surcharge_type,"applied_cod_charge_min"=>$applied_cod_charge_min,"applied_cod_charge"=>$applied_cod_charge,"applied_cod_charge_type"=>$applied_cod_charge_type,"applied_awb_charge"=>$applied_awb_charge,"applied_fob_surcharge_minimum"=>$applied_fob_surcharge_minimum,"applied_fob_surcharge_percentage"=>$applied_fob_surcharge_percentage,"applied_handeling_charge"=>$applied_handeling_charge,"applied_handeling_charge_type"=>$applied_handeling_charge_type,"applied_damage_surcharge_min"=>$applied_damage_surcharge_min,"applied_damage_surcharge"=>$applied_damage_surcharge,"applied_damage_surcharge_type"=>$applied_damage_surcharge_type,"applied_oda_surcharge_min"=>$applied_oda_surcharge_min,"applied_oda_surcharge"=>$applied_oda_surcharge,"applied_oda_surcharge_type"=>$applied_oda_surcharge_type,"applied_packaging_surcharge"=>$applied_packaging_surcharge,"applied_packaging_surcharge_type"=>$applied_packaging_surcharge_type,"applied_special_delivery_or_appointment_charge_min"=>$applied_special_delivery_or_appointment_charge_min,"applied_special_delivery_or_appointment_charge"=>$applied_special_delivery_or_appointment_charge,"applied_special_delivery_or_appointment_charge_type"=>$applied_special_delivery_or_appointment_charge_type,"applied_pickup_charge"=>$applied_pickup_charge,"applied_pickup_charge_type"=>$applied_pickup_charge_type);
                            $create_order = $query->insertData('orders',$orderArr);
                            
                            $cong_arr = array("order_id"=>$order_id,"company"=>$company,"name"=>$name,"phone"=>$phone,"email"=>$email,"address"=>$address,"city"=>$city,"state"=>$state);
                            $insert_consignee_details =  $query->insertData('consignee_details',$cong_arr);
                            
                            $new_bal = floatval($wallet_balance - $total_charge);
              	            $tdate=date('Y-m-d H:i:s');
                            if($payment_mode=='Prepaid' || $payment_mode=="CoD"){
                                $getprevTrans = $query->getData('*','transactions','',array("txn_id_type"=>"Serial"),'id','DESC','1');
                              	if($getprevTrans != 0){
                                    $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
                                }else{
                                    $merchantTransactionId = 'KINGFISH100000';
                                }
                                $neworderdetails = str_replace("'", "\'", "Order id.:".$order_id."'s new order placed");
              		            $transsArr = array("date_time"=>$tdate,"user_type"=>"users","user_id"=>$user_id,"amount"=>$total_charge,"balance"=>$new_bal,"type"=>"Online","details"=>$neworderdetails,"txn_id"=>$merchantTransactionId);
                  	            $insert_transaction = $query->insertData('transactions',$transsArr);
                                if($insert_transaction)
                                {
                                    $cond_uw= array("wallet_balance"=>$new_bal);
                                    $up_wall = $query->updateData('users',$cond_uw,'id',$user_id);
                                    if($up_wall){
                                        if($order_done == 10){
                                            $getprevCRTrans = $query->getData('*','credit_transactions','','','id','DESC','1');
                                          	if($getprevCRTrans != 0){
                                                $CRmerchantTransactionId = "KNGCRE".(str_replace("KNGCRE","",$getprevCRTrans[0]['txn_id'])+1);
                                            }else{
                                                $CRmerchantTransactionId = 'KNGCRE100000';
                                            }
                                            $crdetails = str_replace("'", "\'", "Order id.:".$order_id."'s order placed");
                                            $transscrArr = array("date_time"=>$tdate,"user_type"=>"users","type_id"=>$user_id,"amount"=>$creditUse,"balance"=>$new_bal,"details"=>$crdetails,"txn_id"=>$CRmerchantTransactionId);
                              	            $insertcr_transaction = $query->insertData('credit_transactions',$transscrArr);
                              	        }
                                    }else{
                                        echo '<script type="text/javascript" language="javascript">
                                                alert("Something went wrong! Please contact with administrator");
                                                window.location = "create_order";
                                              </script>';
                                    }
                                }
                            }elseif($payment_mode=='To-Pay'){
                                $getprevTransTP = $query->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                              	if($getprevTransTP != 0){
                                    $merchantTransactionIdTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransTP[0]['txn_id'])+1);
                                }else{
                                    $merchantTransactionIdTP = 'KINGFISH100000';
                                }
                                $descTP = str_replace("'", "\'", "Order id.: ".$order_id."'s order placed with to pay");
                                $transsArrTP = array("date_time"=>$tdate,"user_type"=>'users',"user_id"=>$user_id,"amount"=>'0',"balance"=>$wallet_balance,"type"=>"Manual","details"=>$descTP,"txn_id"=>$merchantTransactionIdTP);
                  	            $insert_transactionTP = $query->insertData('transactions',$transsArrTP);
                            }elseif($payment_mode=='Franchise-ToPay'){
                                $getprevTransFTP = $query->getData('*','transactions','',array("txn_id_type"=>"Serial"),'id','DESC','1');
                              	if($getprevTransFTP != 0){
                                    $merchantTransactionIdFTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransFTP[0]['txn_id'])+1);
                                }else{
                                    $merchantTransactionIdFTP = 'KINGFISH100000';
                                }
                                $descFTP = str_replace("'", "\'", "Order id.: ".$order_id."'s order placed with franchise to pay");
                                $transsArrFTP = array("date_time"=>$tdate,"user_type"=>'users',"user_id"=>$user_id,"amount"=>'0',"balance"=>$wallet_balance,"type"=>"Manual","details"=>$descFTP,"txn_id"=>$merchantTransactionIdFTP);
                  	            $insert_transactionFTP = $query->insertData('transactions',$transsArrFTP);
                            }
                            
                            if($dimensions_in =='CM')
                            {
                                $dimensions_in = 'cm';
                            }
                            elseif($dimensions_in =='IN')
                            {
                                $dimensions_in = 'inch';
                            }
                            for($i=0;$i<count($qty);$i++)
                            {
                                $cong_box = array("order_id"=>$order_id,"qty"=>floatval($qty[$i]),"length"=>floatval($length[$i]),"width"=>floatval($width[$i]),"height"=>floatval($height[$i]),"dimention"=>$dimensions_in);
                                $insert_box_details =  $query->insertData('box_details',$cong_box);
                            }
                            
                            for($k=0;$k<count($n_value);$k++)
                            {
                                $cong_invoice = array("order_id"=>$order_id,"ewaybill"=>$ewaybill[$k],"n_value"=>floatval($n_value[$k]),"inv_no"=>$inv[$k]);
                                $insert_invoice_details =  $query->insertData('invoice_details',$cong_invoice);
                            }
                            
                            if($create_order && $insert_consignee_details && $insert_box_details && $insert_invoice_details)
                            {
                                sleep(30);
                                header("location:action?get_manifest_job_id=$job_id&order_id=$order_id&cft_type=$cft_type");
                            }
                        }else{
                            if(preg_match("/duplicaterequest/i", $response_arr->message) && preg_match("/already/i", $response_arr->message) && preg_match("/manifested/i", $response_arr->message) && !empty($lr)){
                               echo '<script>alert("Duplicate LR found! Please try with another LR.");window.location="create_order";</script>';
                            }else{
                                echo '<script>alert("System can\'t not create order right now! Please! try again later.");window.location="create_order";</script>';
                            }
                        }
                    }
                }else{
                    echo'<script>alert("System can\'t not create order right now! Please! try again later.");window.location="create_order";</script>';
                }
            }
        }
    }
    
    
    // save for pickup
    if(isset($_POST['saveForPickup'])):
        $newPost = array();
        foreach($_POST as $postkey => $postval):
            $newPost[$postkey] = str_replace("'","\'",$postval);
        endforeach;
        unset($_POST);
        $_POST = $newPost;
        extract($_POST);
        $cond = array("api_token_name"=>$cft_type);
        $get_3pl = $query->getData("*","3pls","",$cond,"","","")[0];
        
        $cftregistered_name = $get_3pl['registered_name'];
        $cfttoken = $get_3pl['api_token'];
        $cftpassword = $get_3pl['password'];
        
        $user_cond=array("id"=>$user_id);
        $check_user_details = $query->getData("*","users","",$user_cond,"","","");
        $party_type = $check_user_details[0]['party_type'];
        $credit_limt= $check_user_details[0]['credit_limit'];
        $wallet_balance = $check_user_details[0]['wallet_balance'];
        
        $zone1 = $query->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$pin),"","","1")[0]['zone'];
        $zone2 = $query->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$del_pin),"","","1")[0]['zone'];
        $frightZone = $zone1."_to_".$zone2;
        if($getUserDetails['fright_charge'] == "no"):
            $applied_weight_charge = $query->getData('*','default_fright_master','',array('id'=>'1'),'id','DESC','1')[0][$frightZone];
        elseif($getUserDetails['fright_charge'] == "yes"):
            $applied_weight_charge = $query->getData('*','users_fright_master','',array('user_id'=>$getUserDetails['id']),'id','DESC','1')[0][$frightZone];
        endif;
        
        $order_done = 1;
        if($payment_mode == "CoD" && ($check_user_details[0]['cod_charge_enable_disable'] == "enable")){
           $payment_mode = "CoD";
        }elseif($check_user_details[0]['party_type'] == "Paid"){
           $payment_mode = "Prepaid";
        }elseif($check_user_details[0]['party_type'] == "To-Pay"){
           $payment_mode = "To-Pay";
        }elseif($check_user_details[0]['party_type'] == "Franchise-ToPay"){
           $payment_mode = "Franchise-ToPay";
        }
        
        if ($cft_type == "6CFT") {
            $cod_charge = $_POST['cod_charge_6cft'];
            $fuel_surcharge = $_POST['fuel_surcharge_6cft'];
            $awb_charge = $_POST['awb_charge_6cft'];
            $fob_surcharge = $_POST['fob_surcharge_6cft'];
            $handeling_charge = $_POST['handeling_charge_6cft'];
            $pickup_charge = $_POST['pickup_charge_6cft'];
            $damage_surcharge = $_POST['damage_surcharge_6cft'];
            $oda_surcharge = $_POST['oda_surcharge_6cft'];
            $packaging_surcharge = $_POST['packaging_surcharge_6cft'];
            $special_delivery_charge = $_POST['special_delivery_charge_6cft'];
            $weight_charge = $_POST['weight_charge_6cft'];
            $total_charge = $_POST['total_charge_6cft'];
            $vol_weight = $_POST['sixcft_volweight'];
            $igst_amount = $_POST['igst_6cft'];
            $cgst_amount = $_POST['cgst_6cft'];
            $sgst_amount = $_POST['sgst_6cft'];
            
        } elseif ($cft_type == "8CFT") {
            $cod_charge = $_POST['cod_charge_8cft'];
            $fuel_surcharge = $_POST['fuel_surcharge_8cft'];
            $awb_charge = $_POST['awb_charge_8cft'];
            $fob_surcharge = $_POST['fob_surcharge_8cft'];
            $handeling_charge = $_POST['handeling_charge_8cft'];
            $pickup_charge = $_POST['pickup_charge_8cft'];
            $damage_surcharge = $_POST['damage_surcharge_8cft'];
            $oda_surcharge = $_POST['oda_surcharge_8cft'];
            $packaging_surcharge = $_POST['packaging_surcharge_8cft'];
            $special_delivery_charge = $_POST['special_delivery_charge_8cft'];
            $weight_charge = $_POST['weight_charge_8cft'];
            $total_charge = $_POST['total_charge_8cft'];
            $vol_weight = $_POST['eightcft_volweight'];
            $igst_amount = $_POST['igst_6cft'];
            $cgst_amount = $_POST['cgst_6cft'];
            $sgst_amount = $_POST['sgst_6cft'];
            
        } elseif ($cft_type == "10CFT") {
            $cod_charge = $_POST['cod_charge_10cft'];
            $fuel_surcharge = $_POST['fuel_surcharge_10cft'];
            $awb_charge = $_POST['awb_charge_10cft'];
            $fob_surcharge = $_POST['fob_surcharge_10cft'];
            $handeling_charge = $_POST['handeling_charge_10cft'];
            $pickup_charge = $_POST['pickup_charge_10cft'];
            $damage_surcharge = $_POST['damage_surcharge_10cft'];
            $oda_surcharge = $_POST['oda_surcharge_10cft'];
            $packaging_surcharge = $_POST['packaging_surcharge_10cft'];
            $special_delivery_charge = $_POST['special_delivery_charge_10cft'];
            $weight_charge = $_POST['weight_charge_10cft'];
            $total_charge = $_POST['total_charge_10cft'];
            $vol_weight = $_POST['tencft_volweight'];
            $igst_amount = $_POST['igst_6cft'];
            $cgst_amount = $_POST['cgst_6cft'];
            $sgst_amount = $_POST['sgst_6cft'];
        }
        
        if($payment_mode == 'Prepaid' || $payment_mode == "CoD")
        {
            if($total_charge > $wallet_balance)
            {
                if($party_type == "TBB" && $credit_limt >= round(($total_charge - $wallet_balance), 2)){
                    $order_done = 10;
                    if($total_charge >= ($total_charge - $wallet_balance)){
                        $creditUse = round(($total_charge - $wallet_balance),2);
                    }else{
                        $creditUse = $total_charge;
                    }
                }else{
                    $order_done = 0;
                }
            }
        }
        else
        {
            $order_done = 1;
        }
        if($order_done == 0){
            echo'<script type="text/javascript" language="javascript">alert("Sorry!!Order not created due to unsufficient balance.");window.location="add_money";</script>';
        }else{
            $pick_cond = array("id"=>$warehouse_id);
            $get_pick_details = $query->getData("*","warehouses","",$pick_cond,"","","");
            
            $pickup_location = $get_pick_details[0]['warehouse_name'];
            $r_address =  $get_pick_details[0]['r_address'];
            $r_pin =  $get_pick_details[0]['r_pin'];
            $r_city =  $get_pick_details[0]['r_city'];
            $phone_number = $get_pick_details[0]['phone_number'];
            
            $gramweight = round(($weight*1000),2);
            $cod_amnt = 0;
            if($payment_mode == "CoD")
            {
                $cod_amnt = round(($cod_amount),2);
                $payment_type = "CoD";
            }
            elseif($payment_mode == "To-Pay")
            {
                $cod_amnt = round(($total_charge),2);
                $payment_type = "CoD";
            }
            elseif($payment_mode == "Franchise-ToPay")
            {
                $cod_amnt = round(($total_charge+$profit_amount),2);
                $payment_type = "CoD";
            }
            else
            {
                $payment_type = "Prepaid";
            }
            
            $dimensions = [];
            for($i=0;$i<count($qty);$i++)
            {
                $dimensions[] = array(
                    "length" => floatval($length[$i]),
                    "width" => floatval($width[$i]),
                    "height" => floatval($height[$i]),
                    "count" => intval($qty[$i])
                );
                $count_suborders = $count_suborders+intval($qty[$i]);
            }
            
            $invoices = [];
            for($k=0;$k<count($n_value);$k++)
            {
                
                $invoices[] = array(
                     "ident" => $inv[$k],
                     "n_value" => floatval($n_value[$k]),
                     "ewaybill" => $ewaybill[$k]
                );
            }
            
            $job_id = $uploadId;
            
            $origins = explode("--", getCenterandCity($pin,$cftregistered_name,$cftpassword));
            $destinations = explode("--", getCenterandCity($del_pin,$cftregistered_name,$cftpassword));
            
            $order_date = date('Y-m-d');
            $order_time = date('h:i:sa');
            
            if($payment_mode == "To-Pay")
            {
                $cod_amnt = 0;
            }
            elseif($payment_mode == "Franchise-ToPay")
            {
                $cod_amnt = 0;
            }
            $getOrderid = $query->getData('*','orders','','','id','DESC','1');
          	if($getOrderid != 0){
                $order_id = "ORD".(str_replace("ORD","",$getOrderid[0]['order_id'])+1);
            }else{
                $order_id = 'ORD100000000';
            }
            
            $orderArr = array("user_type"=>"users","type_id"=>$user_id,"order_id"=>$order_id,"order_date"=>$order_date,"order_time"=>$order_time,"warehouse_id"=>$warehouse_id,"pick_pin"=>$pin,"del_pin"=>$del_pin,"weight"=>$weight,"vol_weight"=>$vol_weight,"payment_mode"=>$payment_mode,"cod_amount"=>$cod_amnt,"profit_amount"=>$profit_amount,"invoice_amount"=>$invoice_amount,"insurance"=>$insurance,"ltype"=>$ltype,"lr"=>$lr,"description"=>$description,"job_id"=>$job_id,"hsn"=>$hsn,"oda"=>$oda,"cod_charge"=>$cod_charge,"fuel_surcharge"=>$fuel_surcharge,"awb_charge"=>$awb_charge,"fob_surcharge"=>$fob_surcharge,"handeling_charge"=>$handeling_charge,"pickup_charge"=>$pickup_charge,"damage_surcharge"=>$damage_surcharge,"oda_surcharge"=>$oda_surcharge,"packaging_surcharge"=>$packaging_surcharge,"special_delivery_charge"=>$special_delivery_charge,"gst_charge"=>$gst_charge,"weight_charge"=>$weight_charge,"total_charge"=>$total_charge,"channel"=>"Delhivery","item_type"=>$item,"seller_gst_tin"=>$seller_gst_tin,"consignee_gst_tin"=>$consignee_gst_tin,"status"=>"Created","cft_type"=>$cft_type,"subident"=>$client_ref_no,"master_waybill"=>$master_waybill_no,"origin_center"=>$origins[0],"destination_center"=>$destinations[0],"origin_city"=>$origins[1],"destination_city"=>$destinations[1],"igst_per"=>$igst_per,"sgst_per"=>$sgst_per,"cgst_per"=>$cgst_per,"igst_amount"=>$igst_amount,"cgst_amount"=>$cgst_amount,"sgst_amount"=>$sgst_amount,"applied_weight_charge"=>$applied_weight_charge,"applied_fuel_surcharge"=>$applied_fuel_surcharge,"applied_fuel_surcharge_type"=>$applied_fuel_surcharge_type,"applied_cod_charge_min"=>$applied_cod_charge_min,"applied_cod_charge"=>$applied_cod_charge,"applied_cod_charge_type"=>$applied_cod_charge_type,"applied_awb_charge"=>$applied_awb_charge,"applied_fob_surcharge_minimum"=>$applied_fob_surcharge_minimum,"applied_fob_surcharge_percentage"=>$applied_fob_surcharge_percentage,"applied_handeling_charge"=>$applied_handeling_charge,"applied_handeling_charge_type"=>$applied_handeling_charge_type,"applied_damage_surcharge_min"=>$applied_damage_surcharge_min,"applied_damage_surcharge"=>$applied_damage_surcharge,"applied_damage_surcharge_type"=>$applied_damage_surcharge_type,"applied_oda_surcharge_min"=>$applied_oda_surcharge_min,"applied_oda_surcharge"=>$applied_oda_surcharge,"applied_oda_surcharge_type"=>$applied_oda_surcharge_type,"applied_packaging_surcharge"=>$applied_packaging_surcharge,"applied_packaging_surcharge_type"=>$applied_packaging_surcharge_type,"applied_special_delivery_or_appointment_charge_min"=>$applied_special_delivery_or_appointment_charge_min,"applied_special_delivery_or_appointment_charge"=>$applied_special_delivery_or_appointment_charge,"applied_special_delivery_or_appointment_charge_type"=>$applied_special_delivery_or_appointment_charge_type,"applied_pickup_charge"=>$applied_pickup_charge,"applied_pickup_charge_type"=>$applied_pickup_charge_type);
            $create_order = $query->insertData('orders',$orderArr);
            
            $cong_arr = array("order_id"=>$order_id,"company"=>$company,"name"=>$name,"phone"=>$phone,"email"=>$email,"address"=>$address,"city"=>$city,"state"=>$state);
            $insert_consignee_details =  $query->insertData('consignee_details',$cong_arr);
            
            $new_bal = floatval($wallet_balance - $total_charge);
            $tdate = date('Y-m-d H:i:s');
            if($payment_mode=='Prepaid' || $payment_mode=="CoD"){
                $getprevTrans = $query->getData('*','transactions','',array("txn_id_type"=>"Serial"),'id','DESC','1');
              	if($getprevTrans != 0){
                    $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
                }else{
                    $merchantTransactionId = 'KINGFISH100000';
                }
                $neworderdetails = str_replace("'", "\'", "Order id.:".$order_id."'s new order placed");
  	            $transsArr = array("date_time"=>$tdate,"user_type"=>"users","user_id"=>$user_id,"amount"=>$total_charge,"balance"=>$new_bal,"type"=>"Online","details"=>$neworderdetails,"txn_id"=>$merchantTransactionId);
  	            $insert_transaction = $query->insertData('transactions',$transsArr);
                if($insert_transaction)
                {
                    $cond_uw= array("wallet_balance"=>$new_bal);
                    $up_wall = $query->updateData('users',$cond_uw,'id',$user_id);
                    if($up_wall){
                        if($order_done == 10){
                            $getprevCRTrans = $query->getData('*','credit_transactions','','','id','DESC','1');
                          	if($getprevCRTrans != 0){
                                $CRmerchantTransactionId = "KNGCRE".(str_replace("KNGCRE","",$getprevCRTrans[0]['txn_id'])+1);
                            }else{
                                $CRmerchantTransactionId = 'KNGCRE100000';
                            }
                            $crdetails = str_replace("'", "\'", "Order id.:".$order_id."'s order placed");
                            $transscrArr = array("date_time"=>$tdate,"user_type"=>"users","type_id"=>$user_id,"amount"=>$creditUse,"balance"=>$new_bal,"details"=>$crdetails,"txn_id"=>$CRmerchantTransactionId);
              	            $insertcr_transaction = $query->insertData('credit_transactions',$transscrArr);
              	        }
                    }else{
                        echo '<script type="text/javascript" language="javascript">
                                alert("Something went wrong! Please contact with administrator");
                                window.location = "create_order";
                              </script>';
                    }
                }
            }elseif($payment_mode=='To-Pay'){
                $getprevTransTP = $query->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
              	if($getprevTransTP != 0){
                    $merchantTransactionIdTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransTP[0]['txn_id'])+1);
                }else{
                    $merchantTransactionIdTP = 'KINGFISH100000';
                }
                $descTP = str_replace("'", "\'", "Order id.: ".$order_id."'s order placed with to pay");
                $transsArrTP = array("date_time"=>$tdate,"user_type"=>'users',"user_id"=>$user_id,"amount"=>'0',"balance"=>$wallet_balance,"type"=>"Manual","details"=>$descTP,"txn_id"=>$merchantTransactionIdTP);
  	            $insert_transactionTP = $query->insertData('transactions',$transsArrTP);
            }elseif($payment_mode=='Franchise-ToPay'){
                $getprevTransFTP = $query->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
              	if($getprevTransFTP != 0){
                    $merchantTransactionIdFTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransFTP[0]['txn_id'])+1);
                }else{
                    $merchantTransactionIdFTP = 'KINGFISH100000';
                }
                $descFTP = str_replace("'", "\'", "Order id.: ".$order_id."'s order placed with franchise to pay");
                $transsArrFTP = array("date_time"=>$tdate,"user_type"=>'users',"user_id"=>$user_id,"amount"=>'0',"balance"=>$wallet_balance,"type"=>"Manual","details"=>$descFTP,"txn_id"=>$merchantTransactionIdFTP);
  	            $insert_transactionFTP = $query->insertData('transactions',$transsArrFTP);
            }
            
            if($dimensions_in =='CM')
            {
                $dimensions_in = 'cm';
            }
            elseif($dimensions_in =='IN')
            {
                $dimensions_in = 'inch';
            }
            for($i=0;$i<count($qty);$i++)
            {
                $cong_box = array("order_id"=>$order_id,"qty"=>floatval($qty[$i]),"length"=>floatval($length[$i]),"width"=>floatval($width[$i]),"height"=>floatval($height[$i]),"dimention"=>$dimensions_in);
                $insert_box_details =  $query->insertData('box_details',$cong_box);
            }
            
            for($k=0;$k<count($n_value);$k++)
            {
                $cong_invoice = array("order_id"=>$order_id,"ewaybill"=>$ewaybill[$k],"n_value"=>floatval($n_value[$k]),"inv_no"=>$inv[$k]);
                $insert_invoice_details =  $query->insertData('invoice_details',$cong_invoice);
            }
            
            if($create_order && $insert_consignee_details && $insert_box_details && $insert_invoice_details){
                if(empty($job_id)){
                    echo'<script>alert("Order successfully created!!");window.location="create_order";</script>';
                }else{
                    header("location:action?get_manifest_job_id=$job_id&order_id=$order_id&cft_type=$cft_type");
                }
            }else{
                echo'<script>alert("Something went wrong! Contact with administrator.");window.location="create_order";</script>';
            }
        }
    endif;
    
    
// get manifest
    if(isset($_GET['get_manifest_job_id']) && isset($_GET['order_id']) && isset($_GET['cft_type'])){
        extract($_GET);
        $job_id = $get_manifest_job_id;
        
        $get_3pl = $query->getData("*","3pls","",array("api_token_name"=>$cft_type),"","","1")[0];
        
        $cftregistered_name = $get_3pl['registered_name'];
        $cfttoken = $get_3pl['api_token'];
        $cftpassword = $get_3pl['password'];
        
        $loginF = array(
                "username" => $cftregistered_name,
                "password" => $cftpassword
            );
        $li = curl_init();
        curl_setopt($li, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
        curl_setopt($li, CURLOPT_POSTFIELDS, json_encode($loginF));
        curl_setopt($li, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($li, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($li, CURLOPT_SSL_VERIFYHOST, false);  
        curl_setopt($li, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($li, CURLOPT_TIMEOUT, 400);
        curl_setopt($li, CURLOPT_HTTPHEADER, array(
          "accept: application/json",
          "cache-control: no-cache",
          "content-type: application/json"
        ));
        $response_login = curl_exec($li);
        $error_login = curl_error($li);
        curl_close($li);
        if($error_login){
          echo $error_login;
        }
        else{
            $jwt_tokn = json_decode($response_login)->jwt;
            $cb = curl_init();
            curl_setopt($cb, CURLOPT_URL, "https://btob.api.delhivery.com/v3/manifest?job_id=$job_id");
            curl_setopt($cb, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cb, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cb, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($cb, CURLOPT_CONNECTTIMEOUT ,0); 
            curl_setopt($cb, CURLOPT_TIMEOUT, 400);
            curl_setopt($cb, CURLOPT_HTTPHEADER, array(
              "Authorization: Bearer $jwt_tokn",
              "accept: application/json",
              "cache-control: no-cache",
              "content-type: application/json"
            ));
            $responses = curl_exec($cb);
            $errors = curl_error($cb);
            curl_close($cb);
            if($errors){
              echo $errors;
            }
            else{
                $responseArray = json_decode($responses, true);
                $statusType = $responseArray['status']['type'];
                $success = $responseArray['status']['success'];
                if($statusType == "Complete" || $statusType == "Processing"){
                    if($success == 1){
                        if(!empty($responseArray['status']['value']['lrnum']) && !empty($responseArray['status']['value']['doc_waybill']) && !empty($responseArray['status']['value']['master_waybill'])){
                            $lrnum = $responseArray['status']['value']['lrnum'];
                            $docWaybill = $responseArray['status']['value']['doc_waybill'];
                            $masterWaybill = $responseArray['status']['value']['master_waybill'];
                            $waybills = $responseArray['status']['value']['waybills'];
                            foreach($waybills as $awb){
                                $waybill_string = $waybill_string.'|'.$awb['ident'];
                            }
                            $cond_ord = array("status"=>$statusType,"lr"=>$lrnum,"waybills"=>trim($waybill_string,'|'),"master_waybill"=>$masterWaybill,"doc_waybill"=>$docWaybill);
                            $update_recent_order = $query->updateData('orders',$cond_ord,'order_id',$order_id);
                            if($update_recent_order){
                                $mobiles = $query->getData("`phone`","consignee_details","",array("order_id"=>$order_id),"id","DESC","1")[0]['phone'];
                                $date = date("Y-m-d");
                                $waybillUrl = "kingfishlogistics.in/$lrnum";
                                $data = http_build_query(["user"=>"KNGFSH","password"=>"1aa5e65fb6XX","senderid"=>"KNGFSH","entityid"=>"1701171966722308074","tempid"=>"1707172000632294769","mobiles"=>"$mobiles","sms"=>"Shipment No: $lrnum (Kingfish Logistics) has been booked on $date LR Copy $waybillUrl Track your Shipment @ www.Kingfishlogistics.in"]);
                                $template = file_get_contents("http://inbox.bulksmswale.in/sendsms.jsp?$data");
                                echo '<script>alert("Order successfully created!!");window.location="create_order";</script>';
                            }else{
                                echo '<script>alert("An error occured! Contact with administrator.");window.location="create_order";</script>';
                            }
                        }else{
                            echo '<script>alert("Order successfully created! But, LR has not generated! It will update within 5-6 minutes.");window.location="create_order";</script>';
                        }
                    }else{
                        if($statusType == "Processing"){
                            echo '<script>alert("Order successfully created! But, LR has not generated! It will update within 5-6 minutes.");window.location="create_order";</script>';
                        }else{
                            echo '<script>alert("There is an error on the order! Try another one");window.location="create_order";</script>';
                        }
                    }
                }else{
                    echo '<script>alert("Order not created due to an error!!");window.location="create_order";</script>';
                }
            }
        }
    }
    
    
// create self drop
if(isset($_POST['create_selfdrop'])){
    
    extract($_POST);
    // print_r($_POST);exit;
    if(empty($order_id)){
        echo "<script>alert('LR not found to Self drop');window.location = 'all_orders';</script>";
    }
    else{
        $total_order_id = count($order_id);
        $selfdrop_date = date('d-m-Y');
        for($i=0; $i<$total_order_id; $i++){
            $cond_ords = array("selfdrop"=>"Y","selfdrop_date"=>$selfdrop_date);
            $update_order = $query->updateData('orders',$cond_ords,'order_id',$order_id[$i]);
            if($update_order){
                echo'<script>alert("Selfdrop created Successfully");window.location = "all_orders";</script>';
            }
        }
    }
    
}
    
    
// generate shipping label
if(isset($_POST['throwOrderLabel'])){
    extract($_POST);
    $throwOrderLabel = $newfunc->real_string(trim($throwOrderLabel, " "));
    $getorder = $query->getData('*','orders','',array('lr'=>$throwOrderLabel),'id','DESC','1')[0];
    if(!empty($getorder['generate_labels'])){
        $labels = explode(',',$getorder['generate_labels']);
        $sls = 1;
        $countData = count($labels);
        foreach($labels as $file){
            $showlabels = $showlabels.'<div class="row mb-3">
                                      <div class="col-md-8 d-flex justify-content-center"><h5>';
            if($countData == $sls){
                $showlabels = $showlabels.'Documents';
            }else{
                $showlabels = $showlabels.'Box '.$sls.' label';
            }
            $showlabels = $showlabels.' label : </h5></div>
                          <div class="col-md-4"><a download href="../shippingLabels/'.$file.'" class="btn btn-sm me-1 shadow dwn-btn">Download <i class="bi bi-download"></i></a></div>
                         </div>';
            $sls++;
        }
        echo $showlabels;
    }else{
        $loginFields = array(
            "username" => "KINGFISH10B2BC",
            "password" => "Jaishreeshyam@2025"
        );
        $cs = curl_init();
        curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
        curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
        curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($cs, CURLOPT_CONNECTTIMEOUT ,0); 
            curl_setopt($cs, CURLOPT_TIMEOUT, 400);
        curl_setopt($cs, CURLOPT_HTTPHEADER, array(
          "accept: application/json",
          "cache-control: no-cache",
          "content-type: application/json"
        ));
        $response = curl_exec($cs);
        $error = curl_error($cs);
        curl_close($cs);
        if($error){
          echo $error;
        }
        else{
            $resp = json_decode($response);
            $jwt = $resp->jwt;
            $cf = curl_init();
            curl_setopt($cf, CURLOPT_URL, "https://btob.api.delhivery.com/v3/get-label-urls/a4/$throwOrderLabel?document=true");
            curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);  
                curl_setopt($cf, CURLOPT_CONNECTTIMEOUT ,0); 
                curl_setopt($cf, CURLOPT_TIMEOUT, 400);
            curl_setopt($cf, CURLOPT_HTTPHEADER, array(
              "Authorization: Bearer $jwt",
              "accept: application/json",
              "cache-control: no-cache",
              "content-type: application/json",
              "conection: keep-alive"
            ));
            $lblresponse = curl_exec($cf);
            $lblerror = curl_error($cf);
            curl_close($cf);
            if($lblerror){
              echo $lblerror;
            }
            else{
                $result = json_decode($lblresponse);
                if($result->success == 1 && !empty($result->data)){
                    $sl = 1;
                    $labelsArr = '';
                    $lblUrl = '';
                    $countData = count($result->data);
                    foreach($result->data as $labels){
                        $pdf_base64 = file_get_contents($labels);
                        $uri = substr($pdf_base64,strpos($pdf_base64,",")+1);
                        $lbl = $throwOrderLabel."-".time()."label".$sl.".png";
                        file_put_contents('../shippingLabels/'.$lbl, base64_decode($uri));
                        $labelsArr = $labelsArr.'<div class="row mb-3">
                                      <div class="col-md-8 d-flex justify-content-center"><h5>';
                        if($countData == $sl){
                            $labelsArr = $labelsArr.'Documents';
                        }else{
                            $labelsArr = $labelsArr.'Box '.$sl.' label';
                        }
                        $labelsArr = $labelsArr.' label : </h5></div>
                                      <div class="col-md-4"><a download href="../shippingLabels/'.$lbl.'" class="btn btn-sm me-1 shadow dwn-btn">Download <i class="bi bi-download"></i></a></div>
                                     </div>';
                        $lblUrl = $lblUrl.",".$lbl;
                        $sl++;
                    }
                    $upd = $query->updateData('orders',array('generate_labels'=>trim($lblUrl,",")),'lr',$throwOrderLabel);
                    if($upd){
                        echo $labelsArr;
                    }
                }else{
                    echo 0;
                }
            }
        }
    }
}
    
    
// submit invoice Generation
if(isset($_POST['orderInvoice'])){
    extract($_POST);
    $cndr = array("lr"=>$lr);
    $getOrd = $query->getData("*","orders","",$cndr,"","","");
    $ord_id = $getOrd[0]['id'];
    if($ord_id != 0){
        $_SESSION['invoice_order_id'] = $ord_id;
        echo '<script type="text/javascript" language="javascript">
                window.location = "../invoice/index";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "all_orders";
              </script>';
    }
}


// get city and center
function getCenterandCity($pin,$cftregistered_name,$cftpassword){
        $loginFields = array(
            "username" => $cftregistered_name,
            "password" => $cftpassword
        );
        $ct = curl_init();
        curl_setopt($ct, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
        curl_setopt($ct, CURLOPT_POSTFIELDS, json_encode($loginFields));
        curl_setopt($ct, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ct, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ct, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($ct, CURLOPT_CONNECTTIMEOUT ,0); 
            curl_setopt($ct, CURLOPT_TIMEOUT, 400);
        curl_setopt($ct, CURLOPT_HTTPHEADER, array(
           "accept: application/json",
           "cache-control: no-cache",
           "content-type: application/json"
        ));
        $responselog = curl_exec($ct);
        $errorlog = curl_error($ct);
        curl_close($ct);
        if($errorlog){
            echo $errorlog;
        }else{
            $jwt = json_decode($responselog)->jwt;
            $ca = curl_init();
            curl_setopt($ca, CURLOPT_URL, "https://ltl-serviceability.delhivery.com/serviceability/$pin/details/?pincode=$pin");
            curl_setopt($ca, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ca, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer $jwt",
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"
            ));
            $responsePin = curl_exec($ca);
            $errorPin = curl_error($ca);
            curl_close($ca);
            if($errorPin){
                echo $errorPin;
            }else{
                return json_decode($responsePin)->data[0]->center."--".json_decode($responsePin)->data[0]->city;
            }
        }
    }


// Checking reference number
if(isset($_POST['ref_no']) && isset($_POST['type'])  && isset($_POST['type_id'])){
    $ref_no = $_POST['ref_no'];
    $type = $_POST['type'];
    $type_id = $_POST['type_id'];
    $check_order_details = $query->getData('*','orders','',array('subident'=>$ref_no),'','','');
    if($check_order_details > 0){
        echo 'EXIST';
    }else{
        $check_ref_details = $query->getData('*','reference_number_allotment','',array('user_type'=>$type,'type_id'=>$type_id),'','','');
        if($check_ref_details != 0){
            $found = false;
            foreach($check_ref_details as $ref_details){
                $start_allotment_no = $ref_details['start_allotment_no'];
                $end_allotment_no = $ref_details['end_allotment_no'];
                if($ref_no >=$start_allotment_no && $ref_no<=$end_allotment_no){
                    echo 'REFOK';
                    $found = true;
                    break;
                }
            }
            if(!$found){
                echo 'RNT';
            }
        }else{
            echo 'NOROWS'; 
        }
    }
}

?>