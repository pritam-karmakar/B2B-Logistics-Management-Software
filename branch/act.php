<?php
session_start();
$branch_id = $_SESSION['branchuser_id'];
include("../database/db.php");
include("../functions/all-functions.php");
$query = new query();
$newfunc = new allfunctions();
date_default_timezone_set("Asia/Kolkata");
$getBranchDetails = $query->getData("*","branches","",array("id"=>$branch_id),"id","DESC","1")[0];


// create pickup request
if(isset($_POST['createPickupRequest'])){
    extract($_POST);
    foreach($_POST as $arrkey => $arrval){
        $requestArr[$arrkey] = $newfunc->real_string(trim($arrval, " "));
    }
    unset($requestArr['createPickupRequest']);
    $getwarehouse = $query->getData("*","warehouses","",array("id"=>$requestArr['pickup_location']),"id","DESC","1")[0];
    
    $cond = array("id"=>$requestArr['cft']);
    $get_3pl = $query->getData("*","3pls","",$cond,"","","")[0];
    
    $cftregistered_name = $get_3pl['registered_name'];
    $cfttoken = $get_3pl['api_token'];
    $cftpassword = $get_3pl['password'];
    
    $loginFields = array(
        "username" => $cftregistered_name,
        "password" => $cftpassword
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
        echo'<script>alert("System can\'t not create order right now! Please! try again later.");window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
    }
    else{
        // echo $responselg; exit();
        $jwt = json_decode($responselg)->jwt;
        if(!empty($jwt)){
            $loginF = array(
                "pickup_location" => $getwarehouse['warehouse_name'],
                "expected_package_count" => intval($requestArr['expected_package_count']),
                "pickup_date" => $requestArr['pickup_date'],
                "pickup_time" => $requestArr['pickup_time']
            );
            // echo "<pre>"; print_r($loginF);
            // echo $jwt;
            // exit();
            $cf = curl_init();
            curl_setopt($cf, CURLOPT_URL, "https://track.delhivery.com/fm/request/new/");
            curl_setopt($cf, CURLOPT_POSTFIELDS, json_encode($loginF));
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
            else{
                // echo $response; exit();
                $result = json_decode($response);
                if(!empty($result->pickup_id) && !empty($result->incoming_center_name)){
                    $requestArr['type'] = "branches";
                    $requestArr['type_id'] = $branch_id;
                    $requestArr['cft_id'] = $requestArr['cft'];
                    $requestArr['pickup_id'] = $result->pickup_id;
                    $requestArr['incoming_center_name'] = $result->incoming_center_name;
                    unset($requestArr['cft']);
                    $inspickup_request = $query->insertData("pickup_request",$requestArr);
                    if($inspickup_request){
                        echo "<script type='text/javascript' language='javascript'>
                                alert('You are successfully requested to pickup');
                                window.location = 'pickup_request';
                              </script>";
                    }else{
                        echo "<script type='text/javascript' language='javascript'>
                                alert('You are successfully requested to pickup. But there are something error! Please contact with administrator immediately');
                                window.location = 'pickup_request';
                              </script>";
                    }
                }else{
                    if($result->success == false && $result->pr_exist == true && !empty($result->error)){
                        echo "<script type='text/javascript' language='javascript'>
                                alert('This warehouse has a pickup request for this date and time');
                                window.location = 'pickup_request';
                              </script>";
                    }else{
                        echo "<script type='text/javascript' language='javascript'>
                                alert('Sorry We can't take your request right now! Please! try again later');
                                window.location = 'pickup_request';
                              </script>";
                    }
                }
            }
        }else{
            echo'<script>alert("System can\'t not create order right now! Please! try again later.");window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
        }
    }
}


// cancel api
if(isset($_POST['cancelWaybillno'])){
    extract($_POST);
    $cancelWaybillno = $newfunc->real_string(trim($cancelWaybillno, " "));
    $loginFields = array(
                    "username" => "KINGFISH10B2BC",
                    "password" => "Jaishreeshyam@2025"
                );
    $cs = curl_init();
    curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
    curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
    curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
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
        $loginF = array(
                "waybill" => $cancelWaybillno,
                "cancellation" => true
            );
        $cf = curl_init();
        curl_setopt($cf, CURLOPT_URL, "https://track.delhivery.com/api/p/edit");
        curl_setopt($cf, CURLOPT_POSTFIELDS, json_encode($loginF));
        curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
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
        else{
            echo $response;
        }
    }
}


