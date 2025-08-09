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
    <title>Kingfish Logistics || 4*2 Label</title>
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
        <table cellpadding="0" cellspacing="0" class="table-container" id="printThermalPackingSlips" style="width:4in; height: 2in; overflow: hidden; margin: 5px auto 0px;">
            <tbody>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" style="border: 1px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding:0px 5px;" width="5%">
                                        <img src="main-logo.jpg" style="padding:1px 0px;" width="85">
                                    </td>
                                    <td style="color: #333333; font-size: 12px; vertical-align: middle;padding:0px 5px;" width="45%">
                                        <!---->
                                        <strong>ORDER-ID : <?= $order_id; ?></strong>
                                    </td>
                                    <td align="right" style="color: #333333; font-size: 12px; vertical-align: middle; padding:0px 5px;" width="40%">
                                        <strong>Date : <?= $order_details[0]['order_date']; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;text-align:center;" width="100%">
                            <tbody>
                                <tr>
                                    <!---->
                                    <td style="border-right: 1px solid #000000;  font-size: 12px; padding:0 2px;" width="22%">
                                        <strong>Box: <?= $i+1; ?>/<?= $box_count; ?></strong>
                                    </td>
                                    <!---->
                                    <td style="border-right: 1px solid #000000;  font-size: 12px; padding: 0 2px;text-align:center;" width="58%">
                                        <!---->
                                    </td>
                                    <td style="color: #333333; font-size: 12px; vertical-align: middle; padding:0 2px;" width="20%">
                                        <strong><?= $three_words; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="border-right: 1px solid #000000; font-size: 12px; padding:0 5px;text-align:center;">
                                        <p style="font-weight:bolder; margin: 0;color:#000000 !important">LRN: <?= $order_details[0]['lr']; ?></p>
                                    </td>
                                    <td style="font-size: 12px; padding:0 2px;text-align:center;">
                                        <strong><?= $center; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!---->
                        <!---->
                        <table cellpadding="0" cellspacing="0" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="font-size: 13px; padding:5px 5px;">
                                        <p style="font-weight:600; margin: 0">Consignee Address: </p>
                                        <p style="margin: 0; line-height: 9pt; font-size:10px;">
                                            <strong><?= $get_consignee_details['name'];?>, <?= $get_consignee_details['address'];?>, City: <?= $get_consignee_details['city'];?>, State: <?= $get_consignee_details['state'];?>, PIN: <?= $del_pin;?></strong>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellpadding="2" cellspacing="0" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td align="center" style="padding-top: 5px;padding-bottom: 5px;" width="100%">
                                        <?php if($i==0){$new_waybill=$order_details[0]['master_waybill'];}else{$new_waybill =  $waybills[$i];} ?>
                                        <div barcode-gen="" id="<?= $new_waybill; ?>" style="padding: 0px; overflow: auto; width: 264px;margin-top: 2px;">
                                            <?php echo $generator->getBarcode($new_waybill, $generator::TYPE_CODE_128); ?>
                                            <div
                                                style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 12px;">
                                                <?= $new_waybill; ?></div>
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
        <table cellpadding="0" cellspacing="0" class="table-container" id="printThermalPackingSlips" style="width:4in; height: 2in; overflow: hidden; margin: 5px auto 0px;">
            <tbody>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" style="border: 1px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding:0px 5px;" width="5%">
                                        <img src="main-logo.jpg" style="padding:1px 0px;" width="85">
                                    </td>
                                    <td style="color: #333333; font-size: 12px; vertical-align: middle;padding:0px 5px;" width="45%">
                                        <!---->
                                        <strong>ORDER-ID : <?= 'DOC_'.$order_details[0]['lr']; ?></strong>
                                    </td>
                                    <td align="right" style="color: #333333; font-size: 12px; vertical-align: middle; padding:0px 5px;" width="40%">
                                        <strong>Date : <?= $order_details[0]['order_date']; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;text-align:center;" width="100%">
                            <tbody>
                                <tr>
                                    <!---->
                                    <td style="border-right: 1px solid #000000;  font-size: 12px; padding:0 2px;" width="22%">
                                        <strong><?= 'Documents'; ?></strong>
                                    </td>
                                    <!---->
                                    <td style="border-right: 1px solid #000000;  font-size: 12px; padding: 0 2px;text-align:center;" width="58%">
                                        <!---->
                                    </td>
                                    <td style="color: #333333; font-size: 12px; vertical-align: middle; padding:0 2px;" width="20%">
                                        <strong><?= $three_words; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="border-right: 1px solid #000000; font-size: 12px; padding:0 5px;text-align:center;">
                                        <p style="font-weight:bolder; margin: 0;color:#000000 !important">LRN: <?= $order_details[0]['lr']; ?></p>
                                    </td>
                                    <td style="font-size: 12px; padding:0 2px;text-align:center;">
                                        <strong><?= $center; ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!---->
                        <!---->
                        <table cellpadding="0" cellspacing="0" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="font-size: 13px; padding:5px 5px;">
                                        <p style="font-weight:600; margin: 0">Consignee Address: </p>
                                        <p style="margin: 0; line-height: 9pt; font-size:10px;">
                                            <strong><?= $get_consignee_details['name'];?>, <?= $get_consignee_details['address'];?>, City: <?= $get_consignee_details['city'];?>, State: <?= $get_consignee_details['state'];?>, PIN: <?= $del_pin;?></strong>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellpadding="2" cellspacing="0" style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td align="center" style="padding-top: 5px;padding-bottom: 5px;" width="100%">
                                        <div barcode-gen="" id="<?= $order_details[0]['doc_waybill']; ?>" style="padding: 0px; overflow: auto; width: 264px;margin-top: 2px;">
                                            <?php echo $generator->getBarcode($order_details[0]['doc_waybill'], $generator::TYPE_CODE_128); ?>
                                            <div
                                                style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 12px;">
                                                <?= $order_details[0]['doc_waybill']; ?></div>
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
