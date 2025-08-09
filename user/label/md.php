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
        $order_cond = array("lr"=>$lr,);
        $order_details = $query->getData('*','orders','',$order_cond,'','','');
        if($order_details != 0){
            $order_id = $order_details[0]['order_id'];
            $del_pin = $order_details[0]['del_pin'];
            $consgn_cond = array("order_id"=>$order_id);
            $get_consignee_details = $query->getData('*','consignee_details','',$consgn_cond,'','','')[0];
            $box_cond = array("order_id"=>$order_id);
            $get_box_details = $query->getData('*','box_details','',$box_cond,'','','');
            foreach($get_box_details as $boxes){
                $box_count[$lr] = $box_count[$lr]+$boxes['qty'];
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
    <title>Kingfish Logistics || 4*2.5 Label</title>
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
            for($i=0;$i<$box_count[$lr];$i++)
            {
            ?>
            <table cellpadding="0" cellspacing="0" class="table-container" style="width:4in;height:2in; overflow:hidden;margin: 0px auto 47px;">
            <tbody>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" class="table" style="border: 0 2px 2px 2px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <table cellpadding="5" cellspacing="0" height="100%" style="border-right: 2px solid #000000;border-top: 2px solid #000000" width="100%">
                                            <tbody><tr>
                                                <td align="center" style="border-right: 2px solid #000000;border-left: 2px solid #000000;padding-bottom:0;" width="70%">
                                                    <div barcode-gen="" id="<?= $lr; ?>" style="padding: 0px; overflow: auto; width: 242px;">
                                                        <?php echo $generator->getBarcode($lr, $generator::TYPE_CODE_128); ?>
                                                        <div style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 15px; margin-top: 5px;"><?= $lr; ?></div>
                                                    </div>
                                                </td>
                                                <td style="margin: 0; line-height: 9pt; font-size:10px;text-align: center;" width="30%">
                                                    <p style="margin: 0; font-size:12px;text-overflow: clip;overflow: hidden">
                                                        <strong><?= $registered_name; ?></strong>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                        <table cellpadding="5" cellspacing="0" style="border: 2px solid #000000;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="border-right: 2px solid #000000;color: #333333; font-size: 16px; vertical-align: middle; padding:0 3px;" width="27%">
                                                        <strong><?= $order_id; ?></strong>
                                                    </td>
                                                    <td style="border-right: 2px solid #000000;  font-size: 12px; padding: 5px 4px;text-align:center;" width="51%">
                                                        <span ng-if="package?.etc?.store_code">
                                                            <strong style="font-size:14px"></strong>
                                                        </span>
                                                    </td>
                                                    <td align="right" style="color:#333333; font-size:16px;vertical-align: middle;padding:0px;text-align: center" width="22%">
                                                        <strong><?= $i+1; ?>/<?= $box_count[$lr]; ?></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellpadding="5" cellspacing="0" style="border-right: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="border-right: 2px solid #000000;  font-size: 12px; padding: 5px 4px; text-align:center;" width="56%">
                                                        <span ng-if="package?.destination">
                                                            <strong style="font-size:12px;"><?= $center; ?></strong>
                                                        </span>
                                                    </td>
                                                    <td style="font-size: 10px; padding: 5px 2px;text-align:center;" width="37%">
                                                        <p style="margin:0"><strong>MAWB:</strong></p>
                                                        <p style="margin:0"><strong><?= $order_details[0]['master_waybill']; ?></strong></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellpadding="5" cellspacing="0" style="border-right: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size:12px;padding:2px;">
                                                        <p style="margin: 0; line-height: 11pt;height:60px;font-size:12px;text-overflow: clip;overflow: hidden">
                                                            <strong><?= $get_consignee_details['name'];?>, <?= $get_consignee_details['address'];?>, City: <?= $get_consignee_details['city'];?>, State: <?= $get_consignee_details['state'];?>, PIN: <?= $del_pin;?></strong>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellpadding="2" cellspacing="4" style="border-right: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="padding: 5px;" width="100%">
                                                    <?php if($i==0){$new_waybill=$order_details[0]['master_waybill'];}else{$new_waybill =  $waybills[$i];} ?>
                                                    <div barcode-gen="" id="<?= $new_waybill; ?>" style="padding: 0px; overflow: auto; width: 264px;">
                                                        <?php echo $generator->getBarcode($new_waybill, $generator::TYPE_CODE_128); ?>
                                                        <div style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 15px; margin-top: 5px;"><?= $new_waybill; ?></div>
                                                    </div>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
        
        <table cellpadding="0" cellspacing="0" class="table-container" style="width:4in;height:2in; overflow:hidden;margin: 0px auto 47px;">
            <tbody>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" class="table" style="border: 0 2px 2px 2px solid #000000;" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <table cellpadding="5" cellspacing="0" height="100%" style="border-right: 2px solid #000000;border-top: 2px solid #000000" width="100%">
                                            <tbody><tr>
                                                <td align="center" style="border-right: 2px solid #000000;border-left: 2px solid #000000;padding-bottom:0;" width="70%">
                                                    <div barcode-gen="" id="<?= $lr; ?>" style="padding: 0px; overflow: auto; width: 242px;">
                                                        <?php echo $generator->getBarcode($lr, $generator::TYPE_CODE_128); ?>
                                                        <div style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 15px; margin-top: 5px;"><?= $lr; ?></div>
                                                    </div>
                                                </td>
                                                <td style="margin: 0; line-height: 9pt; font-size:10px;text-align: center;" width="30%">
                                                    <p style="margin: 0; font-size:12px;text-overflow: clip;overflow: hidden">
                                                        <strong><?= $registered_name; ?></strong>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                        <table cellpadding="5" cellspacing="0" style="border: 2px solid #000000;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="border-right: 2px solid #000000;color: #333333; font-size: 16px; vertical-align: middle; padding:0 3px;" width="27%">
                                                        <strong><?= 'DOC_'.$order_details[0]['lr']; ?></strong>
                                                    </td>
                                                    <td style="border-right: 2px solid #000000;  font-size: 12px; padding: 5px 4px;text-align:center;" width="51%">
                                                        <span ng-if="package?.etc?.store_code">
                                                            <strong style="font-size:14px"></strong>
                                                        </span>
                                                    </td>
                                                    <td align="right" style="color:#333333; font-size:16px;vertical-align: middle;padding:0px;text-align: center" width="22%">
                                                        <strong><?= 'DOC'; ?></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellpadding="5" cellspacing="0" style="border-right: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="border-right: 2px solid #000000;  font-size: 12px; padding: 5px 4px; text-align:center;" width="56%">
                                                        <span ng-if="package?.destination">
                                                            <strong style="font-size:12px;"><?= $center; ?></strong>
                                                        </span>
                                                    </td>
                                                    <td style="font-size: 10px; padding: 5px 2px;text-align:center;" width="37%">
                                                        <p style="margin:0"><strong>MAWB:</strong></p>
                                                        <p style="margin:0"><strong><?= $order_details[0]['master_waybill']; ?></strong></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellpadding="5" cellspacing="0" style="border-right: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size:12px;padding:2px;">
                                                        <p style="margin: 0; line-height: 11pt;height:60px;font-size:12px;text-overflow: clip;overflow: hidden">
                                                            <strong><?= $get_consignee_details['name'];?>, <?= $get_consignee_details['address'];?>, City: <?= $get_consignee_details['city'];?>, State: <?= $get_consignee_details['state'];?>, PIN: <?= $del_pin;?></strong>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellpadding="2" cellspacing="4" style="border-right: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="padding: 5px;" width="100%">
                                                    
                                                    <div barcode-gen="" id="<?= $order_details[0]['doc_waybill']; ?>" style="padding: 0px; overflow: auto; width: 264px;">
                                                        <?php echo $generator->getBarcode($order_details[0]['doc_waybill'], $generator::TYPE_CODE_128); ?>
                                                        <div style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 15px; margin-top: 5px;"><?= $order_details[0]['doc_waybill'];?></div>
                                                    </div>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
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