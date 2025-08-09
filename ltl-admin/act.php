<?php
session_start();
include("../database/db.php");
include("../functions/all-functions.php");
include("../functions/api-Functions.php");
if(isset($_SESSION['ltl_admin_id']) && !empty($_SESSION['ltl_admin_id']) && isset($_SESSION['ltl_admin_username']) && !empty($_SESSION['ltl_admin_username'])){
    $ltl_admin_id = $_SESSION['ltl_admin_id'];
}else{
    header("location:index");
}
$newquery = new query();
$newfunc = new allfunctions();
date_default_timezone_set("Asia/Kolkata");
$charges = $newquery->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];


// export users booking report
if(isset($_POST['exportUsersOrders'])){
    extract($_POST);
    $showusercond = array(array("orders`.`user_type","=","users"));
    if(!empty($ordersOfUser)){
        $showusercond[] = array("orders`.`type_id","=",$newquery->getData('`id`','users','',array('username'=>$ordersOfUser),'id','DESC','1')[0]['id']);
    }
    if(!empty($startDate) && empty($endDate)){
        $showusercond[] = array('order_date','=',$startDate);
    }
    if(!empty($startDate) && !empty($endDate)){
        $showusercond[] = array('orders`.`order_date','BETWEEN',$startDate,"AND",$endDate);
    }
    $order_details = $newquery->getData('*, `orders`.`status` as "order_status",`order_items`.`item` as "product_type"','orders',array(array('LEFT','warehouses','warehouses','id','orders','warehouse_id'),array('LEFT','order_items','order_items','id','orders','item_type')),$showusercond,'orders`.`id','DESC','');
    if($order_details != 0){
        $report[] = array('Order Id','CFT','LR No.','Master Waybill No.','Manifested Date','Pickup Date','Delivered Date','Invoice No.','Ewaybill','Count of Boxes','Party Name (username)','Consigner Details','Consignee Details','Consignee Contacts','Consignee Address','Warehouse Name','Origin Center','Destination Center','Origin City','Destination City','Origin Pincode','Destination Pincode','Billing Type','Product Type','Product Name','Client Reference No.','Invoice Value','COD Amount','Profit Amount','Status','Rate','Weight','Volumatric Weight','Freight Charge','ROV/Insurance','ODA','COD Charge','Fuel Surcharge','AWB Charge','FOV Surcharge','Handeling Charge','Cartage Charge','Pickup Charge','Damarage Surcharge','ODA Surcharge','Packaging Surcharge','Special Delivery / Appointment Charge','Sub Total','Discount Amount','IGST','CGST','SGST','Total Amount','Client GSTIN','Delhivery GSTIN','HSN');
        $slu = 1;
        foreach($order_details as $order){
            $getUser = $newquery->getData('*','users','',array('id'=>$order['type_id']),'','','')[0];
            $invs = $newquery->getData('*','invoice_details','',array('order_id'=>$order['order_id']),'id','DESC','');
            $inv_numbers;
            $ewaybills;
            if($invs != 0){
                foreach($invs as $inv){
                    $inv_no[] = $inv['inv_no'];
                    $eway_no[] = $inv['ewaybill'];
                }
                if(!empty($inv_no)){
                    $inv_numbers = trim(implode(", ", $inv_no), ", ");
                }
                if(!empty($eway_no)){
                    $ewaybills = trim(implode(", ", $eway_no), ", ");
                }
            }
            $boxCount[$slu] = $newquery->getData('SUM(`qty`) as "box_count"','box_details','',array('order_id'=>$order['order_id']),'id','DESC','')[0]['box_count'];
            $subtotalCharge = round($order['total_charge']-($order['igst_amount']+$order['cgst_amount']+$order['sgst_amount']), 2);
            if(empty($order['cartage_charge'])){ $cartageCharge = 0; }else{ $cartageCharge = $order['cartage_charge']; }
            $consignee = $newquery->getData('*','consignee_details','',array('order_id'=>$order['order_id']),'id','DESC','1')[0];
            if(empty($order['weight_charge'])){ $order['weight_charge'] = 0; }
            $report[] = array($order['order_id'],$order['cft_type'],$order['lr'],$order['master_waybill'],$order['order_date']." ".date_format(date_create($order['order_time']), "H:i:s"),$order['pickup_date'],$order['delivered_date'],$inv_numbers,$ewaybills,$boxCount[$slu],$getUser['party_name']." (username: ".$getUser['username'].")",$getUser['party_name'],$consignee['name'].", ".$consignee['company_name'],$consignee['phone'].", ".$consignee['email'],$consignee['address'].", ".$consignee['city'].", ".$consignee['state'],$order['warehouse_name'],$order['origin_center'],$order['destination_center'],$order['origin_city'],$order['destination_city'],$order['pick_pin'],$order['del_pin'],$order['payment_mode'],$order['product_type'],$order['description'],$order['subident'],$order['invoice_amount'],$order['cod_amount'],$order['profit_amount'],$order['order_status'],round($order['weight_charge']/$order['weight'], 2),$order['weight'],$order['vol_weight'],$order['weight_charge'],$order['insurance'],$order['oda'],$order['cod_charge'],$order['fuel_surcharge'],$order['awb_charge'],$order['fob_surcharge'],$order['handeling_charge'],$cartageCharge,$order['pickup_charge'],$order['damage_surcharge'],$order['oda_surcharge'],$order['packaging_surcharge'],$order['special_delivery_charge'],$subtotalCharge,0,$order['igst_amount'],$order['cgst_amount'],$order['sgst_amount'],$order['total_charge'],$order['seller_gst_tin'],$order['consignee_gst_tin'],$order['hsn']);
        $slu++;
        unset($inv_no);
        unset($eway_no);
        }
        ob_start();
        $downloadFile = fopen("php://output", 'w');
        $sl = 0;
        foreach($report as $row){
            if(count($report) != $sl){
                fputcsv($downloadFile, $row);
            }
            $sl++;
        }
        fclose($downloadFile);
        header('Content-Type:application/csv');
        header('Content-Disposition:attachment; filename='.date("d-m-Y").'_booking_report.csv');
        echo $downloadFile;
    }else{
        $newfunc->alertRedirect("No Orders Found",$_SERVER['HTTP_REFERER']);
    }
}


// export branches booking report
if(isset($_POST['exportBranchesOrders'])){
    extract($_POST);
    $showusercond = array(array("orders`.`user_type","=","branches"));
    if(!empty($ordersOfBranch)){
        $showusercond[] = array("orders`.`type_id","=",$newquery->getData('`id`','branches','',array('branch_user_name'=>$ordersOfBranch),'id','DESC','1')[0]['id']);
    }
    if(!empty($startDate) && empty($endDate)){
        $showusercond[] = array('order_date','=',$startDate);
    }
    if(!empty($startDate) && !empty($endDate)){
        $showusercond[] = array('orders`.`order_date','BETWEEN',$startDate,"AND",$endDate);
    }
    $order_details = $newquery->getData('*,`orders`.`status` as "order_status",`order_items`.`item` as "product_type"','orders',array(array('LEFT','warehouses','warehouses','id','orders','warehouse_id'),array('LEFT','order_items','order_items','id','orders','item_type')),$showusercond,'orders`.`id','DESC','');
    if($order_details != 0){
        $report[] = array('Order Id','CFT','LR No.','Master Waybill No.','Manifested Date','Pickup Date','Delivered Date','Invoice No.','Ewaybill','Count of Boxes','Branch Name (username) [type]','Consigner Details','Consigner Contacts','Consigner Address','Consignee Details','Consignee Contacts','Consignee Address','Warehouse Name','Origin Center','Destination Center','Origin City','Destination City','Origin Pincode','Destination Pincode','Billing Type','Product Type','Product Name','Client Reference No.','Invoice Value','COD Amount','Profit Amount','Status','Rate','Weight','Volumatric Weight','Freight Charge','ROV/Insurance','ODA','COD Charge','Fuel Surcharge','AWB Charge','FOV Surcharge','Handeling Charge','Cartage Charge','Pickup Charge','Damarage Surcharge','ODA Surcharge','Packaging Surcharge','Special Delivery / Appointment Charge','Sub Total','Discount Amount','IGST','CGST','SGST','Total Amount','Client GSTIN','Delhivery GSTIN','HSN');
        $slb = 1;
        foreach($order_details as $order){
            $getBranch = $newquery->getData('*','branches','',array('id'=>$order['type_id']),'','','')[0];
            $invs = $newquery->getData('*','invoice_details','',array('order_id'=>$order['order_id']),'id','DESC','');
            $inv_numbers;
            $ewaybills;
            if($invs != 0){
                foreach($invs as $inv){
                    $inv_no[] = $inv['inv_no'];
                    $eway_no[] = $inv['ewaybill'];
                }
                if(!empty($inv_no)){
                    $inv_numbers = trim(implode(", ", $inv_no), ", ");
                }
                if(!empty($eway_no)){
                    $ewaybills = trim(implode(", ", $eway_no), ", ");
                }
            }
            $boxCount[$slb] = $newquery->getData('SUM(`qty`) as "box_count"','box_details','',array('order_id'=>$order['order_id']),'id','DESC','')[0]['box_count'];
            $subtotalCharge = round($order['total_charge']-($order['igst_amount']+$order['cgst_amount']+$order['sgst_amount']), 2);
            $consignee = $newquery->getData('*','consignee_details','',array('order_id'=>$order['order_id']),'id','DESC','1')[0];
            $consigner = $newquery->getData('*','consigner_details','',array('order_id'=>$order['order_id']),'id','DESC','1')[0];
            if(empty($order['weight_charge'])){ $order['weight_charge'] = 0; }
            $report[] = array($order['order_id'],$order['cft_type'],$order['lr'],$order['master_waybill'],$order['order_date']." ".date_format(date_create($order['order_time']), "H:i:s"),$order['pickup_date'],$order['delivered_date'],$inv_numbers,$ewaybills,$boxCount[$slb],$getBranch['branch_name']." (username: ".$getBranch['branch_user_name'].") [type: ".ucwords($getBranch['type'])."]",$consigner['name'].", ".$consigner['company_name'],$consigner['phone'].", ".$consigner['email'],$consigner['address'].", ".$consigner['city'].", ".$consigner['state'],$consignee['name'].", ".$consignee['company_name'],$consignee['phone'].", ".$consignee['email'],$consignee['address'].", ".$consignee['city'].", ".$consignee['state'],$order['warehouse_name'],$order['origin_center'],$order['destination_center'],$order['origin_city'],$order['destination_city'],$order['pick_pin'],$order['del_pin'],$order['payment_mode'],$order['product_type'],$order['description'],$order['subident'],$order['invoice_amount'],$order['cod_amount'],$order['profit_amount'],$order['order_status'],round($order['weight_charge']/$order['weight'], 2),$order['weight'],$order['vol_weight'],$order['weight_charge'],$order['insurance'],$order['oda'],$order['cod_charge'],$order['fuel_surcharge'],$order['awb_charge'],$order['fob_surcharge'],$order['handeling_charge'],$order['cartage_charge'],$order['pickup_charge'],$order['damage_surcharge'],$order['oda_surcharge'],$order['packaging_surcharge'],$order['special_delivery_charge'],$subtotalCharge,0,$order['igst_amount'],$order['cgst_amount'],$order['sgst_amount'],$order['total_charge'],$order['seller_gst_tin'],$order['consignee_gst_tin'],$order['hsn']);
        $slb++;
        unset($inv_no);
        unset($eway_no);
        }
        ob_start();
        $downloadFile = fopen("php://output", 'w');
        $sl = 0;
        foreach($report as $row){
            if(count($report) != $sl){
                fputcsv($downloadFile, $row);
            }
            $sl++;
        }
        fclose($downloadFile);
        header('Content-Type:application/csv');
        header('Content-Disposition:attachment; filename='.date("d-m-Y").'_branch_report.csv');
        echo $downloadFile;
    }else{
        $newfunc->alertRedirect("No Orders Found",$_SERVER['HTTP_REFERER']);
    }
}


