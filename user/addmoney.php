<?php
session_start();
include("../database/db.php");
include("../functions/all-functions.php");
include("../functions/api-Functions.php");
$newfunc = new allfunctions();
$query = new query();
date_default_timezone_set("Asia/Kolkata");


// add money phonepay
if(isset($_POST['add_money']))
{
    $id = $_POST['type_id'];
    $amount = $_POST['amount'];
    $merchantId = 'M22KM0TKG3MDW';
    // $merchantId = "PGTESTPAYUAT148";
    $apiKey="89ba7c48-8e3a-475c-b420-2aebda80d6c8"; //live key
    // $apiKey = "046d9f63-bf3b-4b74-9b8e-93121160573e"; //Test Key
    $order_id = uniqid(); 
    
    
    function merchantTransactionId($query){
        $merchantTransactionId = rand(100000000000,999999999999);
        $txnIdQuery = $query->getData("*","gateways_addmoney","",array('gateway_txn_id'=>$merchantTransactionId),"id","DESC","1");
        if($txnIdQuery != 0){
            merchantTransactionId($query);
        }else{
            return $merchantTransactionId;
        }
    }
    $merchantTransactionId = merchantTransactionId($query);
    $header = base64_encode(json_encode(array('alg'=>'HS256','type'=>'JWT')));
    $payload = base64_encode(json_encode(array('addToDoId'=>$id,'setAmount'=>$amount,'txnId'=>$merchantTransactionId,'redirect'=>$_SERVER['HTTP_REFERER'])));
    $jwt = $header.".".$payload.".".base64_encode(hash_hmac('SHA256', $header.$payload, '89ba7c48-8e3a-475c-b420-2aebda80d6c8'));
    $redirectUrl = 'https://kingfishlogistics.in/b2b/user/addmoney?jwtForPayment='.$jwt;
     
    // $test_url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay"; //test url
    $live_url = "https://api.phonepe.com/apis/hermes/pg/v1/pay"; //live key
    $name=$_POST['name'];
    $email=$_POST['email'];
    $mobile= $_POST['mobile'];
    $description = 'Payment for add money';
    
     
    $paymentData = array(
        'merchantId' => $merchantId,
        'merchantTransactionId' => $merchantTransactionId, 
        "merchantUserId"=>"MUID123",
        'amount' => $amount*100,
        'redirectUrl'=>$redirectUrl,
        'redirectMode'=>"POST",
        'callbackUrl'=>"https://kingfishlogistics.in",
        "merchantOrderId"=>$order_id,
        "mobileNumber"=>$mobile,
        "message"=>$description,
        "email"=>$email,
        "shortName"=>$name,
        "paymentInstrument"=> array(    
        "type"=> "PAY_PAGE",
      )
    );
 
 
    $jsonencode = json_encode($paymentData);
    $payloadMain = base64_encode($jsonencode);
    $salt_index = 1; //key index 1
    $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
    $sha256 = hash("sha256", $payload);
    $final_x_header = $sha256 . '###' . $salt_index;
    $request = json_encode(array('request'=>$payloadMain));
                
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => $live_url, //test-liveurl
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $request,
      CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
         "X-VERIFY: " . $final_x_header,
         "accept: application/json"
      ],
    ]);
 
    $response = curl_exec($curl);
    $err = curl_error($curl);
     
    curl_close($curl);
     
    if ($err) 
    {
      echo "cURL Error #:" . $err;
    } 
    else 
    {
      $res = json_decode($response);
     
        if(isset($res->success) && $res->success=='1')
        {
            $paymentCode=$res->code;
            $paymentMsg=$res->message;
            $payUrl=$res->data->instrumentResponse->redirectInfo->url;
             
            header('Location:'.$payUrl);
        }else{
            echo "<script type='text/javascript' language='javascript'>alert('Not able to add money right now! Try again later sometime!');window.location.href='add_money';</script>";
        }
    }
}


