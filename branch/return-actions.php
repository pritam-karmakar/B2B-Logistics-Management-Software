<?php
session_start();
include("../database/db2.php");
include("../functions/all-functions.php");
include("../functions/api-Functions.php");
include("../functions/freight-Calculation-Functions.php");
if(!empty($_SESSION['branchusername']) && !empty($_SESSION['branchuser_id'])){
    $username = $_SESSION['branchusername'];
    $user_id = $_SESSION['branchuser_id'];
}else{
    header("location:index");
}
$newfunc = new allfunctions();
$query = new query();
$freightQuery = new freightCalculationFunctions();
date_default_timezone_set("Asia/Kolkata");
$getUserDetails = $query->getData('*','branches','',array('id'=>$user_id),'id','DESC','1')[0];


// origin pincode checking for freight calculator
if(!empty($_POST['OriginPincodeChecking'])){
    $cft = ($getUserDetails['threepl'] == 'all')? '6CFT' : $getUserDetails['threepl'];
    $return = apiFunctions::pincodeServiceAbility($_POST['OriginPincodeChecking'],$cft);
    if($return != 0){
        echo json_decode($return)->data[0]->city;
    }else{
        echo 0;
    }
}


// destination pincode checking for freight calculator
if(!empty($_POST['DestinationPincodeChecking'])){
    $cft = ($getUserDetails['threepl'] == 'all')? '6CFT' : $getUserDetails['threepl'];
    $return = apiFunctions::pincodeServiceAbilityWithOda($_POST['DestinationPincodeChecking'],$cft);
    if($return != 0){
        echo json_encode(array(json_decode($return[0])->data[0]->city,$return[1]));
    }else{
        echo 0;
    }
}


// freight calculation for user
if(isset($_POST['freight-calculation'])){
    extract($_POST);
    $calculation = $freightQuery->BranchesFreightCalculation($user_id,$OriginPincode,$DestinationPincode,$cftType,$paymentMode,$totalWeight,$dimention,$invoiceAmount,$insurance,$pickupType,$qty,$length,$width,$height);
    echo ($calculation == false)? false : json_encode($calculation);
}