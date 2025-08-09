<?php
session_start();
include ("../database/db.php");
include ("../functions/all-functions.php");

$newquery = new query();
$newfunc = new allfunctions();
if(isset($_SESSION['invoice_order_id'])){
    $order_id = $_SESSION['invoice_order_id'];
    $join = array("0" => array("LEFT", "users", "orders", "type_id", "users", "id"), "1" => array("LEFT", "box_details", "orders", "order_id", "box_details", "order_id"));
    $condArr = array("orders`.`id" => $order_id);
    $invoice = $newquery->getData("*, SUM(qty) AS tqty", "orders", $join, $condArr, "", "", "")[0];
}
if(isset($_SESSION['billing_order_id'])){
    $order_id = $_SESSION['billing_order_id'];
    $join = array("0" => array("LEFT", "users", "orders", "type_id", "users", "id"), "1" => array("LEFT", "box_details", "orders", "order_id", "box_details", "order_id"));
    $condArr = array("orders`.`id" => $order_id);
    $invoice = $newquery->getData("*, SUM(qty) AS tqty", "orders", $join, $condArr, "", "", "")[0];
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <!-- Site Title -->
  <title>Kingfish Logistics Invoice</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_head tm_mb20">
            <div class="tm_invoice_left col-3">
              <div class="tm_logo">
                <img src="assets/logo/logo.png" alt="Logo">
              </div>
            </div>
            <div class="tm_invoice_right">
              <div class="tm_grid_row tm_col_3">
                <div>
                  <b class="tm_primary_color">Tax Info</b> <br>
                  <div style="margin-right: -11px;">ORIGINAL FOR RECIPIENT</div>
                  PAN : IRJPS0802Q
                </div>
                <div>
                  <b class="tm_primary_color">Contact</b> <br>
                  +91 9915993324 <br>
                  +91 8264438324 <br>
                  info@kingfishlogistics.in
                </div>
                <div>
                  <b class="tm_primary_color">Address</b> <br>
                  Plot 315,  
                  phase 2 industrial area, <br>
                  panchkula, 134113
                </div>
              </div>
            </div>
          </div>
          <div class="tm_invoice_info tm_mb10">
            <div class="tm_invoice_info_left">
              <p class="tm_mb2"><b>Bill To:</b></p>
              <p>
                <b class="tm_f16 tm_primary_color">
                  <?= $invoice['party_name']; ?>
                </b> <br>
                <?= $invoice['address']; ?><br>
                <?= $invoice['email']; ?><br>
                <?= $invoice['mobile_no']; ?>
              </p>
            </div>
            <div class="tm_invoice_info_right">
              <div
                class="tm_ternary_color tm_f50 tm_text_uppercase tm_text_center tm_invoice_title tm_mb15 tm_mobile_hide">
                Tax Invoice</div>
              <div class="tm_grid_row tm_col_3 tm_invoice_info_in tm_gray_bg tm_round_border">
                <div>
                  <span>Customer CODE:</span> <br>
                  <b class="tm_primary_color">
                    <?= $invoice['username']; ?>
                  </b>
                </div>
                <div>
                  <span>Invoice Date:</span> <br>
                  <b class="tm_primary_color">
                    <?= $invoice['order_date']; ?>
                  </b>
                </div>
                <div>
                  <span>Order No:</span> <br>
                  <b class="tm_primary_color">#
                    <?= $invoice['order_id']; ?>
                  </b>
                </div>
              </div>
            </div>
          </div>
          <div class="tm_table tm_style1">
            <div class="tm_round_border">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_width_7 tm_semi_bold tm_primary_color">Item Details</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color">HSN/SAC</th>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color">Cost</th>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color">Quantity</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_text_right">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="tm_width_7">
                        <?= $invoice['description']; ?>
                      </td>
                      <td class="tm_width_2">
                        <?= $invoice['hsn']; ?>
                      </td>
                      <td class="tm_width_1">
                        ₹
                        <?= round(($invoice['total_charge'] - $invoice['gst_charge']) / $invoice['qty'], 2); ?><br>
                      </td>
                      <td class="tm_width_2 tm_text_center">
                        <?= $invoice['qty']; ?>
                      </td>
                      <td class="tm_width_2 tm_text_center">₹
                        <?= $invoice['total_charge'] - $invoice['gst_charge']; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tm_invoice_footer">
              <div class="tm_left_footer" style="display: flex;">
                <div>
                  <p class="tm_mb2"><b class="tm_primary_color">Payment info:</b></p>
                  <p class="tm_m0" style="font-size: 13px;">Please make all cheques/DD payable to Kingfish Logistics
                    Remittance to be made to the following account <br>
                    A/C Holder Name: Kingfish Logistics<br>
                    A/C Number: 014820800000181 <br>
                    IFSC Code: YESB0000148 <br>
                  </p>
                </div>
                <div style="width: 100%;">
                  <img src="https://cdn.ttgtmedia.com/rms/misc/qr_code_barcode.jpg">
                </div>
              </div>
              <div class="tm_right_footer">
                <table>
                  <tbody>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtotal</td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">₹
                        <?= $invoice['total_charge'] - $invoice['gst_charge']; ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">IGST</td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">
                        <?php if ($invoice['igst'] == 'yes') {
                          echo "₹" . $invoice['gst_charge'];
                        } else {
                          echo "-";
                        } ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">CGST</td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">
                        <?php if ($invoice['igst'] == 'not') {
                          echo "₹" . $invoice['gst_charge'] / 2;
                        } else {
                          echo "-";
                        } ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">SGST</td>
                      <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">
                        <?php if ($invoice['igst'] == 'not') {
                          echo "₹" . $invoice['gst_charge'] / 2;
                        } else {
                          echo "-";
                        } ?>
                      </td>
                    </tr>
                    <!--<tr>-->
                    <!--  <td class="tm_width_3 tm_border_none tm_pt0">Discount 10%</td>-->
                    <!--  <td class="tm_width_3 tm_text_right tm_border_none tm_pt0 tm_danger_color">-₹16</td>-->
                    <!--</tr>-->
                    <tr>
                      <td
                        class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color tm_accent_bg tm_radius_6_0_0_6">
                        Grand Total</td>
                      <td
                        class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right tm_white_color tm_accent_bg tm_radius_0_6_6_0">
                        ₹
                        <?= $invoice['total_charge'] - $invoice['gst_charge']; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tm_note tm_text_center tm_m0_md">
            <p class="tm_m0">
              This is computer generated invoice and does not require any stamp or signature. <br>
              service for Customer Name to GST ID: ……………………………….. from Kingfish <br>
              GST ID:02IRJPS0802Q1ZE, STATE CODE: ………, PLACE OF SUPPLY: …………….
            </p>
            <p class="tm_m0">
              Click here to pay by Current A/C Netbanking (Charges borne by Kingfish):
            </p>
          </div>
        </div>
      </div>
      <div class="tm_invoice_btns tm_hide_print">
        <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path
                d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
              <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor"
                stroke-linejoin="round" stroke-width="32" />
              <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
                stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
              <circle cx="392" cy="184" r="24" fill='currentColor' />
            </svg>
          </span>
          <span class="tm_btn_text">Print</span>
        </a>
        <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
              <path
                d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03"
                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
            </svg>
          </span>
          <span class="tm_btn_text">Download</span>
        </button>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jspdf.min.js"></script>
  <script src="assets/js/html2canvas.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>