// export users / branches tds report
if(isset($_POST['exportBranchorUsersTDS'])){
    extract($_POST);
    if($visible == "users" || $visible == "branches"){
        $showusercond["user_type"] = $visible;
    }
    if(!empty($orderUsersorBranches)){
        if($visible == "users"){
            $visibleusername = "username";
        }elseif($visible == "branches"){
            $visibleusername = "branch_user_name";
        }
        $showusercond['type_id'] = $newquery->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id'];
    }
    if(!empty($startDate) && empty($endDate)){
        $showusercond['order_date'] = $startDate;
    }
    if(!empty($startDate) && !empty($endDate)){
        unset($showusercond);
        if($visible == "users" || $visible == "branches"){
            $showusercond[] = array("user_type","=",$visible);
        }
        if(!empty($orderUsersorBranches)){
            if($visible == "users"){
                $visibleusername = "username";
            }elseif($visible == "branches"){
                $visibleusername = "branch_user_name";
            }
            $showusercond[] = array("type_id","=",$newquery->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id']);
        }
        $showusercond[] = array('order_date','BETWEEN',$startDate,"AND",$endDate);
    }
    $order_details = $newquery->getData('*','orders','',$showusercond,'order_date','DESC','');
    if($order_details != 0){
        $report[] = array('Customer Type','LR/AWB No.','Order Date','Customer Details','Basic Freight','Consignee Name (Company)','Consignee Contact','PAN','TDS');
        foreach($order_details as $order){
            $userdetails = $newquery->getData("*",$visible,"",array("id"=>$order['type_id']),"id","DESC","1")[0];
            if($visible == "users"){
                $customerDetails = $userdetails['party_name']."Username : ".$userdetails['username'];
                $pan = $userdetails['pan'];
            }elseif($visible == "branches"){
                $customerDetails = $userdetails['branch_name']."Username : ".$userdetails['branch_user_name'];
                $pan = $userdetails['pan_no'];
            }
            $get_consignee_details = $newquery->getData('*','consignee_details','',array("order_id"=>$order['order_id']),'','','');
            if($userdetails['tds'] == 'yes'){
                $report[] = array(ucwords(trim(trim($visible, "s"), "es")),$order['lr'],$order['order_date'],$customerDetails,$order['weight_charge'],$get_consignee_details[0]['name']." (".$get_consignee_details[0]['company'].")",$get_consignee_details[0]['phone'].",".$get_consignee_details[0]['email'],$pan,(($order['weight_charge']*2)/100));
            }
        }
        if(empty($report[1])){
            $newfunc->alertRedirect("No Orders Found",$_SERVER['HTTP_REFERER']);
            exit();
        }
        ob_start();
        $downloadFile = fopen("php://output", 'w');
        $sl = 0;
        foreach($report as $row){
            if(count($report) != $sl){
                fputcsv($downloadFile, $row);
            }
            $sl++;
        }
        fclose($downloadFile);
        header('Content-Type:application/csv');
        header('Content-Disposition:attachment; filename='.date("d-m-Y").'_tds_report.csv');
        echo $downloadFile;
    }else{
        $newfunc->alertRedirect("No Orders Found",$_SERVER['HTTP_REFERER']);
    }
}


// export bill report
if(isset($_POST['exportBillReport'])){
    if($visible == "users" || $visible == "branches"){
        $showusercond["user_type"] = $visible;
    }
    if(!empty($orderUsersorBranches)){
        if($visible == "users"){
            $visibleusername = "username";
        }elseif($visible == "branches"){
            $visibleusername = "branch_user_name";
        }
        $showusercond['type_id'] = $newquery->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id'];
    }
    if(!empty($startDate) && empty($endDate)){
        $showusercond['invoice_date'] = $startDate;
    }
    if(!empty($startDate) && !empty($endDate)){
        unset($showusercond);
        if($visible == "users" || $visible == "branches"){
            $showusercond[] = array("user_type","=",$visible);
        }
        if(!empty($orderUsersorBranches)){
            if($visible == "users"){
                $visibleusername = "username";
            }elseif($visible == "branches"){
                $visibleusername = "branch_user_name";
            }
            $showusercond[] = array("type_id","=",$newquery->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id']);
        }
        $showusercond[] = array('invoice_date','BETWEEN',$startDate,"AND",$endDate);
    }
    $invoices_details = $newquery->getData('*','stationary_invoices','',$showusercond,'id','DESC','');
    if($invoices_details != 0){
        $report[] = array('Invoice No.','Invoice Date','Name','Address','GST No.','GST Before Amount','IGST','CGST','SGST','Grand Total');
        foreach($invoices_details as $invoices){
            $report[] = array($invoices['invoice_no'],$invoices['invoice_date'],$invoices['name'],$invoices['address'],$invoices['gst_number'],$invoices['gst_before_amount'],$invoices['igst'],$invoices['cgst'],$invoices['sgst'],$invoices['grand_total']);
        }
        ob_start();
        $downloadFile = fopen("php://output", 'w');
        $sl = 0;
        foreach($report as $row){
            if(count($report) != $sl){
                fputcsv($downloadFile, $row);
            }
            $sl++;
        }
        fclose($downloadFile);
        header('Content-Type:application/csv');
        header('Content-Disposition:attachment; filename='.date("d-m-Y").'_bill_report.csv');
        echo $downloadFile;
    }else{
        $newfunc->alertRedirect("No Reports Found",$_SERVER['HTTP_REFERER']);
    }
}


// export broker report
if(isset($_POST['exportBrokerReport'])){
    extract($_POST);
    $showusercond = array("selfdrop"=>"N");
    if(!empty($orderUsersorBranches) && empty($startDate) && empty($endDate)){
        $showusercond['type_id'] = $newquery->getData('`id`','branches','',array('branch_user_name'=>$orderUsersorBranches),'id','DESC','1')[0]['id'];
    }
    $showusercond['orders`.`user_type'] = "branches";
    $showusercond['branches`.`type'] = "agent";
    if(!empty($startDate) && empty($endDate)){
        $showusercond['order_date'] = $startDate;
    }
    if(!empty($startDate) && !empty($endDate)){
        unset($showusercond);
        $showusercond = array(array("selfdrop","=","N"),array("user_type","=","branches"));
        if(!empty($orderUsersorBranches)){
            $showusercond[] = array("type_id","=",$newquery->getData('`id`','branches','',array('branch_user_name'=>$orderUsersorBranches),'id','DESC','1')[0]['id']);
        }
        $showusercond[] = array('order_date','BETWEEN',$startDate,"AND",$endDate);
        $showusercond[] = array("orders`.`user_type","=","branches");
        $showusercond[] = array("branches`.`type","=","agent");
    }
    $order_details = $newquery->getData('`orders`.*,`branches`.`type`,`branches`.`id`','orders',array(array('LEFT','branches','branches','id','orders','type_id')),$showusercond,'orders`.`id','DESC','');
    if($order_details != 0){
        $report[] = array('LR/AWB No.','Receipt Date','Consigner Name (Company)','Consignee Name (Company)','From','To','Broker Name','Quantity','Weight','Total Charge','Total Commission','Payment Status');
        $broSl = 1;
        foreach($order_details as $orders){
            $branch = $newquery->getData("*",'branches',"",array("id"=>$orders['type_id']),"id","DESC","1")[0];
            $get_consignee_details = $newquery->getData('*','consignee_details','',array("order_id"=>$orders['order_id']),'','','');
            $get_consigner_details = $newquery->getData('*','consigner_details','',array("order_id"=>$orders['order_id']),'','','');
            $get_box_details = $newquery->getData('*','box_details','',array("order_id"=>$orders['order_id']),'','','');
            $getwarehouse = $newquery->getData('*','warehouses','',array('id'=>$orders['warehouse_id']),'id','DESC','1')[0];
            $totalBox[$broSl] = $newquery->getData('SUM(`qty`) as "box_count"','box_details','',array('order_id'=>$orders['order_id']),'id','DESC','')[0]['box_count'];
            if($branch['broker_commission_type'] == "Kg"){
                $commission = round($branch['broker_commission']*$orders['vol_weight'], 2);
            }elseif($branch['broker_commission_type'] == "Percentage"){
                $commission = round((($orders['weight_charge']+$orders['fuel_surcharge']+$orders['awb_charge']+$orders['fob_surcharge'])*$branch['broker_commission'])/100, 2);
            }
            $report[] = array($orders['lr'],$orders['order_date'],$get_consigner_details[0]['name']." (".$get_consigner_details[0]['company'].")",$get_consignee_details[0]['name']." (".$get_consignee_details[0]['company'].")",$orders['pick_pin'],$orders['del_pin'],$branch['branch_name'].", Username : ".$branch['branch_user_name'],$totalBox[$broSl],$orders['vol_weight'],$orders['total_charge'],$commission,$orders['commission_status']);
            $broSl++;
        }
        ob_start();
        $downloadFile = fopen("php://output", 'w');
        $sl = 0;
        foreach($report as $row){
            if(count($report) != $sl){
                fputcsv($downloadFile, $row);
            }
            $sl++;
        }
        fclose($downloadFile);
        header('Content-Type:application/csv');
        header('Content-Disposition:attachment; filename='.date("d-m-Y").'_brokerage_report.csv');
        echo $downloadFile;
    }else{
        $newfunc->alertRedirect("No Orders Found",$_SERVER['HTTP_REFERER']);
    }
}


// Download Ledger
if(isset($_POST['exportLedger'])){
    extract($_POST);
    if($visible == "users" || $visible == "branches"){
        $showusercond["user_type"] = $visible;
    }
    if(!empty($UsersorBranches)){
          if($visible == "users"){
              $visibleusername = "username";
          }elseif($visible == "branches"){
              $visibleusername = "branch_user_name";
          }
          $showusercond['user_id'] = $newquery->getData('`id`',$visible,'',array($visibleusername=>$UsersorBranches),'id','DESC','1')[0]['id'];
    }
    $gettxns = $newquery->getData("*","transactions","",$showusercond,"id","DESC","");
    if($gettxns != 0){
        $report[] = array('User Type','User Details','Date & Time','Transaction Id','Remarks','Transaction Type','Credit Amount','Debit Amount','Balance');
        foreach($gettxns as $txn){
            $getuser = $newquery->getData("*",$txn['user_type'],"",array("id"=>$txn['user_id']),"","","")[0];
            $userDetails = ($txn['user_type'] == "branches")? $getuser['branch_name'].", Username: ".$getuser['branch_user_name'] : $getuser['party_name'].", Username: ".$getuser['username'];
            $remainingDetails = ", Mobile: ".$getuser['mobile_no'].", Email Id: ".$getuser['email'];
            $creditAmount = ($txn['status'] == "Credit")? $txn['amount'] : 0;
            $debitAmount = ($txn['status'] == "Debit")? $txn['amount'] : 0;
            $report[] = array(ucwords(rtrim(rtrim($txn['user_type'], "s"), "es")), $userDetails.$remainingDetails, $txn['date_time'], $txn['txn_id'], $txn['details'], $txn['status'], $creditAmount, $debitAmount, $txn['balance']);
        }
        ob_start();
        $downloadFile = fopen("php://output", 'w');
        $sl = 0;
        foreach($report as $row){
            if(count($report) != $sl){
                fputcsv($downloadFile, $row);
            }
            $sl++;
        }
        fclose($downloadFile);
        header('Content-Type:application/csv');
        header('Content-Disposition:attachment; filename='.date("d-m-Y").'_ledger_details.csv');
        echo $downloadFile;
    }else{
        $newfunc->alertRedirect("No Transactions Found",$_SERVER['HTTP_REFERER']);
    }
}


// deposit commission to agent
if(isset($_POST['payCommissionToAgent'])){
    $transactionId = $newfunc->real_string(trim($_POST['transactionId'], " "));
    $orderId = $newfunc->real_string(trim($_POST['orderId'], " "));
    $order_details = $newquery->getData('*','orders','',array('order_id'=>$orderId),'id','DESC','1')[0];
    if($order_details){
        $branch = $newquery->getData("*","branches","",array("id"=>$order_details['type_id']),"id","DESC","1")[0];
        if($branch){
            if($branch['broker_commission_type'] == "Kg"){
                $commission = round(($branch['broker_commission']*$order_details['vol_weight']),2);
            }elseif($branch['broker_commission_type'] == "Percentage"){
                $commission = round(((($order_details['weight_charge']+$order_details['fuel_surcharge']+$order_details['awb_charge']+$order_details['fob_surcharge'])*$branch['broker_commission'])/100),2);
            }
            $getprevTrans = $newquery->getData('*','transactions','',array("txn_id_type"=>"Serial"),'id','DESC','1');
          	if($getprevTrans != 0){
                $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
            }else{
                $merchantTransactionId = 'KINGFISH100000';
            }
            $new_bal = round(($branch['wallet_balance'] + $commission), 2);
            $tdate = date('Y-m-d H:i:s');
            $desc = str_replace("'", "\'", "Commission for LR No.: ".$order_details['lr']);
            $transsArr = array("date_time"=>$tdate,"user_type"=>'branches',"user_id"=>$branch['id'],"amount"=>$commission,"balance"=>$new_bal,"type"=>"Manual","details"=>$desc,"txn_id"=>$merchantTransactionId,"status"=>"Credit");
            $insert_transaction = $newquery->insertData('transactions',$transsArr);
            if($insert_transaction){
                $new_bal2 = round(($new_bal - $commission), 2);
  	            $desc2 = str_replace("'", "\'", "Commission for LR No.: ".$order_details['lr']." has withdrawaled and sent to the bank");
  	            $transsArr2 = array("date_time"=>$tdate,"user_type"=>'branches',"user_id"=>$branch['id'],"amount"=>$commission,"balance"=>$new_bal2,"type"=>"Online","details"=>$desc2,"txn_id"=>$transactionId,"txn_id_type"=>"Different","status"=>"Debit");
  	            $insert_transaction2 = $newquery->insertData('transactions',$transsArr2);
  	            if($insert_transaction2){
  	                $updCom = $newquery->updateData('orders',array('commission_status'=>'Paid'),'order_id',$orderId);
  	                if($updCom){
                        $newfunc->alertRedirect("You have successfully deposited the commission",$_SERVER['HTTP_REFERER']);
  	                }else{
                        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                    }
  	            }else{
                    $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
            }
        }else{
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// fetch users / branches due of to pay
if(isset($_POST['toPayuser']) && isset($_POST['toPayuserType'])){
    $toPayuserType = $newfunc->real_string(trim($_POST['toPayuserType'], " "));
    $toPayuser = $newfunc->real_string(trim($_POST['toPayuser'], " "));
    if($toPayuserType == "users"){
        $type = "username";
    }elseif($toPayuserType == "branches"){
        $type = "branch_user_name";
    }
    $us = $newquery->getData('*',$toPayuserType,'',array('delete_status'=>'show',$type=>$toPayuser),'id','DESC','1')[0];
    echo $us['to_pay_due'].",".$us['wallet_balance'];
}


// fetch users / branches due of franchise to pay
if(isset($_POST['frantoPayuser']) && isset($_POST['frantoPayuserType'])){
    $frantoPayuserType = $newfunc->real_string(trim($_POST['frantoPayuserType'], " "));
    $frantoPayuser = $newfunc->real_string(trim($_POST['frantoPayuser'], " "));
    if($frantoPayuserType == "users"){
        $type = "username";
    }elseif($frantoPayuserType == "branches"){
        $type = "branch_user_name";
    }
    $us = $newquery->getData('*',$frantoPayuserType,'',array('delete_status'=>'show',$type=>$frantoPayuser),'id','DESC','1')[0];
    echo $us['franchise_topay_due'].",".$us['wallet_balance'];
}


// fetch users form table for to pay
if(!empty($_POST['toPayUserType'])){
    extract($_POST);
    $toPayUserType = $newfunc->real_string(trim($toPayUserType, " "));
    $getch = $newquery->getData('*',$toPayUserType,'',array('delete_status'=>'show'),'','','');
    if($getch != 0){
        echo '<option value="" hidden>Choose '.ucwords(trim(trim($toPayUserType, "s"),"es")).'</option>';
        foreach($getch as $getall){
            if($toPayUserType == "users"){
                $name = $getall['party_name'];
                $username = $getall['username'];
            }elseif($toPayUserType == "branches"){
                $name = $getall['branch_name'];
                $username = $getall['branch_user_name'];
            }
            echo '<option value="'.$username.'">'.$name.' (Username: '.$username.') [Mob: '.$getall['mobile_no'].']</option>';
        }
    }
}


// fetch users form table
if(!empty($_POST['orderUserType'])){
    extract($_POST);
    $orderUserType = $newfunc->real_string(trim($orderUserType, " "));
    $getch = $newquery->getData('*',$orderUserType,'',array('delete_status'=>'show'),'','','');
    if($getch != 0){
        echo '<option value="" hidden>Choose '.ucwords(trim(trim($orderUserType, "s"),"es")).'</option>';
        foreach($getch as $getall){
            if($orderUserType == "users"){
                $name = $getall['party_name'];
                $username = $getall['username'];
            }elseif($orderUserType == "branches"){
                $name = $getall['branch_name'];
                $username = $getall['branch_user_name'];
            }
            echo '<option value="'.$username.'">'.$name.' (Username: '.$username.') [Mob: '.$getall['mobile_no'].']</option>';
        }
    }
}


// fetch users form table
if(!empty($_POST['freightUserType'])){
    extract($_POST);
    $freightUserType = $newfunc->real_string(trim($freightUserType, " "));
    $getch = $newquery->getData('*',$freightUserType,'',array('delete_status'=>'show'),'','','');
    if($getch != 0){
        echo '<option value="" hidden>Choose '.ucwords(trim(trim($freightUserType, "s"),"es")).'</option>';
        foreach($getch as $getall){
            if($freightUserType == "users"){
                $name = $getall['party_name'];
                $username = $getall['username'];
            }elseif($freightUserType == "branches"){
                $name = $getall['branch_name'];
                $username = $getall['branch_user_name'];
            }
            echo '<option value="'.$getall['id'].'">'.$name.' (Username: '.$username.') [Mob: '.$getall['mobile_no'].']</option>';
        }
    }
}


// fetch lrs by username and user type
if(isset($_POST['LRuserIs']) && isset($_POST['visible'])){
    extract($_POST);
    if($visible == 'users'){
        $that = array('username'=>$LRuserIs,'delete_status'=>'show');
    }elseif($visible == 'branches'){
        $that = array('branch_user_name'=>$LRuserIs,'delete_status'=>'show');
    }
    $ID = $newquery->getData('`id`',$visible,'',$that,'id','DESC','1')[0]['id'];
    $getlrs = $newquery->getData('*','orders','',array(array('user_type','=',$visible),array('type_id','=',$ID)),'id','DESC','');
    if($getlrs != 0){
        echo '<option value="" hidden>Choose one LR</option>';
        foreach($getlrs as $lrs){
            echo '<option>'.$lrs['lr'].'</option>';
        }
    }else{
        echo '<option>No order found!</option>';
    }
}


// fetch lrs by username and user type of cod remittance
if(isset($_POST['codLRs']) && !empty($_POST['codVisibleType'])){
    extract($_POST);
    if($codVisibleType == 'users'){
        $that = array('username'=>$codLRs,'delete_status'=>'show');
    }elseif($codVisibleType == 'branches'){
        $that = array('branch_user_name'=>$codLRs,'delete_status'=>'show');
    }
    $ID = $newquery->getData('`id`',$codVisibleType,'',$that,'id','DESC','1')[0]['id'];
    $getlrs = $newquery->getData('*','orders','',array('user_type'=>$codVisibleType,'type_id'=>$ID,'payment_mode'=>'CoD','cod_remittance_status'=>'Pending'),'id','DESC','');
    if($getlrs != 0){
        foreach($getlrs as $lrs){
            echo '<option>'.$lrs['lr'].'</option>';
        }
    }
}


// fetch cod amount by lr
if(isset($_POST['codLRAmount'])){
    extract($_POST);
    $lRs = explode(",", $_POST['codLRAmount']);
    foreach($lRs as $codlR):
        $lrsAmount = $lrsAmount+$newquery->getData('`cod_amount`','orders','',array('lr'=>$codlR),'id','DESC','1')[0]['cod_amount'];
    endforeach;
    echo round($lrsAmount, 2);
}


// fetch users form table for franchise to pay remittance
if(!empty($_POST['frantopayVisibleType'])){
    extract($_POST);
    $frantopayVisibleType = $newfunc->real_string(trim($frantopayVisibleType, " "));
    $getch = $newquery->getData('*',$frantopayVisibleType,'',array('delete_status'=>'show'),'','','');
    if($getch != 0){
        echo '<option value="" hidden>Choose '.ucwords(trim(trim($frantopayVisibleType, "s"),"es")).'</option>';
        foreach($getch as $getall){
            if($frantopayVisibleType == "users"){
                $name = $getall['party_name'];
                $username = $getall['username'];
            }elseif($frantopayVisibleType == "branches"){
                $name = $getall['branch_name'];
                $username = $getall['branch_user_name'];
            }
            echo '<option value="'.$username.'">'.$name.' (Username: '.$username.') [Mob: '.$getall['mobile_no'].']</option>';
        }
    }
}


// fetch lrs by username and user type of franchise to pay remittance
if(isset($_POST['frantopayLRs']) && !empty($_POST['frantopayVisibles'])){
    extract($_POST);
    if($frantopayVisibles == 'users'){
        $that = array('username'=>$frantopayLRs,'delete_status'=>'show');
    }elseif($frantopayVisibles == 'branches'){
        $that = array('branch_user_name'=>$frantopayLRs,'delete_status'=>'show');
    }
    $ID = $newquery->getData('`id`',$frantopayVisibles,'',$that,'id','DESC','1')[0]['id'];
    $getlrs = $newquery->getData('*','orders','',array('user_type'=>$frantopayVisibles,'type_id'=>$ID,'payment_mode'=>'Franchise-ToPay','franchise_to_pay_remittance_status'=>'Pending'),'id','DESC','');
    if($getlrs != 0){
        foreach($getlrs as $lrs){
            echo '<option>'.$lrs['lr'].'</option>';
        }
    }
}


// fetch profit amount by lr
if(isset($_POST['frantoPayLRAmount'])){
    extract($_POST);
    $lRs = explode(",", $_POST['frantoPayLRAmount']);
    foreach($lRs as $FTPlR):
        $lrsAmount = $lrsAmount+$newquery->getData('`profit_amount`','orders','',array('lr'=>$FTPlR),'id','DESC','1')[0]['profit_amount'];
    endforeach;
    echo round($lrsAmount, 2);
}


// Delete LR
if(isset($_GET['deleteLr']) && $_GET['submittedBy']){
    extract($_GET);
    $lrDetails = $newquery->getData("*","orders","",array("lr"=>$deleteLr),"id","DESC","1");
    if($lrDetails != 0):
        $statusUpate = $newquery->updateData("orders",array("lr_status"=>"deleted","lr_status_deleted_by"=>"admin","lr_status_deleted_by_id"=>"1"),"lr",$deleteLr);
        if($statusUpate):
            $lrDetails = $lrDetails[0];
            if($lrDetails['payment_mode'] == "Prepaid" || $lrDetails['payment_mode'] == "CoD"):
                $getprevTrans = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
              	if($getprevTrans != 0){
                    $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
                }else{
                    $merchantTransactionId = 'KINGFISH100000';
                }
                $get_user_details = $newquery->getData("*",$lrDetails['user_type'],"",array("id"=>$lrDetails['type_id']),"id","DESC","1")[0];
                $new_bal = round(($get_user_details['wallet_balance'] + $lrDetails['total_charge']), 2);
                $tdate = date('Y-m-d H:i:s');
                $desc = str_replace("'", "\'", "Order Id: ".$lrDetails['order_id']."'s total charge refunded");
                $insert_transaction = $newquery->insertData('transactions',array("date_time"=>$tdate,"user_type"=>$lrDetails['user_type'],"user_id"=>$lrDetails['type_id'],"amount"=>$lrDetails['total_charge'],"balance"=>$new_bal,"type"=>"Manual","details"=>$desc,"txn_id"=>$merchantTransactionId,"status"=>"Credit"));
                if($insert_transaction):
                    $walletbalanceUpdate = $newquery->updateData($lrDetails['user_type'],array("wallet_balance"=>$new_bal),"id",$lrDetails['type_id']);
                    if($walletbalanceUpdate):
                        $newfunc->alertRedirect("LR number: $deleteLr successfully deleted",$_SERVER['HTTP_REFERER']);
                    else:
                        $newfunc->alertRedirect("An error occured while updating wallet balance!",$_SERVER['HTTP_REFERER']);
                    endif;
                else:
                    $newfunc->alertRedirect("An error occured while updating transaction!",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("LR number: $deleteLr successfully deleted",$_SERVER['HTTP_REFERER']); 
            endif;
        else:
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
    endif;
}


// edit single lr
if(isset($_POST['updateSingleLR'])){
    $newPost = array();
    foreach($_POST as $postkey => $postval):
        $newPost[$postkey] = str_replace("'","\'",$postval);
    endforeach;
    unset($_POST);
    $_POST = $newPost;
    extract($_POST);
    $getorder = $newquery->getData('*','orders','',array('order_id'=>$orderId),'id','DESC','1')[0];
    $get_user_details = $newquery->getData('*',$getorder['user_type'],'',array('id'=>$getorder['type_id']),'id','DESC','1')[0];
    for($i = 0; $i < count($length); $i++){
        if($dimention == "cm"){
            $valuematricWeight = $valuematricWeight+(((($length[$i]*$width[$i]*$height[$i])/27000)*str_replace("CFT", "", $getorder['cft_type']))*$qty[$i]);
        }elseif($dimention == "inch"){
            $valuematricWeight = $valuematricWeight+(((($length[$i]*$width[$i]*$height[$i])/1728)*str_replace("CFT", "", $getorder['cft_type']))*$qty[$i]);
        }
        $totalQty = $totalQty+$qty[$i];
    }
    if($get_user_details['freight_type'] == "Weight"){
        if($valuematricWeight < $weight){
            $frightCharge = round(($applied_weight_charge*$weight), 2);
            $calweight = $weight;
        }else{
            $frightCharge = round(($applied_weight_charge*$valuematricWeight), 2);
            $calweight = $valuematricWeight;
        }
    }elseif($get_user_details['freight_type'] == "Quantity"){
        $frightCharge = round(($applied_weight_charge*$totalQty), 2);
        if($valuematricWeight < $weight){
            $calweight = $weight;
        }else{
            $calweight = $valuematricWeight;
        }
    }
    $lr = $getorder['lr'];
    $calweight = round($calweight, 2);
    $awb_charge = $applied_awb_charge;
    if(isset($_POST['checkInsurance'])){
        $insurance = 'Yes';
        if(round($invoice_amount*($applied_fob_surcharge_percentage/100),2) > $applied_fob_surcharge_minimum){
            $fob_surcharge = round($invoice_amount*($applied_fob_surcharge_percentage/100),2);
        }else{
            $fob_surcharge = $applied_fob_surcharge_minimum;
        }
    }else{
        $insurance = 'No';
        $fob_surcharge = $applied_fob_surcharge_minimum;
    }
    if($applied_handeling_charge_type == "Quantity"){
        $handeling_charge = round(($applied_handeling_charge*$totalQty), 2);
    }elseif($applied_handeling_charge_type == "Kg"){
        $handeling_charge = round(($applied_handeling_charge*$calweight), 2);
    }
    if(!$applied_cartage_charge_type){
        if($applied_cartage_charge_type == "Quantity"){
            $cartage_charge = round(($applied_cartage_charge*$totalQty), 2);
        }elseif($applied_cartage_charge_type == "Fixed"){
            $cartage_charge = $applied_cartage_charge;
        }
    }else{
        $cartage_charge = 0;
    }
    if($applied_damage_surcharge_type == "Quantity"){
        $new_damage_surcharge = round(($applied_damage_surcharge*$totalQty), 2);
        if($applied_damage_surcharge_min < $new_damage_surcharge){
            $damage_surcharge = $new_damage_surcharge;
        }else{
            $damage_surcharge = $applied_damage_surcharge_min;
        }
    }elseif($applied_damage_surcharge_type == "Kg"){
        $new_damage_surcharge = round(($applied_damage_surcharge*$calweight), 2);
        if($applied_damage_surcharge_min < $new_damage_surcharge){
            $damage_surcharge = $new_damage_surcharge;
        }else{
            $damage_surcharge = $applied_damage_surcharge_min;
        }
    }
    if($getorder['del_pin'] == $consignee_pincode){
        $destination_center = $getorder['destination_center'];
        $destination_city = $getorder['destination_city'];
        if($getorder['oda'] == "true"){
            $oda = "true";
            if($applied_oda_surcharge_type == "Quantity"){
                $new_oda_surcharge = round(($applied_oda_surcharge*$totalQty), 2);
                if($applied_oda_surcharge_min < $new_oda_surcharge){
                    $oda_surcharge = $new_oda_surcharge;
                }else{
                    $oda_surcharge = $applied_oda_surcharge_min;
                }
            }elseif($applied_oda_surcharge_type == "Kg"){
                $new_oda_surcharge = round(($applied_oda_surcharge*$calweight), 2);
                if($applied_oda_surcharge_min < $new_oda_surcharge){
                    $oda_surcharge = $new_oda_surcharge;
                }else{
                    $oda_surcharge = $applied_oda_surcharge_min;
                }
            }
        }else{
            $oda = "false";
            $oda_surcharge = 0;
        }
    }else{
        $odaDetails = apiFunctions::pincodeServiceAbilityWithOda($consignee_pincode, $getorder['cft_type']);
        $destinations = explode("--", getCenterandCity($del_pin,$getorder['cft_type']));
        $destination_center = $destinations[0];
        $destination_city = $destinations[1];
        if($odaDetails[1] == true){
            $oda = "true";
            if($applied_oda_surcharge_type == "Quantity"){
                $new_oda_surcharge = round(($applied_oda_surcharge*$totalQty), 2);
                if($applied_oda_surcharge_min < $new_oda_surcharge){
                    $oda_surcharge = $new_oda_surcharge;
                }else{
                    $oda_surcharge = $applied_oda_surcharge_min;
                }
            }elseif($applied_oda_surcharge_type == "Kg"){
                $new_oda_surcharge = round(($applied_oda_surcharge*$calweight), 2);
                if($applied_oda_surcharge_min < $new_oda_surcharge){
                    $oda_surcharge = $new_oda_surcharge;
                }else{
                    $oda_surcharge = $applied_oda_surcharge_min;
                }
            }
        }else{
            $oda = "false";
            $oda_surcharge = 0;
        }
    }
    if($applied_packaging_surcharge_type == "Quantity"){
        $packaging_surcharge = round(($applied_packaging_surcharge*$totalQty), 2);
    }elseif($applied_packaging_surcharge_type == "Kg"){
        $packaging_surcharge = round(($applied_packaging_surcharge*$calweight), 2);
    }
    if($applied_special_delivery_or_appointment_charge_type == "Fixed"){
        $new_special_delivery_charge = round(($applied_special_delivery_or_appointment_charge), 2);
        if($applied_special_delivery_or_appointment_charge_min < $new_special_delivery_charge){
            $special_delivery_charge = $new_special_delivery_charge;
        }else{
            $special_delivery_charge = $applied_special_delivery_or_appointment_charge_min;
        }
    }elseif($applied_special_delivery_or_appointment_charge_type == "Percentage"){
        $new_special_delivery_charge = round(($frightCharge*($applied_special_delivery_or_appointment_charge/100)), 2);
        if($applied_special_delivery_or_appointment_charge_min < $new_special_delivery_charge){
            $special_delivery_charge = $new_special_delivery_charge;
        }else{
            $special_delivery_charge = $applied_special_delivery_or_appointment_charge_min;
        }
    }
    if($applied_pickup_charge_type == "Quantity"){
        $pickup_charge = round(($applied_pickup_charge*$totalQty), 2);
    }elseif($applied_pickup_charge_type == "Kg"){
        $pickup_charge = round(($applied_pickup_charge*$calweight), 2);
    }
    if($applied_fuel_surcharge_type == "Fixed"){
        $fuel_surcharge = round(($applied_fuel_surcharge), 2);
    }elseif($applied_fuel_surcharge_type == "Percentage"){
        $fuel_surcharge = round(($frightCharge*($applied_fuel_surcharge/100)), 2);
    }
    $cod_charge = 0;
    if($lr_payment_mode == "CoD" || $lr_payment_mode == "To-Pay" || $lr_payment_mode == "Franchise-ToPay"){
        if($getorder['user_type'] == "users"){
            $cod_charge_check = ($get_user_details['cod_charge_enable_disable'] == "enable")? "yes" : "no";
        }elseif($getorder['user_type'] == "branches"){
            $cod_charge_check = "yes";
        }
        if($cod_charge_check == "yes" || $lr_payment_mode == "To-Pay" || $lr_payment_mode == "Franchise-ToPay"){
            if($applied_cod_charge_type == "Fixed"){
                $new_cod_charge = $applied_cod_charge;
                if($applied_cod_charge_min < $new_cod_charge){
                    $cod_charge = $new_cod_charge;
                }else{
                    $cod_charge = $applied_cod_charge_min;
                }
            }elseif($applied_cod_charge_type == "Percentage"){
                $new_cod_charge = $frightCharge*($applied_cod_charge/100);
                if($applied_cod_charge_min < $new_cod_charge){
                    $cod_charge = $new_cod_charge;
                }else{
                    $cod_charge = $applied_cod_charge_min;
                }
            }
        }
    }
    $before_gst_total_charge = ($frightCharge+$awb_charge+$fuel_surcharge+$fob_surcharge+$handeling_charge+$oda_surcharge+$packaging_surcharge+$cod_charge+$cartage_charge);
    if($getorder['special_delivery_charge_applied'] == "Yes"){
        $before_gst_total_charge+=$special_delivery_charge;
    }else{
        $special_delivery_charge = 0;
    }
    if($getorder['pickup_charge_refunded'] == "No"){
        $before_gst_total_charge+=$pickup_charge;
    }else{
        $pickup_charge = 0;
    }
    if(isset($_POST['damage_charge_applied'])){
        $damage_charge_applied = "Yes";
        $before_gst_total_charge+=$damage_surcharge;
    }else{
        $damage_charge_applied = "No";
        $damage_surcharge = 0;
    }
    if($get_user_details['igst'] == "not"){
        $gst_charge = round(($before_gst_total_charge*($getorder['sgst_per']/100))+($before_gst_total_charge*($getorder['cgst_per']/100)), 2);
        $sgst_amount = round(($before_gst_total_charge*($getorder['sgst_per']/100)), 2);
        $cgst_amount = round(($before_gst_total_charge*($getorder['cgst_per']/100)), 2);
        $igst_amount = 0;
    }elseif($get_user_details['igst'] == "yes"){
        $gst_charge = round(($before_gst_total_charge*($getorder['igst_per']/100)), 2);
        $igst_amount = round(($before_gst_total_charge*($getorder['igst_per']/100)), 2);
        $cgst_amount = 0;
        $sgst_amount = 0;
    }
    $total_charge = round(($before_gst_total_charge+$gst_charge), 2);
    $volweight = $calweight;
    if($lr_payment_mode != "CoD"){
        $cod_amount = 0;
    }
    if($lr_payment_mode != "Franchise-ToPay"){
        $profit_amount = 0;
    }
    $chargeArr = array("del_pin"=>$consignee_pincode,"weight"=>$weight,"vol_weight"=>$volweight,"cod_charge"=>$cod_charge,"fuel_surcharge"=>$fuel_surcharge,"awb_charge"=>$awb_charge,"fob_surcharge"=>$fob_surcharge,"handeling_charge"=>$handeling_charge,"damage_surcharge"=>$damage_surcharge,"damage_charge_applied"=>$damage_charge_applied,"oda_surcharge"=>$oda_surcharge,"packaging_surcharge"=>$packaging_surcharge,"special_delivery_charge"=>$special_delivery_charge,"gst_charge"=>$gst_charge,"weight_charge"=>$frightCharge,"cartage_charge"=>$cartage_charge,"pickup_charge"=>$pickup_charge,"total_charge"=>$total_charge,'payment_mode'=>$lr_payment_mode,'insurance'=>$insurance,'invoice_amount'=>$invoice_amount,'seller_gst_tin'=>$seller_gst_tin,'consignee_gst_tin'=>$consignee_gst_tin,'cod_amount'=>$cod_amount,'profit_amount'=>$profit_amount,"destination_center"=>$destination_center,"destination_city"=>$destination_city,"oda"=>$oda,"applied_weight_charge"=>$applied_weight_charge,"applied_fuel_surcharge"=>$applied_fuel_surcharge,"applied_fuel_surcharge_type"=>$applied_fuel_surcharge_type,"applied_cod_charge_min"=>$applied_cod_charge_min,"applied_cod_charge"=>$applied_cod_charge,"applied_cod_charge_type"=>$applied_cod_charge_type,"applied_awb_charge"=>$applied_awb_charge,"applied_fob_surcharge_minimum"=>$applied_fob_surcharge_minimum,"applied_fob_surcharge_percentage"=>$applied_fob_surcharge_percentage,"applied_handeling_charge"=>$applied_handeling_charge,"applied_handeling_charge_type"=>$applied_handeling_charge_type,"applied_cartage_charge"=>$applied_cartage_charge,"applied_cartage_charge_type"=>$applied_cartage_charge_type,"applied_damage_surcharge_min"=>$applied_damage_surcharge_min,"applied_damage_surcharge"=>$applied_damage_surcharge,"applied_damage_surcharge_type"=>$applied_damage_surcharge_type,"applied_oda_surcharge_min"=>$applied_oda_surcharge_min,"applied_oda_surcharge"=>$applied_oda_surcharge,"applied_oda_surcharge_type"=>$applied_oda_surcharge_type,"applied_packaging_surcharge"=>$applied_packaging_surcharge,"applied_packaging_surcharge_type"=>$applied_packaging_surcharge_type,"applied_special_delivery_or_appointment_charge_min"=>$applied_special_delivery_or_appointment_charge_min,"applied_special_delivery_or_appointment_charge"=>$applied_special_delivery_or_appointment_charge,"applied_special_delivery_or_appointment_charge_type"=>$applied_special_delivery_or_appointment_charge_type,"applied_pickup_charge"=>$applied_pickup_charge,"applied_pickup_charge_type"=>$applied_pickup_charge_type,"igst_per"=>$getorder['igst_per'],"sgst_per"=>$getorder['sgst_per'],"cgst_per"=>$getorder['cgst_per'],"igst_amount"=>$igst_amount,"cgst_amount"=>$cgst_amount,"sgst_amount"=>$sgst_amount);
    $updateOrder = $newquery->updateData('orders',$chargeArr,'lr',$lr);
    if($updateOrder){
        $boxIds = $newquery->getData('`id`','box_details','',array('order_id'=>$orderId),'','','');
        for($b = 0; $b < count($boxIds); $b++){
            $newquery->updateData('box_details',array('qty'=>$qty[$b],'dimention'=>$dimention,'length'=>$length[$b],'width'=>$width[$b],'height'=>$height[$b]),'id',$boxIds[$b]['id']);
        }
        $invIds = $newquery->getData('`id`','invoice_details','',array('order_id'=>$orderId),'','','');
        for($c = 0; $c < count($invIds); $c++){
            $newquery->updateData('invoice_details',array('ewaybill'=>$ewaybill[$c],'n_value'=>$n_value[$c],'inv_no'=>$inv_no[$c]),'id',$invIds[$c]['id']);
        }
        $consigneeUpd = $newquery->updateData('consignee_details',array('name'=>$consignee_name,'company'=>$consignee_company,'address'=>$consignee_address,'city'=>$consignee_city,'state'=>$consignee_state,'phone'=>$consignee_phone,'email'=>$consignee_email),'order_id',$orderId);
        $consignerUpd = $newquery->updateData('consigner_details',array('name'=>$consigner_name,'company'=>$consigner_company,'address'=>$consigner_address,'city'=>$consigner_city,'state'=>$consigner_state,'phone'=>$consigner_phone,'email'=>$consigner_email),'order_id',$orderId);
        if($consigneeUpd && $consignerUpd){
            if($getorder['payment_mode'] == "Prepaid" || $getorder['payment_mode'] == "CoD"){
                $refundCharge = $getorder['total_charge'];
            }else{
                $refundCharge = 0;
            }
            $getprevTrans = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
          	if($getprevTrans != 0){
                $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
            }else{
                $merchantTransactionId = 'KINGFISH100000';
            }
            $new_bal = round(($get_user_details['wallet_balance'] + $refundCharge), 2);
              $tdate = date('Y-m-d H:i:s');
              $desc = str_replace("'", "\'", "Order Id: ".$getorder['order_id']."'s total charge refunded");
              $transsArr = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>$refundCharge,"balance"=>$new_bal,"type"=>"Manual","details"=>$desc,"txn_id"=>$merchantTransactionId,"status"=>"Credit");
              $insert_transaction = $newquery->insertData('transactions',$transsArr);
              if($insert_transaction){
                $up_wall = $newquery->updateData($getorder['user_type'],array("wallet_balance"=>$new_bal),'id',$get_user_details['id']);
                  $get_user_detailsN = $newquery->getData('*',$getorder['user_type'],'',array('id'=>$getorder['type_id']),'id','DESC','1')[0];
                if($lr_payment_mode == "Prepaid" || $lr_payment_mode == "CoD"){
                    $new_bal2 = round(($get_user_detailsN['wallet_balance'] - $total_charge), 2);
      	            $desc2 = str_replace("'", "\'", "Order Id: ".$getorder['order_id']."'s charges or details updated and total charge was deducted");
      	            $getprevTrans2 = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                  	if($getprevTrans2 != 0){
                        $merchantTransactionId2 = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans2[0]['txn_id'])+1);
                    }else{
                        $merchantTransactionId2 = 'KINGFISH100000';
                    }
  		            $transsArr2 = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>$total_charge,"balance"=>$new_bal2,"type"=>"Manual","details"=>$desc2,"txn_id"=>$merchantTransactionId2);
      	            $insert_transaction2 = $newquery->insertData('transactions',$transsArr2);
                    if($insert_transaction2){
                        $up_wall2 = $newquery->updateData($getorder['user_type'],array("wallet_balance"=>$new_bal2),'id',$get_user_details['id']);
                        if($up_wall2){
                            $newfunc->alertRedirect("You have successfully updated the LR details",$_SERVER['HTTP_REFERER']);
                        }
                    }else{
                        $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                    }
                }elseif($lr_payment_mode == "To-Pay"){
                    $getprevTransTP = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                  	if($getprevTransTP != 0){
                        $merchantTransactionIdTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransTP[0]['txn_id'])+1);
                    }else{
                        $merchantTransactionIdTP = 'KINGFISH100000';
                    }
      	            $descTP = str_replace("'", "\'", "Order Id: ".$getorder['order_id']."'s charges or details updated for to pay");
                    $transsArrTP = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>'0',"balance"=>$get_user_detailsN['wallet_balance'],"type"=>"Manual","details"=>$descTP,"txn_id"=>$merchantTransactionIdTP);
      	            $insert_transactionTP = $newquery->insertData('transactions',$transsArrTP);
      	            if($insert_transactionTP){
                        $newfunc->alertRedirect("You have successfully updated the LR details",$_SERVER['HTTP_REFERER']);
      	            }else{
      	                $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
      	            }
                }elseif($lr_payment_mode == "Franchise-ToPay"){
                    $getprevTransFTP = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                  	if($getprevTransFTP != 0){
                        $merchantTransactionIdFTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransFTP[0]['txn_id'])+1);
                    }else{
                        $merchantTransactionIdFTP = 'KINGFISH100000';
                    }
      	            $descFTP = str_replace("'", "\'", "Order Id: ".$getorder['order_id']."'s charges or details updated for franchise to pay");
                    $transsArrFTP = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>'0',"balance"=>$get_user_detailsN['wallet_balance'],"type"=>"Manual","details"=>$descFTP,"txn_id"=>$merchantTransactionIdFTP);
      	            $insert_transactionFTP = $newquery->insertData('transactions',$transsArrFTP);
      	            if($insert_transactionFTP){
                        $newfunc->alertRedirect("You have successfully updated the LR details","edit-lr");
      	            }else{
                        $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
      	            }
                }else{
                    $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                }
              }else{
                $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
            }
        }else{
            $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// save change bulk lr update
if(isset($_POST['bulkLRWeightSave'])){
    $newPost = array();
    foreach($_POST as $postkey => $postval):
        $newPost[$postkey] = str_replace("'","\'",$postval);
    endforeach;
    unset($_POST);
    $_POST = $newPost;
    extract($_POST);
    $ext = pathinfo($_FILES['lrWeightFiles']['name'],PATHINFO_EXTENSION);
    if($ext == 'xlsx' || $ext == 'csv'){
		require('excelReader/excel_reader2.php');
        require('excelReader/SpreadsheetReader.php');
        
        $upl = "bulkupdatelrweight".time().".".$ext;
        $uio = "../dyfiles/bulkupdatelr/" . $upl;
        move_uploaded_file($_FILES['lrWeightFiles']['tmp_name'], $uio);
        
        $obj = new SpreadsheetReader($uio);
        $sl = 1;
        foreach($obj as $sheet){
            if($sl != 1 && !empty($sheet[0])){
                $lr  = $sheet[0];
                $length = intval($sheet[1]);
                $width = intval($sheet[2]);
                $height = intval($sheet[3]);
                $weight = round(floatval($sheet[4]), 2);
                $getorder = $newquery->getData('`orders`.*,`box_details`.`qty`','orders',array(array('LEFT','box_details','orders','order_id','box_details','order_id')),array('orders`.`lr'=>$lr),'orders`.`id','DESC','1')[0];
                if($getorder != 0){
                    $get_user_details = $newquery->getData('*',$getorder['user_type'],'',array('id'=>$getorder['type_id']),'id','DESC','1')[0];
                    $valuematricWeight = round(round(($length*$width*$height)/27000, 2)*round(str_replace("CFT", "", $getorder['cft_type'])*$getorder['qty'], 2), 2);
                    if($get_user_details['freight_type'] == "Weight"){
                        if($valuematricWeight < $weight){
                            $frightCharge = round(($getorder['applied_weight_charge']*$weight), 2);
                            $calweight = $weight;
                        }else{
                            $frightCharge = round(($getorder['applied_weight_charge']*$valuematricWeight), 2);
                            $calweight = $valuematricWeight;
                        }
                    }elseif($get_user_details['freight_type'] == "Quantity"){
                        if($valuematricWeight < $weight){
                            $calweight = $weight;
                            $frightCharge = round(($getorder['applied_weight_charge']*$getorder['qty']), 2);
                        }else{
                            $calweight = $valuematricWeight;
                            $frightCharge = round(($getorder['applied_weight_charge']*$getorder['qty']), 2);
                        }
                    }
                    $awb_charge = $getorder['applied_awb_charge'];
                    if($getorder['insurance'] == "No"){
                        $fob_surcharge = $getorder['applied_fob_surcharge_minimum'];
                    }elseif($getorder['insurance'] == "Yes"){
                        $new_fob_surcharge = round($getorder['invoice_amount']*($getorder['applied_fob_surcharge_percentage']/100), 2);
                        $fob_surcharge = ($getorder['applied_fob_surcharge_minimum'] < $new_fob_surcharge)? $new_fob_surcharge : $getorder['applied_fob_surcharge_minimum'];
                    }
                    if($getorder['applied_handeling_charge_type'] == "Quantity"){
                        $handeling_charge = round(($getorder['applied_handeling_charge']*$getorder['qty']), 2);
                    }elseif($getorder['applied_handeling_charge_type'] == "Kg"){
                        $handeling_charge = round(($getorder['applied_handeling_charge']*$calweight), 2);
                    }
                    if(!$getorder['applied_cartage_charge_type']){
                        if($getorder['applied_cartage_charge_type'] == "Quantity"){
                            $cartage_charge = round(($getorder['applied_cartage_charge']*$getorder['qty']), 2);
                        }elseif($getorder['applied_cartage_charge_type'] == "Fixed"){
                            $cartage_charge = $getorder['applied_cartage_charge'];
                        }
                    }else{
                        $cartage_charge = 0;
                    }
                    if($getorder['applied_damage_surcharge_type'] == "Quantity"){
                        $new_damage_surcharge = round(($getorder['applied_damage_surcharge']*$getorder['qty']), 2);
                        if($getorder['applied_damage_surcharge_min'] < $new_damage_surcharge){
                            $damage_surcharge = $new_damage_surcharge;
                        }else{
                            $damage_surcharge = $getorder['applied_damage_surcharge_min'];
                        }
                    }elseif($getorder['applied_damage_surcharge_type'] == "Kg"){
                        $new_damage_surcharge = round(($getorder['applied_damage_surcharge']*$calweight), 2);
                        if($getorder['applied_damage_surcharge_min'] < $new_damage_surcharge){
                            $damage_surcharge = $new_damage_surcharge;
                        }else{
                            $damage_surcharge = $getorder['applied_damage_surcharge_min'];
                        }
                    }
                    if($getorder['oda'] == "true"){
                        if($getorder['applied_oda_surcharge_type'] == "Quantity"){
                            $new_oda_surcharge = round(($getorder['applied_oda_surcharge']*$getorder['qty']), 2);
                            if($getorder['applied_oda_surcharge_min'] < $new_oda_surcharge){
                                $oda_surcharge = $new_oda_surcharge;
                            }else{
                                $oda_surcharge = $getorder['applied_oda_surcharge_min'];
                            }
                        }elseif($getorder['applied_oda_surcharge_type'] == "Kg"){
                            $new_oda_surcharge = round(($getorder['applied_oda_surcharge']*$calweight), 2);
                            if($getorder['applied_oda_surcharge_min'] < $new_oda_surcharge){
                                $oda_surcharge = $new_oda_surcharge;
                            }else{
                                $oda_surcharge = $getorder['applied_oda_surcharge_min'];
                            }
                        }
                    }else{
                        $oda_surcharge = 0;
                    }
                    if($getorder['applied_packaging_surcharge_type'] == "Quantity"){
                        $packaging_surcharge = round(($getorder['applied_packaging_surcharge']*$getorder['qty']), 2);
                    }elseif($getorder['applied_packaging_surcharge_type'] == "Kg"){
                        $packaging_surcharge = round(($getorder['applied_packaging_surcharge']*$calweight), 2);
                    }
                    if($getorder['applied_special_delivery_or_appointment_charge_type'] == "Fixed"){
                        $new_special_delivery_charge = round(($getorder['applied_special_delivery_or_appointment_charge']), 2);
                        if($getorder['applied_special_delivery_or_appointment_charge_min'] < $new_special_delivery_charge){
                            $special_delivery_charge = $new_special_delivery_charge;
                        }else{
                            $special_delivery_charge = $getorder['applied_special_delivery_or_appointment_charge_min'];
                        }
                    }elseif($getorder['applied_special_delivery_or_appointment_charge_type'] == "Percentage"){
                        $new_special_delivery_charge = round(($frightCharge*($getorder['applied_special_delivery_or_appointment_charge']/100)), 2);
                        if($getorder['applied_special_delivery_or_appointment_charge_min'] < $new_special_delivery_charge){
                            $special_delivery_charge = $new_special_delivery_charge;
                        }else{
                            $special_delivery_charge = $getorder['applied_special_delivery_or_appointment_charge_min'];
                        }
                    }
                    if($getorder['applied_pickup_charge_type'] == "Quantity"){
                        $pickup_charge = round(($getorder['applied_pickup_charge']*$getorder['qty']), 2);
                    }elseif($getorder['applied_pickup_charge_type'] == "Kg"){
                        $pickup_charge = round(($getorder['applied_pickup_charge']*$calweight), 2);
                    }
                    if($getorder['applied_fuel_surcharge_type'] == "Fixed"){
                        $fuel_surcharge = round(($getorder['applied_fuel_surcharge']), 2);
                    }elseif($getorder['applied_fuel_surcharge_type'] == "Percentage"){
                        $fuel_surcharge = round(($frightCharge*($getorder['applied_fuel_surcharge']/100)), 2);
                    }
                    $cod_charge = 0;
                    if($getorder['payment_mode'] == "CoD" || $getorder['payment_mode'] == "To-Pay" || $getorder['payment_mode'] == "Franchise-ToPay"){
                        if($getorder['user_type'] == "users"){
                            $cod_charge_check = ($get_user_details['cod_charge_enable_disable'] == "enable")? "yes" : "no";
                        }elseif($getorder['user_type'] == "branches"){
                            $cod_charge_check = "yes";
                        }
                        if($cod_charge_check == "yes" || $getorder['payment_mode'] == "To-Pay" || $getorder['payment_mode'] == "Franchise-ToPay"){
                            if($getorder['applied_cod_charge_type'] == "Fixed"){
                                $new_cod_charge = $getorder['applied_cod_charge'];
                                if($getorder['applied_cod_charge_min'] < $new_cod_charge){
                                    $cod_charge = $new_cod_charge;
                                }else{
                                    $cod_charge = $getorder['applied_cod_charge_min'];
                                }
                            }elseif($getorder['applied_cod_charge_type'] == "Percentage"){
                                $new_cod_charge = round(($frightCharge*($getorder['applied_cod_charge']/100)), 2);
                                if($getorder['applied_cod_charge_min'] < $new_cod_charge){
                                    $cod_charge = $new_cod_charge;
                                }else{
                                    $cod_charge = $getorder['applied_cod_charge_min'];
                                }
                            }
                        }
                    }
                    $before_gst_total_charge = ($frightCharge+$awb_charge+$fuel_surcharge+$fob_surcharge+$handeling_charge+$oda_surcharge+$packaging_surcharge+$cod_charge+$cartage_charge);
                    if($getorder['special_delivery_charge_applied'] == "Yes"){
                        $before_gst_total_charge+=$special_delivery_charge;
                    }else{
                        $special_delivery_charge = 0;
                    }
                    if($getorder['pickup_charge_refunded'] == "No"){
                        $before_gst_total_charge+=$pickup_charge;
                    }else{
                        $pickup_charge = 0;
                    }
                    if($getorder['damage_charge_applied'] == "Yes"){
                        $before_gst_total_charge+=$damage_surcharge;
                    }else{
                        $damage_surcharge = 0;
                    }
                    if($get_user_details['igst'] == "not"){
                        $gst_charge = round((($before_gst_total_charge*($getorder['sgst_per']/100))+($before_gst_total_charge*($getorder['cgst_per']/100))),2);
                        $sgst_amount = round(($before_gst_total_charge*($getorder['sgst_per']/100)),2);
                        $cgst_amount = round(($before_gst_total_charge*($getorder['cgst_per']/100)),2);
                        $igst_amount = 0;
                    }elseif($get_user_details['igst'] == "yes"){
                        $gst_charge = round(($before_gst_total_charge*($getorder['igst_per']/100)),2);
                        $igst_amount = round(($before_gst_total_charge*($getorder['igst_per']/100)),2);
                        $cgst_amount = 0;
                        $sgst_amount = 0;
                    }
                    $total_charge = round(($before_gst_total_charge+$gst_charge), 2);
                    $chargeArr = array("weight"=>$sheet[4],"vol_weight"=>$valuematricWeight,"cod_charge"=>$cod_charge,"fuel_surcharge"=>$fuel_surcharge,"awb_charge"=>$awb_charge,"fob_surcharge"=>$fob_surcharge,"handeling_charge"=>$handeling_charge,"damage_surcharge"=>$damage_surcharge,"oda_surcharge"=>$oda_surcharge,"packaging_surcharge"=>$packaging_surcharge,"special_delivery_charge"=>$special_delivery_charge,"gst_charge"=>$gst_charge,"weight_charge"=>$frightCharge,"cartage_charge"=>$cartage_charge,"total_charge"=>$total_charge,"igst_per"=>$getorder['igst_per'],"sgst_per"=>$getorder['sgst_per'],"cgst_per"=>$getorder['cgst_per'],"igst_amount"=>$igst_amount,"cgst_amount"=>$cgst_amount,"sgst_amount"=>$sgst_amount);
                    $updateOrder = $newquery->updateData('orders',$chargeArr,'lr',$lr);
                    $boxUpdate = $newquery->updateData('box_details',array('length'=>$length,'width'=>$width,'height'=>$height),'id',$newquery->getData('*','box_details','',array('order_id'=>$getorder['order_id']),'id','DESC','1')[0]['id']);
                    if($boxUpdate){
                        $getprevTrans = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                      	if($getprevTrans != 0){
                            $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
                        }else{
                            $merchantTransactionId = 'KINGFISH100000';
                        }
                        if($getorder['payment_mode'] == "Prepaid" || $getorder['payment_mode'] == "CoD"){
                            $refundCharge = $getorder['total_charge'];
                        }else{
                            $refundCharge = 0;
                        }
                        $new_bal = round(($get_user_details['wallet_balance'] + $refundCharge), 2);
          	            $tdate = date('Y-m-d H:i:s');
          	            $desc = str_replace("'", "\'", "Order Id: ".$getorder['order_id']."'s total charge refunded");
      		            $transsArr = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>$refundCharge,"balance"=>$new_bal,"type"=>"Manual","details"=>$desc,"txn_id"=>$merchantTransactionId,"status"=>"Credit");
          	            $insert_transaction = $newquery->insertData('transactions',$transsArr);
                        if($insert_transaction){
                            $up_wall = $newquery->updateData($getorder['user_type'],array("wallet_balance"=>$new_bal),'id',$get_user_details['id']);
          	                $get_user_detailsN = $newquery->getData('*',$getorder['user_type'],'',array('id'=>$getorder['type_id']),'id','DESC','1')[0];
                            if($getorder['payment_mode'] == "Prepaid" || $getorder['payment_mode'] == "CoD"){
                                $get_user_detailsN = $newquery->getData('*',$getorder['user_type'],'',array('id'=>$getorder['type_id']),'id','DESC','1')[0];
                                $new_bal2 = round(($get_user_detailsN['wallet_balance'] - $total_charge), 2);
                  	            $desc2 = str_replace("'", "\'", "Order Id: ".$getorder['order_id']."'s charges or details updated and total charge was deducted");
                  	            $getprevTrans2 = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                              	if($getprevTrans2 != 0){
                                    $merchantTransactionId2 = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans2[0]['txn_id'])+1);
                                }else{
                                    $merchantTransactionId2 = 'KINGFISH100000';
                                }
              		            $transsArr2 = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>$total_charge,"balance"=>$new_bal2,"type"=>"Manual","details"=>$desc2,"txn_id"=>$merchantTransactionId2);
                  	            $insert_transaction2 = $newquery->insertData('transactions',$transsArr2);
                                if($insert_transaction2){
                                    $up_wall2 = $newquery->updateData($getorder['user_type'],array("wallet_balance"=>$new_bal2),'id',$get_user_details['id']);
                                    if(!$up_wall2){
                                        $newfunc->alertRedirect("Row no. '.$sl-1.' is updated! Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                                        break;
                                    }
                                }else{
                                    $newfunc->alertRedirect("Row no. '.$sl-1.' is updated! Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                                    break;
                                }
                            }elseif($getorder['payment_mode'] == "To-Pay"){
                                $getprevTransTP = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                              	if($getprevTransTP != 0){
                                    $merchantTransactionIdTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransTP[0]['txn_id'])+1);
                                }else{
                                    $merchantTransactionIdTP = 'KINGFISH100000';
                                }
                  	            $descTP = str_replace("'", "\'", "Order Id: ".$getorder['order_id']."'s charges or details updated for to pay");
                                $transsArrTP = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>'0',"balance"=>$get_user_detailsN['wallet_balance'],"type"=>"Manual","details"=>$descTP,"txn_id"=>$merchantTransactionIdTP);
                  	            $insert_transactionTP = $newquery->insertData('transactions',$transsArrTP);
                  	            if(!$insert_transactionTP){
                                    $newfunc->alertRedirect("Row no. '.$sl-1.' is updated! Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                                    break;
                  	            }
                            }elseif($getorder['payment_mode'] == "Franchise-ToPay"){
                                $getprevTransFTP = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                              	if($getprevTransFTP != 0){
                                    $merchantTransactionIdFTP = "KINGFISH".(str_replace("KINGFISH","",$getprevTransFTP[0]['txn_id'])+1);
                                }else{
                                    $merchantTransactionIdFTP = 'KINGFISH100000';
                                }
                  	            $descFTP = str_replace("'", "\'", "Order Id: ".$getorder['order_id']."'s charges or details updated for franchise to pay");
                                $transsArrFTP = array("date_time"=>$tdate,"user_type"=>$getorder['user_type'],"user_id"=>$get_user_details['id'],"amount"=>'0',"balance"=>$get_user_detailsN['wallet_balance'],"type"=>"Manual","details"=>$descFTP,"txn_id"=>$merchantTransactionIdFTP);
                  	            $insert_transactionFTP = $newquery->insertData('transactions',$transsArrFTP);
                  	            if(!$insert_transactionFTP){
                                    $newfunc->alertRedirect("Row no. '.$sl-1.' is updated! Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                                    break;
                                }
                            }else{
                                $newfunc->alertRedirect("Row no. '.$sl-1.' is updated! Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                                break;
                            }
                        }else{
                            $newfunc->alertRedirect("Row no. '.$sl-1.' is updated! Something went wrong on update of LR No. '.$lr.'! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                            break;
                        }
                    }
                }
                continue;
            }
            $sl++;
            $before_gst_total_charge = 0;
        }
        $newfunc->alertRedirect("You have successfully updated all LR\'s",$_SERVER['HTTP_REFERER']);
    }
}


