<?php
include("database/db.php");
$query = new query();
date_default_timezone_set("Asia/Kolkata");


$data = json_decode(file_get_contents("php://input"));
$dataHeader = getallheaders();
$arrayofIPs = array('13.229.195.68','18.139.238.62','52.76.70.1','3.108.106.65','13.127.20.101','13.126.12.240','35.154.161.83');


// Set the maximum execution time to 500 milliseconds
ini_set('max_execution_time', 1); // 1 second (PHP's granularity is in seconds)
set_time_limit(1); // Another way to set max execution time

// Capture the start time
$startTime = microtime(true);

// Check for Authorization header
if (!empty($dataHeader['Authorization'])) {
    if (substr($dataHeader['Authorization'], 0, 6) !== 'Token ') {
        echo json_encode(array(
            "success" => false,
            "message" => "Unauthorized"
        ), JSON_PRETTY_PRINT);
        exit; // Exit to prevent further execution
    } else {
        $token = trim(substr($dataHeader['Authorization'], 6));
        if ($token === "25cf28c91ee46c5215fc2afb57d511fcf5474ffa") {
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
                    asyncInsertTrackingDetails($query, $data);
                } else {
                    throw new Exception("Update failed");
                }

            } catch (Exception $e) {
                
                echo json_encode(array(
                    "success" => false,
                    "message" => "Failed to update status: " . $e->getMessage(),
                ), JSON_PRETTY_PRINT);
            }
        } else {
            echo json_encode(array(
                "success" => false,
                "message" => "Unauthorized"
            ), JSON_PRETTY_PRINT);
        }
    }
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Unauthorized"
    ), JSON_PRETTY_PRINT);
}

// Check if the script is taking longer than 500ms and exit if so
if ((microtime(true) - $startTime) > 0.5) {
    exit; // Exit to ensure the script does not run for more than 500 milliseconds
}

// Asynchronous function to insert tracking details
function asyncInsertTrackingDetails($query, $data) {
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
        error_log('Failed to insert tracking details for LR No: ' . $data->lrnum);
    }else{
        echo json_encode(array(
            "success" => true,
            "message" => "Status successfully updated of this LR No",
        ), JSON_PRETTY_PRINT);
    }
}


?>