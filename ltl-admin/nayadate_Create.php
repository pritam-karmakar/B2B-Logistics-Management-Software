<?php
include("../database/db.php");
$query = new query();
date_default_timezone_set("Asia/Kolkata");

// $getlr = $query->getData('*','warehouses','','','id','DESC','');
// foreach($getlr as $alllr){
//     $created_date = date_format(date_create($alllr['created_date']), "Y-m-d");
//     $query->updateData('warehouses',array("created_date"=>$created_date),'id',$alllr['id']);
// }


$getlr = $query->getData('*','orders','',[array('pickup_date','IS',NULL),array('order_date','=','2024-07-02')],'id','DESC','');
foreach($getlr as $alllr){
    
    $created_date = date_format(date_create($alllr['created_date']), "Y-m-d");
    $query->updateData('warehouses',array("created_date"=>$created_date),'id',$alllr['id']);
}