if(isset($_POST['bsd'])){
    
    $pdf_base64 = file_get_contents("https://ltl-clients-api.delhivery.com/label/print/a4/28363510007114?box_index=1&h=e4db20715999ec31202cdacf7935dc193024895b4e7dfe1d47a41ffd8868fee8&ts=1711735862129&o=1");
    $data = $pdf_base64;

    $uri = substr($data,strpos($data,",")+1);

    file_put_contents('sbdsajhekdl.png', base64_decode($uri));
}


// create bulk orders
if(isset($_POST['uploadBulkSubmit']) && !empty($_POST['warehouse']) && !empty($_FILES['upload_order_file']['name'])){
    extract($_POST);
    $ext = pathinfo($_FILES['upload_order_file']['name'],PATHINFO_EXTENSION);
    if($ext == 'xlsx' || $ext == 'csv'){
		require('../ltl-admin/excelReader/excel_reader2.php');
        require('../ltl-admin/excelReader/SpreadsheetReader.php');
        
        $upl = "bulkorder".time().".".$ext;
        $uio = "../dyfiles/bulkorders/" . $upl;
        move_uploaded_file($_FILES['upload_order_file']['tmp_name'], $uio);
        
        $obj = new SpreadsheetReader($uio);
        $sl = 1;
        foreach($obj as $sheet){
            if($sl != 1){
                $weight = $sheet[14];
                $check_branch_details = $query->getData("*","branches","",array("id"=>$branch_id),"","","");
                $wallet_balance = $check_branch_details[0]['wallet_balance'];
                
                $get_pick_details = $query->getData("*","warehouses","","",array("id"=>$warehouse),"","","");
                $warehouse_id = $get_pick_details[0]['id'];
                $pickup_location = $get_pick_details[0]['warehouse_name'];
                $r_address =  $get_pick_details[0]['r_address'];
                $r_pin =  $get_pick_details[0]['r_pin'];
                $r_city =  $get_pick_details[0]['r_city'];
                $phone_number = $get_pick_details[0]['phone_number'];
                
                if($get_pick_details[0]['cft'] != "all"){
                    $cft_id = $get_pick_details[0]['cft'];
                }else{
                    $get_cft = $query->getData("*","3pls","",array("api_token_name"=>$cft_type),"","","")[0];
                    $cft_id = $get_cft['id'];
                }
                $get_3pl = $query->getData("*","3pls","",array("id"=>$cft_id),"","","")[0];
                
                $registered_name = $get_3pl['registered_name'];
                $password = $get_3pl['password'];
                
                $getstate1 = $query->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$get_pick_details[0]['pincode']),"","","1")[0];
                $getstate2 = $query->getData("`pincodes`.*,`states`.`zone_id`,`zones`.`zone`","pincodes",array("0"=>array("LEFT","states","states","id","pincodes","state_id"),array("LEFT","zones","zones","id","states","zone_id")),array("pincode"=>$sheet[4]),"","","1")[0];
                $frightZone = $getstate1['zone']."_to_".$getstate2['zone'];
                
                $get_branch_details = $check_branch_details[0];
                
                if($get_branch_details['branch_charge'] == "yes"){
                    $fright = $query->getData('*','branches_fright_master','',array('branch_id'=>$branch_id),'id','DESC','1')[0];
                }else{
                    $fright = $query->getData('*','default_fright_master','',array('id'=>'1'),'id','DESC','1')[0];
                }
                
                $valuematricWeight = (($length*$width*$height)/27000)*str_replace("CFT", "", $get_3pl['api_token_name'])*$sheet[10];
                if($get_branch_details['freight_type'] == 'Weight'){
                    if($valuematricWeight < $weight){
                        $frightCharge = floatval($fright[$frightZone]*$weight);
                    }else{
                        $frightCharge = floatval($fright[$frightZone]*$valuematricWeight);
                        $weight = $valuematricWeight;
                    }
                }elseif($get_branch_details['freight_type'] == 'Quantity'){
                    if($valuematricWeight > $weight){
                        $weight = $valuematricWeight;
                    }
                    $frightCharge = floatval($fright[$frightZone]*$sheet[10]);
                }
                $pin = $get_pick_details[0]['pincode'];
                $del_pin = $sheet[4];
                $description = $sheet[15];
                
                $awb_charge = $get_branch_details['awb_charge'];
                if($sheet[22] == "No"){
                    $fob_surcharge = $get_branch_details['fob_surcharge_minimum'];
                }elseif($sheet[22] == "Yes"){
                    $fob_surcharge = floatval($sheet[18]*($get_branch_details['fob_surcharge_percentage']/100),2);
                }
                if($get_branch_details['fuel_surcharge_type'] == "Fixed"){
                    $fuel_surcharge = floatval($get_branch_details['fuel_surcharge']);
                }elseif($get_branch_details['fuel_surcharge_type'] == "Percentage"){
                    $fuel_surcharge = floatval($frightCharge*($get_branch_details['fuel_surcharge']/100));
                }
                if($get_branch_details['handeling_charge_type'] == "Quantity"){
                    $handeling_charge = floatval($handeling_charge*$sheet[10]);
                }elseif($get_branch_details['handeling_charge_type'] == "Kg"){
                    $handeling_charge = floatval($handeling_charge*$weight);
                }
                if($get_branch_details['damage_surcharge_type'] == "Quantity"){
                    $new_damage_surcharge = floatval($get_branch_details['damage_surcharge']*$sheet[10]);
                    if($get_branch_details['damage_surcharge_min'] < $new_damage_surcharge){
                        $damage_surcharge = $new_damage_surcharge;
                    }else{
                        $damage_surcharge = $get_branch_details['damage_surcharge_min'];
                    }
                }elseif($get_branch_details['damage_surcharge_type'] == "Kg"){
                    $new_damage_surcharge = floatval($get_branch_details['damage_surcharge']*$weight);
                    if($get_branch_details['damage_surcharge_min'] < $new_damage_surcharge){
                        $damage_surcharge = $new_damage_surcharge;
                    }else{
                        $damage_surcharge = $get_branch_details['damage_surcharge_min'];
                    }
                }
                if($get_branch_details['oda_surcharge_type'] == "Quantity"){
                    $new_oda_surcharge = floatval($get_branch_details['oda_surcharge']*$sheet[10]);
                    if($get_branch_details['oda_surcharge_min'] < $new_oda_surcharge){
                        $oda_surcharge = $new_oda_surcharge;
                    }else{
                        $oda_surcharge = $get_branch_details['oda_surcharge_min'];
                    }
                }elseif($get_branch_details['oda_surcharge_type'] == "Kg"){
                    $new_oda_surcharge = floatval($get_branch_details['oda_surcharge']*$weight);
                    if($get_branch_details['oda_surcharge_min'] < $new_oda_surcharge){
                        $oda_surcharge = $new_oda_surcharge;
                    }else{
                        $oda_surcharge = $get_branch_details['oda_surcharge_min'];
                    }
                }
                if($get_branch_details['packaging_surcharge_type'] == "Quantity"){
                    $packaging_surcharge = floatval($packaging_surcharge*$sheet[10]);
                }elseif($get_branch_details['packaging_surcharge_type'] == "Kg"){
                    $packaging_surcharge = floatval($packaging_surcharge*$weight);
                }
                if($get_branch_details['special_delivery_or_appointment_charge_type'] == "Fixed"){
                    $new_special_delivery_charge = floatval($get_branch_details['special_delivery_or_appointment_charge']);
                    if($get_branch_details['special_delivery_or_appointment_charge_min'] < $new_special_delivery_charge){
                        $special_delivery_charge = $new_special_delivery_charge;
                    }else{
                        $special_delivery_charge = $get_branch_details['special_delivery_or_appointment_charge_min'];
                    }
                }elseif($get_branch_details['special_delivery_or_appointment_charge_type'] == "Percentage"){
                    $new_special_delivery_charge = floatval($frightCharge*($get_branch_details['special_delivery_or_appointment_charge']/100));
                    if($get_branch_details['special_delivery_or_appointment_charge_min'] < $new_special_delivery_charge){
                        $special_delivery_charge = $new_special_delivery_charge;
                    }else{
                        $special_delivery_charge = $get_branch_details['special_delivery_or_appointment_charge_min'];
                    }
                }
                if($get_branch_details['pickup_charge_type'] == "Quantity"){
                    $pickup_charge = floatval($get_branch_details['pickup_charge']*$sheet[10]);
                }elseif($get_branch_details['pickup_charge_type'] == "Kg"){
                    $pickup_charge = floatval($get_branch_details['pickup_charge']*$weight);
                }
                if($get_branch_details['cartage_charge_type'] == "Quantity"){
                    $cartage_charge = floatval($get_branch_details['cartage_charge']*$sheet[10]);
                }elseif($get_branch_details['cartage_charge_type'] == "Kg"){
                    $cartage_charge = floatval($get_branch_details['cartage_charge']*$weight);
                }
                $cod_amnt = 0;
                $cod_charge = 0;
                $payment_mode = $sheet[16];
                if($payment_mode == "C"){
                    $payment_mode = "CoD";
                    $payment_type="CoD";
                    $cod_amnt = round(($sheet[17]),2);
                    if($get_branch_details['cod_charge_type'] == "Fixed"){
                        $new_cod_charge = $get_branch_details['cod_charge_type'];
                        if($get_branch_details['cod_charge_min'] < $new_cod_charge){
                            $cod_charge = $new_cod_charge;
                        }else{
                            $cod_charge = $get_branch_details['cod_charge_min'];
                        }
                    }elseif($get_branch_details['cod_charge_type'] == "Percentage"){
                        $new_cod_charge = $frightCharge*($get_branch_details['cod_charge_type']/100);
                        if($get_branch_details['cod_charge_min'] < $new_cod_charge){
                            $cod_charge = $new_cod_charge;
                        }else{
                            $cod_charge = $get_branch_details['cod_charge_min'];
                        }
                    }
                }elseif($payment_mode == "P"){
                    $payment_mode = "Prepaid";
                    $payment_type = "Prepaid";
                }elseif($payment_mode == "T"){
                    $payment_mode = "To-Pay";
                    $payment_type = "Prepaid";
                }elseif($payment_mode == "F"){
                    $payment_mode = "Franchise-ToPay";
                    $payment_type = "Prepaid";
                }
                else{
                    if($sheet[16] == "P" || $sheet[16] == "C" || $sheet[16] == "T" || $sheet[16] == "F"){
                        echo'<script type="text/javascript" language="javascript">
                               alert("Sorry!! '.($sl-2).' orders has created. But rest of the orders not created due to invalid sign of payment mode.");
                               window.location="bulk_orders";
                             </script>';
                    }
                    $payment_type = "Prepaid";
                }
                $before_gst_total_charge = ($frightCharge+$awb_charge+$fob_surcharge+$handeling_charge+$damage_surcharge+$oda_surcharge+$packaging_surcharge+$special_delivery_charge+$cartage_charge+$pickup_charge+$cod_charge);
                
                $getGSTCharges = $query->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];
                if($get_branch_details['igst'] == "not"){
                    $gst_charge = round((floatval($before_gst_total_charge*($getGSTCharges['sgst']/100))+floatval($frightCharge*($getGSTCharges['cgst']/100))),2);
                }elseif($get_branch_details['igst'] == "yes"){
                    $gst_charge = round(floatval($before_gst_total_charge*($getGSTCharges['igst']/100)),2);
                }
                $total_charge = ($before_gst_total_charge+$gst_charge);
                $order_done = 1;
                if($payment_mode == "Prepaid" || $payment_mode == "CoD"){
                    if($total_charge > $wallet_balance){
                        $order_done = 0;
                    }
                }
                if($order_done == 0 || $order_done == 10){
                    if($sl == 2){
                        echo'<script type="text/javascript" language="javascript">
                               alert("Sorry!! Order not created due to unsufficient balance.");
                               window.location="add_money";
                             </script>';
                    }else{
                        echo'<script type="text/javascript" language="javascript">
                               alert("Sorry!! '.($sl-2).' orders has created. But rest of the orders not created due to unsufficient balance.");
                               window.location="add_money";
                             </script>';
                    }
                }else{
                    $count_suborders = 1;
                    
                    $subident = "KING".rand(100000,999999);
                    $rov_insurance = ($sheet[22] === 'Yes') ? True : False;
                    
                    $loginFields = array(
                            "username" => $registered_name,
                            "password" => $password
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
                        echo '<script type="text/javascript" language="javascript">
                                 alert("Sorry!! '.($sl-2).' orders has created. But rest of the orders, system can\'t create order right now. Please! try again later.");
                                 window.location = "bulk_orders";
                              </script>';
                    }else{
                        $lr = $sheet[0];
                        if(empty($lr)){
                            $ltype = "Automatic";
                        }else{
                            $ltype = "Manual";
                        }
                        $jwt = json_decode($response)->jwt;
                        if(!empty($jwt)){
                            $fields = array(
                                  "ident" => $lr,
                                  "pickup_location" => $pickup_location,
                                  "dropoff_location" => array(
                                    "consignee" => $sheet[2],
                                    "address" => $sheet[3],
                                    "city" => $sheet[5],
                                    "state" => $sheet[6],
                                    "zip" => $sheet[4],
                                    "phone" => $sheet[7]
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
                                "weight"=> round(($sheet[14]*1000),2),
                                "invoices" => [
                                    array(
                                         "ident" => $sheet[19],
                                         "n_value" => floatval($sheet[20]),
                                         "ewaybill" => $sheet[21]
                                    )
                                ],
                                "suborders" => [
                                    array(
                                        "ident" => $sheet[18],
                                        "count" => intval($sheet[10]),
                                        "description" => $sheet[15],
                                        "master" => false
                                    )
                                ],
                                "dimensions" =>  [
                                    array(
                                        "length" => floatval($sheet[11]),
                                        "width" => floatval($sheet[12]),
                                        "height" => floatval($sheet[13]),
                                        "count" => intval($sheet[10])
                                    )
                                ]
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
                                echo '<script type="text/javascript" language="javascript">
                                         alert("Sorry!! '.($sl-2).' orders has created. But rest of the orders, system can\'t create order right now. Please! try again later.");
                                         window.location = "bulk_orders";
                                      </script>';
                            }
                            else{
                                $response_arr =  json_decode($response_j);
                                if(isset($response_arr->job_id) && !empty($response_arr->job_id))
                                {
                                    $job_id = $response_arr->job_id;
                                    $getOrderid = $query->getData('*','orders','','','id','DESC','1');
                                    
                                  	if($getOrderid != 0){
                                        $order_id = "ORD".(str_replace("ORD","",$getOrderid[0]['order_id'])+1);
                                    }else{
                                        $order_id = 'ORD100000000';
                                    }
                                    $order_date = date('Y-m-d');
                                    $order_time = date('h:i:sa');
                                    $orderArr = array("user_type"=>"branches","type_id"=>$branch_id,"order_id"=>$order_id,"order_date"=>$order_date,"order_time"=>$order_time,"warehouse_id"=>$warehouse_id,"pick_pin"=>$pin,"del_pin"=>$del_pin,"weight"=>$sheet[14],"payment_mode"=>$payment_mode,"cod_amount"=>$cod_amnt,"profit_amount"=>$profit_amount,"invoice_amount"=>floatval($sheet[20]),"insurance"=>$sheet[22],"ltype"=>$ltype,"lr"=>$lr,"description"=>$description,"job_id"=>$job_id,"cod_charge"=>$cod_charge,"fuel_surcharge"=>$fuel_surcharge,"awb_charge"=>$awb_charge,"fob_surcharge"=>$fob_surcharge,"handeling_charge"=>$handeling_charge,"damage_surcharge"=>$damage_surcharge,"cartage_charge"=>$cartage_charge,"oda_surcharge"=>$oda_surcharge,"packaging_surcharge"=>$packaging_surcharge,"special_delivery_charge"=>$special_delivery_charge,"gst_charge"=>$gst_charge,"weight_charge"=>$frightCharge,"total_charge"=>$total_charge,"channel"=>"Delhivery","pick_up_point"=>$pick_up_point,"consignee_gst_tin"=>$sheet[9],"status"=>"Created","cft_type"=>$get_pick_details[0]['api_token_name']);
                                    
                                    $create_order = $query->insertData('orders',$orderArr);
                                    
                                    $cong_arr = array("order_id"=>$order_id,"company"=>$sheet[1],"name"=>$sheet[2],"phone"=>$sheet[7],"email"=>$sheet[8],"address"=>$sheet[3],"city"=>$sheet[5],"state"=>$sheet[6]);
                                    $insert_consignee_details =  $query->insertData('consignee_details',$cong_arr);
                                    $cong_box = array("order_id"=>$order_id,"qty"=>floatval($sheet[10]),"length"=>floatval($sheet[11]),"width"=>floatval($sheet[12]),"height"=>floatval($sheet[13]));
                                    $insert_box_details =  $query->insertData('box_details',$cong_box);
                                    $cong_invoice = array("order_id"=>$order_id,"ewaybill"=>$sheet[19],"n_value"=>floatval($sheet[20]),"inv_no"=>$sheet[21]);
                                    $insert_invoice_details =  $query->insertData('invoice_details',$cong_invoice);
                                    
                                    $new_bal = round(($wallet_balance - $total_charge),2);
                      	            $tdate = date('Y-m-d H:i:s');
                      	            
                                    if($payment_mode == "CoD" || $payment_mode == "Prepaid"){
                                        $getprevTrans = $query->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                                      	if($getprevTrans != 0){
                                            $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
                                        }else{
                                            $merchantTransactionId = 'KINGFISH100000';
                                        }
                                        
                      		            $transsArr = array("date_time"=>$tdate,"user_type"=>"branches","user_id"=>$branch_id,"amount"=>$total_charge,"balance"=>$new_bal,"type"=>"Online","details"=>"New Order place","txn_id"=>$merchantTransactionId);
                          	            $insert_transaction = $query->insertData('transactions',$transsArr);
                                        if($insert_transaction)
                                        {
                                            $cond_uw = array("wallet_balance"=>$new_bal);
                                            $up_wall = $query->updateData('branches',$cond_uw,'id',$branch_id);
                                            if($up_wall){
                                                if($order_done == 10){
                                                    $getprevCRTrans = $query->getData('*','credit_transactions','','','id','DESC','1');
                                                  	if($getprevCRTrans != 0){
                                                        $CRmerchantTransactionId = "KNGCRE".(str_replace("KNGCRE","",$getprevCRTrans[0]['txn_id'])+1);
                                                    }else{
                                                        $CRmerchantTransactionId = 'KNGCRE100000';
                                                    }
                                                    $transsArr = array("date_time"=>$tdate,"user_type"=>"branches","user_id"=>$branch_id,"amount"=>$creditUse,"balance"=>$new_bal,"type"=>"Online","details"=>str_replace("'", "\'", "Order id.:".$order_id."'s order placed"),"txn_id"=>$CRmerchantTransactionId);
                                      	            $insert_transaction2 = $query->insertData('credit_transactions',$transsArr);
                                      	        }
                                            }else{
                                                echo '<script type="text/javascript" language="javascript">
                                                        alert("Something went wrong! Please contact with administrator");
                                                        window.location = "all_orders";
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
                                        $descTP = str_replace("'", "\'", "Order id.: ".$order_id." order placed with to pay");
                                        $transsArrTP = array("date_time"=>$tdate,"user_type"=>'branches',"user_id"=>$branch_id,"amount"=>'0',"balance"=>$wallet_balance,"type"=>"Manual","details"=>$descTP,"txn_id"=>$merchantTransactionIdTP);
                          	            $insert_transactionTP = $query->insertData('transactions',$transsArrTP);
                          	            if($insert_transactionTP){
                                            $query->updateData('branches',array('to_pay_due'=>floatval($total_charge+$get_branch_details['to_pay_due'])),'id',$branch_id);
                          	            }
                                    }elseif($payment_mode=='Franchise-ToPay'){
                                        $getprevTransFTP = $query->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                                      	if($getprevTransFTP != 0){
                                            $merchantTransactionIdFTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransFTP[0]['txn_id'])+1);
                                        }else{
                                            $merchantTransactionIdFTP = 'KINGFISH100000';
                                        }
                                        $descFTP = str_replace("'", "\'", "Order id.: ".$order_id." order placed with franchise to pay");
                                        $transsArrFTP = array("date_time"=>$tdate,"user_type"=>'branches',"user_id"=>$branch_id,"amount"=>'0',"balance"=>$wallet_balance,"type"=>"Manual","details"=>$descFTP,"txn_id"=>$merchantTransactionIdFTP);
                          	            $insert_transactionFTP = $query->insertData('transactions',$transsArrFTP);
                          	            if($insert_transactionFTP){
                                            $query->updateData('branches',array('franchise_topay_due'=>floatval($total_charge+$get_branch_details['franchise_topay_due'])),'id',$branch_id);
                          	            }
                                    }
                                    
                                    if($create_order && $insert_consignee_details && $up_wall && $insert_box_details && $insert_invoice_details)
                                    {
                                        $jobIdArr[] = array($job_id,$order_id);
                                    }
                                }else{
                                    echo '<script type="text/javascript" language="javascript">
                                             alert("Sorry!! '.($sl-2).' orders has created. But rest of the orders, system can\'t create order right now. Please! try again later.");
                                             window.location = "bulk_orders";
                                          </script>';
                                }
                            }
                        }else{
                            echo'<script type="text/javascript" language="javascript">
                               alert("Sorry!! '.($sl-2).' orders has created. But rest of the orders not created due to unsufficient balance.");
                               window.location="add_money";
                             </script>';
                        }
                    }
                }
            }
            $sl++;
        }
        sleep(30);
        $get_3pl = $query->getData("*","3pls","",array("id"=>$query->getData("`warehouses`.*,`3pls`.`api_token_name`","warehouses",array("0"=>array("LEFT","3pls","3pls","id","warehouses","cft")),array("id"=>$warehouse),"","","")[0]['cft']),"","","")[0];
        
        $registered_name = $get_3pl['registered_name'];
        $password = $get_3pl['password'];
        foreach($jobIdArr as $job_id){
            $loginF = array(
                    "username" => $registered_name,
                    "password" => $password
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
                $jobId = $job_id[0];
                $re_lo= json_decode($response_login);
                $jwt_tokn = $re_lo->jwt;
                $cb = curl_init();
                curl_setopt($cb, CURLOPT_URL, "https://btob.api.delhivery.com/v3/manifest?job_id=$jobId");
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
                    $responses;
                    $responseArray = json_decode($responses, true);
    
                    $statusType = $responseArray['status']['type'];
                    $success = $responseArray['status']['success'];
                    $jobId = $responseArray['status']['job_id'];
                    $lrnum = $responseArray['status']['value']['lrnum'];
                    $docWaybill = $responseArray['status']['value']['doc_waybill'];
                    $masterWaybill = $responseArray['status']['value']['master_waybill'];
                    $waybillsIdent = $responseArray['status']['value']['waybills'][0]['ident'];
                    
                    $cond_ord = array("status"=>$statusType,"job_id"=>$jobId,"lr"=>$lrnum,"waybills"=>$waybillsIdent,"master_waybill"=>$masterWaybill,"doc_waybill"=>"$docWaybill");
                    $update_recent_order = $query->updateData('orders',$cond_ord,'order_id',$job_id[1]);
                }
            }
        }
    	echo '<script type="text/javascript" language="javascript">
        		alert("You have successfully uploaded all orders");
                window.location = "bulk_orders";
        	  </script>';
	}else{
		echo '<script type="text/javascript" language="javascript">
        		alert("Invalid file format");
                window.location = "bulk_orders";
        	  </script>';
	}
}


