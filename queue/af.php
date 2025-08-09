<?php


$times = []; // Collect times for each request
for($i = 1; $i <= 1000; $i++){
    // Capture the start time
    $startTime = microtime(true);
    $loginFields = [
        "shipment_remark" => "Shipment Received at Facility",
        "location" => "Moga_HardevNagar_I (Punjab)",
        "count" => 5,
        "lrnum" => "261677768",
        "mwn" => "28363510062694",
        "name" => "DEEPAK MOGA",
        "package_type" => "Pre-paid",
        "promised_delivery_date" => "2024-06-11T23:59:59",
        "expected_delivery_date" => "2024-06-11T23:59:59",
        "timestamp" => "2024-06-13T02:54:18.687000",
        "Status" => "Pending"
    ];
    
    // Start time measurement
    $start_time = microtime(true);
    
    $cs = curl_init();
    curl_setopt($cs, CURLOPT_URL, "https://projects.casfus.com/kingfishlogistics.in/b2b/change-status.php");
    curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
    curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false);  
    curl_setopt($cs, CURLOPT_CONNECTTIMEOUT, 0); 
    curl_setopt($cs, CURLOPT_TIMEOUT, 400); // Increase this if needed
    curl_setopt($cs, CURLOPT_HTTPHEADER, array(
        "Authorization: Token 25cf28c91ee46c5215fc2afb57d511fcf5474ffa",
        "accept: application/json",
        "cache-control: no-cache",
        "content-type: application/json"
    ));
    
    $responselg = curl_exec($cs);
    $errorlg = curl_error($cs);
    
    // End time measurement
    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    
    curl_close($cs);
    
    if ($errorlg) {
        echo $errorlg;
    } else {
        echo $responselg;
    }
    
    // Check if the execution time is more than 60 seconds (1 minute)
    if ($execution_time > 60) {
        echo "Warning: The request took longer than expected. It took " . round($execution_time, 2) . " seconds.";
    } else {
        echo "The request completed in " . round($execution_time, 2) . " seconds.";
    }
    // Your processing code here
    usleep(5000); // Example delay
    
    $endTime = microtime(true);
    $times[] = $endTime - $startTime;
    
}


sort($times);
$p99Index = ceil(0.99 * count($times)) - 1;
$p99Time = $times[$p99Index];
file_put_contents("response-times.log", "P99: " . $p99Time . " seconds\n", FILE_APPEND);