// get city and center
function getCenterandCity($pin,$cftType){
    $jwt = apiFunctions::jwtToken($cftType);
    if($jwt != 0){
        $ca = curl_init();
        curl_setopt($ca, CURLOPT_URL, "https://ltl-serviceability.delhivery.com/serviceability/$pin/details/?pincode=$pin");
        curl_setopt($ca, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ca, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $jwt",
            "accept: application/json",
            "cache-control: no-cache",
            "content-type: application/json"
        ));
        $responsePin = curl_exec($ca);
        $errorPin = curl_error($ca);
        curl_close($ca);
        if($errorPin){
            echo $errorPin;
        }else{
            return json_decode($responsePin)->data[0]->center."--".json_decode($responsePin)->data[0]->city;
        }
    }else{
        return 0;
    }
}


// update self drop
if(isset($_POST['saveSelfDrop'])){
    extract($_POST);
    foreach($_POST as $varikey => $varival){
        $selfDropArray[$varikey] = $newfunc->real_string(trim($varival, " "));
    }
    unset($selfDropArray['saveSelfDrop']);
    unset($selfDropArray['orderLR']);
    $tdate = date('Y-m-d H:i:s');
    $getSelfDropD = $newquery->getData('*','orders','',array('lr'=>$orderLR),'id','DESC','1')[0];
    $updSelfDrop = $newquery->updateData('orders',$selfDropArray,'lr',$orderLR);
    if($updSelfDrop){
        if($getSelfDropD['selfdrop_dis_status'] == "Work In Process" && $getSelfDropD['pickup_charge_refunded'] == "No"){
            $getprevTrans = $newquery->getData('*','transactions','',array("txn_id_type"=>"Serial"),'id','DESC','1');
          	if($getprevTrans != 0){
                $merchantTransactionId = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans[0]['txn_id'])+1);
            }else{
                $merchantTransactionId = 'KINGFISH100000';
            }
            $get_user_details = $newquery->getData('*',$getSelfDropD['user_type'],'',array('id'=>$getSelfDropD['type_id']),'id','DESC','1')[0];
            $new_bal = round($get_user_details['wallet_balance'] + $getSelfDropD['pickup_charge'], 2);
            $transsArr = array("date_time"=>$tdate,"user_type"=>$getSelfDropD['user_type'],"user_id"=>$get_user_details['id'],"amount"=>$getSelfDropD['pickup_charge'],"balance"=>$new_bal,"type"=>"Manual","details"=>str_replace("'", "\'", "Order Id: ".$getSelfDropD['order_id']."'s pickup charge refunded due to selfdrop"),"txn_id"=>$merchantTransactionId,"status"=>"Credit");
            $insert_transaction = $newquery->insertData('transactions',$transsArr);
            if($insert_transaction){
                if($newquery->updateData('orders',array('pickup_charge_refunded'=>'Yes'),'lr',$orderLR)){
                    if($newquery->updateData($getSelfDropD['user_type'],array('wallet_balance'=>$new_bal),'id',$getSelfDropD['type_id'])){
                        $nowTotalCharge = round($getSelfDropD['total_charge'] - $getSelfDropD['pickup_charge'], 2);
                        if(!$newquery->updateData('orders',array('total_charge'=>$nowTotalCharge),'lr',$orderLR)){
                            $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                        }
                    }else{
                        $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                    }
                }else{
                    $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
            }
        }
        if(!empty($selfDropArray['selfdrop_amount'])){
            $getprevTrans2 = $newquery->getData('*','transactions','',array("txn_id_type"=>"Serial"),'id','DESC','1');
          	if($getprevTrans != 0){
                $merchantTransactionId2 = "KINGFISH".(str_replace("KINGFISH","",$getprevTrans2[0]['txn_id'])+1);
            }else{
                $merchantTransactionId2 = 'KINGFISH100000';
            }
            $get_user_details2 = $newquery->getData('*',$getSelfDropD['user_type'],'',array('id'=>$getSelfDropD['type_id']),'id','DESC','1')[0];
            $new_bal2 = round(($get_user_details2['wallet_balance'] - $selfDropArray['selfdrop_amount']), 2);
            $transsArr2 = array("date_time"=>$tdate,"user_type"=>$getSelfDropD['user_type'],"user_id"=>$get_user_details2['id'],"amount"=>$selfDropArray['selfdrop_amount'],"balance"=>$new_bal2,"type"=>"Manual","details"=>str_replace("'", "\'", "Order Id: ".$getSelfDropD['order_id']."'s self drop amount deducted"),"txn_id"=>$merchantTransactionId2);
            $insert_transaction2 = $newquery->insertData('transactions',$transsArr2);
            if($insert_transaction2){
                if($newquery->getData($getSelfDropD['user_type'],array('wallet_balance'=>$new_bal2),'id',$getSelfDropD['type_id'])){
                    $updord = $newquery->updateData('orders',array('selfdrop_pay_status'=>'Paid'),'lr',$orderLR);
                    if($updord){
                        $newfunc->alertRedirect("You have successfully updated the self drop",$_SERVER['HTTP_REFERER']);
                    }else{
                        $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                    }
                }else{
                    $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
            }
        }
        $newfunc->alertRedirect("You have successfully updated the self drop",$_SERVER['HTTP_REFERER']);
    }else{
        $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
    }
}


