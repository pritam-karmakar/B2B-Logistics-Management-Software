<?php
session_start();
include("../database/db.php");
include("../functions/all-functions.php");
include("../functions/api-Functions.php");
include("../functions/freight-Calculation-Functions.php");
if(!empty($_SESSION['username']) && !empty($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    return false;
}
$query = new query();
$newfunc = new allfunctions();
$freightQuery = new freightCalculationFunctions();
date_default_timezone_set("Asia/Kolkata");
$getUserDetails = $query->getData('*','users','',array('id'=>$user_id),'id','DESC','1')[0];
$userThreePl = $query->getData("*","3pls","",array('id'=>$getUserDetails['threepl']),"","","")[0]['api_token_name'];


// origin pincode checking for freight calculator
if(!empty($_POST['OriginPincodeChecking'])){
    $cft = ($getUserDetails['threepl'] == 'all')? '8CFT' : $userThreePl;
    $return = apiFunctions::pincodeServiceAbility($_POST['OriginPincodeChecking'], $cft);
    if($return != 0){
        echo json_decode($return)->data[0]->city;
    }else{
        echo 0;
    }
}


// destination pincode checking for freight calculator
if(!empty($_POST['DestinationPincodeChecking'])){
    $cft = ($getUserDetails['threepl'] == 'all')? '8CFT' : $userThreePl;
    $return = apiFunctions::pincodeServiceAbilityWithOda($_POST['DestinationPincodeChecking'], $cft);
    if($return != 0){
        echo json_encode(array(json_decode($return[0])->data[0]->city,$return[1]));
    }else{
        echo 0;
    }
}


// freight calculation for user
if(isset($_POST['freight-calculation'])){
    extract($_POST);
    $calculation = $freightQuery->UsersFreightCalculation($user_id,$OriginPincode,$DestinationPincode,$cftType,$paymentMode,$totalWeight,$dimention,$invoiceAmount,$insurance,$pickupType,$qty,$length,$width,$height);
    echo ($calculation == false)? false : json_encode($calculation);
}