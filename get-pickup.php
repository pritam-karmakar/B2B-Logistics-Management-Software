<?php
    include("database/db.php");
    include("functions/api-Functions.php");
    $query = new query();
    date_default_timezone_set("Asia/Kolkata");
    
    
    $pickupLrs = $query->getData("*","orders","",[array("status","!=","Manifested"),array("status","!=","Complete"),array("status","!=","Created"),array("status","!=","Not Picked"),array("status","!=","NOT_PICKED"),array("pickup_date","IS","NULL","OR","pickup_date","=",""),array("status","!=","Manifested"),array("status","!=","Complete"),array("status","!=","Created"),array("status","!=","Not Picked"),array("status","!=","NOT_PICKED","OR","pickup_date","=","0000-00-00 00:00:00"),array("status","!=","Manifested"),array("status","!=","Complete"),array("status","!=","Created"),array("status","!=","Not Picked"),array("status","!=","NOT_PICKED")],"id","DESC","");
    if($pickupLrs != 0):
        foreach($pickupLrs as $pickupLr):
            if(!empty($pickupLr['lr'])):
                $Tracking = apiFunctions::Tracking($pickupLr['lr']);
                if($Tracking != 0):
                    if(strtolower(json_decode($Tracking, true)['message']) == "unauthorized"):
                        $jwtToken = apiFunctions::jwtToken($pickupLr['cft_type']);
                        if($jwtToken != 0):
                            $Tracking = apiFunctions::Tracking($pickupLr['lr']);
                        else:
                            echo 0;
                        endif;
                    endif;
                endif;
                if($Tracking != 0 || strtolower(json_decode($Tracking, true)['message']) == "unauthorized"):
                    $pickup_date = str_replace("T", " ", json_decode($Tracking)->data->wbns[0]->pickup_date);
                    $expected_delivery_date = str_replace("T", " ", json_decode($Tracking)->data->wbns[0]->promised_delivery_date);
                    if(!empty($pickup_date)){
                        $updArr['pickup_date'] = $pickup_date;
                    }
                    if(!empty($expected_delivery_date)){
                        $updArr['expected_delivery_date'] = $expected_delivery_date;
                    }
                    if(!empty($updArr)){
                        echo $query->updateData('orders',$updArr,'lr',$pickupLr['lr']);
                    }
                endif;
            endif;
        endforeach;
    else:
        echo "No LR found to pickup";
    endif;
    
    
    // $pickupLrs = $query->getData("*","orders","","","id","DESC","");
    // foreach($pickupLrs as $pickuplr):
    //     $status = ucwords(strtolower(str_replace("_", " ", $pickuplr['status'])));
    //     echo $query->updateData('orders',array("status"=>$status),'lr',$pickuplr['lr']);
    // endforeach;