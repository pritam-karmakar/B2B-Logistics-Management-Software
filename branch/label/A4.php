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
        foreach($get_box_details as $boxes){
            $box_count[$lr] = $box_count[$lr]+$boxes['qty'];
        }
        $getwarehouse = $query->getData('*','warehouses','',array('id'=>$order_details[0]['warehouse_id']),'id','DESC','1')[0];
        
        $cft_type = $order_details[0]['cft_type'];
        
        $cond =array("api_token_name"=>$cft_type);
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
            <title>Kingfish Logistics || A4 Label</title>
            <style>
                *[_ngcontent-c4] {
                    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
                }
                div {
                    display: block;
                    unicode-bidi: isolate;
                }
                .table-container[_ngcontent-c4] {
                    width: 740px;
                    overflow: hidden;
                    margin: 0px auto 15px;
                }
                .table[_ngcontent-c4] {
                    float: left;
                    padding: 10px;
                    width: 370px;
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
          
            <div _ngcontent-c4="" class="table-container">
                <?php
                $waybills = explode('|',$order_details[0]['waybills']);
                // print_r($waybills);exit;
                for($i = 0; $i <$box_count[$lr]; $i++)
                {
                    ?>
                    <table _ngcontent-c4="" cellpadding="0" cellspacing="0" class="table">
                    <tbody _ngcontent-c4="">
                        <tr _ngcontent-c4="">
                            <td _ngcontent-c4="">
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1" width="50%">
                                                <img _ngcontent-c4="" src="main-logo.jpg"  width="120">
                                                <h4 _ngcontent-c4=""
                                                    class="margin-0 display-inline line-38 float-right bold font-20">LTL</h4>
                                            </td>
                                            <td _ngcontent-c4="" align="right" class="row-1-column-2" width="50%">
                                                <strong _ngcontent-c4="" style="font-size: 13px;">Order ID : </strong><span _ngcontent-c4=""
                                                    class="" style="font-size: 13px;"><?= $order_id; ?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <strong _ngcontent-c4="" style="font-size: 13px;">
                                                    Master: <span _ngcontent-c4=""
                                                        style="font-size: 13px;"><?= $order_details[0]['master_waybill']; ?></span>
                                                </strong>
                                            </td>
                                            <td _ngcontent-c4="" align="center" class="row-1-column-2" width="50%">
                                                <strong _ngcontent-c4=""><?php if($i==0){echo'Master';}else{echo'Child';} ?></strong>
                                            </td>
                                        </tr>
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1" style="margin-top: 0;padding-top:0"
                                                width="50%">
                                                <strong _ngcontent-c4="">LRN: <span _ngcontent-c4=""
                                                        class="font-15"><?= $order_details[0]['lr']; ?></span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" align="center" width="100%">
                                                <?php if($i==0){$new_waybill=$order_details[0]['master_waybill'];}else{$new_waybill =  $waybills[$i];} ?>
                                                <div _ngcontent-c4="" barcode-gen="" id="<?= $new_waybill; ?>"
                                                    style="padding: 0px; overflow: auto;">
                                                    <?php echo $generator->getBarcode($new_waybill, $generator::TYPE_CODE_128); ?>
                                                    <div
                                                        style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 15px; margin-top: 5px;">
                                                        <?= $new_waybill; ?></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="0" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <!---->
                                            <td _ngcontent-c4="" align="center" class="border-right " width="30%">
                                                <strong _ngcontent-c4="">Box: <?=$i+1; ?> / <?= $box_count[$lr];?></strong>
                                            </td>
                                            <!---->
                                            <td _ngcontent-c4="" class="border-right" width="40%">
                                                <!---->
                                            </td>
                                            <td _ngcontent-c4="" align="center" class="vert-mid-pad" width="30%">
                                                <p _ngcontent-c4="" class="mar-0-lin-9-f-10"><?= $del_pin; ?>
                                                    <br _ngcontent-c4=""><?= $three_words; ?>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="border-right" width="50%">
                                                <p _ngcontent-c4="" class="mar-0-lin-9-f-10">
                                                    <?= $center; ?>
                                                </p>
                                            </td>
                                            <td _ngcontent-c4="" align="center" class="vert-mid-pad" width="50%">
                                                <strong _ngcontent-c4=""><?= $registered_name; ?></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="0" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="border-right font-size-12 vert-mid-pad-6" width="70%">
                                                <p _ngcontent-c4="" class="bold margin-0">Shipping address : </p>
                                                <p _ngcontent-c4="" class="margin-0 font-10 line-9">
                                                    <?= $get_consignee_details['name'];?>, <?= $get_consignee_details['address'];?>, City: <?= $get_consignee_details['city'];?>, State: <?= $get_consignee_details['state'];?>, PIN: <?= $del_pin;?></span>
                                                </p>
                                            </td>
                                            <td _ngcontent-c4="" class="font-12 vert-mid-pad-6" width="30%">
                                                <!---->
                                                <p _ngcontent-c4="" class="mar-0-lin-9-f-10"><?= $order_details[0]['description']; ?></p>
                                                <!---->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" align="left" class="vert-mid-pad" width="100%">
                                                <span _ngcontent-c4="" class="mar-0-lin-9-f-10 bold">Return address : </span>
                                                <span _ngcontent-c4="" class="mar-0-lin-9-f-10">
                                                    <?= $getwarehouse['warehouse_name']; ?>, <?= $getwarehouse['address']; ?>, <?= $getwarehouse['city']; ?>, <?= $getwarehouse['pincode']; ?>.
                                                </span>
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
                
                <table _ngcontent-c4="" cellpadding="0" cellspacing="0" class="table">
                    <tbody _ngcontent-c4="">
                        <tr _ngcontent-c4="">
                            <td _ngcontent-c4="">
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1" width="50%">
                                                <img _ngcontent-c4="" src="main-logo.jpg"  width="120">
                                                <h4 _ngcontent-c4=""
                                                    class="margin-0 display-inline line-38 float-right bold font-20">LTL</h4>
                                            </td>
                                            <td _ngcontent-c4="" align="right" class="row-1-column-2" width="50%">
                                                <strong _ngcontent-c4="" style="font-size: 13px;">Order ID : </strong><span _ngcontent-c4=""
                                                    class="" style="font-size: 13px;"><?= 'DOC_'.$order_details[0]['lr']; ?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1"
                                                style="margin-bottom: 0;padding-bottom:0" width="50%">
                                                <strong _ngcontent-c4="" style="font-size: 13px;">
                                                    Master: <span _ngcontent-c4=""
                                                        style="font-size: 13px;"><?= $order_details[0]['master_waybill']; ?></span>
                                                </strong>
                                            </td>
                                            <td _ngcontent-c4="" align="center" class="row-1-column-2" width="50%">
                                                <strong _ngcontent-c4="">Child</strong>
                                            </td>
                                        </tr>
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="row-1-column-1" style="margin-top: 0;padding-top:0"
                                                width="50%">
                                                <strong _ngcontent-c4="">LRN: <span _ngcontent-c4=""
                                                        class="font-15"><?= $order_details[0]['lr']; ?></span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" align="center" width="100%">
        
                                                <div _ngcontent-c4="" barcode-gen="" id="<?= $order_details[0]['doc_waybill']; ?>"
                                                    style="padding: 0px; overflow: auto;">
                                                    <?php echo $generator->getBarcode($order_details[0]['doc_waybill'], $generator::TYPE_CODE_128); ?>
                                                    <div
                                                        style="clear:both; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 15px; margin-top: 5px;">
                                                        <?= $order_details[0]['doc_waybill']; ?></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="0" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <!---->
                                            <td _ngcontent-c4="" align="center" class="border-right " width="30%">
                                                <strong _ngcontent-c4="">MPS : Documents</strong>
                                            </td>
                                            <!---->
                                            <td _ngcontent-c4="" class="border-right" width="40%">
                                                <!---->
                                            </td>
                                            <td _ngcontent-c4="" align="center" class="vert-mid-pad" width="30%">
                                                <p _ngcontent-c4="" class="mar-0-lin-9-f-10"><?= $del_pin; ?>
                                                    <br _ngcontent-c4=""><?= $three_words; ?>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="border-right" width="50%">
                                                <p _ngcontent-c4="" class="mar-0-lin-9-f-10">
                                                    <?= $center; ?>
                                                </p>
                                            </td>
                                            <td _ngcontent-c4="" align="center" class="vert-mid-pad" width="50%">
                                                <strong _ngcontent-c4=""><?= $registered_name; ?></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="0" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" class="border-right font-size-12 vert-mid-pad-6" width="70%">
                                                <p _ngcontent-c4="" class="bold margin-0">Shipping address : </p>
                                                <p _ngcontent-c4="" class="margin-0 font-10 line-9">
                                                    <?= $get_consignee_details['name'];?>, <?= $get_consignee_details['address'];?>, City: <?= $get_consignee_details['city'];?>, State: <?= $get_consignee_details['state'];?>, PIN: <?= $del_pin;?></span>
                                                </p>
                                            </td>
                                            <td _ngcontent-c4="" class="font-12 vert-mid-pad-6" width="30%">
                                                <!---->
                                                <p _ngcontent-c4="" class="mar-0-lin-9-f-10"><?= $order_details[0]['description']; ?></p>
                                                <!---->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table _ngcontent-c4="" cellpadding="5" cellspacing="0" class="border-3-sides" width="100%">
                                    <tbody _ngcontent-c4="">
                                        <tr _ngcontent-c4="">
                                            <td _ngcontent-c4="" align="left" class="vert-mid-pad" width="100%">
                                                <span _ngcontent-c4="" class="mar-0-lin-9-f-10 bold">Return address : </span>
                                                <span _ngcontent-c4="" class="mar-0-lin-9-f-10">
                                                    <?= $getwarehouse['warehouse_name']; ?>, <?= $getwarehouse['address']; ?>, <?= $getwarehouse['city']; ?>, <?= $getwarehouse['pincode']; ?>.
                                                </span>
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