// Previous Invoice Allotment Delete
if(isset($_POST['delPrevInvAllot'])):
    extract($_POST);
    if($newquery->getData('*','stationary_invoice_allotments','',array('id'=>$allotedNumbers),'id','DESC','1')[0]['number_status'] == "Not Started"):
        $delAllot = $newquery->deleteData('stationary_invoice_allotments',array('id'=>$allotedNumbers));
        if($delAllot):
            $newfunc->alertRedirect("You have successfully deleted the allotment",$_SERVER['HTTP_REFERER']);
        else:
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("You can't delete this allotment numbers!",$_SERVER['HTTP_REFERER']);
    endif;
endif;


// previous invoice allotment edit
if(isset($_POST['changeInvoiceStationary'])):
    extract($_POST);
    if($start_allotment_no < $end_allotment_no):
        $invoiceAllots = $newquery->getData('*','stationary_invoice_allotments','',array('id'=>$allotedNumbers),'id','DESC','1')[0];
        $allots = $newquery->getData("*","stationary_invoice_allotments","",[array("stationary_invoice_id","=",$stationary),array("id","!=",$allotedNumbers)],"id","DESC","");
        if($invoiceAllots['number_status'] == "Not Started"):
            $isvalid = 1;
            foreach($allots as $allot):
                for($i = $start_allotment_no; $i <= $end_allotment_no; $i++):
                    if($allot['start_allotment_no'] <= $i && $allot['end_allotment_no'] >= $i):
                        $isvalid = 0;
                        break;
                        break;
                    endif;
                endfor;
            endforeach;
            if($isvalid == 1):
                $updAlloted = $newquery->updateData("stationary_invoice_allotments",array("start_allotment_no"=>$start_allotment_no,"end_allotment_no"=>$end_allotment_no,"stationary_invoice_id"=>$stationary),"id",$allotedNumbers);
                if($updAlloted):
                    $newfunc->alertRedirect("Alloted numbers are successfully edited!",$_SERVER['HTTP_REFERER']);
                else:
                    $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("This numbers are already alloted!",$_SERVER['HTTP_REFERER']);
            endif;
        elseif($invoiceAllots['number_status'] == "Running"):
            unset($allots);
            $allots = $newquery->getData("*","stationary_invoice_allotments","",[array("stationary_invoice_id","=",$invoiceAllots['stationary_invoice_id']),array("id","!=",$allotedNumbers)],"id","DESC","");
            $isvalid = 1;
            if($invoiceAllots['start_allotment_no'] > $end_allotment_no):
                $newfunc->alertRedirect("Start allotment number should less than end!",$_SERVER['HTTP_REFERER']);
            else:
                $invoices = $newquery->getData('*','stationary_invoices','',array('stationary_prefix_id'=>$invoiceAllots['stationary_invoice_id'],'user_type'=>$invoiceAllots['user_type'],'type_id'=>$invoiceAllots['type_id']),'id','DESC','');
                foreach($invoices as $inv):
                    $prefix = $newquery->getData("*","stationaries","",array("id"=>$inv["stationary_prefix_id"]),"id","DESC","1")[0]['stationary_prefix'];
                    $lastInvNumber = str_replace($prefix, "", $inv["invoice_no"]);
                    if($lastInvNumber == $end_allotment_no):
                        $updInvAllot = $newquery->updateData("stationary_invoice_allotments",array("start_allotment_no"=>$start_allotment_no,"end_allotment_no"=>$end_allotment_no,"number_status"=>"End"),"id",$allotedNumbers);
                        if($updInvAllot):
                            $newfunc->alertRedirect("Alloted numbers are successfully edited!",$_SERVER['HTTP_REFERER']);
                        else:
                            $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                        endif;
                    elseif($lastInvNumber < $end_allotment_no):
                        $isvalid = 1;
                        foreach($allots as $allot):
                            for($i = $invoiceAllots['start_allotment_no']; $i <= $end_allotment_no; $i++):
                                if($allot['start_allotment_no'] <= $i && $allot['end_allotment_no'] >= $i):
                                    $isvalid = 0;
                                    break;
                                    break;
                                endif;
                            endfor;
                        endforeach;
                        if($isvalid == 1):
                            $updInvAlloted = $newquery->updateData("stationary_invoice_allotments",array("end_allotment_no"=>$end_allotment_no),"id",$allotedNumbers);
                            if($updInvAlloted):
                                $newfunc->alertRedirect("Alloted numbers are successfully edited!",$_SERVER['HTTP_REFERER']);
                            else:
                                $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                            endif;
                        else:
                            $newfunc->alertRedirect("This numbers are already alloted!",$_SERVER['HTTP_REFERER']);
                        endif;
                    elseif($lastInvNumber > $end_allotment_no):
                        $newfunc->alertRedirect("End allotment number should be greater than last invoice number!",$_SERVER['HTTP_REFERER']);
                    endif;
                endforeach;
                foreach($allots as $allot):
                    if($allot['start_allotment_no'] >= $start_allotment_no && $allot['end_allotment_no'] <= $end_allotment_no):
                        $isvalid = 0;
                        break;
                    endif;
                endforeach;
            endif;
        else:
            $newfunc->alertRedirect("You can't edit this alloted numbers!",$_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("Start allotment number should less than end!",$_SERVER['HTTP_REFERER']);
    endif;
endif;


// Previous Other Allotment Delete
if(isset($_POST['delPrevOthAllot'])):
    extract($_POST);
    if($newquery->getData('*',$stationary_type.'_stationary_allotments','',array('id'=>$allotedNumbers),'id','DESC','1')[0]['number_status'] == "Not Started"):
        $delAllot = $newquery->deleteData($stationary_type.'_stationary_allotments',array('id'=>$allotedNumbers));
        if($delAllot):
            $newfunc->alertRedirect("You have successfully deleted the allotment",$_SERVER['HTTP_REFERER']);
        else:
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("You can't delete this allotment numbers!",$_SERVER['HTTP_REFERER']);
    endif;
endif;


// previous other allotment edit
if(isset($_POST['changeOtherStationary'])):
    extract($_POST);
    if($start_allotment_no < $end_allotment_no):
        $otherAllots = $newquery->getData('*',$stationary_type.'_stationary_allotments','',array('id'=>$allotedNumbers),'id','DESC','1')[0];
        $allots = $newquery->getData("*",$stationary_type."_stationary_allotments","",[array("other_stationary_id","=",$stationary),array("id","!=",$allotedNumbers)],"id","DESC","");
        if($otherAllots['number_status'] == "Not Started"):
            $isvalid = 1;
            foreach($allots as $allot):
                for($i = $start_allotment_no; $i <= $end_allotment_no; $i++):
                    if($allot['start_allotment_no'] <= $i && $allot['end_allotment_no'] >= $i):
                        $isvalid = 0;
                        break;
                        break;
                    endif;
                endfor;
            endforeach;
            if($isvalid == 1):
                $updAlloted = $newquery->updateData($stationary_type."_stationary_allotments",array("start_allotment_no"=>$start_allotment_no,"end_allotment_no"=>$end_allotment_no,"other_stationary_id"=>$stationary),"id",$allotedNumbers);
                if($updAlloted):
                    $newfunc->alertRedirect("Alloted numbers are successfully edited!",$_SERVER['HTTP_REFERER']);
                else:
                    $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("This numbers are already alloted!",$_SERVER['HTTP_REFERER']);
            endif;
        elseif($otherAllots['number_status'] == "Running"):
            unset($allots);
            $allots = $newquery->getData("*",$stationary_type."_stationary_allotments","",[array("other_stationary_id","=",$otherAllots['other_stationary_id']),array("id","!=",$allotedNumbers)],"id","DESC","");
            $isvalid = 1;
            if($otherAllots['start_allotment_no'] > $end_allotment_no):
                $newfunc->alertRedirect("Start allotment number should less than end!",$_SERVER['HTTP_REFERER']);
            else:
                $invoices = $newquery->getData('*','stationary_invoices','',array('stationary_prefix_id'=>$otherAllots['other_stationary_id'],'user_type'=>$otherAllots['user_type'],'type_id'=>$otherAllots['type_id']),'id','DESC','');
                foreach($invoices as $inv):
                    $prefix = $newquery->getData("*","stationaries","",array("id"=>$inv["stationary_prefix_id"]),"id","DESC","1")[0]['stationary_prefix'];
                    $lastInvNumber = str_replace($prefix, "", $inv["invoice_no"]);
                    if($lastInvNumber == $end_allotment_no):
                        $updInvAllot = $newquery->updateData($stationary_type."_stationary_allotments",array("start_allotment_no"=>$start_allotment_no,"end_allotment_no"=>$end_allotment_no,"number_status"=>"End"),"id",$allotedNumbers);
                        if($updInvAllot):
                            $newfunc->alertRedirect("Alloted numbers are successfully edited!",$_SERVER['HTTP_REFERER']);
                        else:
                            $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                        endif;
                    elseif($lastInvNumber < $end_allotment_no):
                        $isvalid = 1;
                        foreach($allots as $allot):
                            for($i = $otherAllots['start_allotment_no']; $i <= $end_allotment_no; $i++):
                                if($allot['start_allotment_no'] <= $i && $allot['end_allotment_no'] >= $i):
                                    $isvalid = 0;
                                    break;
                                    break;
                                endif;
                            endfor;
                        endforeach;
                        if($isvalid == 1):
                            $updInvAlloted = $newquery->updateData($stationary_type."_stationary_allotments",array("end_allotment_no"=>$end_allotment_no),"id",$allotedNumbers);
                            if($updInvAlloted):
                                $newfunc->alertRedirect("Alloted numbers are successfully edited!",$_SERVER['HTTP_REFERER']);
                            else:
                                $newfunc->alertRedirect("Something went wrong! Please contact with administrator immediately",$_SERVER['HTTP_REFERER']);
                            endif;
                        else:
                            $newfunc->alertRedirect("This numbers are already alloted!",$_SERVER['HTTP_REFERER']);
                        endif;
                    elseif($lastInvNumber > $end_allotment_no):
                        $newfunc->alertRedirect("End allotment number should be greater than last invoice number!",$_SERVER['HTTP_REFERER']);
                    endif;
                endforeach;
                foreach($allots as $allot):
                    if($allot['start_allotment_no'] >= $start_allotment_no && $allot['end_allotment_no'] <= $end_allotment_no):
                        $isvalid = 0;
                        break;
                    endif;
                endforeach;
            endif;
        else:
            $newfunc->alertRedirect("You can't edit this alloted numbers!",$_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("Start allotment number should less than end!",$_SERVER['HTTP_REFERER']);
    endif;
endif;


// save bill for email
if(!empty($_POST['data'])){
    $data = $_POST['data'];
    $b64 = $data;
    
    # Decode the Base64 string, making sure that it contains only valid characters
    $bin = base64_decode($b64, true);
    
    # Perform a basic validation to make sure that the result is a valid PDF file
    # Be aware! The magic number (file signature) is not 100% reliable solution to validate PDF files
    # Moreover, if you get Base64 from an untrusted source, you must sanitize the PDF contents
    if(strpos($bin, '%PDF') !== 0){
        throw new Exception('Missing the PDF file signature');
    }
    
    # Write the PDF contents to a local file
    if(file_put_contents('assets/bill.pdf', $bin)){
        echo 1;
    }else{
        echo 0;
    }
}


// generate shipping label
if(isset($_POST['throwOrderLabel'])){
    extract($_POST);
    $throwOrderLabel = $newfunc->real_string(trim($throwOrderLabel, " "));
    $getorder = $newquery->getData('*','orders','',array('lr'=>$throwOrderLabel),'id','DESC','1')[0];
    if(!empty($getorder['generate_labels'])){
        $labels = explode(',',$getorder['generate_labels']);
        $sls = 1;
        $countData = count($labels);
        foreach($labels as $file){
            $showlabels = $showlabels.'<div class="row mb-3">
                                      <div class="col-md-8 d-flex justify-content-center"><h5>';
            if($countData == $sls){
                $showlabels = $showlabels.'Documents';
            }else{
                $showlabels = $showlabels.'Box '.$sls.' label';
            }
            $showlabels = $showlabels.' label : </h5></div>
                          <div class="col-md-4"><a download href="../shippingLabels/'.$file.'" class="btn btn-sm me-1 shadow dwn-btn">Download <i class="bi bi-download"></i></a></div>
                         </div>';
            $sls++;
        }
        echo $showlabels;
    }else{
        $loginFields = array(
            "username" => "KINGFISH10B2BC",
            "password" => "Jaishreeshyam@2025"
        );
        $cs = curl_init();
        curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
        curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
        curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cs, CURLOPT_HTTPHEADER, array(
          "accept: application/json",
          "cache-control: no-cache",
          "content-type: application/json"
        ));
        $response = curl_exec($cs);
        $error = curl_error($cs);
        curl_close($cs);
        if($error){
          echo $error;
        }
        else{
            $resp = json_decode($response);
            $jwt = $resp->jwt;
            $cf = curl_init();
            curl_setopt($cf, CURLOPT_URL, "https://btob.api.delhivery.com/v3/get-label-urls/a4/$throwOrderLabel?document=true");
            curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cf, CURLOPT_HTTPHEADER, array(
              "Authorization: Bearer $jwt",
              "accept: application/json",
              "cache-control: no-cache",
              "content-type: application/json",
              "conection: keep-alive"
            ));
            $lblresponse = curl_exec($cf);
            $lblerror = curl_error($cf);
            curl_close($cf);
            if($lblerror){
              echo $lblerror;
            }
            else{
                $result = json_decode($lblresponse);
                if($result->success == 1 && !empty($result->data)){
                    $sl = 1;
                    $labelsArr = '';
                    $lblUrl = '';
                    $countData = count($result->data);
                    foreach($result->data as $labels){
                        $pdf_base64 = file_get_contents($labels);
                        $uri = substr($pdf_base64,strpos($pdf_base64,",")+1);
                        $lbl = $throwOrderLabel."-".time()."label".$sl.".png";
                        file_put_contents('../shippingLabels/'.$lbl, base64_decode($uri));
                        $labelsArr = $labelsArr.'<div class="row mb-3">
                                      <div class="col-md-8 d-flex justify-content-center"><h5>';
                        if($countData == $sl){
                            $labelsArr = $labelsArr.'Documents';
                        }else{
                            $labelsArr = $labelsArr.'Box '.$sl.' label';
                        }
                        $labelsArr = $labelsArr.' label : </h5></div>
                                      <div class="col-md-4"><a download href="../shippingLabels/'.$lbl.'" class="btn btn-sm me-1 shadow dwn-btn">Download <i class="bi bi-download"></i></a></div>
                                     </div>';
                        $lblUrl = $lblUrl.",".$lbl;
                        $sl++;
                    }
                    $upd = $newquery->updateData('orders',array('generate_labels'=>trim($lblUrl,",")),'lr',$throwOrderLabel);
                    if($upd){
                        echo $labelsArr;
                    }
                }else{
                    echo 0;
                }
            }
        }
    }
}


