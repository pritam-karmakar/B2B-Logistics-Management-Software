<?php
include('menu/header.php');
include('menu/navbar.php');
?>
    
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-4">Freight Estimator</h4>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5 class="card-title"><strong>Calculator for Freight</strong></h5>
                        <hr/>
                    </div>
                    <div class="card-body pb-0" id="freight-master">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Origin Pincode <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon11"><i class="menu-icon tf-icons bx bxs-map"></i></span>
                                    <input type="text" maxlength="6" name="OriginPincode" class="form-control numeric-input" placeholder="Enter Origin Pincode">
                                </div>
                                <span class="text-danger origin-error d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Destination Pincode <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon11"><i class="menu-icon tf-icons bx bxs-map"></i></span>
                                    <input type="text" maxlength="6" name="DestinationPincode" class="form-control numeric-input" placeholder="Enter Destination Pincode">
                                </div>
                                <span class="text-danger destination-error d-flex justify-content-end" style="font-size: 12px;"></span>
                                <span class="text-success destination-oda d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-4 pt-3">     
                                <div class="form-group">
                                    <label class="control-label mb-1">CFT <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="cftType">
                                            <?php
                                                echo ($get_user_details[0]['threepl'] != 'all')? "disabled" : "<option value='' hidden>Choose one</option>";
                                                $showCFT = ($get_user_details[0]['threepl'] != 'all')? array('id'=>$get_user_details[0]['threepl']) : "";
                                                $cftDetails = $query->getData("*","3pls","",$showCFT,"","","");
                                                foreach($cftDetails as $cft){
                                                    echo "<option>".$cft['api_token_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <span class="text-danger cft-error d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-4 pt-3">     
                                <div class="form-group">
                                    <label class="control-label mb-1">Payment mode <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <select class="form-control" name="payment-mode">
                                            <option>Prepaid</option>
                                            <option>CoD</option>
                                        </select>
                                    </div>
                                </div>
                                <span class="text-danger payment-mode-error d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-4 pt-3">     
                                <div class="form-group">
                                    <label class="control-label mb-1">Total Weight in Kg <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="totalWeight"><i class='bx bxs-box'></i></span>
                                        <input type="text" id="totalWeight" name="totalWeight" placeholder="Total Weight" class="form-control numeric-decimal">
                                    </div>
                                </div>
                                <span class="text-danger total-weight-error d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-4 pt-3">     
                                <div class="form-group">
                                    <label class="control-label mb-1">Total Boxes <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="totalBoxes"><i class='bx bxs-package'></i></span>
                                        <input type="text" id="totalBoxes" name="totalBoxes" placeholder="Total Boxes" class="form-control numeric-input">
                                    </div>
                                </div>
                                <span class="text-danger total-boxes-error d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-4 pt-3">     
                                <div class="form-group">
                                    <label class="control-label mb-1">Dimension in <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon11"><i class='bx bxs-cube'></i></span>
                                        <select class="form-control" name="dimention">
                                            <option>Centimeter</option>
                                            <option>Inch</option>
                                        </select>
                                    </div>
                                </div>
                                <span class="text-danger dimention-error d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-4 pt-3">     
                                <div class="form-group">
                                    <label class="control-label mb-1">Invoice Value <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon11">₹</span>
                                        <input type="text" id="invoiceAmount" name="invoiceAmount" placeholder="Enter Invoice Value" class="form-control numeric-decimal">
                                    </div>
                                </div>
                                <span class="text-danger invoice-amount-error d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-6 pt-3">
                                <label class="control-label mb-1">Insurance? <span class="text-danger">*</span></label><br>
                                <div class="form-check form-check-inline">
                                    <input name="insurance" class="form-check-input" id="insurance1" type="radio" value="Yes" >
                                    <label class="form-check-label" for="insurance1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="insurance" class="form-check-input" id="insurance2" type="radio" value="No"  >
                                    <label class="form-check-label" for="insurance2">No</label>
                                </div>
                                <span class="text-danger insurance-error d-flex justify-content-center" style="font-size: 12px;"></span>
                            </div>
                            <div class="col-md-6 pt-3">
                                <label class="control-label mb-1">Pickup Type <span class="text-danger">*</span></label><br>
                                <div class="form-check form-check-inline">
                                    <input name="pickupType" class="form-check-input" id="pickup-type1" type="radio" value="Yes" >
                                    <label class="form-check-label" for="pickup-type1">FM-Pickup</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="pickupType" class="form-check-input" id="pickup-type2" type="radio" value="No"  >
                                    <label class="form-check-label" for="pickup-type2">Self-Drop</label>
                                </div>
                                <span class="text-danger pickup-type-error d-flex justify-content-end" style="font-size: 12px;"></span>
                            </div>
                        </div>
                        <input type="hidden" id="diemension_no" value="0">
                        <div id="dimension" class="pt-3">
                            <div class="row" id="row0">
                                <div class="col-lg-2"> 
                                  <div class="form-group">
                                    <label class="control-label mb-1">Qty <span class="text-danger">*</span></label>
                                    <input name="qty[]" id="count0" type="text" placeholder="Qty" class="count form-control numeric-input" >
                                  </div>
                                  <span class="text-danger qty-error d-flex justify-content-end" style="font-size: 12px;"></span>
                                </div> 
                                <div class="col-lg-3">   
                                    <div class="form-group">
                                        <label class="control-label mb-1">Length <span class="text-danger">*</span></label>
                                        <input name="length[]" id="length0" type="text" placeholder="Length" class="form-control w-95 numeric-decimal" >
                                    </div>
                                    <span class="text-danger length-error d-flex justify-content-end" style="font-size: 12px;"></span>
                                </div>
                                <div class="col-lg-3">   
                                    <div class="form-group">
                                        <label class="control-label mb-1">Width <span class="text-danger">*</span></label>
                                        <input name="width[]" id="width0" type="text" placeholder="Width" class="form-control w-95 numeric-decimal" > 
                                    </div>  
                                    <span class="text-danger width-error d-flex justify-content-end" style="font-size: 12px;"></span>
                               </div>
                                <div class="col-lg-3">    
                                    <div class="form-group"> 
                                        <label class="control-label mb-1">Height <span class="text-danger">*</span></label>
                                        <input name="height[]" id="height0" type="text" placeholder="Height" class="form-control w-95 numeric-decimal">
                                    </div>
                                    <span class="text-danger height-error d-flex justify-content-end" style="font-size: 12px;"></span>
                                </div> 
                                <div class="col-lg-1 d-flex justify-content-end align-items-center" style="padding-top: 1.5rem;">  
                                    <div class="text-center">
                                        <button id="add_weight" type="button" class="btn btn-info btn-xs" style="padding: 2px 4px"><i class="bx bxs-plus-circle"></i></button>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <div class="card-footer d-flex justify-content-end pt-0">
                        <button type="button" name="CalculateFreight" class="btn btn-primary">Calculate Freight</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="freight-calculation-card">
                        <div class="card-header pb-0">
                            <h5 class="card-title"><strong>Calculated Freight Details</strong></h5>
                            <hr/>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>1. Base Freight Charge: </b></dt><dd><b>₹ <span id="basic-freight">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>2. Fuel Surcharge :</b></dt><dd><b>₹ <span id="fuel-surcharge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>3. AWB Charge :</b></dt><dd><b>₹ <span id="awb-charge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>4. FOV Surcharge :</b></dt><dd><b>₹ <span id="fov-surcharge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>5. Handeling Charge :</b></dt><dd><b>₹ <span id="handeling-charge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>6. Cartage Charge :</b></dt><dd><b>₹ <span id="cartage-charge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>7. Damrage Surcharge :</b></dt><dd><b>₹ <span id="damrage-surcharge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>8. ODA Surcharge :</b></dt><dd><b>₹ <span id="oda-surcharge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>9. Packaging Surcharge :</b></dt><dd><b>₹ <span id="packaging-surcharge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>10. Special Delivery / Appointment Surcharge :</b></dt><dd><b>₹ <span id="special-delhivery">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>11. COD Charge :</b></dt><dd><b>₹ <span id="cod-charge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>12. Pickup Charge :</b></dt><dd><b>₹ <span id="pickup-charge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>13. Pre-Tax Freight Charge :</b></dt><dd><b>₹ <span id="pre-tax-freight-charge">0</span></b></dd></dl>
                                <dl class="d-flex" style="justify-content: space-between;"><dt><b>14. GST Charge :</b></dt><dd><b>₹ <span id="gst-charge">0</span></b></dd></dl>
                                <hr/>
                                <dl class="d-flex" style="justify-content: space-between; font-size: 21px;"><dt><b>Total Charge :</b></dt><dd><b>₹ <span id="total-charge">0</span></b></dd></dl>
                            </div>
                            <div class="text-danger">These Freight Charges are for estimation only. The actual charges are subject to change in lieu of other factors / special pricing.*</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('menu/footer.php');
?>
<script src="menu/freight.js"></script>