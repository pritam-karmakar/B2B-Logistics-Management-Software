<?php
include("database/db.php");
include("functions/all-functions.php");
$newquery = new query();
$newfunc = new allfunctions();
date_default_timezone_set("Asia/Kolkata");
$charges = $newquery->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];


if(isset($_GET['getLRs'])){
    $lrs = "(".$_GET['getLRs'].")";
    $lrArray = array(array("lr","IN",$lrs));
    $order_details = $newquery->getData('*,`orders`.`status` as "order_status",`order_items`.`item` as "product_type"','orders',array(array('LEFT','warehouses','warehouses','id','orders','warehouse_id'),array('LEFT','order_items','order_items','id','orders','item_type')),$lrArray,'orders`.`id','DESC','');
    if($order_details != 0){
        $report[] = array('Order Id','LR No.','Master Waybill No.','Manifested Date','Pickup Date','Delivered Date','Invoice No.','Ewaybill','Count of Boxes','Consignor Name','Consignee Name','Warehouse Name','Origin Center','Destination Center','Origin City','Destination City','Origin Pincode','Destination Pincode','Billing Type','Product Type','Product Name','Client Reference No.','Invoice Value','COD Amount','Profit Amount','Status','Rate','Weight','Volumatric Weight','Freight Charge','ROV/Insurance','ODA','COD Charge','Fuel Surcharge','AWB Charge','FOV Surcharge','Handeling Charge','Cartage Charge','Pickup Charge','Damarage Surcharge','ODA Surcharge','Packaging Surcharge','Special Delivery / Appointment Charge','Sub Total','Discount Amount','IGST','CGST','SGST','Total Amount','Client GSTIN','Delhivery GSTIN','HSN','CFT');
        $slub = 1;
        foreach($order_details as $order){
            $getUserTypeDetails = $newquery->getData('*',$order['user_type'],'',array('id'=>$order['type_id']),'','','')[0];
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
            $boxCount[$slub] = $newquery->getData('SUM(`qty`) as "box_count"','box_details','',array('order_id'=>$order['order_id']),'id','DESC','')[0]['box_count'];
            $subtotalCharge = round($order['total_charge']-($order['igst_amount']+$order['cgst_amount']+$order['sgst_amount']), 2);
            $consignee = $newquery->getData('*','consignee_details','',array('order_id'=>$order['order_id']),'id','DESC','1')[0];
            if($order['user_type'] == "branches"){
                $consigner = $newquery->getData('*','consigner_details','',array('order_id'=>$order['order_id']),'id','DESC','1')[0];
            }elseif($order['user_type'] == "users"){
                $consigner = $getUserTypeDetails['party_name'];
            }
            if(empty($order['weight_charge'])){ $order['weight_charge'] = 0; }
            $report[] = array($order['order_id'],$order['lr'],$order['master_waybill'],$order['order_date']." ".date_format(date_create($order['order_time']), "H:i:s"),$order['pickup_date'],$order['delivered_date'],$inv_numbers,$ewaybills,$boxCount[$slub],$consigner,$consignee['name'],$order['warehouse_name'],$order['origin_center'],$order['destination_center'],$order['origin_city'],$order['destination_city'],$order['pick_pin'],$order['del_pin'],$order['payment_mode'],$order['product_type'],$order['description'],$order['subident'],$order['invoice_amount'],$order['cod_amount'],$order['profit_amount'],$order['order_status'],round($order['weight_charge']/$order['weight'], 2),$order['weight'],$order['vol_weight'],$order['weight_charge'],$order['insurance'],$order['oda'],$order['cod_charge'],$order['fuel_surcharge'],$order['awb_charge'],$order['fob_surcharge'],$order['handeling_charge'],$order['cartage_charge'],$order['pickup_charge'],$order['damage_surcharge'],$order['oda_surcharge'],$order['packaging_surcharge'],$order['special_delivery_charge'],$subtotalCharge,0,$order['igst_amount'],$order['cgst_amount'],$order['sgst_amount'],$order['total_charge'],$order['seller_gst_tin'],$order['consignee_gst_tin'],$order['hsn'],$order['cft_type']);
            $slub++;
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
    }
}
"<script type='text/javascript' language='javascript'>window.opener = self;window.close();</script>";