// checking reference number
// if(!empty($_POST['startAllotmentNo']) && !empty($_POST['endAllotmentNo'])){
//     extract($_POST);
//     $valid = 0;
//     $allotednumbers = $newquery->getData('*','reference_number_allotment','','','id','DESC','');
//     if($allotednumbers != 0){
//         foreach($allotednumbers as $numbers){
//             for($i = $startAllotmentNo; $i <= $endAllotmentNo; $i++){
//                 if($numbers['start_allotment_no'] <= $i && $numbers['end_allotment_no'] >= $i){
//                     $valid = 1;
//                     break 2;
//                 }
//             }
//         }
//     }else{
//         $valid = 0;
//     }
//     echo $valid;
// }


// submit allotment number
if(isset($_POST['addAllotment'])){
    extract($_POST);
    $valid = 0;
    $allotednumbers = $newquery->getData('*','reference_number_allotment','','','id','DESC','');
    if($allotednumbers != 0){
        foreach($allotednumbers as $numbers){
            for($i = $startAllotmentNo; $i <= $endAllotmentNo; $i++){
                if($numbers['start_allotment_no'] <= $i && $numbers['end_allotment_no'] >= $i){
                    $valid = 1;
                    break 2;
                }
            }
        }
    }else{
        $valid = 0;
    }
    if($valid == 1){
        $newfunc->alertRedirect("This number is already alloted! can't be alloted!",$_SERVER['HTTP_REFERER']);
    }elseif($valid == 0){
        if($userType == "users"){
            $username = 'username';
        }elseif($userType == "branches"){
            $username = 'branch_user_name';
        }
        $type_id = $newquery->getData('*',$userType,'',array($username=>$userIs),'id','DESC','1')[0]['id'];
        $addAllot = $newquery->insertData('reference_number_allotment',array('user_type'=>$userType,'type_id'=>$type_id,'start_allotment_no'=>$startAllotmentNo,'end_allotment_no'=>$endAllotmentNo));
        if($addAllot){
            $newfunc->alertRedirect("Ref. number successfully alloted to this ".trim(trim($userType, 's'), 'es'),$_SERVER['HTTP_REFERER']);
        }
    }
}


