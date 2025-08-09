<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include(__DIR__ . "/database/db.php");
$newquery = new query();
date_default_timezone_set("Asia/Kolkata");

// Define the base directory
$baseDir = __DIR__ . "/";

$logfile = $baseDir.'userLogFile.log';
file_put_contents($logfile, "User's MIS Script started at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

try {
    $company = $newquery->getData('*','company_master','',array('id'=>'1'),'id','DESC','1')[0];
    
    
    $userType = 'users';
    $previousDate = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
    $getUsersBranches = $newquery->getData('*',$userType,'',array('delete_status'=>'show','status'=>'Unblock'),'id','DESC','');
    if($getUsersBranches != 0){
        foreach($getUsersBranches as $usersbranches){
            $showusercond = array(array("orders`.`user_type","=",$userType),array("orders`.`type_id","=",$usersbranches['id']),array('orders`.`order_date','=',$previousDate));
            $order_details = $newquery->getData('*,`orders`.`status` as "order_status",`order_items`.`item` as "product_type"','orders',array(array('LEFT','warehouses','warehouses','id','orders','warehouse_id'),array('LEFT','order_items','order_items','id','orders','item_type')),$showusercond,'orders`.`id','DESC','');
            if($order_details != 0){
                $usname = $usersbranches['username'];
                $report[] = array('Order Id','LR No.','Master Waybill No.','Manifested Date','Pickup Date','Delivered Date','Invoice No.','Ewaybill','Count of Boxes','Party Name (username)','Consignor Name','Consignee Name','Warehouse Name','Origin Center','Destination Center','Origin City','Destination City','Origin Pincode','Destination Pincode','Billing Type','Product Type','Product Name','Client Reference No.','Invoice Value','COD Amount','Profit Amount','Status','Rate','Weight','Volumatric Weight','Freight Charge','ROV/Insurance','ODA','COD Charge','Fuel Surcharge','AWB Charge','FOV Surcharge','Handeling Charge','Cartage Charge','Pickup Charge','Damarage Surcharge','ODA Surcharge','Packaging Surcharge','Special Delivery / Appointment Charge','Sub Total','Discount Amount','IGST','CGST','SGST','Total Amount','Client GSTIN','Delhivery GSTIN','HSN','CFT');
                $slu = 1;
                $boxCount = array();
                $delivered = 0;
                $undelivered = 0;
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
                    if($order['status'] == "Delivered" || $order['status'] == "DELIVERED"){
                        $delivered++;
                    }else{
                        $undelivered++;
                    }
                    $boxCount[$slu] = $newquery->getData('SUM(`qty`) as "box_count"','box_details','',array('order_id'=>$order['order_id']),'id','DESC','')[0]['box_count'];
                    $subtotalCharge = round($order['total_charge']-($order['igst_amount']+$order['cgst_amount']+$order['sgst_amount']), 2);
                    if(empty($order['cartage_charge'])){ $cartageCharge = 0; }else{ $cartageCharge = $order['cartage_charge']; }
                    $consignee = $newquery->getData('*','consignee_details','',array('order_id'=>$order['order_id']),'id','DESC','1')[0];
                    if(empty($order['weight_charge'])){ $order['weight_charge'] = 0; }
                    $report[] = array($order['order_id'],$order['lr'],$order['master_waybill'],$order['order_date']." ".date_format(date_create($order['order_time']), "H:i:s"),$order['pickup_date'],$order['delivered_date'],$inv_numbers,$ewaybills,$boxCount[$slu],$getUser['party_name']." (username: ".$getUser['username'].")",$getUser['party_name'],$consignee['name'],$order['warehouse_name'],$order['origin_center'],$order['destination_center'],$order['origin_city'],$order['destination_city'],$order['pickup_pin'],$order['del_pin'],$order['payment_mode'],$order['product_type'],$order['description'],$order['subident'],$order['invoice_amount'],$order['cod_amount'],$order['profit_amount'],$order['order_status'],round($order['weight_charge']/$order['weight'], 2),$order['weight'],$order['vol_weight'],$order['weight_charge'],$order['insurance'],$order['oda'],$order['cod_charge'],$order['fuel_surcharge'],$order['awb_charge'],$order['fob_surcharge'],$order['handeling_charge'],$cartageCharge,$order['pickup_charge'],$order['damage_surcharge'],$order['oda_surcharge'],$order['packaging_surcharge'],$order['special_delivery_charge'],$subtotalCharge,0,$order['igst_amount'],$order['cgst_amount'],$order['sgst_amount'],$order['total_charge'],$order['seller_gst_tin'],$order['consignee_gst_tin'],$order['hsn'],$order['cft_type']);
                    $slu++;
                    unset($inv_no);
                    unset($eway_no);
                }
                ob_start();
                $downloadFile = fopen("assets/".date("d-m-Y").'_mis_report_of_'.$usname.'.csv', 'w');
                $sl = 0;
                foreach($report as $row){
                    if(count($report) != $sl){
                        fputcsv($downloadFile, $row);
                    }
                    $sl++;
                }
                fclose($downloadFile);
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=".date("d-m-Y").'_mis_report_of_'.$usname.".csv");
                $messagename = $usersbranches['party_name'];
                $filename = date("d-m-Y").'_mis_report_of_'.$usname.'.csv';
                $file = 'assets/'.$filename;
                $content = file_get_contents($file);
                $content = chunk_split(base64_encode($content));
                $uid = md5(uniqid(time()));
                $file_name = basename($file);
                $message = "Hello,\n\nGreetings from Kingfish.\n\nPlease find attachment MIS Report.\nHope this helps you to keep track of all the consignments.\nYou may get in touch with your SPOC for any further assistance.\n\nShipment's Status Summary:\nDelivered: $delivered\nUndelivered: $undelivered\nReturned: 0\n\n\nRegards,\nKingfish Logistics";
                $replyto = 'noreply@kingfishlogistics.in';
                $from_name = 'Kingfish Logistics';
                $mailto = $usersbranches['email'];
                $from_mail = $company['email_id'];
                $subject = "MIS Report ".date('d M, Y')." for ".$messagename;
                
                // header
                $header = "From: " . $from_name . " <" . $from_mail . ">\r\n";
                $header .= "Reply-To: " . $replyto . "\r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
                
                // message & attachment
                $nmessage = "--" . $uid . "\r\n";
                $nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
                $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $nmessage .= $message . "\r\n\r\n";
                $nmessage .= "--" . $uid . "\r\n";
                $nmessage .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\r\n";
                $nmessage .= "Content-Transfer-Encoding: base64\r\n";
                $nmessage .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"\r\n\r\n";
                $nmessage .= $content . "\r\n\r\n";
                $nmessage .= "--" . $uid . "--";
                
                if(mail($mailto, $subject, $nmessage, $header)){
                    if(unlink($file)){
                        sleep(15);
                        unset($report);
                        echo $usname."'s MIS report successfully sent. ";
                        continue;
                    }
                }
            }
        }
    }
} catch (Exception $e) {
    file_put_contents($logfile, "\User's MIS Error: " . $e->getMessage() . "\n", FILE_APPEND);
}

file_put_contents($logfile, "\nUser's MIS Script ended at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
?>