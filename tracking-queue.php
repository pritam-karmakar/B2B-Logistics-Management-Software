<?php
include("database/db.php");
$query = new query();
date_default_timezone_set("Asia/Kolkata");


$tempOrderTrackings = $query->getData("*","order_tracking_details_temporary","",array("status"=>"not done"),"","","");
if($tempOrderTrackings != 0):
    foreach($tempOrderTrackings as $details):
        $data = json_decode($details['response']);
        
        $updArr['status'] = $data->Status;
        
        // Optimize database query
        $getOrderData = $query->getData('*', 'orders', '', array('lr' => $data->lrnum), 'id', 'DESC', '1');
        
        if ($getOrderData !== 0) {
            if (strtolower($data->shipment_remark) == "shipment picked up" && empty($getOrderData[0]['pickup_date'])) {
                $updArr['pickup_date'] = str_replace("T", " ", substr($data->timestamp, 0, -7));
            }
            if (strtolower($data->Status) == "delivered" && empty($getOrderData[0]['delivered_date'])) {
                $updArr['delivered_date'] = str_replace("T", " ", substr($data->timestamp, 0, -7));
            }
        }
        
        try {
            
            // Update orders
            $updateResult = $query->updateData('orders', $updArr, 'lr', $data->lrnum);
            
            if ($updateResult) {
                // Insert tracking details asynchronously
                asyncInsertTrackingDetails($query, $data, $details['id']);
            } else {
                throw new Exception("Update failed");
                file_put_contents("tracking-error.log", "Failed to update due to an error: for id : ". $details['id'] ." on ".date("Y-m-d H:i:s")."\n", FILE_APPEND);
            }
        
        } catch (Exception $e) {
            
            echo json_encode(array(
                "success" => false,
                "message" => "Failed to update status: " . $e->getMessage(),
            ), JSON_PRETTY_PRINT);
            
            file_put_contents("tracking-error.log", "Tracking details not inserted due to Error: " . $e->getMessage() . " for id : ". $details['id'] ." on ".date("Y-m-d H:i:s")."\n", FILE_APPEND);
            
        }
    endforeach;
else:
    echo "No Details Found !";
endif;

// Asynchronous function to insert tracking details
function asyncInsertTrackingDetails($query, $data, $detailsId) {
    // This function should run the insert operation in a background job
    // Here, we will just simulate it with a delayed operation
    $insQuery = $query->insertData('order_tracking_details', array(
        'lr' => $data->lrnum,
        'status' => $data->Status,
        'scan_remark' => $data->shipment_remark,
        'date_time' => str_replace("T", " ", substr($data->timestamp, 0, -7)),
        'location' => $data->location
    ));

    if (!$insQuery) {
        // Log the failure for further inspection
        file_put_contents("tracking-error.log", "Failed to insert tracking details for LR No: " . $data->lrnum . " for id : ". $detailsId ." on ".date("Y-m-d H:i:s")."\n", FILE_APPEND);
    }else{
        $permanentTrackingDone = $query->updateData("order_tracking_details_temporary",array("status"=>"done"),"id",$detailsId);
        if($permanentTrackingDone){
            echo json_encode(array(
                "success" => true,
                "message" => "Status successfully updated of this LR No",
            ), JSON_PRETTY_PRINT);
        }else{
            file_put_contents("tracking-error.log", "Failed to update temporary tracking details for LR No: " . $data->lrnum . " for id : ". $detailsId ." on ".date("Y-m-d H:i:s")."\n", FILE_APPEND);
        }
        
    }
}


?>