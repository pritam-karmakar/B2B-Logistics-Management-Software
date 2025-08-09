<?php
if(isset($_GET['lr']))
{
    include("../../database/db.php");
    include("../../functions/api-Functions.php");
    require('vendor/autoload.php');
    $getLrs = explode(",", $_GET['lr']);
    $query = new query();
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    foreach($getLrs as $lr){
        $order_cond = array("lr"=>$lr);
        $order_details = $query->getData('*','orders','',$order_cond,'','','');
        
        $order_id = $order_details[0]['order_id'];
        $del_pin = $order_details[0]['del_pin'];
        $consgn_cond = array("order_id"=>$order_id);
        $get_consignee_details = $query->getData('*','consignee_details','',$consgn_cond,'','','')[0];
        $box_cond = array("order_id"=>$order_id);
        $get_box_details = $query->getData('*','box_details','',$box_cond,'','','');
        $box_count = count($get_box_details);
        $getwarehouse = $query->getData('*','warehouses','',array('id'=>$order_details[0]['warehouse_id']),'id','DESC','1')[0];
        
        $shipper_details = $query->getData('*',$order_details[0]['user_type'],'',array('id'=>$order_details[0]['type_id']),'id','DESC','1')[0];
        
        $get_invoice_details = $query->getData('*','invoice_details','',array("order_id"=>$order_id),'','','');
        
        if($order_details[0]['user_type']=='branches'){
            $consigner_cond = array("order_id"=>$order_id);
            $get_consigner_details = $query->getData('*','consigner_details','',$consigner_cond,'','','')[0];
        }
        $cft_type = $order_details[0]['cft_type'];
        $response = apiFunctions::pincodeServiceAbility($del_pin, $cft_type);
        if($response == 0):
            echo "Something went wrong!";
        else:
            $response_array = json_decode($response, true);
            $center = $response_array['data'][0]['center'];
            $words = explode('_', $center);
            $first_three_words = array_slice($words, 0, 2);
            $uppercased_words = array_map('strtoupper', $first_three_words);
            $three_words = substr($uppercased_words[0],0,3).'/'.substr($uppercased_words[1],0,3);
        endif;
?>
    <!DOCTYPE html>
    <html class="no-js" lang="en">
    
        <head>
            <!-- Meta Tags -->
            <meta charset="utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="author" content="Casfus">
            <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        
            <!-- Site Title -->
            <title>Kingfish Logistics || Waybill Copy</title>
            <style>
                @media print {
                    .table-container {
                        page-break-before: always;
                        border-collapse: collapse;
                        border:none;
                    }
                }
                
                *[_ngcontent-c4] {
                    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
                }
                div {
                    display: block;
                    unicode-bidi: isolate;
                }
                .table-container[_ngcontent-c4] {
                    /*width: 740px;*/
                    overflow: hidden;
                    margin: 0px auto 15px;
                    display:flex;
                    justify-content:center;
                }
                .table[_ngcontent-c4] {
                    float: left;
                    padding: 10px;
                    width: 800px;
                }
                table[Attributes Style] {
                    -webkit-border-horizontal-spacing: 0px;
                    -webkit-border-vertical-spacing: 0px;
                }
                ::-webkit-scrollbar {
                    width: 10px;
                }
                
                ::-webkit-scrollbar-thumb {
                    background: #888;
                }
                ::-webkit-scrollbar-track {
                    background: #f1f1f1;
                }
                tbody {
                    display: table-row-group;
                    vertical-align: middle;
                    unicode-bidi: isolate;
                    border-color: inherit;
                }
               
                table.table {
                    border-collapse: separate;
                    text-indent: initial;
                    border-spacing: 2px;
                }
                tr {
                    display: table-row;
                    vertical-align: inherit;
                    unicode-bidi: isolate;
                    border-color: inherit;
                }
                .table[_ngcontent-c4] > tbody[_ngcontent-c4] > tr[_ngcontent-c4] > td[_ngcontent-c4] {
                    border-top: 0;
                }
                .border[_ngcontent-c4] {
                    border: 1px solid #000000;
                }
                table[_ngcontent-c4] th[_ngcontent-c4], table[_ngcontent-c4] td[_ngcontent-c4] {
                    font-size: 11px;
                    vertical-align: top;
                }
                table {
                    display: table;
                    border-collapse: separate;
                    box-sizing: border-box;
                    text-indent: initial;
                    unicode-bidi: isolate;
                    border-spacing: 0px;
                    border-color: none;
                }
               
                table[_ngcontent-c4] th[_ngcontent-c4], table[_ngcontent-c4] td[_ngcontent-c4] {
                    font-size: 11px;
                    vertical-align: top;
                }
                .border-3-sides[_ngcontent-c4] {
                    border-right: 1px solid #000000;
                    border-bottom: 1px solid #000000;
                    border-left: 1px solid #000000;
                }
                img {
                    overflow-clip-margin: content-box;
                    overflow: clip;
                }
                .font-15[_ngcontent-c4] {
                    font-size: 15px !important;
                }
                td[_ngcontent-c4] h4[_ngcontent-c4] {
                font-size: 16px;
                }
                .bold[_ngcontent-c4] {
                    font-weight: bold;
                }
                .float-right[_ngcontent-c4] {
                    float: right;
                }
                .line-38[_ngcontent-c4] {
                    line-height: 38px;
                }
                .margin-0[_ngcontent-c4] {
                    margin: 0;
                }
                .display-inline[_ngcontent-c4] {
                    display: inline;
                }
                
                .font-20[_ngcontent-c4] {
                    font-size: 20px;
                }
                h1[_ngcontent-c4], h2[_ngcontent-c4], h3[_ngcontent-c4], h4[_ngcontent-c4], h5[_ngcontent-c4], h6[_ngcontent-c4] {
                    color: #333333;
                    font-weight: 300;
                    margin-bottom: 10px;
                    margin-top: 10px;
                }
                
                h4 {
                    display: block;
                    margin-block-start: 1.33em;
                    margin-block-end: 1.33em;
                    margin-inline-start: 0px;
                    margin-inline-end: 0px;
                    font-weight: bold;
                    unicode-bidi: isolate;
                }
                .border-right[_ngcontent-c4] {
                    border-right: 1px solid #000000;
                }
                .padding-6[_ngcontent-c4] {
                    padding: 6px;
                }
                b[_ngcontent-c4], strong[_ngcontent-c4] {
                    font-weight: 600;
                    font-size: 15px;
                }
                .vert-mid-pad-6[_ngcontent-c4] {
                    vertical-align: middle;
                    padding: 6px;
                }
                .row-1-column-1[_ngcontent-c4] {
                    border-right: 1px solid #000000;
                    font-size: 12px;
                }
                p{
                    margin-block:0px;
                }
                
                @media print {
                    .table-container table {
                        page-break-inside: avoid; /* Avoid breaking tables across pages */
                    }
                }
            </style>
        </head>
    
        <body>
        <?php
            $no_ofbox = $query->getData('SUM(`qty`) as "totalBoxes"','box_details','',$box_cond,'id','DESC','1')[0]['totalBoxes'];
            for($w=1;$w<=5;$w++){
        ?>  <div _ngcontent-c4="" class="table-container">
                <table _ngcontent-c4="" cellpadding="0" cellspacing="0" class="table" id="waybill">
                    <tbody _ngcontent-c4="">
                        <tr _ngcontent-c4="">
                            <td _ngcontent-c4="">
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1" width="30%">
                                                <img _ngcontent-c4="" src="main-logo.jpg"  width="200" >
                                            </td>
                                            <td _ngcontent-c4="" align="center" class="row-1-column-1" style="padding-top: 30px;font-size: 15px;" width="20%">
                                               <span><b>Date: </b><?= $order_details[0]['order_date']; ?></span>
                                            </td>
                                            <td _ngcontent-c4="" align="left" class="row-1-column-2" style="padding-top: 30px;"  width="15%">
                                                <strong _ngcontent-c4="" style="font-size: 15px;"><?= $order_details[0]['lr']; ?></strong><span _ngcontent-c4=""
                                                    class="" style="font-size: 13px;"></span>
                                            </td>
                                            <td _ngcontent-c4="" align="center" class="row-1-column-2"  width="35%">
                                                <div _ngcontent-c4="" barcode-gen="" id="<?= $new_master; ?>"
                                                    style="padding: 0px; overflow: auto;margin-top: 5px;">
                                                    <?php echo $generator->getBarcode($order_details[0]['lr'], $generator::TYPE_CODE_128); ?>
                                                    <div style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 15px; margin-top: 5px;">
                                                        <?= $order_details[0]['lr']; ?></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <div style="display:flex;justify-content:space-between;">
                                                    <span _ngcontent-c4="" align="left"><b>1.From</b></span>
                                                    <span _ngcontent-c4="" align="right"><b>Drop Off <input type="checkbox"></b></span>
                                                </div>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-2" width="50%">
                                                <div style="display:flex;justify-content:space-between;">
                                                    <span _ngcontent-c4="" align="left"><b>4.To</span>
                                                    <span _ngcontent-c4="" align="right"><b>Self Collect <input type="checkbox"></b></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <p _ngcontent-c4="" align="left"><b>Shipper's Name: <?php if($order_details[0]['user_type']=='users'){echo $shipper_details['username'];}else{$get_consigner_details['name'];} ?></b></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-2" width="50%">
                                                <p _ngcontent-c4=""  align="left"><b>Recipient's Name: <?= $get_consignee_details['name']; ?></b></p>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <p _ngcontent-c4="" align="left"><b>Shipper's Phone: <?php if($order_details[0]['user_type']=='users'){echo $shipper_details['mobile_no'];}else{echo $get_consigner_details['phone'];} ?></b></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-2" width="50%">
                                                <p _ngcontent-c4=""  align="left"><b>Recipient's Phone: <?= $get_consignee_details['phone']; ?></b></p>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <p _ngcontent-c4="" align="left"><b>Shipper's Company: <?php if($order_details[0]['user_type']=='users'){echo '';}else{echo $get_consigner_details['name'].','.$get_consigner_details['company'];} ?></b></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-2" width="50%">
                                                <p _ngcontent-c4=""  align="left"><b>Recipient's Company: <?= $get_consignee_details['company']; ?></b></p>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:7px" width="15%">
                                                <p _ngcontent-c4="" align="left"><b>City: </b><?= $getwarehouse['city']; ?></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:7px" width="20%">
                                                <p _ngcontent-c4="" align="left"><b>State: </b><?= $getwarehouse['state']; ?></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-1" style="margin-bottom: 0;padding-bottom:7px"  width="15%">
                                                <p _ngcontent-c4=""  align="left"><b>Pincode: </b><?= $getwarehouse['pincode']; ?></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:7px" width="15%">
                                                <p _ngcontent-c4="" align="left"><b>City: </b><?= $get_consignee_details['city']; ?></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:7px" width="20%">
                                                <p _ngcontent-c4="" align="left"><b>State: </b><?= $get_consignee_details['state']; ?></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-2" style="margin-bottom: 0;padding-bottom:7px"  width="15%">
                                                <p _ngcontent-c4=""  align="left"><b>Pincode: </b><?= $order_details[0]['del_pin']; ?></p>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:20px;" width="50%">
                                                <p _ngcontent-c4="" align="left"><b>Street Name: </b><?= $getwarehouse['address']; ?></p>
                                            </td>
                                            <td _ngcontent-c4=""  style="margin-bottom: 0;padding-bottom:20px;" class="row-1-column-2" width="50%">
                                                <p _ngcontent-c4=""  align="left"><b>Street Name: </b><?= $get_consignee_details['address']; ?></p>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <p _ngcontent-c4="" align="left" style="text-transform: uppercase;"><b>GST No: </b><?= $order_details[0]['seller_gst_tin']; ?></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-2" width="50%">
                                                <p _ngcontent-c4=""  align="left" style="text-transform: uppercase;"><b>GST No: </b><?= $order_details[0]['consignee_gst_tin']; ?></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <p _ngcontent-c4="" align="left"><b>2.Shipment's Information</b></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-2" width="50%">
                                                <p _ngcontent-c4=""  align="left"><b>Client/Store/Address Code:</b></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <p _ngcontent-c4="" align="left"><b>SHIPPER'S REFERENCE NO. (25 characters): </b></p>
                                                <p style="font-size:15px;"><?= $order_details[0]['order_id']; ?></p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-1" width="20%" >
                                                <p _ngcontent-c4=""  align="left"><b>5.MOT:</b></p>
                                                <p _ngcontent-c4=""  align="left">Air <input type="checkbox"></p>
                                                <p _ngcontent-c4=""  align="left">Ground <input type="checkbox"></p>
                                            </td>
                                            <td  _ngcontent-c4="" class="row-1-column-2" width="30%" >
                                                <p _ngcontent-c4=""  align="left"><b>6.SPECIAL HANDLING:</b></p>
                                                <span  _ngcontent-c4=""  align="left">FRAGILE <input type="checkbox"></span>
                                                <span _ngcontent-c4=""  align="left">HEAVY (>30 KG) <input type="checkbox"></span><br>
                                                <span  _ngcontent-c4=""  align="left">DG <input type="checkbox"></span>
                                                <span _ngcontent-c4=""  align="left">VAL CARGO. <input type="checkbox"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="25%">
                                                <p _ngcontent-c4="" align="left"><b>Invoice No: </b>
                                                    <?php
                                                    $count_records = count($get_invoice_details); 
                                                    for($i=0; $i<=1; $i++) { 
                                                        echo $get_invoice_details[$i]['inv_no']; 
                                                        if ($i==0 && $count_records > 1) {
                                                            echo ', ';
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-1" width="25%">
                                                <p _ngcontent-c4=""  align="left"><b>EWBN: </b>
                                                    <?php
                                                    $count_records = count($get_invoice_details); 
                                                    for($i=0; $i<=1; $i++) { 
                                                        echo $get_invoice_details[$i]['ewaybill']; 
                                                        if ($i==0 && $count_records > 1) {
                                                            echo ', ';
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </td>
                                            <td width="50%">
                                                <p _ngcontent-c4=""  align="left">POD on Invoice:</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="display:flex;">
                                    <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="50%">
                                        <tbody _ngcontent-c4="">
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-1"
                                                    style="margin-bottom: 0;padding-bottom:0" width="35%">
                                                    <p _ngcontent-c4="" align="left"><b>TOTAL INVOICE VALUE: </b><span style="font-size:15px;"><b><?= round($order_details[0]['invoice_amount']); ?></b></span></p>
                                                </td>
                                                <td _ngcontent-c4="" class="row-1-column-2" width="40%">
                                                    <p _ngcontent-c4=""  align="left"><b>Master Id: </b><span style="font-size:15px;"><b><?= $order_details[0]['master_waybill']; ?></b></span></p>
                                                </td>
                                                
                                            </tr>
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-1"
                                                    style="margin-bottom: 0;padding-bottom:0;border-top:1px solid;" width="35%">
                                                    <b>BOXES DIMENSION (LxWxH) cm</b>
                                                </td>
                                                <td _ngcontent-c4="" class="row-1-column-1"  style="margin-bottom: 0;padding-bottom:0;border-top:1px solid;"width="35%">
                                                    <b>DESCRIPTION</b>
                                                </td>
                                                <td _ngcontent-c4="" class="row-1-column-2" style="margin-bottom: 0;padding-bottom:0;border-top:1px solid;" width="30%">
                                                    <b>TOTAL WEIGHT</b>
                                                </td>
                                            </tr>
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-1"
                                                    style="margin-bottom: 0;padding-bottom:10px;border-top:1px solid;" width="35%">
                                                    <?php 
                                                    for($i=0;$i<$box_count;$i++)
                                                    {
                                                        $length = $get_box_details[$i]['length'];
                                                        $width = $get_box_details[$i]['width'];
                                                        $height = $get_box_details[$i]['height'];
                                                        if($get_box_details[$i]['dimention'] == 'inch')
                                                        {
                                                            $length *= 2.54*$length;
                                                            $width *= 2.54*$width;
                                                            $height *= 2.54*$height;
                                                        }
                                                        ?><u style="font-size: 12px;"><?= $get_box_details[$i]['qty'].' : '.$length.'*'.$width.'*'.$height; ?><br></u><?php
                                                    }
                                                    ?>
                                                </td>
                                                <td _ngcontent-c4="" class="row-1-column-1"  style="margin-bottom: 0;padding-bottom:10px;border-top:1px solid;"width="35%">
                                                    <p><?= $order_details[0]['description']; ?></p>
                                                </td>
                                                <td _ngcontent-c4="" class="row-1-column-2" style="margin-bottom: 0;padding-bottom:10px;border-top:1px solid;" width="30%">
                                                    <p><?= $order_details[0]['vol_weight'].'KGS'; ?></p>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    <table _ngcontent-c4="" cellpadding="5" cellspacing="0" style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;" width="50%">
                                        <tbody _ngcontent-c4="">
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-1"
                                                    style="margin-bottom: 0;padding-bottom:0" width="40%">
                                                    <p _ngcontent-c4="" align="left"><b>Insurance:</b></p>
                                                    <p  _ngcontent-c4=""  align="left">FOV <input type="checkbox"></p>
                                                    <p  _ngcontent-c4=""  align="left">MARINE VALUE <input type="checkbox"></p>
                                                    <span>......</span>
                                                </td>
                                                <td _ngcontent-c4="" class="row-1-column-2" width="60%">
                                                    <p _ngcontent-c4=""  align="left"><b>Payment:</b></p>
                                                    <span  _ngcontent-c4=""  align="left">TRANSPORT: SHIPPER <input type="checkbox"></span>
                                                    <span  _ngcontent-c4=""  align="left">RECIPIENT<input type="checkbox"></span><br>
                                                    <span  _ngcontent-c4=""  align="left">DUTIES & TAXES:SHIPPER<input type="checkbox"></span>
                                                    <span  _ngcontent-c4=""  align="left">RECIPIENT<input type="checkbox"></span><br>
                                                    <span  _ngcontent-c4=""  align="left">CASH ON DELIVERY<input type="checkbox"></span><br>
                                                    <span  _ngcontent-c4=""  align="left"><?php if($order_details[0]['payment_mode'] == "Prepaid" || $order_details[0]['payment_mode'] == "CoD"){ echo "COD Amount:"; }else{
                                                    echo "To-Pay Amount:"; } ?> ₹<?php if($order_details[0]['payment_mode'] == "CoD"){ echo $order_details[0]['cod_amount']; }elseif($order_details[0]['payment_mode'] == "Prepaid"){ echo 0; }elseif($order_details[0]['payment_mode'] == "To-Pay"){ echo $order_details[0]['total_charge']; }else{ echo $order_details[0]['total_charge']+$order_details[0]['profit_amount']; } ?></span><br>
                                                    <span  _ngcontent-c4=""  align="left">CHEQUE ON DELIVERY<input type="checkbox"></span><br>
                                                      CHEQUE BENEFICIARY'S NAME:&nbsp;<span>..................</span>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div style="display:flex;">
                                    <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="50%">
                                        <tbody _ngcontent-c4="">
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-2"
                                                    style="margin-bottom: 0;padding-bottom:10px;" width="100%">
                                                    
                                                    <p _ngcontent-c4="" align="left">TOTAL NUMBER OF BOXES:<?= $no_ofbox; ?></p>
                                                    <p>DOCUMENT RECEIVED: <span>INVOICE ( )<input type="checkbox"></span> <span>TAX FORMS ( )<input type="checkbox"></span>  <span>OTHERs ( )<input type="checkbox"></span>
                                                    </p>
                                                    <p>No. Of DOCUMENTS:</p>
                                                </td>
                                            </tr>
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-2" style="margin-bottom: 0;padding-bottom:10px;border-top:1px solid;" width="100%">
                                                    <b>REQUIRED SIGNATURE - ORIGIN:</b>
                                                </td>
                                            </tr>
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-2" style="margin-bottom: 0;padding-bottom:10px;" width="100%">
                                                    <div style="display:flex;justify-content:space-between;">
                                                        <span>EMP ID:..............</span><span>SHIPPER'S SIGN:..............</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table _ngcontent-c4="" cellpadding="5" cellspacing="0" style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;" width="50%">
                                        <tbody _ngcontent-c4="">
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-2" style="margin-bottom: 0;padding-bottom:30px;"  width="40%">
                                                    <b>REQUIRED SIGNATURE - DESTINATION:</b>
                                                    <p>RECIPIENT'S SIGNATURE AND STAMP:</p>
                                                </td>
                                            </tr>
                                            <tr _ngcontent-c4="">
                                                <td _ngcontent-c4="" class="row-1-column-2" style="margin-bottom: 0;padding-bottom:0px;"  width="40%">
                                                    <div style="display:flex;justify-content:space-between;">
                                                        <span>DATE..............</span><span>TIME..............</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                    
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" style="border-left: 1px solid #000000;border-right: 1px solid #000000;border-bottom: 1px solid #000000;" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:5px" width="70%">
                                                <p _ngcontent-c4="" align="left">	
                                                    KINGFISH LOGISTICS. REGISTERED OFFICE: Plot-315, Phase-2 Industrial Area, Panchkula-134113<br>					
                                                	CONTACT NUMBER: +91 9915993324. PAN: IRJPS0802Q GSTN : 02IRJPS0802Q1ZE<br>
                                                	<!--CIN : U60231RJ2019PTC065495<br>			-->
                                                	FOR TERMS & CONDITIONS, VISIT <a href="https://kingfishlogistics.in/" target="_blank">www.kingfishlogistics.in</a>
                                                </p>
                                            </td>
                                            <td _ngcontent-c4="" class="row-1-column-2" style="padding-top:35px"  width="30%">
                                                <p _ngcontent-c4=""  align="right"><b><?php if($w==1){echo'SHIPPER COPY';}elseif($w==2){echo'ORIGIN/ACCOUNTS COPY';}elseif($w==3){echo'REGULATORY COPY';}elseif($w==4){echo'LM POD';}elseif($w==5){echo'RECIPIENT COPY';} ?></b></p>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <?php
            }
            ?>
            
        </body>
        <!-- Include html2pdf.js library -->
       
    </html>
<?php
    }
}
else{
    echo header('location:../all_orders');
}
 ?>