// get POD
if(!empty($_POST['lrPOD'])){
    extract($_POST);
    
    $get_3pl = $query->getData("`orders`.`cft_type`,`3pls`.*","3pls",array("0"=>array("LEFT","orders","3pls","api_token_name","orders","cft_type")),array("orders`.`lr"=>$lrPOD),"orders`.`id","DESC","1")[0];
    
    $registered_name = $get_3pl['registered_name'];
    $token = $get_3pl['api_token'];
    $password = $get_3pl['password'];
    $loginFields = array(
            "username" => $registered_name,
            "password" => $password
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
    $response = curl_exec($ct);
    $error = curl_error($ct);
    curl_close($ct);
    if($error){
      echo $error;
    }
    else{
        $jwt = json_decode($response)->jwt;
        $cf = curl_init();
        curl_setopt($cf, CURLOPT_URL, "https://btob.api.delhivery.com/v3/document/$lrPOD?doc_type=LM_POD");
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
        $response_pod = curl_exec($cf);
        $error_pod = curl_error($cf);
        curl_close($cf);
        if($error_pod){
          echo $error_pod;
        }
        else{
            if(!empty(json_decode($response_pod)->data)){
                echo json_decode($response_pod)->data[0];
            }else{
                echo 0;
            }
        }
    }
}
?>