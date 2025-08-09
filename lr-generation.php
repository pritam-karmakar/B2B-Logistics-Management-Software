<?php
    include("database/db.php");
    include("functions/api-Functions.php");
    $query = new query();
    date_default_timezone_set("Asia/Kolkata");
    
    
    $zeroLrs = $query->getData("*","orders","",array("order_date"=>date('Y-m-d'),"lr"=>""),"id","DESC","");
    if($zeroLrs != 0){
        foreach($zeroLrs as $zerolr){
            $generateLR = apiFunctions::generateLR($zerolr['job_id']);
            if($generateLR != 1){
                if(strtolower($generateLR['message']) == "unauthorized"){
                    $jwtToken = apiFunctions::jwtToken($zerolr['cft_type']);
                    if($jwtToken != 0){
                        echo apiFunctions::generateLR($zerolr['job_id']);
                    }else{
                        echo 0;
                    }
                }else{
                    echo 0;
                }
            }else{
                echo 1;
            }
        }
    }else{
        echo "No LR Found";
    }
