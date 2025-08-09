<?php
if(!empty($_GET['lr']))
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
        if($order_details != 0){
            $order_id = $order_details[0]['order_id'];
            $del_pin = $order_details[0]['del_pin'];
            $consgn_cond = array("order_id"=>$order_id);
            $get_consignee_details = $query->getData('*','consignee_details','',$consgn_cond,'','','')[0];
            $box_cond = array("order_id"=>$order_id);
            $get_box_details = $query->getData('*','box_details','',$box_cond,'','','');
            foreach($get_box_details as $boxes){
                $box_count = $box_count+$boxes['qty'];
            }
            $getwarehouse = $query->getData('*','warehouses','',array('id'=>$order_details[0]['warehouse_id']),'id','DESC','1')[0];
            
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
        }
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
    <title>Kingfish Logistics || 3*2 Label</title>
    <!--<link rel="stylesheet" href="assets2/css/style.css">-->
    <style>
        @media print {
            @media print {
            .table-container {
                page-break-before: always;
                border-collapse: collapse;
                border:none;
            }
        }
        }
        *[_ngcontent-c4] {
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .section-container{
            display:flex;
            justify-content:center;
            overflow: hidden;
            margin-top: 20px;
        }
        div {
            display: block;
            unicode-bidi: isolate;
        }
        
        table {
            display: table;
            /*border-collapse: separate;*/
            box-sizing: border-box;
            text-indent: initial;
            unicode-bidi: isolate;
            border-spacing: 0px;
            /*border-color: none;*/
        }
    </style>
</head>
<body>
    <div _ngcontent-c4="section-container">
        <?php
        $waybills = explode('|',$order_details[0]['waybills']);
            for($i=0;$i<$box_count;$i++)
            {
        ?>
        <table _ngcontent-c7="" cellpadding="0" cellspacing="0" class="table-container" id="printThermalPackingSlips" style="width:3in; height: 2in; overflow: hidden; margin: 0px auto 47px;">
            <tbody _ngcontent-c7="">
                <tr _ngcontent-c7="">
                    <td _ngcontent-c7="">
                        <table _ngcontent-c7="" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;" width="100%">
                            <tbody _ngcontent-c7="">
                                <tr _ngcontent-c7="">
                                    <td _ngcontent-c7="" style="width:1in; height: 1in; padding:0px;">
                                      <div _ngcontent-c7=""  style="padding-left:8px;">
                                        <img src='https://qrcode.tec-it.com/API/QRCode?data=<?php if($i==0){echo $new_waybill=$order_details[0]['master_waybill'];}else{echo $new_waybill =  $waybills[$i];} ?>' style="width: 80px; height: 80px;" id="barcodeCanvas-0_0" >
                                      </div>
                                    </td>
                                    <td _ngcontent-c7="" style="width:2in; height: 1in; padding:0px;">
                                        <table>
                                            <tbody _ngcontent-c7="">
                                                <tr _ngcontent-c7="">
                                                    <td _ngcontent-c7="" style="width:2in; height: 0.25in; border-bottom: 1px solid #000000; border-left: 1px solid #000000; text-align:center; font-size: 12px; padding:0px;">
                                                      <strong _ngcontent-c7="">LR: <?= $order_details[0]['lr']; ?></strong>
                                                    </td>
                                                </tr>
                                                <tr _ngcontent-c7="">
                                                    <td _ngcontent-c7="" style="width:2in; height: 0.25in; border-bottom: 1px solid #000000; border-left: 1px solid #000000; text-align:center; font-size: 12px; padding:0px;">
                                                      <strong _ngcontent-c7="">MAWB: <?= $order_details[0]['master_waybill']; ?> </strong>
                                                    </td>
                                                </tr>
                                                <tr _ngcontent-c7="">
                                                    <td _ngcontent-c7="" style="width:2in; height: 0.25in; border-bottom: 1px solid #000000; border-left: 1px solid #000000; text-align:center; font-size: 12px; padding:0px;">
                                                      <strong _ngcontent-c7="">Box Count: <?= $i+1; ?>/<?= $box_count; ?></strong>
                                                    </td>
                                                </tr>
                                                <tr _ngcontent-c7="">
                                                    <td _ngcontent-c7="" style="width:2in; height: 0.25in; text-align:center; font-size: 12px; border-left: 1px solid #000000; padding:0px;">
                                                      <p _ngcontent-c7="" style="margin: 0;color:#000000 !important">Client: <?= $registered_name; ?></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table _ngcontent-c7="" cellpadding="0" cellspacing="0" style="width:3in; height: 0.16in; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;">
                            <tbody _ngcontent-c7="">
                                <tr _ngcontent-c7="">
                                    <td _ngcontent-c7="" style="width:1in; height: 0.16in; text-align:center; padding:0px;">
                                        <p _ngcontent-c7="" style="margin: 0;color:#000000 !important; font-size: 10px;">LM Pincode: <?= $del_pin;?></p>
                                    </td>
                                    <td _ngcontent-c7="" style="width:2in; height: 0.16in; border-left: 1px solid #000000; text-align:center; font-size: 10px; padding:0px;">
                                        <p _ngcontent-c7="" style="margin: 0;color:#000000 !important">OID: <?= $order_id; ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table _ngcontent-c7="" cellpadding="0" cellspacing="0" style="width:3in; height: 0.84in; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;text-align:center;">
                            <tbody _ngcontent-c7="">
                                <tr _ngcontent-c7="">
                                    <td _ngcontent-c7="" align="center" style="padding-top: 0px;padding-bottom: 0;" width="100%">
                                        <?php if($i==0){$new_waybill=$order_details[0]['master_waybill'];}else{$new_waybill =  $waybills[$i];} ?>
                                        <div _ngcontent-c7="" barcode-gen="" id="<?= $new_waybill; ?>" style="padding: 0px; overflow: auto; width: 264px;">
                                            <?php echo $generator->getBarcode($new_waybill, $generator::TYPE_CODE_128); ?>
                                            <div style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 13px; margin-top: 5px;"><?= $new_waybill; ?></div>
                                        </div>
                                    </td>
                                </tr>
                          </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
            }
        ?>
        <table _ngcontent-c7="" cellpadding="0" cellspacing="0" class="table-container" id="printThermalPackingSlips" style="width:3in; height: 2in; overflow: hidden; margin: 0px auto 47px;">
            <tbody _ngcontent-c7="">
                <tr _ngcontent-c7="">
                    <td _ngcontent-c7="">
                        <table _ngcontent-c7="" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;" width="100%">
                            <tbody _ngcontent-c7="">
                                <tr _ngcontent-c7="">
                                    <td _ngcontent-c7="" style="width:1in; height: 1in; padding:0px;">
                                      <div _ngcontent-c7=""  style="padding-left:8px;">
                                        <img src='https://qrcode.tec-it.com/API/QRCode?data=<?= $order_details[0]['doc_waybill']; ?>' style="width: 80px; height: 80px;" id="barcodeCanvas-0_0" >
                                      </div>
                                    </td>
                                    <td _ngcontent-c7="" style="width:2in; height: 1in; padding:0px;">
                                        <table>
                                            <tbody _ngcontent-c7="">
                                                <tr _ngcontent-c7="">
                                                    <td _ngcontent-c7="" style="width:2in; height: 0.25in; border-bottom: 1px solid #000000; border-left: 1px solid #000000; text-align:center; font-size: 12px; padding:0px;">
                                                      <strong _ngcontent-c7="">LR: <?= $order_details[0]['lr']; ?></strong>
                                                    </td>
                                                </tr>
                                                <tr _ngcontent-c7="">
                                                    <td _ngcontent-c7="" style="width:2in; height: 0.25in; border-bottom: 1px solid #000000; border-left: 1px solid #000000; text-align:center; font-size: 12px; padding:0px;">
                                                      <strong _ngcontent-c7="">MAWB: <?= $order_details[0]['master_waybill']; ?> </strong>
                                                    </td>
                                                </tr>
                                                <tr _ngcontent-c7="">
                                                    <td _ngcontent-c7="" style="width:2in; height: 0.25in; border-bottom: 1px solid #000000; border-left: 1px solid #000000; text-align:center; font-size: 12px; padding:0px;">
                                                      <strong _ngcontent-c7="">Box Count: <?= 'Documents'; ?></strong>
                                                    </td>
                                                </tr>
                                                <tr _ngcontent-c7="">
                                                    <td _ngcontent-c7="" style="width:2in; height: 0.25in; text-align:center; font-size: 12px; border-left: 1px solid #000000; padding:0px;">
                                                      <p _ngcontent-c7="" style="margin: 0;color:#000000 !important">Client: <?= $registered_name; ?></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table _ngcontent-c7="" cellpadding="0" cellspacing="0" style="width:3in; height: 0.16in; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;">
                            <tbody _ngcontent-c7="">
                                <tr _ngcontent-c7="">
                                    <td _ngcontent-c7="" style="width:1in; height: 0.16in; text-align:center; padding:0px;">
                                        <p _ngcontent-c7="" style="margin: 0;color:#000000 !important; font-size: 10px;">LM Pincode: <?= $del_pin;?></p>
                                    </td>
                                    <td _ngcontent-c7="" style="width:2in; height: 0.16in; border-left: 1px solid #000000; text-align:center; font-size: 10px; padding:0px;">
                                        <p _ngcontent-c7="" style="margin: 0;color:#000000 !important">OID: <?= 'DOC_'.$order_details[0]['lr']; ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table _ngcontent-c7="" cellpadding="0" cellspacing="0" style="width:3in; height: 0.84in; border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;text-align:center;">
                            <tbody _ngcontent-c7="">
                                <tr _ngcontent-c7="">
                                    <td _ngcontent-c7="" align="center" style="padding-top: 0px;padding-bottom: 0;" width="100%">
                                        <div _ngcontent-c7="" barcode-gen="" id="<?= $order_details[0]['doc_waybill']; ?>" style="padding: 0px; overflow: auto; width: 264px;">
                                            <?php echo $generator->getBarcode($order_details[0]['doc_waybill'], $generator::TYPE_CODE_128); ?>
                                            <div style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 13px; margin-top: 5px;"><?= $order_details[0]['doc_waybill']; ?></div>
                                        </div>
                                    </td>
                                </tr>
                          </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  
    <script src="assets2/js/jquery.min.js"></script>
    <script src="assets2/js/jspdf.min.js"></script>
    <script src="assets2/js/html2canvas.min.js"></script>
    <script src="assets2/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById("inv_download_btn").addEventListener("click", ()=> {
            const invoice = this.document.getElementById("inv_download");
            const fnm = $("#filenm").children("b").text();
            var option = {
                margin: 1,
                filename: fnm+'.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'A4', orientation: 'portrait' }
            };
            html2pdf().from(invoice).set(option).save();
        });
    </script>
</body>
</html>
<?php
    }
}else{
    echo "<script type='text/javascript'>
        closeCurrentWindow();
    </script>";
}
?>