// get 3pls for add and edit (user and branch)
if(isset($_POST['get3plsFor'])){
    $get3plsFor = $_POST['get3plsFor'];
    echo '<option hidden value="">Choose 3PL</option>';
    if($get3plsFor == "Weight"){
        echo '<option value="all">All</option>';
    }
    $sel3pl = $newquery->getData('*','3pls','','','','','');
    if($sel3pl != 0){
        foreach($sel3pl as $var3){
            echo '<option value="'.$var3["id"].'">'.$var3["api_token_name"].'</option>';
        }
    }
}


// Open user / branch account
if(!empty($_GET['openAccUsertype']) && !empty($_GET['openAccUsernameFor'])):
    extract($_GET);
    $usernametype = ($openAccUsertype == "users")? "username" : "branch_user_name";
    $getdetails = $newquery->getData("*",$openAccUsertype,"",array($usernametype=>$openAccUsernameFor),"id","DESC","1");
    if($getdetails != 0):
        if($openAccUsertype == "users"):
            $_SESSION['username'] = $getdetails[0]['username'];
            $_SESSION['user_id'] = $getdetails[0]['id'];
            $newfunc->alertRedirect("You have successfully logged in", "https://b2b.kingfishlogistics.in/user/");
        elseif($openAccUsertype == "branches"):
            $_SESSION['branchusername'] = $getdetails[0]['branch_user_name'];
            $_SESSION['branchuser_id'] = $getdetails[0]['id'];
            $newfunc->alertRedirect("You have successfully logged in", "https://b2b.kingfishlogistics.in/branch/");
        endif;
    else:
        echo '<script type="text/javascript" language="javascript">alert("No '.trim(trim($openAccUsertype, "s"), "es") .' Found!");window.close();</script>';
    endif;
endif;


?>