// add money response
elseif(isset($_GET['jwtForPayment'])){
    $jwt = explode('.', $_GET['jwtForPayment']);
    $details = json_decode(base64_decode($jwt[1]), true);
    $id = $details['addToDoId'];
    $amnt = $details['setAmount'];
    $txn_id = $details['txnId'];
    if(base64_encode(hash_hmac('SHA256', $jwt[0].$jwt[1], '89ba7c48-8e3a-475c-b420-2aebda80d6c8')) == $jwt[2]){
        $redirect = $details['redirect'];
        $get_user_details = $query->getData("*","users","",array("id"=>$id),"","","");
        $_SESSION['username'] = $get_user_details[0]['username'];
        $_SESSION['user_id'] = $get_user_details[0]['id'];
        
        $merchantId = "M22KM0TKG3MDW";
        $apiKey = "89ba7c48-8e3a-475c-b420-2aebda80d6c8";
        $merchantTransactionId = $txn_id;
        $paymentData = array(
            'merchantId' => $merchantId,
            'merchantTransactionId' => $merchantTransactionId
        );
        
        $salt_index = 1; //key index 1
        $payload = "/pg/v1/status/$merchantId/$merchantTransactionId" . $apiKey;
        $sha256 = hash("sha256", $payload);
        $final_x_header = $sha256 . '###' . $salt_index;
                    
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/status/$merchantId/$merchantTransactionId", //test-liveurl
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-VERIFY: " . $final_x_header,
                "X-MERCHANT-ID: " . $merchantId,
                "accept: application/json"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err){
            $query->insertData('gateways_error_transactions',array('user_type'=>'users','type_id'=>$id,'amount'=>$amnt,'transaction_id'=>$txn_id,'date_time'=>date('Y-m-d H:i:s'),'gateway'=>'Phone Pe'));
            $newfunc->alertRedirect("Something went wrong! Contact with administrator!", $redirect);
        }else{
            $res = json_decode($response);
            if($res->code == "PAYMENT_SUCCESS" && $res->data->state == "COMPLETED"){
                $txnIdQuery = $query->getData("*","gateways_addmoney","",array('gateway_txn_id'=>$txn_id),"id","DESC","1");
                if($txnIdQuery == 0){
                    $type = "users";
                    $get_user_details = $query->getData("*",$type,"",array("id"=>$id),"","","");
                  	if($get_user_details){
                      	$new_bal = floatval($get_user_details[0]['wallet_balance'] + $amnt);
                      	$date = date('Y-m-d H:i:s');
                        $getTxnId = $query->getData('*','transactions','',array("txn_id_type"=>"Serial"),'id','DESC','1');
                      	if($getTxnId != 0){
                            $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getTxnId[0]['txn_id'])+1);
                        }else{
                            $merchantTransactionId = 'KINGFISH100000';
                        }
                  		$conditionArr = array("date_time"=>$date,"user_type"=>$type,"user_id"=>$id,"amount"=>$amnt,"balance"=>$new_bal,"type"=>"Online","details"=>"Money added via Phonepay","txn_id"=>$merchantTransactionId,'status'=>'Credit');
                      	if($query->insertData('transactions',$conditionArr)){
                            $cond_w= array("wallet_balance"=>$new_bal);
                            if($up_wall = $query->updateData($type,$cond_w,'id',$id)){
                                $insertGatewayaddmDetails = $query->insertData("gateways_addmoney",array("date_time"=>$date,"user_type"=>$type,"user_id"=>$id,"amount"=>$amnt,"gateway"=>"Phone Pe","gateway_txn_id"=>$txn_id,"txn_id"=>$merchantTransactionId));
                                if($insertGatewayaddmDetails){
                            	    $outstanding = $query->getData("*","outstanding_report","",array("user_type"=>$type,"type_id"=>$id,"status"=>"Not Clear"),"","","1");
                                    if($outstanding != 0):
                                        $haveClearPrice = $outstanding[0]['outstanding_price'] - $outstanding[0]['cleared_price'];
                                        if($haveClearPrice > $amnt):
                                            $clearPrice = $amnt;
                                            $clearStatus = "Not Clear";
                                        elseif($haveClearPrice <= $amnt):
                                            $clearPrice = $outstanding[0]['outstanding_price'];
                                            $clearStatus = "Cleared";
                                        endif;
                                        $updOurStand = $query->updateData("outstanding_report",array("cleared_price"=>$clearPrice,"clear_date"=>date("Y-m-d"),"status"=>$clearStatus),"id",$outstanding[0]['id']);
                                        if(!$updOurStand):
                                            $newfunc->alertRedirect("Something went wrong! Please Contact with administrator", $redirect);
                                        endif;
                                    endif;
                              	    header('location:'.$redirect.'?done');
                                }else{
                                    $query->insertData('gateways_error_transactions',array('user_type'=>'users','type_id'=>$id,'amount'=>$amnt,'transaction_id'=>$txn_id,'date_time'=>date('Y-m-d H:i:s'),'gateway'=>'Phone Pe'));
                                    echo '<script type="text/javascript" language="javascript">alert("An error occured! Contact with administrator");window.location.href="'.$redirect.'";</script>';
                                }
                          	}else{
                                $query->insertData('gateways_error_transactions',array('user_type'=>'users','type_id'=>$id,'amount'=>$amnt,'transaction_id'=>$txn_id,'date_time'=>date('Y-m-d H:i:s'),'gateway'=>'Phone Pe'));
                                echo '<script type="text/javascript" language="javascript">alert("An error occured! Contact with administrator");window.location.href="'.$redirect.'";</script>';
                            }
                        }else{
                            $query->insertData('gateways_error_transactions',array('user_type'=>'users','type_id'=>$id,'amount'=>$amnt,'transaction_id'=>$txn_id,'date_time'=>date('Y-m-d H:i:s'),'gateway'=>'Phone Pe'));
                            echo '<script type="text/javascript" language="javascript">alert("An error occured! Contact with administrator");window.location.href="'.$redirect.'";</script>';
                        }
                    }else{
                        $query->insertData('gateways_error_transactions',array('user_type'=>'users','type_id'=>$id,'amount'=>$amnt,'transaction_id'=>$txn_id,'date_time'=>date('Y-m-d H:i:s'),'gateway'=>'Phone Pe'));
                        echo '<script type="text/javascript" language="javascript">alert("An error occured! Contact with administrator");window.location.href="'.$redirect.'";</script>';
                    }
                }else{
                    $query->insertData('gateways_error_transactions',array('user_type'=>'users','type_id'=>$id,'amount'=>$amnt,'transaction_id'=>$txn_id,'date_time'=>date('Y-m-d H:i:s'),'gateway'=>'Phone Pe'));
                    echo '<script type="text/javascript" language="javascript">alert("Invalid Transaction Id!");window.location.href="'.$redirect.'";</script>';
                }
            }else{
                $query->insertData('gateways_error_transactions',array('user_type'=>'users','type_id'=>$id,'amount'=>$amnt,'transaction_id'=>$txn_id,'date_time'=>date('Y-m-d H:i:s'),'gateway'=>'Phone Pe'));
                $newfunc->alertRedirect("Payment Failed!", $redirect);
            }
        }
    }else{
        $query->insertData('gateways_error_transactions',array('user_type'=>'users','type_id'=>$id,'amount'=>$amnt,'transaction_id'=>$txn_id,'date_time'=>date('Y-m-d H:i:s'),'gateway'=>'Phone Pe'));
        echo '<script type="text/javascript" language="javascript">alert("Invalid Payment Details!");window.location.href="'.$redirect.'";</script>';
    }
}
elseif(isset($_POST['add_money_gateway'])){
    
}
else{
    header("location:https://b2b.kingfishlogistics.in/user/");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Add Money Redirecting - B2B User || Kingfish Logistics</title>
    
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://kingfishlogistics.in/images/logo/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" /> 
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/tagify/tagify.css" />
    <!-- Page CSS -->
    
    <!--Time Picker-->
    <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/pickr/pickr-themes.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <!--Bootstrap Icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    <link rel="stylesheet" href="menu/newStyle.css">
    <div class="d-flex justify-content-center align-items-center main-loader" style="position: fixed; top: 50%; left: 50%; z-index: 9999; transform: translate(-50%, -50%); flex-direction: column;">
        <div class="loader">
            <div class="ball-spin-fade-loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="p-3 pb-0 mt-5"><h5><?php if(isset($_POST['add_money_gateway'])){ ?>You are being redirected to payment page ...<?php }elseif(isset($_GET['jwtForPayment'])){ ?>You payment is processing ...<?php } ?></h5></div>
    </div>
    
    <form action="addmoney" method="POST"><input type="text" hidden name="type_id" value="<?= $_POST['type_id'] ?>"><input type="text" hidden name="amount" value="<?= $_POST['amount'] ?>"><input type="text" hidden name="name" value="<?= $_POST['name'] ?>"><input type="text" hidden name="mobile" value="<?= $_POST['mobile'] ?>"><input type="text" hidden name="email" value="<?= $_POST['email'] ?>"><button type="submit" hidden name="add_money"></button></form>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="../assets/js/forms-selects.js"></script>
    <script src="../assets/js/forms-tagify.js"></script>
  
    <script src="../assets/vendor/libs/moment/moment.js"></script>
    <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="../assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
    <script src="../assets/vendor/libs/pickr/pickr.js"></script>
    <script src="../assets/js/forms-pickers.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    <script src="menu/newjQuery.js"></script>
    <?php if(isset($_POST['add_money_gateway'])){ ?>
        <script>
            $(document).ready(function(){
                setTimeout(function(){
                    $('button[name=add_money]').click();
                }, 2000);
            });
        </script>
    <?php } ?>