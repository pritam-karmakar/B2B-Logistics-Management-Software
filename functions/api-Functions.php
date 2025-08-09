<?php
class apiFunctions extends query{
    
    
    // Generate token Start
    public static function jwtToken($cftType){
        $nQuery = new query();
        $get3pls = $nQuery->getData("*","3pls","",array("api_token_name"=>$cftType),"id","DESC","1")[0];
        $jwtValidation = apiFunctions::pincodeServiceAbility($nQuery->getData("*","pincodes","","","RAND()","","1")[0]['pincode'],$cftType, true);
        if(strtolower(json_decode($jwtValidation)->message) == "unauthorised"){
            $loginFields = array(
                "username" => $get3pls['registered_name'],
                "password" => $get3pls['password']
            );
            $cs = curl_init();
            curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
            curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
            curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($cs, CURLOPT_CONNECTTIMEOUT ,0); 
            curl_setopt($cs, CURLOPT_TIMEOUT, 400);
            curl_setopt($cs, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"
            ));
            $responselg = curl_exec($cs);
            $errorlg = curl_error($cs);
            curl_close($cs);
            if($errorlg){
                return 0;
            }else{
                $jwtToken = json_decode($responselg)->jwt;
                if(empty($jwtToken)){
                    if($_SESSION[$cftType.'_tokenCount'] <= 3){
                        $_SESSION[$cftType.'_tokenCount'] = $_SESSION[$cftType.'_tokenCount']+1;
                        apiFunctions::jwtToken($cftType);
                    }else{
                        return 0;
                    }
                }else{
                    $insCFTQuery = $nQuery->updateData('3pls',array('jwt'=>$jwtToken,'jwt_creation_date'=>date('Y-m-d H:i:s')),'api_token_name',$cftType);
                    if($insCFTQuery){
                        unset($_SESSION[$cftType.'_tokenCount']);
                        return $jwtToken;
                    }else{
                        return 0;
                    }
                }
            }
        }else{
            return $get3pls['jwt'];
        }
    }
    // Generate token End
    
    
    // Pincode serviceability Start
    public static function pincodeServiceAbility($pincode, $cftType, $jwtValid = null){
        $nQuery = new query();
        if($jwtValid == true){
            $jwt = $nQuery->getData("*","3pls","",array("api_token_name"=>$cftType),"id","DESC","1")[0]['jwt'];
        }else{
            $jwt = apiFunctions::jwtToken($cftType);
        }
        $cf = curl_init();
        curl_setopt($cf, CURLOPT_URL, "https://ltl-serviceability.delhivery.com/serviceability/$pincode/details/?pincode=$pincode");
        curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);  
        curl_setopt($cf, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($cf, CURLOPT_TIMEOUT, 400);
        curl_setopt($cf, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $jwt",
            "accept: application/json",
            "cache-control: no-cache",
            "content-type: application/json"
        ));
        $response = curl_exec($cf);
        $error = curl_error($cf);
        curl_close($cf);
        if($error){
            return 0;
        }else{
            return $response;
        }
    }
    // Pincode serviceability End
    
    
    // Pincode serviceability with ODA Start
    public static function pincodeServiceAbilityWithOda($pincode, $cftType){
        $basicPincodeCheck = apiFunctions::pincodeServiceAbility($pincode, $cftType);
        if(json_decode($basicPincodeCheck)->success == 1){
            $return[] = $basicPincodeCheck;
            $jwt = apiFunctions::jwtToken($cftType);
            $cf = curl_init();
            curl_setopt($cf, CURLOPT_URL, "https://ltl-retail.delhivery.com/v3/retail/pincode-mapping/$pincode?oda_config=DLV");
            curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($cf, CURLOPT_CONNECTTIMEOUT ,0); 
            curl_setopt($cf, CURLOPT_TIMEOUT, 400);
            curl_setopt($cf, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer $jwt",
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"
            ));
            $odaResponse = curl_exec($cf);
            $odaError = curl_error($cf);
            curl_close($cf);
            if($odaError){
                return 0;
            }else{
                $return[] = $odaResponse;
                return $return;
            }
        }else{
            return 0;
        }
    }
    // Pincode serviceability with ODA End
    
    
    // Generate LR start
    public static function generateLR($jobId){
        $nQuery = new query();
        $cftType = $nQuery->getData("cft_type","orders","",array("job_id"=>$jobId),"id","DESC","1")[0]['cft_type'];
        $jwtToken = apiFunctions::jwtToken($cftType);
        $cb = curl_init();
        curl_setopt($cb, CURLOPT_URL, "https://btob.api.delhivery.com/v3/manifest?job_id=$jobId");
        curl_setopt($cb, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cb, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cb, CURLOPT_SSL_VERIFYHOST, false);  
        curl_setopt($cb, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($cb, CURLOPT_TIMEOUT, 400);
        curl_setopt($cb, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $jwtToken",
            "accept: application/json",
            "cache-control: no-cache",
            "content-type: application/json"
        ));
        $responses = curl_exec($cb);
        $errors = curl_error($cb);
        curl_close($cb);
        if($errors){
          return 0;
        }else{
            $responseArray = json_decode($responses, true);
            $statusType = $responseArray['status']['type'];
            if($statusType == "Complete"){
                $success = $responseArray['status']['success'];
                if($success == 1){
                    $jobId = $responseArray['status']['job_id'];
                    $lrnum = $responseArray['status']['value']['lrnum'];
                    $docWaybill = $responseArray['status']['value']['doc_waybill'];
                    $masterWaybill = $responseArray['status']['value']['master_waybill'];
                    $waybills = $responseArray['status']['value']['waybills'];
                    foreach($waybills as $awb){
                        $waybill_string = $waybill_string.'|'.$awb['ident'];
                    }
                    if(!empty($statusType) && !empty($jobId) && !empty($lrnum) && !empty($docWaybill) && !empty($masterWaybill)){
                        $cond_ord = array("status"=>$statusType,"lr"=>$lrnum,"waybills"=>trim($waybill_string,'|'),"master_waybill"=>$masterWaybill,"doc_waybill"=>$docWaybill);
                        $update_recent_order = $nQuery->updateData('orders',$cond_ord,'job_id',$jobId);
                        if($update_recent_order){
                            return 1;
                        }
                    }else{
                        return $responseArray;
                    }
                }else{
                    return $responseArray;
                }
            }else{
                return $responseArray;
            }
        }
    }
    // Generate LR end
    
    
    // Tracking
    public static function Tracking($lRn){
        $nQuery = new query();
        $cftType = $nQuery->getData("`cft_type`","orders","",array("lr"=>$lRn),"id","DESC","1")[0]['cft_type'];
        $jwtToken = apiFunctions::jwtToken($cftType);
        $cb = curl_init();
        curl_setopt($cb, CURLOPT_URL, "https://btob.api.delhivery.com/v3/track/$lRn");
        curl_setopt($cb, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cb, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cb, CURLOPT_SSL_VERIFYHOST, false);  
        curl_setopt($cb, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($cb, CURLOPT_TIMEOUT, 400);
        curl_setopt($cb, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $jwtToken",
            "accept: application/json",
            "cache-control: no-cache",
            "content-type: application/json"
        ));
        $responses = curl_exec($cb);
        $errors = curl_error($cb);
        curl_close($cb);
        if($errors){
            return 0;
        }else{
            return $responses;
        }
    }
    // End Tracking
    
    
}

