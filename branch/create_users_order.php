<?php
extract($_GET);
include('menu/header.php');
include('menu/navbar.php');
?>
    <style>
        .card-header
        {
            padding:10px!important;
        }
        #map-layer img{
            width: 100%;
        }
        .input-group-append, .input-group-prepend {
            color: #696cff;
            width: auto;
            border: none;
        }
        
        .input-group-prepend {
            margin-right: -1px;
        }
        .input-group-prepend, .input-group-append {
            display: flex;
        }
        
        .custom-option-body .clogo {
            float: left;
            margin-top: 1rem !important;
            margin-left: -35px;
        }
    
        .custom-option-body .clogo img {
            border-radius: 1px;
            height: 60px;
            width: 100px;

        }
    
        .custom-option-body .DELHIVERY1 {
            color: #000 !important;
            margin-bottom: 4px;
            font-size: 14px !important;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 19px;
        }
    
        .custom-option-body .kg {
            background: #000;
            color: #fff;
            width: fit-content;
            padding: 1px 8px;
            margin-bottom: 7px;
            border-radius: 6px;
            margin-top: 10px;
            font-size: 11px;
        }
    
        .custom-option-body h6 {
            font-size: 12px;
            line-height: 17px;
            margin: 0;
        }
    
        .custom-option-body .circular-chart1 {
            max-width: 85%;
            margin: 8px auto;
            display: block;
        }
    
        .custom-option-body .circle-bg {
            fill: #4caf50; /* green background */
            stroke: #4caf50;
            stroke-width: 3.8;
        }
    
        .custom-option-body .circle {
            fill: #fff;
        }
    
        .custom-option-body .percentage {
            fill: #222; /* black text */
            font-family: sans-serif;
            font-size: 0.6em;
            text-anchor: middle;
            font-weight: 600;
        }
    
        .custom-option-body .grey {
            color: grey;
        }
    
        .custom-option-body .text-success {
            color: #28a745;
        }
    
        .custom-option-body .text-primary {
            color: #007bff;
        }
        
        p {
            font-size: 12px;
        }
        
        .custom-option-body .small {
            margin-top: 0px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 3px;
            color: #000;
        }
    </style>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <?php
            if(isset($_REQUEST['order_done']))
            {
                echo'<div class="mt-3 alert alert-danger alert-dismissible" role="alert">Order added successfully!!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>';
            }
            ?>
            <div class="d-flex align-items-center mb-3">
                <div class="col-md-6 fw-bold d-flex align-items-end"><h4 class="text-dark fw-bold mb-0">Create New Order For Users</h4></div>
                <div class="col-md-3">
                    <label class="mb-1"><strong class="card-title">Order for user <span class="text-danger">*</span></strong></label>
                    <select class="form-control" name="orderForUser" required>
                        <?php
                            $searchBy = ($get_user_details[0]['type'] == "branch")? "branch" : "booking_agent";
                            $users = $query->getData("*","users","",array($searchBy=>$user_id),"id","DESC","");
                            if($users != 0):
                                echo "<option value='' hidden>Choose one</option>";
                                foreach($users as $user):
                        ?>          <option value='<?= $user['username']; ?>' <?php if($orderForUser == $user['username']){ echo "selected"; } ?>><?= $user['party_name']." (".$user['username']; ?>)</option>";
                        <?php
                                endforeach;
                            else:
                                echo "<option value='' hidden>No users found !</option>";
                            endif;
                        ?>
                    </select>
                    <span class="text-danger" id="orderForUser-error"></span>
                </div>
            </div>
            <div class="col-md-3"></div>
            <?php
                unset($get_user_details);
                $get_user_details = $query->getData("*","users","",array("username"=>$orderForUser),"id","DESC","1");
                $user_id = $get_user_details[0]['id'];
            ?>
            <form method="POST" action="action" onsubmit="return validateCft()">
                <input type="text" hidden value="<?= $orderForUser; ?>" name="orderForUser">
                <div class="row">
                    <div class="col-lg-9">
                        <div id="part-1">
                            <div class="card mb-4">
                                <div class="card-header"> <strong class="card-title">Pickup &amp; Destination Details </strong> </div>
                                <div class="card-body row"> 
                                    <div class="col-lg-4">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Pickup From <span class="text-danger">*</span></label>
                                            <input type="hidden" id="cft">
                                            <input type="hidden" value="<?= $user_id; ?>" id="type_id">
                                            <input name="pin" id="pin" type="text" placeholder="Origin Pincode" class="form-control numeric-input">
                                            <span class="text-danger" id="pin_alert"></span>
                                            <a type="button" id="add_warehouse" class="btn btn-warning mt-2" href="manage_warehouses">Add Warehouse</a>
                                        </div> 
                                    </div>
                                    <div class="col-lg-4">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Warehouse<span class="text-danger">*</span></label>
                                            <select class="form-control" name="warehouse_id" id="warehouse_id">
                                                <option value="" hidden>Choose Warehouse</option>
                                            </select>
                                            <span class="text-danger" id="ware_error"></span>
                                        </div> 
                                    </div>
                        			<div class="col-lg-4">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Deliver To <span class="text-danger">*</span></label>
                                            <input name="del_pin" id="del_pin" type="text" placeholder="Destination Pincode" class="form-control numeric-input">
                                            <span class="text-danger" id="pinerror2"></span>
                                            <span class="text-success" id="oda_status"></span>
                                        </div> 
                                    </div>
                                </div>
                            </div>                     
                            <div class="card mb-4">
                                <div class="card-header">  <strong class="card-title">Weight &amp; Dimensions(in cms / inches) </strong> </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4"> 
                                            <div class="form-group">
                                                <label class="control-label mb-1">Weight <span class="text-danger">(Min <?= $get_user_details[0]['min_charge_weight'].'Kg'?>)*</span></label>
                                                <input name="weight" id="weight" type="text" placeholder="Enter Total Weight" class="form-control numeric-input" >
                                                <input type="hidden" id="min_charge_weight" value="<?= $get_user_details[0]['min_charge_weight']; ?>">
                                                <input type="hidden" id="diemension_no" value="0">
                                                <input type="hidden" id="sixcft_volweight" name="sixcft_volweight" value="0">
                                                <input type="hidden" id="eightcft_volweight" name="eightcft_volweight" value="0">
                                                <input type="hidden" id="tencft_volweight" name="tencft_volweight" value="0">
                                                <span class="text-danger" id="weighterror"></span> 
                                            </div>
                                        </div>
                                        <div class="col-lg-4"> 
                                            <div class="form-group">
                                                <label class="control-label mb-1">Dimensions In <span class="text-danger">*</span></label>
                                                <select class="form-control" name="dimensions_in" id="dimensions_in" required>
                                                    <option value="CM">CM</option>
                                                    <option value="IN">Inch</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"> 
                                            <div class="form-group">
                                                <label class="control-label mb-1">Total No. Of Boxes<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control numeric-input" placeholder="Total Boxes" id="total_no_of_boxes">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">  
                                            <div id="dimension">
                                                <div class="row" id="row0">
                                                    <div class="col-lg-2"> 
                                                      <div class="form-group">
                                                        <label class="control-label mb-1">Qty <span class="text-danger">*</span></label>
                                                        <input name="qty[]" id="count0" type="text" placeholder="Qty" class="count form-control numeric-input" >
                                                        <span id="cerror" class="text-danger"></span> 
                                                      </div>
                                                    </div> 
                                                    <div class="col-lg-3">   
                                                        <div class="form-group">
                                                            <label class="control-label mb-1">Length <span class="text-danger">*</span></label>
                                                            <input name="length[]" id="length0" type="text" placeholder="Length" class="form-control w-95 numeric-input" >
                                                            <span id="lerror" class="text-danger"></span> 
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">   
                                                        <div class="form-group">
                                                            <label class="control-label mb-1">Width <span class="text-danger">*</span></label>
                                                            <input name="width[]" id="width0" type="text" placeholder="Width" class="form-control w-95 numeric-input" > 
                                                            <span id="werror" class="text-danger"></span>
                                                      </div>  
                                                   </div>
                                                    <div class="col-lg-3">    
                                                        <div class="form-group"> 
                                                            <label class="control-label mb-1">Height <span class="text-danger">*</span></label>
                                                            <input name="height[]" id="height0" type="text" placeholder="Height" class="form-control w-95 numeric-input">
                                                            <span id="herror" class="text-danger"></span>
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-1 mt-4">  
                                                        <div class="text-center">
                                                            <button id="add_weight" type="button" class=" btn btn-info btn-sm"><i class="bx bxs-plus-circle"></i></button>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="card"> 
                                <div class="card-header"> <strong class="card-title">Mode &amp; Invoice Details</strong></div>
                                <div class="card-body row">                        
                                    <div class="col-lg-4">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Payment Mode <span class="text-danger">*</span></label>
                                            <select name="payment_mode" id="payment_mode" class="form-control">
                                                <option value="">Choose Payment Mode</option>
                                                <?php if($get_user_details[0]['party_type'] == "Paid" || $get_user_details[0]['party_type'] == "All" || $get_user_details[0]['party_type'] == "TBB"){ ?>
                                                        <option value="Prepaid">Prepaid</option>
                                                <?php } if($get_user_details[0]['cod_charge_enable_disable'] == 'enable'){ ?>
                                                        <option value="CoD">COD</option>
                                                <?php } if($get_user_details[0]['party_type'] == "To-Pay" || $get_user_details[0]['party_type'] == "All"){ ?>
                                                        <option value="To-Pay">To-Pay</option>
                                                <?php } if($get_user_details[0]['party_type'] == "Franchise-ToPay" || $get_user_details[0]['party_type'] == "All"){ ?>
                                                <option value="Franchise-ToPay">Franchise-ToPay</option>
                                                <?php } ?>
                                            </select>
                                            <span class="text-danger" id="modeerror"></span>
                                        </div>
                          
                                        <div id="codtype" >
                                            <div class="form-group">
                                                <label class="control-label mb-1">COD Amount <span class="text-danger">*</span></label>
                                                <input type="text" name="cod_amount" id="cod_amount" placeholder="COD Amount" class="form-control numeric-input">
                                                <span id="coderror" class="text-danger"></span>
                                            </div>
                                        </div>  
                                        <div id="ftype">
                                            <div class="form-group">
                                                <label class="control-label mb-1"> Profit Amount <span class="text-danger">*</span></label>
                                                <input type="text" min="0" id="profit" name="profit_amount" value="0" placeholder="Profit Amount" class="form-control numeric-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">     
                                        <div class="form-group">
                                            <label class="control-label mb-1"> Invoice Value <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon11">₹</span>
                                                <input type="text" id="invoice_amount" name="invoice_amount" placeholder="Enter Invoice Value" class="form-control numeric-input">
                                            </div>
                                        </div>
                                         <span class="text-danger" id="inverror"></span> 
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="control-label mb-1"> Insurance ?  <span class="text-danger">*</span></label><br>
                                        <div class="form-check form-check-inline">
                                            <input name="insurance" class="form-check-input" type="radio" value="Yes" >
                                            <label class="form-check-label" for="insurance1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="insurance" class="form-check-input" type="radio" value="No"  >
                                            <label class="form-check-label" for="insurance2">No</label>
                                        </div>
                                         <br><span class="text-danger" id="insuranceerror"></span> 
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <div class="form-group text-end">
                                            <button type="button" name="step1" id="step1" class="btn btn-primary mt-2">Next</button>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div id="part-2">
                            <h6 class="mb-4"><button type="button" class="btn btn-primary btn-sm" id="step2"><i class="fa fa-reply"></i>&nbsp; Back To Pickup Details</button></h6> 
                            <div class="card mb-3">
                                <div class="card-header"><strong class="card-title">Order Details</strong></div>
                                <div class="card-body row">
                                    <div class="col-lg-6">     
                                        <div class="form-group">
                                            <div class="form-check form-check-inline mb-1">
                                                <input name="ltype" class="form-check-input" type="radio" value="Manual" id="lrmanual" >
                                                <label class="form-check-label" for="lrmanual">Manual</label>
                                            </div>
                                            <div class="form-check form-check-inline mb-1">
                                                <input name="ltype" class="form-check-input" type="radio" value="Automatic" id="lrautomatic" >
                                                <label class="form-check-label" for="lrautomatic">Automatic</label>
                                            </div>
                                           
                                            <input type="text" name="lr" id="lr" class="form-control"  placeholder=" LR No. *" readonly="readonly">
                                            <span id="lrerror" class="text-danger"></span>
                                        </div>
        		                    </div>
        		                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1">HSN Code </label>
                                            <input name="hsn" id="hsn" placeholder="HSN Code " class="form-control">
                                            <span id="hserror" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">     
                                        <div class="form-group">
                                            <label for="" class="control-label mb-1">Item<span class="text-danger">*</label>
                                            <select  class="form-control" name="item" id="item">
                                                <option value="">Select an item</option>
                                                <?php 
                                                $itm_cond = array("delete_status"=>"show");
                                                $get_item_det = $query->getData("*","order_items","",$itm_cond,"","","");
                                                foreach($get_item_det as $item_det)
                                                {
                                                    ?>
                                                        <option value="<?= $item_det['id']; ?>"><?= $item_det['item']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <span id="itemerror" class="text-danger"></span>
                                    </div>
                                    <div class="col-lg-6">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Item Description <span class="text-danger">*</span></label>
                                            <input name="description" id="description" type="text" placeholder="Enter Item Description" class="form-control">
                                            <span class="text-danger" id="deserror"></span> 
                                        </div>
                                    </div>
                                </div>                   
                            </div> 
                            <div class="card mb-3">
                                <div class="card-header"><strong class="card-title">Invoice Details</strong></div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-lg-12">
                                            <div id="pay-invoice">
                                                <!-- The first row -->
                                                <input type="hidden" value="1" id="inv_rowcount">
                                                <div class="row" id="invoice_row1">
                                                    <div class="col-lg-4">     
                                                        <div class="form-group">
                                                            <label class="control-label mb-1">Ewaybill</label>
                                                            <input name="ewaybill[]" id="ewaybill1" type="text" placeholder="ewaybill" class="form-control">
                                                            <span id="eerror1" class="text-danger"></span> 
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">     
                                                        <div class="form-group">
                                                            <label class="control-label mb-1">Amount <span class="text-danger">*</span></label>
                                                            <input name="n_value[]" id="n_value1" value="" type="text" placeholder="Amount" class="amt form-control" required>
                                                            <span id="nerror1" class="text-danger"></span> 
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">     
                                                        <div class="form-group">
                                                            <label class="control-label mb-1">Invoice No. <span class="text-danger">*</span></label>
                                                            <input type="text" id="inv1" name="inv[]" placeholder="Invoice No." class="form-control" required>
                                                            <span id="ierror1" class="text-danger"></span>    
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 text-center mt-4">
                                                        <button type="button" class="btn btn-info btn-sm" onclick="addRow()">+ Add More</button> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="card mb-3">
                                <div class="card-header"> <strong class="card-title">Additional Details</strong></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mb-1">Client's Reference No</label>
                                                 <input name="ref_no" id="ref_no" placeholder="Client's Reference No" class="form-control" onblur="checkReferenceNo()">
                                                <span id="referror" class="text-danger"></span>
                                            </div>
                                        </div>  
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mb-1">Shipper GSTIN </label>
                                                 <input name="seller_gst_tin" id="seller_gst_tin" placeholder="Shipper GSTIN" class="form-control">
                                                 <input name="evalid" id="evalid" type="hidden" class="form-control">
                                            <span id="serror" class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mb-1">Consignee GSTIN </label>
                                                <input name="consignee_gst_tin" id="consignee_gst_tin" placeholder="Consignee GSTIN" class="form-control">
                                                <span id="gerror" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Consignee Details</strong>	              
                                </div>
                                <div class="card-body row">
                                    <!--<div class="col-lg-12">-->
                                    <!--    <label for="select2Basic" class="form-label"></label>-->
                                    <!--    <select id="select2Basic" class="select2 form-select form-select-lg" >-->
                                    <!--        <option>Search</option>-->
                                    <!--    </select>-->
                                    <!--</div>-->
                                    <input type="hidden" name="oda" id="oda">
                                    
                                    <!-- For 6 cft shipment -->
                                    <input type="hidden" name="cod_charge_6cft" id="cod_charge_6cft">
                                    <input type="hidden" name="fuel_surcharge_6cft" id="fuel_surcharge_6cft">
                                    <input type="hidden" name="awb_charge_6cft" id="awb_charge_6cft">
                                    <input type="hidden" name="fob_surcharge_6cft" id="fob_surcharge_6cft">
                                    <input type="hidden" name="handeling_charge_6cft" id="handeling_charge_6cft">
                                    <input type="hidden" name="pickup_charge_6cft" id="pickup_charge_6cft">
                                    <input type="hidden" name="damage_surcharge_6cft" id="damage_surcharge_6cft">
                                    <input type="hidden" name="oda_surcharge_6cft" id="oda_surcharge_6cft">
                                    <input type="hidden" name="packaging_surcharge_6cft" id="packaging_surcharge_6cft">
                                    <input type="hidden" name="special_delivery_charge_6cft" id="special_delivery_charge_6cft">
                                    <input type="hidden" name="weight_charge_6cft" id="weight_charge_6cft" value="">
                                    <input type="hidden" name="total_charge_6cft" id="total_charge_6cft" value="">
                                     <input type="hidden" name="igst_6cft"  id="igst_6cft" value="0">
                                    <input type="hidden" name="cgst_6cft"  id="cgst_6cft" value="0">
                                    <input type="hidden" name="sgst_6cft"  id="sgst_6cft" value="0">
                                    
                                    
                                    <!-- For 8 cft shipment -->
                                    <input type="hidden" name="cod_charge_8cft" id="cod_charge_8cft">
                                    <input type="hidden" name="fuel_surcharge_8cft" id="fuel_surcharge_8cft">
                                    <input type="hidden" name="awb_charge_8cft" id="awb_charge_8cft">
                                    <input type="hidden" name="fob_surcharge_8cft" id="fob_surcharge_8cft">
                                    <input type="hidden" name="handeling_charge_8cft" id="handeling_charge_8cft">
                                    <input type="hidden" name="pickup_charge_8cft" id="pickup_charge_8cft">
                                    <input type="hidden" name="damage_surcharge_8cft" id="damage_surcharge_8cft">
                                    <input type="hidden" name="oda_surcharge_8cft" id="oda_surcharge_8cft">
                                    <input type="hidden" name="packaging_surcharge_8cft" id="packaging_surcharge_8cft">
                                    <input type="hidden" name="special_delivery_charge_8cft" id="special_delivery_charge_8cft">
                                    <input type="hidden" name="weight_charge_8cft" id="weight_charge_8cft" value="">
                                    <input type="hidden" name="total_charge_8cft" id="total_charge_8cft" value="">
                                    <input type="hidden" name="igst_8cft"  id="igst_8cft" value="0">
                                    <input type="hidden" name="cgst_8cft"  id="cgst_8cft" value="0">
                                    <input type="hidden" name="sgst_8cft"  id="sgst_8cft" value="0">

                                    
                                    <!-- For 10 cft shipment -->
                                    <input type="hidden" name="cod_charge_10cft" id="cod_charge_10cft">
                                    <input type="hidden" name="fuel_surcharge_10cft" id="fuel_surcharge_10cft">
                                    <input type="hidden" name="awb_charge_10cft" id="awb_charge_10cft">
                                    <input type="hidden" name="fob_surcharge_10cft" id="fob_surcharge_10cft">
                                    <input type="hidden" name="handeling_charge_10cft" id="handeling_charge_10cft">
                                    <input type="hidden" name="pickup_charge_10cft" id="pickup_charge_10cft">
                                    <input type="hidden" name="damage_surcharge_10cft" id="damage_surcharge_10cft">
                                    <input type="hidden" name="oda_surcharge_10cft" id="oda_surcharge_10cft">
                                    <input type="hidden" name="packaging_surcharge_10cft" id="packaging_surcharge_10cft">
                                    <input type="hidden" name="special_delivery_charge_10cft" id="special_delivery_charge_10cft">
                                    <input type="hidden" name="weight_charge_10cft" id="weight_charge_10cft" value="">
                                    <input type="hidden" name="total_charge_10cft" id="total_charge_10cft" value="">
                                     <input type="hidden" name="igst_10cft"  id="igst_10cft" value="0">
                                    <input type="hidden" name="cgst_10cft"  id="cgst_10cft" value="0">
                                    <input type="hidden" name="sgst_10cft"  id="sgst_10cft" value="0">
                                    
                                    
                                    
                                    
                                    
                                    <?php
                                    $igst_per=0;
                                    $sgst_per=0;
                                    $cgst_per=0;
                                    $get_gst_det = $query->getData("*","charges","","","","","");
                                    if($get_user_details[0]['igst']=='yes')
                                    {
                                        $gst_charge = $get_gst_det[0]['igst'];
                                        $igst_per= $get_gst_det[0]['igst'];
                                    }
                                    else
                                    {
                                        $gst_charge = $get_gst_det[0]['sgst']+$get_gst_det[0]['cgst'];
                                        $sgst_per=$get_gst_det[0]['sgst'];
                                        $cgst_per=$get_gst_det[0]['cgst'];
                                    }
                                    ?>
                                    <input type="hidden" name="igst_per" id="igst_per" value="<?= $igst_per; ?>">
                                    <input type="hidden" name="sgst_per" id="sgst_per" value="<?= $sgst_per; ?>">
                                    <input type="hidden" name="cgst_per" id="cgst_per" value="<?= $cgst_per; ?>">
                                    <input type="hidden" name="gst_charge" id="gst_charge" value="<?= $gst_charge; ?>">
                                    
                                    
                                     
                                    <input type="hidden" id="cod_charge" name="applied_cod_charge" value="<?= $get_user_details[0]['cod_charge']; ?>">
                                    <input type="hidden" id="cod_charge_min" name="applied_cod_charge_min" value="<?= $get_user_details[0]['cod_charge_min']; ?>">
                                    <input type="hidden" id="cod_charge_type" name="applied_cod_charge_type"  value="<?= $get_user_details[0]['cod_charge_type']; ?>">
                                    
                                   
                                    <input type="hidden" id="fuel_surcharge" name="applied_fuel_surcharge" value="<?= $get_user_details[0]['fuel_surcharge']; ?>">
                                    <input type="hidden" id="fuel_surcharge_type" name="applied_fuel_surcharge_type" value="<?= $get_user_details[0]['fuel_surcharge_type']; ?>">
                                    
                                    
                                    <input type="hidden" id="awb_charge" name="applied_awb_charge" value="<?= $get_user_details[0]['awb_charge']; ?>">
                                    
                                    
                                    
                                    <input type="hidden" id="fob_surcharge_minimum" name="applied_fob_surcharge_minimum" value="<?= $get_user_details[0]['fob_surcharge_minimum']; ?>">
                                    <input type="hidden" id="fob_surcharge_percentage" name="applied_fob_surcharge_percentage" value="<?= $get_user_details[0]['fob_surcharge_percentage']; ?>">

                                    
                                    <input type="hidden" id="handeling_charge" name="applied_handeling_charge" value="<?= $get_user_details[0]['handeling_charge']; ?>">
                                    <input type="hidden" id="handeling_charge_type" name="applied_handeling_charge_type" value="<?= $get_user_details[0]['handeling_charge_type']; ?>">
                                    
                                    
                                    
                                    
                                    <input type="hidden" id="pickup_charge" name="applied_pickup_charge" value="<?= $get_user_details[0]['pickup_charge']; ?>">
                                    <input type="hidden" id="pickup_charge_type" name="applied_pickup_charge_type"  value="<?= $get_user_details[0]['pickup_charge_type']; ?>">
                                    
                                    
                                    <input type="hidden" id="damage_surcharge" name="applied_damage_surcharge" value="<?= $get_user_details[0]['damage_surcharge']; ?>">
                                    <input type="hidden" id="damage_surcharge_min" name="applied_damage_surcharge_min" value="<?= $get_user_details[0]['damage_surcharge_min']; ?>">
                                    <input type="hidden" id="damage_surcharge_type" name="applied_damage_surcharge_type" value="<?= $get_user_details[0]['damage_surcharge_type']; ?>">
                                    
                                    
                                    <input type="hidden" id="oda_surcharge"  name="applied_oda_surcharge" value="<?= $get_user_details[0]['oda_surcharge']; ?>">
                                    <input type="hidden" id="oda_surcharge_min"  name="applied_oda_surcharge_min"  value="<?= $get_user_details[0]['oda_surcharge_min']; ?>">
                                    <input type="hidden" id="oda_surcharge_type"  name="applied_oda_surcharge_type"  value="<?= $get_user_details[0]['oda_surcharge_type']; ?>">

                                    
                                    <input type="hidden" id="packaging_surcharge"  name="applied_packaging_surcharge"  value="<?= $get_user_details[0]['packaging_surcharge']; ?>">
                                    <input type="hidden" id="packaging_surcharge_type"  name="applied_packaging_surcharge_type"  value="<?= $get_user_details[0]['packaging_surcharge_type']; ?>">
                                    
                                    
                                    <input type="hidden" id="special_delivery_charge"   name="applied_special_delivery_or_appointment_charge" value="<?= $get_user_details[0]['special_delivery_or_appointment_charge']; ?>">
                                    <input type="hidden" id="special_delivery_or_appointment_charge_min"   name="applied_special_delivery_or_appointment_charge_min" value="<?= $get_user_details[0]['special_delivery_or_appointment_charge_min']; ?>">
                                    <input type="hidden" id="special_delivery_charge_type"   name="applied_special_delivery_or_appointment_charge_type" value="<?= $get_user_details[0]['special_delivery_or_appointment_charge_type']; ?>">
                                    
                                    <input type="hidden" id="threepl" value="<?=  $get_user_details[0]['threepl']; ?>">
                                    <input type="hidden" id="freight_type" value="<?=  $get_user_details[0]['freight_type']; ?>">
                                    
                                    <div class="col-lg-4">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Company Name</label>
                                            <input name="company" id="company" type="text" placeholder="Enter Company Name " class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Customer Name<span class="text-danger">*</span></label>
                                            <input name="name" id="name" type="text" placeholder="Enter Customer Name" class="form-control">
                                            <span id="nameerror" class="text-danger"></span> 
                                        </div>
                                    </div>
                                  
                                     <div class="col-lg-4">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Phone Number  <span class="text-danger">*</span></label>
                                            <input name="phone" id="phone" type="text" placeholder="Enter Phone Number" class="form-control" >
                                            <span id="phoneerror" class="text-danger"></span> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Email Address</label>
                                            <input name="email" id="email" type="text" placeholder="Enter Email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">Address<span class="text-danger">*</span></label>
                                            <input name="address" id="address" type="text" placeholder="Enter Address" class="form-control">
                                            <span id="addresserror" class="text-danger"></span> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">City<span class="text-danger">*</span></label>
                                            <input name="city" id="city" type="text" value="" placeholder="Enter City" class="form-control" readonly="readonly">
                                            <span id="cityerror" class="text-danger"></span> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">     
                                        <div class="form-group">
                                            <label class="control-label mb-1">State<span class="text-danger">*</span></label>
                                            <input name="state" id="state" type="text" value="" placeholder="Enter State" class="form-control" readonly="readonly">
                                            <span id="stateerror" class="text-danger"></span> 
                                        </div>
                                    </div> 
                                    <div class="col-lg-12">     
                                        <div class="form-group text-end">
                                            <button type="button" class="btn btn-success mt-2" id="step2_next">Next</button> 
                                        </div>                   
                                    </div>
                                </div>                   
                            </div>
                        </div>
                        <div id="part-3">
                            <h6 class="mb-4"><button type="button" class="btn btn-primary btn-sm" id="step3_prev"><i class="fa fa-reply"></i>&nbsp; Back To Order Details</button></h6>
                            <div class="card mb-3">
                                <div class="card-header"><strong class="card-title">Shipment Charge Details</strong></div>
                                <div class="card-body">
                                    <?php
                                    if($get_user_details[0]['threepl']=='all')
                                    {   
                                        ?><div class="row mt-3"><?php
                                        $cf=1;
                                        $get_cft = $query->getData("*","3pls","","","","","");
                                        foreach($get_cft as $cft)
                                        {
                                            ?>
                                            
                                                <div class="col-md-12  mb-2">
                                                    <div class="form-check custom-option custom-option-basic">
                                                      <label class="form-check-label custom-option-content" for="cft_type<?= $cf; ?>">
                                                        <input name="cft_type" class="form-check-input" type="radio" value="<?= $cft['api_token_name']; ?>" id="cft_type<?= $cf; ?>"  style="display: none;">
                                                        
                                                        <span class="custom-option-body">
                                                            <div class="row logis">
                                                                <div class="col-lg-1 col-sm-3">
                                                                    <div class="clogo pull-left">
                                                                        <img class="img-responsive" src="https://kingfishlogistics.in/images/logo/logo.png">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-9 p-0"> 
                                                                    <h4 class="mt-2 DELHIVERY1 text-end"><span id="with5">Kingfish Logistics</span><br/><span class="badge rounded-pill bg-dark"><?php if($cft['api_token_name']=='6CFT'){echo'Normal';}elseif($cft['api_token_name']=='8CFT'){echo'Heavy';}else{echo'Dence';}?></span> </h4>
                                                                    
                                                                    <p id="vol_weight<?= $cf; ?>" style="margin-left: 20px;"></p> 
                                                                </div>
                                                                <div class="col-lg-3 col-sm-12 "> 
                                                                    <h6 class="mt-2">Charges</h6>    
                                                                    <p style="margin-bottom: 1px;">Weight Charge : <i class="fa fa-inr" aria-hidden="true"></i> <span id="weight_charge<?= $cf; ?>"></span></p>    
                                                                    <p style="margin-bottom: 1px;">Fuel Charge: <i class="fa fa-inr" aria-hidden="true"></i> <span id="fuel_charge<?= $cf; ?>"></span></p>  
                                                                    <p style="margin-bottom: 1px;">AWB Charge: <i class="fa fa-inr" aria-hidden="true"></i> <span id="awb_charge_spn<?= $cf; ?>"></span></p>
                                                                    <p style="margin-bottom: 1px;">GST: <i class="fa fa-inr" aria-hidden="true"></i> <span id="gst_charge_spn<?= $cf; ?>"></span></p>
                                                                </div>
                                                                <div class="col-lg-3 p-0 col-sm-9 p-0"> 
                                                                    <h6 class="mt-2">Additional</h6>
                                                                    <p style="margin-bottom: 1px;">COD Charges: <i class="fa fa-inr" aria-hidden="true"></i> <span id="cod_charge_spn<?= $cf; ?>"></span></p>
                                                                    <p style="margin-bottom: 1px;">ODA Charges: <i class="fa fa-inr" aria-hidden="true"></i> <span id="oda_charge_spn<?= $cf; ?>"></span></p>
                                                                    <p style="margin-bottom: 1px;">Damrage Charges: <i class="fa fa-inr" aria-hidden="true"></i> <span id="damage_charge_spn<?= $cf; ?>"></span></p>
                                                                    <p style="margin-bottom: 1px;">Other Charges: <i class="fa fa-inr" aria-hidden="true"></i> <span id="others_charges<?= $cf; ?>"></span></p>
                                                                </div>
                                                                <div class="col-lg-1 p-0 col-sm-3 p-0">                        
                                                                    <h6 class="text-center mt-2"><b>Rating</b></h6>
                                                                    <svg viewBox="0 0 36 36" class="circular-chart1 circular-chart green">
                                                                        <path class="circle-bg" d="M18 2.0845  a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                                                        <path class="circle" stroke-dasharray="94, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                                                        <text x="18" y="20.35" class="percentage">9.4</text>
                                                                    </svg>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-9 p-0 text-center">
                                                                    <div class="grey mt-5">
                                                                        <h3 style="font-size:18px;"><b><i class="fa fa-inr"></i><span id="tfr_cost<?= $cf; ?>"></span></b></h3>
                                                                        <!--<p class="text-success text-bold">Pickup Available: Tomorrow</p>-->
                                                                        <!--<p class="text-primary text-bold">Estimated Date: 25 Mar, 2024</p>-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 text-center p-0 mt-1">
                                                                    <p class="small"> <i class="fa fa-map-marker"></i> Tracking : Real Time </p>
                                                                </div>
                                                                <div class="col-lg-4 text-center p-0 mt-1">
                                                                    <p class="small"> <i class="fa fa-phone"></i> Call Before Delivery : Available </p>
                                                                </div>
                                                                <div class="col-lg-4 text-center di-none p-0 mt-1">
                                                                    <p class="small"> <i class="fa fa-address-card"></i> POD : Instant</p>
                                                                </div>
                                                            </div>
                                                        </span>
                                                      </label>
                                                    </div>
                                                </div>
                                            
                                            <?php
                                            $cf++;
                                        }
                                        ?></div><?php
                                    }
                                    else
                                    {
                                        $cond =array("users`.`id"=>$user_id);
                                        $join= array('0'=>array('LEFT','3pls','3pls','id','users','threepl'));
                                        $get_3pl = $query->getData("*","users",$join,$cond,"","","")[0];
                                        ?>
                                        <div class="row mt-3">
                                            <div class="col-md-12  mb-2">
                                                <div class="form-check custom-option custom-option-basic">
                                                  <label class="form-check-label custom-option-content" for="cft_type1">
                                                    <input name="cft_type" class="form-check-input" type="radio" value="<?= $get_3pl['api_token_name']; ?>" id="cft_type1"  style="display: none;">
                                                    
                                                    <span class="custom-option-body">
                                                        <div class="row logis">
                                                            <div class="col-lg-1 col-sm-3 ">
                                                                <div class="clogo pull-left">
                                                                    <img class="img-responsive" src="https://kingfishlogistics.in/images/logo/logo.png">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-sm-9"> 
                                                                <h4 class="mt-2 DELHIVERY1 text-end"><span id="with5">Kingfish Logistics</span><br/><span class="badge rounded-pill bg-dark"><?php if($get_3pl['api_token_name']=='6CFT'){echo'Normal';}elseif($get_3pl['api_token_name']=='8CFT'){echo'Heavy';}else{echo'Dence';}?></span> </h4>
                                                                
                                                                <p id="vol_weight" style="margin-left:20px;"></p> 
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12 "> 
                                                                <h6 class="mt-2">Charges</h6>    
                                                                <p style="margin-bottom: 1px;">Weight Charge : <i class="fa fa-inr" aria-hidden="true"></i> <span id="weight_charge"></span></p>    
                                                                <p style="margin-bottom: 1px;">Fuel Charge: <i class="fa fa-inr" aria-hidden="true"></i> <span id="fuel_charge"></span></p>  
                                                                <p style="margin-bottom: 1px;">AWB Charge: <i class="fa fa-inr" aria-hidden="true"></i> <span id="awb_charge_spn"></span></p>
                                                                <p style="margin-bottom: 1px;">GST: <i class="fa fa-inr" aria-hidden="true"></i> <span id="gst_charge_spn"></span></p>
                                                            </div>
                                                            <div class="col-lg-3 p-0 col-sm-9 p-0"> 
                                                                <h6 class="mt-2">Additional</h6>
                                                                <p style="margin-bottom: 1px;">COD Charges: <i class="fa fa-inr" aria-hidden="true"></i> <span id="cod_charge_spn"></span></p>
                                                                <p style="margin-bottom: 1px;">ODA Charges: <i class="fa fa-inr" aria-hidden="true"></i> <span id="oda_charge_spn"></span></p>
                                                                <p style="margin-bottom: 1px;">Damrage Charges: <i class="fa fa-inr" aria-hidden="true"></i> <span id="damage_charge_spn"></span></p>
                                                                <p style="margin-bottom: 1px;">Other Charges: <i class="fa fa-inr" aria-hidden="true"></i> <span id="others_charges"></span></p>
                                                            </div>
                                                            <div class="col-lg-1 p-0 col-sm-3 p-0">                        
                                                                <h6 class="text-center mt-2"><b>Rating</b></h6>
                                                                <svg viewBox="0 0 36 36" class="circular-chart1 circular-chart green">
                                                                    <path class="circle-bg" d="M18 2.0845  a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                                                    <path class="circle" stroke-dasharray="94, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                                                    <text x="18" y="20.35" class="percentage">9.4</text>
                                                                </svg>
                                                            </div>
                                                            <div class="col-lg-2 col-sm-9 p-0 text-center">
                                                                <div class="grey mt-5">
                                                                    <h3 style="font-size:18px;"><b><i class="fa fa-inr"></i><span id="tfr_cost"></span></b></h3>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 text-center p-0 mt-1">
                                                                <p class="small"> <i class="fa fa-map-marker"></i> Tracking : Real Time </p>
                                                            </div>
                                                            <div class="col-lg-4 text-center p-0 mt-1">
                                                                <p class="small"> <i class="fa fa-phone"></i> Call Before Delivery : Available </p>
                                                            </div>
                                                            <div class="col-lg-4 text-center p-0 mt-1">
                                                                <p class="small"> <i class="fa fa-address-card"></i> POD : Instant</p>
                                                            </div>
                                                        </div>
                                                    </span>
                                                  </label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row mt-3">
                                        <div class="col-lg-12">     
                                            <div class="form-group text-end">
                                                <button type="submit" class="btn btn-success mt-2" name="add_newOrder">Add Order</button> 
                                            </div>                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 d-sm-block d-none">
                        <div class="card" style="background:url('../assets/img/order_bg1.png'); background-size: cover;background-repeat: no-repeat;">
                            <div class="card-body"> 
                                <div id="map">
                                    <div id="map-layer">
                                      <img src="../assets/img/create_order.jpg" height="260">
                                    </div>
                                    <div class="mt-3">
                                        <img src="../assets/img/5215680.jpg" style="width:100%;  margin: auto; display: block; height:260px;"> 
                                    </div>
                               
                                </div>
                            </div>                         
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
        
   
<?php
include('menu/footer.php');
?>
    <script>
        $(document).ready(function(){
            $(".numeric-input").keypress(function(e) {
                var charCode = (e.which) ? e.which : event.keyCode;
                if(String.fromCharCode(charCode).match(/[^0-9]/g)){
                    return false;
                }
            });
        });
    </script>
    <script>
        
        function validateStep2() {
            var isValid = true;
    
            // Reset previous errors
            $(".text-danger").text("");
    
            
            var lrValue = $("#lr").val().trim();
            var lrType = $("input[name='ltype']:checked").val();
            
            if (!lrType) {
                $("#lrerror").text("Please select LR Type (Manual/Automatic).");
                isValid = false;
            } else if (lrType === "Manual") {
                if (lrValue === "") {
                    $("#lrerror").text("Please enter LR No.");
                    isValid = false;
                }
            } else {
               $("#lrerror").text(""); // Clear any existing error message
            }
    
            // Check for Product Description
            var descriptionValue = $("#description").val().trim();
            if (descriptionValue === "") {
                $("#deserror").text("Please enter Item Description.");
                isValid = false;
            }
    
            // Check for item
            var itemValue = $("#item").val().trim();
            if (itemValue === "") {
                $("#itemerror").text("Please select a item.");
                isValid = false;
            }
    
            // Check for HSN Code
            // var hsnValue = $("#hsn").val().trim();
            // if (hsnValue === "") {
            //     $("#hserror").text("Please enter HSN Code.");
            //     isValid = false;
            // }
            
            
            // check ewaybill
            for(var i = 1; i <= $("#inv_rowcount").val().trim(); i++){
                var ewaybillamount = $("#n_value"+i).val().trim();
                if(ewaybillamount > 49999){
                    if($('#ewaybill'+i).val() == ""){
                        $("#eerror"+i).text("Please enter ewaybill number.");
                        isValid = false;
                    }
                }
            }
            let refNo = $('#ref_no').val();
            if(refNo != ''){
                checkReferenceNo();
                if($('#referror').text() == "Reference no. matched"){}
                else{
                    isValid = false;
                }
            }
            
    
            // Check for empty consignee details fields (except email)
            var consigneeFields = [
                { selector: "#name", errorMessage: "Please enter Customer Name." },
                { selector: "#phone", errorMessage: "Please enter Phone Number." },
                { selector: "#address", errorMessage: "Please enter Address." },
                { selector: "#city", errorMessage: "Please enter City." },
                { selector: "#state", errorMessage: "Please enter State." }
            ];
    
            consigneeFields.forEach(function(field) {
                var value = $(field.selector).val().trim();
                var errorSpan = $(field.selector).siblings(".text-danger");
                if (value === "") {
                    errorSpan.text(field.errorMessage);
                    isValid = false;
                }
            });
    
            // Check for empty GST details fields
            var gstDetailsFields = [
                { selector: "#seller_gst_tin", errorMessage: "Please enter Shipper GSTIN." },
                { selector: "#consignee_gst_tin", errorMessage: "Please enter Consignee GSTIN." }
            ];
    
            gstDetailsFields.forEach(function(field) {
                var value = $(field.selector).val().trim();
                var errorSpan = $(field.selector).siblings(".text-danger");
                if (value === "") {
                    errorSpan.text(field.errorMessage);
                    isValid = false;
                }
            });
            
            return isValid;
        }
    </script>
    
    <script>
        function calculateTotalCharge(weightCharge) {
            var countQty = parseFloat($("#diemension_no").val());
            // alert(countQty);
            var totalQty = parseFloat($("#count0").val());
            for (var i = 1; i <= countQty; i++) { 
                totalQty +=parseFloat($("#count"+i).val()); 
            }
            var sixcft_volweight = parseFloat($("#sixcft_volweight").val());
            var eightcft_volweight = parseFloat($("#eightcft_volweight").val());
            var tencft_volweight = parseFloat($("#tencft_volweight").val());
            var volweightCFT ='';
            var threepl = $("#threepl").val();
            if (threepl === '1') 
            {
                volweightCFT = sixcft_volweight;
            } 
            else if (threepl === '2') 
            {
                volweightCFT = eightcft_volweight;
            }
            else if (threepl === '3')
            {
                volweightCFT = tencft_volweight;
            }
            var total_weight_charge = Number(weightCharge);
            
            var gstCharge = parseFloat($("#gst_charge").val());
            // var weight = parseFloat($("#weight").val());
            var invoice_amount = parseFloat($("#invoice_amount").val());
            // Retrieve values of fixed charges
            var codCharge = parseFloat($("#cod_charge").val());
            var fuelSurcharge = parseFloat($("#fuel_surcharge").val());
            var awbCharge = parseFloat($("#awb_charge").val());
            var fobSurcharge_min = parseFloat($("#fob_surcharge_minimum").val());
            var handlingCharge = parseFloat($("#handeling_charge").val());
            var pickupCharge = parseFloat($("#pickup_charge").val());
            var damageSurcharge = parseFloat($("#damage_surcharge").val());
            var odaSurcharge = parseFloat($("#oda_surcharge").val());
            var packagingSurcharge = parseFloat($("#packaging_surcharge").val());
            var specialDeliveryCharge = parseFloat($("#special_delivery_charge").val());
            
            var cod_charge_min = $("#cod_charge_min").val();
            var damage_surcharge_min = $("#damage_surcharge_min").val();
            var oda_surcharge_min = $("#oda_surcharge_min").val();
            var special_delivery_or_appointment_charge_min = $("#special_delivery_or_appointment_charge_min").val();
            // Retrieve types of fixed charges
            var codChargeType = $("#cod_charge_type").val();
            var fuelSurchargeType = $("#fuel_surcharge_type").val();
           
            var fobSurchargePer = $("#fob_surcharge_percentage").val();
            var handlingChargeType = $("#handeling_charge_type").val();
            var damageSurchargeType = $("#damage_surcharge_type").val();
            var pickupChargeType = $("#pickup_charge_type").val();
            var odaSurchargeType = $("#oda_surcharge_type").val();
            var packagingSurchargeType = $("#packaging_surcharge_type").val();
            var specialDeliveryChargeType = $("#special_delivery_charge_type").val();
    
            var payment_mode = $("#payment_mode").val();
            if (payment_mode !== 'Prepaid') 
            {
                if (codChargeType === 'Percentage') 
                {
                    codCharge = (codCharge / 100) * invoice_amount;
                    codCharge = Math.max(codCharge, cod_charge_min);
                } 
                else if (codChargeType === 'Fixed') 
                {
                    codCharge = Math.max(codCharge, cod_charge_min);
                }
            } 
            else 
            {
                codCharge = 0;
            }
            
            if (fuelSurchargeType === 'Percentage') {
                fuelSurcharge = (fuelSurcharge / 100) * total_weight_charge;
            }
            
            
            var insuranceValue = $("input[name='insurance']:checked").val();
            var fobSurcharge;
            if (insuranceValue === 'Yes') 
            {
                fobSurcharge = invoice_amount * (fobSurchargePer / 100);
                fobSurcharge = Math.max(fobSurcharge, fobSurcharge_min);
            }
            else
            {
                fobSurcharge =fobSurcharge_min;
            }
            
            if (handlingChargeType === 'Kg') {
                handlingCharge = handlingCharge * volweightCFT;
            }
            else if (handlingChargeType === 'Quantity') {
                handlingCharge = handlingCharge * totalQty;
            }
            
            if (pickupChargeType === 'Kg') {
                pickupCharge = pickupCharge * volweightCFT;
            }
            else if (pickupChargeType === 'Quantity') {
                pickupCharge = pickupCharge * totalQty;
            }
            
            if (damageSurchargeType === 'Kg')
            {
                damageSurcharge = damageSurcharge * volweightCFT;
                damageSurcharge = Math.max(damageSurcharge, damage_surcharge_min);
            } 
            else if (damageSurchargeType === 'Quantity')
            {
                damageSurcharge = damageSurcharge * totalQty;
                damageSurcharge = Math.max(damageSurcharge, damage_surcharge_min);
            }
            
            
            
            var oda = $("#oda").val();
            if (oda === 'true')
            {
                if (odaSurchargeType === 'Kg') 
                {
                    odaSurcharge = odaSurcharge * volweightCFT;
                    odaSurcharge = Math.max(odaSurcharge, oda_surcharge_min);
                } 
                else if (odaSurchargeType === 'Quantity')
                {
                    odaSurcharge = odaSurcharge * totalQty;
                    odaSurcharge = Math.max(odaSurcharge, oda_surcharge_min);
                }
            } 
            else 
            {
                odaSurcharge = 0;
            }
            
            if (packagingSurchargeType === 'Kg') 
            {
                packagingSurcharge = (packagingSurcharge) * volweightCFT;
            }
            else if(packagingSurchargeType === 'Quantity')
            {
                packagingSurcharge = (packagingSurcharge) * totalQty;
            }
            
            if (specialDeliveryChargeType === 'Percentage') {
                specialDeliveryCharge = (specialDeliveryCharge / 100) * total_weight_charge;
                specialDeliveryCharge = Math.max(specialDeliveryCharge, special_delivery_or_appointment_charge_min);
            }
            else if(specialDeliveryChargeType === 'Fixed')
            {
                specialDeliveryCharge = Math.max(specialDeliveryCharge, special_delivery_or_appointment_charge_min);
            }
    
            // Calculate total fixed charges
            var totalFixedCharges = Number(codCharge) + Number(fuelSurcharge) + Number(awbCharge) + Number(fobSurcharge) + Number(handlingCharge) + Number(pickupCharge)  + Number(odaSurcharge) + Number(packagingSurcharge);
    
            // Calculate total charge including GST
            var totalCharge = Number(totalFixedCharges) + Number(total_weight_charge);
            
            var gstCharges_spn = Number(Number(gstCharge / 100) * Number(totalCharge));
            
            var total_charge_withGst = Number(totalCharge)+Number(gstCharges_spn);
            
            var Otherscharge =  Number(fobSurcharge) + Number(handlingCharge) + Number(pickupCharge) + Number(packagingSurcharge);
            
            var volweight ='';
            var idPrefix = "";
            if (threepl === '1') 
            {
                idPrefix = "_6cft";
                volweight = sixcft_volweight;
            } 
            else if (threepl === '2') 
            {
                idPrefix = "_8cft";
                volweight = eightcft_volweight;
            }
            else if (threepl === '3')
            {
                idPrefix = "_10cft";
                volweight = tencft_volweight;
            }
            // Update the values for each input field
            $("#total_charge" + idPrefix).val(total_charge_withGst.toFixed(2));
            $("#cod_charge" + idPrefix).val(codCharge.toFixed(2));
            $("#fuel_surcharge" + idPrefix).val(fuelSurcharge.toFixed(2));
            $("#awb_charge" + idPrefix).val(awbCharge.toFixed(2));
            $("#fob_surcharge" + idPrefix).val(fobSurcharge.toFixed(2));
            $("#handeling_charge" + idPrefix).val(handlingCharge.toFixed(2));
            $("#pickup_charge" + idPrefix).val(pickupCharge.toFixed(2));
            $("#damage_surcharge" + idPrefix).val(damageSurcharge.toFixed(2));
            $("#oda_surcharge" + idPrefix).val(odaSurcharge.toFixed(2));
            $("#packaging_surcharge" + idPrefix).val(packagingSurcharge.toFixed(2));
            $("#special_delivery_charge" + idPrefix).val(specialDeliveryCharge.toFixed(2));
            $("#weight_charge" + idPrefix).val(total_weight_charge);
            
            var igst_per = $("#igst_per").val();
            var cgst_per = $("#cgst_per").val();
            var sgst_per = $("#sgst_per").val();
            
            var igst_amount = (Number(igst_per) / 100 * Number(totalCharge)).toFixed(2);
            var cgst_amount = (Number(cgst_per) / 100 * Number(totalCharge)).toFixed(2);
            var sgst_amount = (Number(sgst_per) / 100 * Number(totalCharge)).toFixed(2);
            
            $("#igst"+ idPrefix).val(igst_amount);
            $("#cgst"+ idPrefix).val(cgst_amount);
            $("#sgst"+ idPrefix).val(sgst_amount);
            
            $("#fuel_charge").text(fuelSurcharge.toFixed(2));
            $("#awb_charge_spn").text(awbCharge.toFixed(2));
            $("#gst_charge_spn").text(gstCharges_spn.toFixed(2));
            $("#cod_charge_spn").text(codCharge.toFixed(2));
            $("#oda_charge_spn").text(odaSurcharge.toFixed(2));
            $("#damage_charge_spn").text(damageSurcharge.toFixed(2));
            $("#others_charges").text(Otherscharge.toFixed(2));
            $("#tfr_cost").text(total_charge_withGst.toFixed(2));
            $("#weight_charge").text(total_weight_charge);
            $("#vol_weight").text('Vol. Weight: '+volweight+' Kg');

        }
    </script>
    <script>
        function calculateTotalCharge_all(freight_cost_sixcft_volweight,freight_cost_eightcft_volweight,freight_cost_tencft_volweight) {
            calculateTotalChargeForCubicFeet(freight_cost_sixcft_volweight, "_6cft");
            calculateTotalChargeForCubicFeet(freight_cost_eightcft_volweight, "_8cft");
            calculateTotalChargeForCubicFeet(freight_cost_tencft_volweight, "_10cft");
        }
        
        function calculateTotalChargeForCubicFeet(weightCharge, idPrefix) {
                
            var countQty = parseFloat($("#diemension_no").val());
            // alert(countQty);
            var totalQty = parseFloat($("#count0").val());
            for (var i = 1; i <= countQty; i++) { 
                totalQty +=parseFloat($("#count"+i).val()); 
            }
            
            var sixcft_volweight = parseFloat($("#sixcft_volweight").val());
            var eightcft_volweight = parseFloat($("#eightcft_volweight").val());
            var tencft_volweight = parseFloat($("#tencft_volweight").val());
            var vol_cftweight;
            var total_weight_charge;
            if (idPrefix === "_6cft")
            {
               vol_cftweight = sixcft_volweight;
            } 
            else if (idPrefix === "_8cft")
            {
                vol_cftweight = eightcft_volweight;
            } 
            else if (idPrefix === "_10cft")
            {
                vol_cftweight = tencft_volweight;
            }
            
            total_weight_charge= Number(weightCharge);  
            
            // alert(total_weight_charge);
            var gstCharge = parseFloat($("#gst_charge").val());
            // var weight = parseFloat($("#weight").val());
            var invoice_amount = parseFloat($("#invoice_amount").val());
            // Retrieve values of fixed charges
            var codCharge = parseFloat($("#cod_charge").val());
            var fuelSurcharge = parseFloat($("#fuel_surcharge").val());
            var awbCharge = parseFloat($("#awb_charge").val());
            var fobSurcharge_min = parseFloat($("#fob_surcharge_minimum").val());
            var handlingCharge = parseFloat($("#handeling_charge").val());
            var pickupCharge = parseFloat($("#pickup_charge").val());
            var damageSurcharge = parseFloat($("#damage_surcharge").val());
            var odaSurcharge = parseFloat($("#oda_surcharge").val());
            var packagingSurcharge = parseFloat($("#packaging_surcharge").val());
            var specialDeliveryCharge = parseFloat($("#special_delivery_charge").val());
            
            var cod_charge_min = $("#cod_charge_min").val();
            var damage_surcharge_min = $("#damage_surcharge_min").val();
            var oda_surcharge_min = $("#oda_surcharge_min").val();
            var special_delivery_or_appointment_charge_min = $("#special_delivery_or_appointment_charge_min").val();
            // Retrieve types of fixed charges
            var codChargeType = $("#cod_charge_type").val();
            var fuelSurchargeType = $("#fuel_surcharge_type").val();
           
            var fobSurchargePer = $("#fob_surcharge_percentage").val();
            var handlingChargeType = $("#handeling_charge_type").val();
            var damageSurchargeType = $("#damage_surcharge_type").val();
            var pickupChargeType = $("#pickup_charge_type").val();
            var odaSurchargeType = $("#oda_surcharge_type").val();
            var packagingSurchargeType = $("#packaging_surcharge_type").val();
            var specialDeliveryChargeType = $("#special_delivery_charge_type").val();
            
            var payment_mode = $("#payment_mode").val();
            // Calculate COD charge based on payment mode and type
            if (payment_mode !== 'Prepaid') {
                if (codChargeType === 'Percentage') {
                    codCharge = (codCharge / 100) * invoice_amount;
                    codCharge = Math.max(codCharge, cod_charge_min);
                } else if (codChargeType === 'Fixed') {
                    codCharge = Math.max(codCharge, cod_charge_min);
                }
            } else {
                codCharge = 0;
            }
            
            // Calculate fuel surcharge based on type
            if (fuelSurchargeType === 'Percentage') {
                fuelSurcharge = (fuelSurcharge / 100) * total_weight_charge;
            }
            
            // Calculate FOB surcharge based on insurance value
            var insuranceValue = $("input[name='insurance']:checked").val();
            var fobSurcharge;
            if (insuranceValue === 'Yes') {
                fobSurcharge = invoice_amount * (fobSurchargePer / 100);
                fobSurcharge = Math.max(fobSurcharge, fobSurcharge_min);
            } else {
                fobSurcharge = fobSurcharge_min;
            }
            
            // Calculate handling charge based on type
            if (handlingChargeType === 'Kg') {
                handlingCharge = handlingCharge * vol_cftweight;
            } else if (handlingChargeType === 'Quantity') {
                handlingCharge = handlingCharge * totalQty;
            }
            
            // Calculate pickup charge based on type
            if (pickupChargeType === 'Kg') {
                pickupCharge = pickupCharge * vol_cftweight;
            } else if (pickupChargeType === 'Quantity') {
                pickupCharge = pickupCharge * totalQty;
            }
            
            // Calculate damage surcharge based on type
            if (damageSurchargeType === 'Kg') {
                damageSurcharge = damageSurcharge * vol_cftweight;
                damageSurcharge = Math.max(damageSurcharge, damage_surcharge_min);
            } else if (damageSurchargeType === 'Quantity') {
                damageSurcharge = damageSurcharge * totalQty;
                damageSurcharge = Math.max(damageSurcharge, damage_surcharge_min);
            }
            
            // Calculate ODA surcharge based on type and condition
            var oda = $("#oda").val();
            if (oda === 'true') {
                if (odaSurchargeType === 'Kg') {
                    odaSurcharge = odaSurcharge * vol_cftweight;
                    odaSurcharge = Math.max(odaSurcharge, oda_surcharge_min);
                } else if (odaSurchargeType === 'Quantity') {
                    odaSurcharge = odaSurcharge * totalQty;
                    odaSurcharge = Math.max(odaSurcharge, oda_surcharge_min);
                }
            } else {
                odaSurcharge = 0;
            }
            
            // Calculate packaging surcharge based on type
            if (packagingSurchargeType === 'Kg') {
                packagingSurcharge = (packagingSurcharge) * vol_cftweight;
            } else if (packagingSurchargeType === 'Quantity') {
                packagingSurcharge = (packagingSurcharge) * totalQty;
            }
            
            // Calculate special delivery charge based on type
            if (specialDeliveryChargeType === 'Percentage') {
                specialDeliveryCharge = (specialDeliveryCharge / 100) * total_weight_charge;
                specialDeliveryCharge = Math.max(specialDeliveryCharge, special_delivery_or_appointment_charge_min);
            } else if (specialDeliveryChargeType === 'Fixed') {
                specialDeliveryCharge = Math.max(specialDeliveryCharge, special_delivery_or_appointment_charge_min);
            }
        
            // Calculate total fixed charges
            var totalFixedCharges = Number(codCharge) + Number(fuelSurcharge) + Number(awbCharge) + Number(fobSurcharge) + Number(handlingCharge) + Number(pickupCharge) + Number(odaSurcharge) + Number(packagingSurcharge);
           
            
            // Calculate total charge including GST
            var totalCharge = Number(totalFixedCharges) + Number(total_weight_charge);
            
            var gstCharges_spn = Number(Number(gstCharge / 100) * Number(totalCharge));
            
            var total_charge_withGst = Number(totalCharge)+Number(gstCharges_spn);
            
            var Otherscharge =  Number(fobSurcharge) + Number(handlingCharge) + Number(pickupCharge) + Number(packagingSurcharge);
        
            // Update the values for each input field
            $("#total_charge" + idPrefix).val(total_charge_withGst.toFixed(2));
            $("#cod_charge" + idPrefix).val(codCharge.toFixed(2));
            $("#fuel_surcharge" + idPrefix).val(fuelSurcharge.toFixed(2));
            $("#awb_charge" + idPrefix).val(awbCharge.toFixed(2));
            $("#fob_surcharge" + idPrefix).val(fobSurcharge.toFixed(2));
            $("#handeling_charge" + idPrefix).val(handlingCharge.toFixed(2));
            $("#pickup_charge" + idPrefix).val(pickupCharge.toFixed(2));
            $("#damage_surcharge" + idPrefix).val(damageSurcharge.toFixed(2));
            $("#oda_surcharge" + idPrefix).val(odaSurcharge.toFixed(2));
            $("#packaging_surcharge" + idPrefix).val(packagingSurcharge.toFixed(2));
            $("#special_delivery_charge" + idPrefix).val(specialDeliveryCharge.toFixed(2));
            $("#weight_charge" + idPrefix).val(total_weight_charge);
            
            var igst_per = $("#igst_per").val();
            var cgst_per = $("#cgst_per").val();
            var sgst_per = $("#sgst_per").val();
            
            var igst_amount = (Number(igst_per) / 100 * Number(totalCharge)).toFixed(2);
            var cgst_amount = (Number(cgst_per) / 100 * Number(totalCharge)).toFixed(2);
            var sgst_amount = (Number(sgst_per) / 100 * Number(totalCharge)).toFixed(2);
            
            $("#igst"+ idPrefix).val(igst_amount);
            $("#cgst"+ idPrefix).val(cgst_amount);
            $("#sgst"+ idPrefix).val(sgst_amount);
            
            var volweightCFT ='';
            var a;
            for (var c = 1; c <= 3; c++) {
                if (idPrefix === "_6cft")
                {
                    a = 1; 
                    volweightCFT = sixcft_volweight;
                } 
                else if (idPrefix === "_8cft")
                {
                    a = 2;
                    volweightCFT = eightcft_volweight;
                } 
                else if (idPrefix === "_10cft")
                {
                    a = 3;
                     volweightCFT = tencft_volweight;
                }
                $("#fuel_charge" + a).text(fuelSurcharge.toFixed(2));
                $("#awb_charge_spn" + a).text(awbCharge.toFixed(2));
                $("#gst_charge_spn" + a).text(gstCharges_spn.toFixed(2));
                $("#cod_charge_spn" + a).text(codCharge.toFixed(2));
                $("#oda_charge_spn" + a).text(odaSurcharge.toFixed(2));
                $("#damage_charge_spn" + a).text(damageSurcharge.toFixed(2));
                $("#others_charges" + a).text((fobSurcharge + handlingCharge + pickupCharge + packagingSurcharge + specialDeliveryCharge).toFixed(2));
                $("#tfr_cost" + a).text(total_charge_withGst.toFixed(2));
                $("#weight_charge" + a).text(total_weight_charge);
                $("#vol_weight" + a).text('Vol. Weight: ' + volweightCFT + ' Kg');
            }
        }
    </script>
    
    <script>
        $(document).ready(function(){
            function showWarnings(message) {
                swal("Warning!", message, "warning");
            }
            $("#part-1").show();
            $("#part-2").hide();
            $("#part-3").hide();
            $("#step1").click(function(){
                if($("input[name=orderForUser]").val() == ""){
                    $("#orderForUser-error").text('Invalid User');
                    return false;
                }
                // Retrieve all field values
                var pin = $("#pin").val().trim();
                var warehouse_id = $("#warehouse_id").val().trim();
                var del_pin = $("#del_pin").val().trim();
                var weight = $("#weight").val().trim();
                var count = $("#count0").val().trim();
                var length = $("#length0").val().trim();
                var width = $("#width0").val().trim();
                var height = $("#height0").val().trim();
                var payment_mode = $("#payment_mode").val();
                var invoice_amount = $("#invoice_amount").val().trim();
                var cod_amount = $("#cod_amount").val().trim();
                var profit = $("#profit").val().trim();
                var insurance = $("input[name='insurance']:checked").val();
        
                // Select individual span error elements
                var pin_error = $("#pin_alert");
                var ware_error = $("#ware_error");
                var pin_error2 = $("#pinerror2");
                var weight_error = $("#weighterror");
                var count_error = $("#cerror");
                var length_error = $("#lerror");
                var width_error = $("#werror");
                var height_error = $("#herror");
                var mode_error = $("#modeerror");
                var cod_error = $("#coderror");
                var inv_error = $("#inverror");
                var insurance_error = $("#insuranceerror");
        
                // Reset previous errors
                pin_error.text("");
                ware_error.text("");
                pin_error2.text("");
                weight_error.text("");
                count_error.text("");
                length_error.text("");
                width_error.text("");
                height_error.text("");
                mode_error.text("");
                cod_error.text("");
                inv_error.text("");
                insurance_error.text("");
        
                // Check if any field is empty
                if (pin === "" || warehouse_id === "" || del_pin === "" || weight === "" || count === "" || length === "" || width === "" || height === "" || payment_mode === "" || invoice_amount === "" || !insurance) {
                    // Display error for empty fields
                    if (pin === "") pin_error.text("Please enter Origin Pincode.");
                    if (warehouse_id === "") ware_error.text("Please choose a warehouse.");
                    if (del_pin === "") pin_error2.text("Please enter Destination Pincode.");
                    if (weight === "") weight_error.text("Please enter Total Weight.");
                    if (count === "") count_error.text("Please enter Qty.");
                    if (length === "") length_error.text("Please enter Length.");
                    if (width === "") width_error.text("Please enter Width.");
                    if (height === "") height_error.text("Please enter Height.");
                    if (payment_mode === "") mode_error.text("Please choose Payment Mode.");
                    if (invoice_amount === "") inv_error.text("Please enter Invoice Value.");
                    if (!insurance) insurance_error.text("Please select Insurance.");
                    // Show error message and return
                    $("#part-1").show();
                    $("#part-2").hide();
                    $("#part-3").hide();
                    return;
                }
        
                // Check conditions for specific fields
                if ((payment_mode === "CoD" && cod_amount === "") || (payment_mode === "Franchise-ToPay" && profit === "")) {
                    // Display error for specific conditions
                    if (payment_mode === "CoD" && cod_amount === "") cod_error.text("Please enter COD Amount.");
                    if (payment_mode === "Franchise-ToPay" && profit === "") mode_error.text("Please enter Profit Amount.");
        
                    // Show error message and return
                    $("#part-1").show();
                    $("#part-2").hide();
                    $("#part-3").hide();
                    return;
                }
                
                
                
                var dimensions_in = $("#dimensions_in").val();
                var countQty = parseFloat($("#diemension_no").val());
                var Mainweight = parseFloat($("#weight").val());
                var min_charge_weight = parseFloat($("#min_charge_weight").val());
                if(min_charge_weight > Mainweight)
                {
                    Mainweight = min_charge_weight;
                }
                var sixcft_volweight=0;
                var eightcft_volweight=0;
                var tencft_volweight=0;
                
                
                var totalLength;
                var totalWidth;
                var totalHeight;
                var total_Qty;
                // Summing up individual dimensions
                for (var i = 0; i <= countQty; i++) { 
                    // alert(i);
                    totalLength = parseFloat($("#length" + i).val());
                    totalWidth = parseFloat($("#width" + i).val()); 
                    totalHeight = parseFloat($("#height" + i).val()); 
                    total_Qty = parseFloat($("#count" + i).val());
                    if (dimensions_in === 'IN') {
                        totalLength *= 2.54;
                        totalWidth *= 2.54;
                        totalHeight *= 2.54;
                    }
                    sixcft_volweight = Number(Number(sixcft_volweight) + Number((((totalLength * totalWidth * totalHeight) / 27000) * 6) * total_Qty));
                    eightcft_volweight = Number(Number(eightcft_volweight) + Number((((totalLength * totalWidth * totalHeight) / 27000) * 8) * total_Qty));
                    tencft_volweight = Number(Number(tencft_volweight) + Number((((totalLength * totalWidth * totalHeight) / 27000) * 10) * total_Qty));
                }
                
                // Convert to two decimal places
                sixcft_volweight = parseFloat(sixcft_volweight).toFixed(2);
                eightcft_volweight = parseFloat(eightcft_volweight).toFixed(2);
                tencft_volweight = parseFloat(tencft_volweight).toFixed(2);
                
                // Compare Mainweight with volume weights and update corresponding fields
                $('#sixcft_volweight').val(Mainweight > sixcft_volweight ? Mainweight : sixcft_volweight);
                $('#eightcft_volweight').val(Mainweight > eightcft_volweight ? Mainweight : eightcft_volweight);
                $('#tencft_volweight').val(Mainweight > tencft_volweight ? Mainweight : tencft_volweight);
                // $("#weight").val(Mainweight);
                var total_no_of_boxes = $("#total_no_of_boxes").val();
                var total_boxes=0;
                for (var i = 0; i <= countQty; i++) { 
                    total_boxes = total_boxes + Number($("#count" + i).val());
                }
                
                if(total_no_of_boxes != total_boxes)
                {
                    showWarnings('Total Qty Should Be Same As Total Boxes!!');
                    $("#part-1").show();
                    $("#part-2").hide();
                    $("#part-3").hide();
                    return;
                }
                
                // If all conditions met, proceed to the next part
                $("#part-1").hide();
                $("#part-2").show();
                $("#part-3").hide();
            });
            $("#step2").click(function(){
                $("#part-1").show();
                $("#part-2").hide();
                $("#part-3").hide();
            });
            
            $("#step2_next").click(function(){
                // Validate step 2 fields
                var isValid = validateStep2();
                
                if (isValid) {
                    
                    let pick_pin = $("#pin").val();
                    let del_pin = $("#del_pin").val();
                    let type = 'users';
                    let type_id = $("#type_id").val();
                    var sixcft_volweight = parseFloat($("#sixcft_volweight").val());
                    var eightcft_volweight = parseFloat($("#eightcft_volweight").val());
                    var tencft_volweight = parseFloat($("#tencft_volweight").val());
                    var threepl = $("#threepl").val();
                    var freight_type = $("#freight_type").val();
                    if(freight_type == 'Weight')
                    {
                        if(threepl=='all')
                        {
                            $.ajax({
                                url: "../user/rate_calculation.php",
                                type: "POST",
                                data: {
                                    pick_pin: pick_pin,
                                    del_pin: del_pin,
                                    type: type,
                                    type_id: type_id,
                                    sixcft_volweight: sixcft_volweight,
                                    eightcft_volweight: eightcft_volweight,
                                    tencft_volweight: tencft_volweight,
                                },
                                success: function(data) {
                                    if(data =='N')
                                    {
                                        showWarnings('Something went error!!');
                                        $("#part-1").hide();
                                        $("#part-2").show();
                                        $("#part-3").hide();
                                    }
                                    else
                                    {
                                        var f_cost_array = JSON.parse(data);
                                        var freight_cost_sixcft_volweight = f_cost_array[0];
                                        var freight_cost_eightcft_volweight = f_cost_array[1];
                                        var freight_cost_tencft_volweight = f_cost_array[2];
                                        $("#part-1").hide();
                                        $("#part-2").hide();
                                        $("#part-3").show();
                                        calculateTotalCharge_all(freight_cost_sixcft_volweight,freight_cost_eightcft_volweight,freight_cost_tencft_volweight);
                                    }
                                    
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error: " + status + " - " + error);
                                }
                            });
                        }
                        else if (threepl=='1')
                        {
                            $.ajax({
                                url: "../user/rate_calculation.php",
                                type: "POST",
                                data: {
                                    pick_pin: pick_pin,
                                    del_pin: del_pin,
                                    type: type,
                                    type_id: type_id,
                                    volweight: sixcft_volweight
                                },
                                success: function(data) {
                                    if(data =='N')
                                    {
                                        showWarnings('Something went error!!');
                                        $("#part-1").hide();
                                        $("#part-2").show();
                                        $("#part-3").hide();
                                    }
                                    else
                                    {
                                        $("#part-1").hide();
                                        $("#part-2").hide();
                                        $("#part-3").show();
                                        calculateTotalCharge(parseFloat(data));
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error: " + status + " - " + error);
                                }
                            });
                        }
                        else if (threepl=='2')
                        {
                            $.ajax({
                                url: "../user/rate_calculation.php",
                                type: "POST",
                                data: {
                                    pick_pin: pick_pin,
                                    del_pin: del_pin,
                                    type: type,
                                    type_id: type_id,
                                    volweight: eightcft_volweight
                                },
                                success: function(data) {
                                    if(data =='N')
                                    {
                                        showWarnings('Something went error!!');
                                        $("#part-1").hide();
                                        $("#part-2").show();
                                        $("#part-3").hide();
                                    }
                                    else
                                    {
                                        $("#part-1").hide();
                                        $("#part-2").hide();
                                        $("#part-3").show();
                                        calculateTotalCharge(parseFloat(data));
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error: " + status + " - " + error);
                                }
                            });
                        }
                        else if (threepl=='3')
                        {
                            $.ajax({
                                url: "../user/rate_calculation.php",
                                type: "POST",
                                data: {
                                    pick_pin: pick_pin,
                                    del_pin: del_pin,
                                    type: type,
                                    type_id: type_id,
                                    volweight: tencft_volweight
                                },
                                success: function(data) {
                                    if(data =='N')
                                    {
                                        showWarnings('Something went error!!');
                                        $("#part-1").hide();
                                        $("#part-2").show();
                                        $("#part-3").hide();
                                    }
                                    else
                                    {
                                        $("#part-1").hide();
                                        $("#part-2").hide();
                                        $("#part-3").show();
                                        calculateTotalCharge(parseFloat(data));
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error: " + status + " - " + error);
                                }
                            });
                        }
                        
                    }
                    else
                    {
                        var countQty = parseFloat($("#diemension_no").val());
                        // alert(countQty);
                        var totalQty = parseFloat($("#count0").val());
                        for (var i = 1; i <= countQty; i++) { 
                            totalQty +=parseFloat($("#count"+i).val()); 
                        }
                        
                        $.ajax({
                                url: "../user/rate_calculation.php",
                                type: "POST",
                                data: {
                                    pick_pin: pick_pin,
                                    del_pin: del_pin,
                                    type: type,
                                    type_id: type_id,
                                    totalQty: totalQty
                                },
                                success: function(data) {
                                    if(data =='N')
                                    {
                                        showWarnings('Something went error!!');
                                        $("#part-1").hide();
                                        $("#part-2").show();
                                        $("#part-3").hide();
                                    }
                                    else
                                    {
                                        $("#part-1").hide();
                                        $("#part-2").hide();
                                        $("#part-3").show();
                                        calculateTotalCharge(parseFloat(data));
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error: " + status + " - " + error);
                                }
                            });
                    }
                }
            });
            
            $("#step3_prev").click(function(){
                $("#part-1").hide();
                $("#part-2").show();
                $("#part-3").hide();
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#codtype").hide();
            $("#ftype").hide();
            $("#payment_mode").change(function(){
                let payment_mode = $(this).val();
                if(payment_mode == 'CoD')
                {
                    $("#codtype").show();
                    $("#ftype").hide();
                }
                else if(payment_mode =='Franchise-ToPay')
                {
                    $("#codtype").hide();
                    $("#ftype").show();
                }
                else
                {
                    $("#codtype").hide();
                    $("#ftype").hide();
                }
            });
            $("input[name='ltype']").click(function(){
                let ltype = $(this).val();
                if(ltype == 'Manual')
                {
                     $("input[name='lr']").prop("readonly", false);
                }
                else if(ltype == 'Automatic')
                {
                     $("input[name='lr']").prop("readonly", true);
                     $("#lr").val('');
                }
            });
            
        });
    </script>
    <script>
        $(document).ready(function(){
        $("#add_weight").click(function(){
            let diemension_no = $("#diemension_no").val();
            diemension_no++;
            $("#diemension_no").val(diemension_no);
            let dimension_row = `<div class="row" id="row`+diemension_no+`">
                        <div class="col-lg-2"> 
                          <div class="form-group">
                            <label class="control-label mb-1">Qty <span class="text-danger">*</span></label>
                            <input name="qty[]" id="count`+diemension_no+`" type="text" placeholder="Qty" class="count form-control" >

                          </div>
                        </div> 
                        <div class="col-lg-3">   
                            <div class="form-group">
                                <label class="control-label mb-1">Length <span class="text-danger">*</span></label>
                                <input name="length[]" id="length`+diemension_no+`" type="text" placeholder="Length" class="form-control w-95" >
                                
                            </div>
                        </div>
                        <div class="col-lg-3">   
                            <div class="form-group">
                                <label class="control-label mb-1">Width <span class="text-danger">*</span></label>
                                <input name="width[]" id="width`+diemension_no+`" type="text" placeholder="Width" class="form-control w-95" > 
                                
                          </div>  
                       </div>
                        <div class="col-lg-3">    
                            <div class="form-group"> 
                                <label class="control-label mb-1">Height <span class="text-danger">*</span></label>
                                <input name="height[]" id="height`+diemension_no+`" type="text" placeholder="Height" class="form-control w-95">
                                
                            </div>
                        </div> 
                        <div class="col-lg-1 mt-4">  
                            <div class="text-center">
                                <button id="remove_weight`+diemension_no+`" type="button" class=" btn btn-danger btn-sm"><i class="bx bxs-minus-circle"></i></button>
                            </div> 
                        </div>
                    </div>`;
            $("#dimension").append(dimension_row);
                $("#remove_weight"+diemension_no).click(function(){
                let diemension_no = $("#diemension_no").val();
                $("#row"+diemension_no).remove();
                diemension_no--;
                $("#diemension_no").val(diemension_no);
                
            });
        });
        
    })
    </script>
    <script>
        function validatePhoneNumberKey(e) {
            var charCode = (e.which) ? e.which : event.keyCode;
            if(String.fromCharCode(charCode).match(/[^0-9]/g)){
                return false;
            }
        }
        document.getElementById("pin").addEventListener("keydown", validatePhoneNumberKey);
        document.getElementById("phone").addEventListener("keydown", validatePhoneNumberKey);
    </script>
    <script>
        $(document).ready(function() {
            function showWarning(message) {
                swal("Warning!", message, "warning");
            }
            $("#add_warehouse").hide();
            $('#pin').blur(function() {
                let pin = $(this).val();
                let type = 'users';
                let type_id = $("#type_id").val();
                if (pin.length === 6) {
                    $.ajax({
                        url: "action",
                        type: "POST",
                        data: {
                            pin: pin,
                            type: type,
                            type_id: type_id,
                        },
                        success: function(data) {
                            if(data =="no_ware"){
                                showWarning('No Warehouse exist on this pincode!!');
                                $('button[name="step1"]').prop('disabled', true);
                                var option = '<option value="" hidden>Choose Warehouse</option>';
                                $("#warehouse_id").html(option);
                                $("#add_warehouse").show();
                                return false;
                            }
                            else{
                                $("#warehouse_id").html(data);
                                $('button[name="step1"]').prop('disabled', false);
                                $("#add_warehouse").hide();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error: " + status + " - " + error);
                        }
                    });
                    $('#pin_alert').text('');
                    $(this).css('border-color', '');
                } else {
                    $('#pin_alert').text('Please enter a valid pincode');
                    $(this).css('border-color', 'red');
                    return false;
                }
            });
        });
    </script>
    <script>
        function displayErrorMessage(error_message) {
            swal("Error!", error_message, "error");
        }
        $('#del_pin').blur(function() {
            let del_pin = $(this).val();
            let type = 'users';
            let type_id = $("#type_id").val();
            let cft = 'all';
            if(cft!=='')
            {
                $.ajax({
                url: "action",
                type: "POST",
                data: {
                    pin_w: del_pin,
                    type_w: type,
                    type_id_w: type_id,
                    cft : cft
                },
                
                success: function(data) {
                    if (data == 'N') 
                    {
                        $('#pinerror2').text('This pincode is not deliveriable');
                        $(this).css('border-color', 'red');
                        $('#step1').prop('disabled', true);
                        return false;
                    }
                    else if (data =='Y') 
                    {
                        $.ajax({
                            url: "action",
                            type: "POST",
                            data: {
                                del_pin: del_pin,
                                type_d: type,
                                type_id_d: type_id,
                                cft : cft
                            },
                            success: function(data) {
                                var responseData = JSON.parse(data);
                                $("#state").val(responseData.state);
                                $("#city").val(responseData.city);
                                $("#oda").val(responseData.oda);
                                if(responseData.oda == "true")
                                {
                                    $("#oda_status").text('ODA Available For this pincode');
                                }
                                else
                                {
                                    $("#oda_status").text('');
                                }
                            },
                        });
                        
                        $('#pinerror2').text('');
                        $(this).css('border-color', '');
                        $('#step1').prop('disabled', false);
                    }else if(data == 'NTR'){
                        $('#pinerror2').text('System can\'t take the request right now! Please! Try again later');
                        $(this).css('border-color', 'red');
                        $('#step1').prop('disabled', true);
                        return false;
                    }
                }
            });
            }
            else
            {
                displayErrorMessage("Enter Valid Pickup Pin");
            }
        });
    </script>
    <script>
        
        function addRow() {
            var rowCount = $("#inv_rowcount").val();
            rowCount++;
            $("#inv_rowcount").val(rowCount);
            var newRow =
                `<div class="row" id="invoice_row${rowCount}">
                    <div class="col-lg-4">     
                        <div class="form-group">
                            <label class="control-label mb-1">Ewaybill</label>
                            <input name="ewaybill[]" id="ewaybill${rowCount}" type="text" placeholder="ewaybill" class="form-control">
                            <span id="eerror${rowCount}" class="text-danger"></span> 
                        </div>
                    </div>
                    <div class="col-lg-3">     
                        <div class="form-group">
                            <label class="control-label mb-1">Amount <span class="text-danger">*</span></label>
                            <input name="n_value[]" id="n_value${rowCount}" value="" type="text" placeholder="Amount" class="amt form-control" required>
                            <span id="nerror${rowCount}" class="text-danger"></span> 
                        </div>
                    </div>
                    <div class="col-lg-3">     
                        <div class="form-group">
                            <label class="control-label mb-1">Invoice No. <span class="text-danger">*</span></label>
                            <input type="text" id="inv${rowCount}" name="inv[]" placeholder="Invoice No." class="form-control" required>
                            <span id="ierror${rowCount}" class="text-danger"></span>    
                        </div>
                    </div>
                    <div class="col-lg-2 text-center mt-4">
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${rowCount})">Delete</button> 
                    </div>
                </div>`;
            
            $('#pay-invoice').append(newRow);
            
        }
    
        function deleteRow(rowId) {
            $('#invoice_row' + rowId).remove(); // Remove the row with given ID
        }
    </script>
    <script>
        function validateCft() {
            if (!$("input[name='cft_type']").is(":checked")) {
                alert("Please select a shipment charge type.");
                return false;
            }else{
                blurBody();
                $('body').prepend(loader('fixed'));
                $('button[name=add_newOrder]').parent('div').append(`<input type="hidden" name="add_Users_Order">`);
                $('button[name=add_newOrder]').html(`<span class="spinner-border spinner-border-sm text-white" style="margin: 4px 20px;"></span>`);
                $('button[name=add_newOrder]').attr('disabled', true);
                return true;
            }
        }
        $(document).ready(function(){
            if($("select[name=orderForUser]").val() == ""){
                warningToast('At First Choose User to Order');
            }
        });
    </script>
    <script>
        function checkReferenceNo() {
            var refNo = $('#ref_no').val();
            let type = 'users';
            let type_id = $("#type_id").val();
            if(refNo !='')
            {
                $.ajax({
                    url: 'action',
                    type: 'POST',
                    data: { ref_no: refNo,
                            type : type,
                            type_id : type_id
                        },
                    success: function(response) {
                        if(response =='EXIST')
                        {
                            $('#referror').removeClass('text-success').addClass('text-danger').text('Reference no already used');
                        }
                        else if(response =='RNT')
                        {
                            $('#referror').removeClass('text-success').addClass('text-danger').text('Please enter a valid ref. no');
                        }
                        else if(response =='REFOK')
                        {
                            $('#referror').removeClass('text-danger').addClass('text-success');
                            $('#referror').text('Reference no. matched');
                        }
                        else if (response === 'NOROWS') {
                            $('#referror').removeClass('text-success').addClass('text-danger').text('Reference no not allotted');
                        }
                    },
                    error: function() {
                        $('#referror').removeClass('text-success').addClass('text-danger').text('An error occurred while checking the reference number.');
                    }
                });
            }
       }
    </script>