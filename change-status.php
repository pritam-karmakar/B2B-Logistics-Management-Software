<?php
include("database/db.php");
$query = new query();
date_default_timezone_set("Asia/Kolkata");

$firstdata = file_get_contents("php://input");
$data = json_decode($firstdata);
$dataHeader = getallheaders();
$arrayofIPs = array('13.229.195.68','18.139.238.62','52.76.70.1','3.108.106.65','13.127.20.101','13.126.12.240','35.154.161.83');


try{
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
            exit;
        } else {
            $token = trim(substr($dataHeader['Authorization'], 6));
            if ($token === "25cf28c91ee46c5215fc2afb57d511fcf5474ffa") {
                // exec("php async_insert_tracking.php > /dev/null 2>&1 &");
                asyncInsertTrackingDetails($query, $firstdata);
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
        file_put_contents("tracking-error.log", "Tracking details not inserted due to Error: " . $e->getMessage() . " and it takes more than 500ms on ".date("Y-m-d H:i:s")."\n", FILE_APPEND);
        exit;
    }
}catch (Exception $e) {
    file_put_contents("tracking-error.log", "Tracking details not inserted due to Error: " . $e->getMessage() . " on ".date("Y-m-d H:i:s")."\n", FILE_APPEND);
}

// Asynchronous function to insert tracking details
function asyncInsertTrackingDetails($query, $firstdata) {
    // This function should run the insert operation in a background job
    // Here, we will just simulate it with a delayed operation
    $insQuery = $query->insertData('order_tracking_details_temporary', array(
        'response' => $firstdata,
        'date_time' => date("Y-m-d H:i:s")
    ));

    if (!$insQuery) {
        file_put_contents("tracking-error.log", "Tracking details not inserted ".$data." on ".date("Y-m-d H:i:s")."\n", FILE_APPEND);
    }else{
        echo json_encode(array(
            "success" => true,
            "message" => "Status successfully updated of this LR No",
        ), JSON_PRETTY_PRINT);
    }
}
