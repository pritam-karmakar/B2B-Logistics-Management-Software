<?php
session_start();
include("../database/db.php");
include("../functions/all-functions.php");
include("../functions/api-Functions.php");
include("../functions/freight-Calculation-Functions.php");
$query = new query();
$newfunc = new allfunctions();
$freightQuery = new freightCalculationFunctions();
date_default_timezone_set("Asia/Kolkata");
if(isset($_SESSION['ltl_admin_id']) && !empty($_SESSION['ltl_admin_id']) && isset($_SESSION['ltl_admin_username']) && !empty($_SESSION['ltl_admin_username'])){
    $ltl_admin_id = $_SESSION['ltl_admin_id'];
    $getdetails = $query->getData("*","admin_login","",array("id"=>$ltl_admin_id),"","","");
}else{
    return false;
}

// origin pincode checking for freight calculator
if(!empty($_POST['OriginPincodeChecking'])){
    $return = apiFunctions::pincodeServiceAbility($_POST['OriginPincodeChecking'], '8CFT');
    if($return != 0){
        echo json_decode($return)->data[0]->city;
    }else{
        echo 0;
    }
}


// destination pincode checking for freight calculator
if(!empty($_POST['DestinationPincodeChecking'])){
    $return = apiFunctions::pincodeServiceAbilityWithOda($_POST['DestinationPincodeChecking'], '8CFT');
    if($return != 0){
        echo json_encode(array(json_decode($return[0])->data[0]->city,$return[1]));
    }else{
        echo 0;
    }
}


// freight calculation for user
if(isset($_POST['freight-calculation'])){
    extract($_POST);
    $goFor = ($userType == "users")? 'UsersFreightCalculation' : 'BranchesFreightCalculation';
    $calculation = $freightQuery->$goFor($UsersorBranches,$OriginPincode,$DestinationPincode,$cftType,$paymentMode,$totalWeight,$dimention,$invoiceAmount,$insurance,$pickupType,$qty,$length,$width,$height);
    echo ($calculation == false)? false : json_encode($calculation);
}