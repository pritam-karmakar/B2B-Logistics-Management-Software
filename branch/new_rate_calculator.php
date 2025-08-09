<?php
$page=13;
include('menu/header.php');
include('menu/navbar.php');
?>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-xl">
                            <div class="card mb-4">
                                <hr class="my-0">
                                <div class="card-body">
                                    <form id="formAccountSettings" method="POST" onsubmit="return false">
                                        <div class="row">
                                            <h4 class="card-header d-flex justify-content-between align-items-center">Rate Calculator</h4>
                                            <div class="mb-3 col-md-10">
                                                <label>Shipment Type</label>
                                                <div class="col-md">
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input" type="radio" name="shipment_type" id="inlineRadio1" value="Delivered" >
                                                        <label class="form-check-label" for="inlineRadio1">Forward</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="shipment_type" id="inlineRadio2" value="RTO">
                                                        <label class="form-check-label" for="inlineRadio2">Return</label>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <!--<div class="mb-3 col-md-5">-->
                                                <!--<label>Order Type</label>-->
                                                <!--<div class="col-md">-->
                                                <!--    <div class="form-check form-check-inline mt-3">-->
                                                <!--        <input class="form-check-input" type="radio" name="order_type" id="inlineRadio3" value="Surface">-->
                                                <!--        <label class="form-check-label" for="inlineRadio3">Surface</label>-->
                                                <!--    </div>-->
                                                <!--    <div class="form-check form-check-inline">-->
                                                <!--        <input class="form-check-input" type="radio" name="order_type" id="inlineRadio4" value="Surface">-->
                                                <!--        <label class="form-check-label" for="inlineRadio4">Area</label>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                            <!--</div>-->
                
                
                                            <div class="mb-3 col-md-5">
                                              <label class="form-label" for="basic-default-fullname">Pickup Pincode</label>
                                              <input type="number" class="form-control pick_pincode" id="basic-default-fullname" placeholder="Enter 6 digit pickup area pincode" />
                                              <span style="color:red;font-family:math" id="pick_error"></span>
                                            </div>
                
                
                                            <div class="mb-3 col-md-5">
                                              <label class="form-label" for="basic-default-company">Delevery Pincode</label>
                                              <input type="number" class="form-control del_pincode" id="basic-default-company" placeholder="Enter 6 digit delivery area pincode"  />
                                              <span style="color:red;font-family:math" id="del_error"></span>
                                            </div>
                
                
                                            <div class="mb-3 col-md-5">
                                                <label class="form-label" for="basic-default-company">Actual Weight</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="0.00" id="weight" aria-label="Amount (to the nearest dollar)">
                                                    <span class="input-group-text">KG</span>
                                                </div>
                                            </div>
                
                
                                            <div class="mb-1 col-md-6 ">
                                                <label class="form-label" for="basic-default-company">Dimensions (Optional)</label>
                                                <div class="input-group display-flex">
                                                    <input type="text" class="form-control" placeholder="L" aria-label="Amount (to the nearest dollar)">
                                                    <span class="input-group-text">CM</span>&nbsp; &nbsp; &nbsp; &nbsp;
                
                                                    <input type="text" class="form-control" placeholder="B" aria-label="Amount (to the nearest dollar)">
                                                    <span class="input-group-text">CM</span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                
                                                    <input type="text" class="form-control" placeholder="H" aria-label="Amount (to the nearest dollar)">
                                                    <span class="input-group-text">CM</span>
                                                </div>
                                            </div>
                                        
                
                                            <div class="mb-3 col-md-5">
                                                <label class="form-label" for="basic-default-company">Payment Typet</label>
                                                <div class="col-md">
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input" type="radio" name="payment_mode" id="inlineRadio3" value="Pre-paid">
                                                        <label class="form-check-label" for="inlineRadio3">Cash on Delivery </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="payment_mode" id="inlineRadio4" value="COD">
                                                        <label class="form-check-label" for="inlineRadio4">Prepaid</label>
                                                    </div>
                                                </div>
                                            </div>
                
                
                                            <div class="mb-3 col-md-5">
                                                <label class="form-label" for="basic-default-company">Shipment Value (₹)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="text" class="form-control" placeholder="Amount"  id="total_amount" aria-label="Amount (to the nearest dollar)">
                                                </div>
                                            </div>
                
                
                                            <div class="mb-3 col-md-5">
                                                <label class="form-label" for="basic-default-company">Shipping Dangerous Goods</label>
                                                <div class="col-md">
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input" type="radio" name="dangerus_good" id="inlineRadio5" value="Y">
                                                        <label class="form-check-label" for="inlineRadio5">Yes </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="dangerus_good" id="inlineRadio6" value="N">
                                                        <label class="form-check-label" for="inlineRadio6">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exLargeModal" id="delivery_address" onclick="myFunction()">Calculate</button> &nbsp; &nbsp;<button type="button" class="btn btn-outline-danger">Reset</button>
                                        <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document" style="max-width:1450px !important">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                      <h6 class="text-dark text-start">Select Courier Partner</h6>
                                        
                                                      <div class="row" >
                                                        <div class="col-xl-12">
                                                          
                                                          <div class="nav-align-top mb-4">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                              <li class="nav-item">
                                                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home"aria-controls="navs-top-home" aria-selected="true" onclick="myFunction()">All</button>
                                                              </li>
                                                              <li class="nav-item">
                                                                <button type="button"
                                                                  class="nav-link" role="tab" data-bs-toggle="tab"  data-bs-target="#navs-top-profile"  aria-controls="navs-top-profile" aria-selected="false" onclick="myFunction()"> Express</button>
                                                              </li>
                                                              <li class="nav-item">
                                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false" onclick="myFunction()">Surface</button>
                                                              </li>
                                                              <!--<li class="nav-item">-->
                                                              <!--  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false">Self-fullfilled</button>-->
                                                              <!--</li>-->
                                                            </ul>
                                                            
                                                            <div class="tab-content">
                                                              <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                                                                <div class="table-responsive text-nowrap">
                                                                  <table class="table table-borderless">
                                                                    <thead>
                                                                      <tr>
                                                                        <th>Courier Partner</th>
                                                                        <!--<th>Ratings</th>-->
                                                                        <th>Chargeable Weight (in Grams)</th>
                                                                        <th>Charges</th>
                                                                       </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                     <!--Delhiver Express-->
                                                                      <tr>
                                                                        <td>
                                                                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                                            <li
                                                                              data-bs-toggle="tooltip"
                                                                              data-popup="tooltip-custom"
                                                                              data-bs-placement="top"
                                                                              class="avatar avatar-xs pull-up"
                                                                              title="Delhivery Express"
                                                                            >
                                                                              <img src="../Delhivery.jpg" alt="Avatar" class="rounded-circle"  />Delhivery Express
                                                                            </li>
                                                                            
                                                                          </ul>
                                                                        </td>
                                                                        <!--<td>-->
                                                                        <!--  <img src="../rattings.png" alt="Avatar"   />-->
                                                                        <!--</td>-->
                                                                        <td><input type="hidden" id="chargeable_weight_" value=""><span id="chargeable_weight_span_"></span></td>
                                                                        <td>
                                                                          <input type="hidden" id="express_charge_" value=""><span id="express_charge_span_"></span>
                                                                        </td>
                                                                        
                                                                      </tr>
                                                                      <!--Delhivery Surface-->
                                                                      <tr>
                                                                        <td>
                                                                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                                            <li
                                                                              data-bs-toggle="tooltip"
                                                                              data-popup="tooltip-custom"
                                                                              data-bs-placement="top"
                                                                              class="avatar avatar-xs pull-up"
                                                                              title="Delhivery Surface"
                                                                            >
                                                                              <img src="../Delhivery.jpg" alt="Avatar" class="rounded-circle"  />Delhivery Surface
                                                                            </li>
                                                                            
                                                                          </ul>
                                                                        </td>
                                                                        <!--<td>-->
                                                                        <!--  <img src="../rattings.png" alt="Avatar"   />-->
                                                                        <!--</td>-->
                                                                        <td><input type="hidden" id="surface_chargeable_weight_" value=""><span id="surface_chargeable_weight_span_"></span></td>
                                                                        <td>
                                                                          <input type="hidden" id="surface_charge_" value=""><span id="surface_charge_span_"></span>
                                                                        </td>
                                                                        
                                                                      </tr>
                                                                    </tbody>
                                                                  </table>
                                                                </div>
                                                              </div>
                                                              <!--Only EXpress-->
                                                              <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                                                                <div class="table-responsive text-nowrap">
                                                                  <table class="table table-borderless">
                                                                    <thead>
                                                                      <tr>
                                                                        <th>Courier Partner</th>
                                                                        <!--<th>Ratings</th>-->
                                                                        <th>Chargeable Weight</th>
                                                                        <th>Charges</th>
                                                                        
                                                                      </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                      <tr>
                                                                        <td>
                                                                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                                            <li
                                                                              data-bs-toggle="tooltip"
                                                                              data-popup="tooltip-custom"
                                                                              data-bs-placement="top"
                                                                              class="avatar avatar-xs pull-up"
                                                                              title="Delhivery Express"
                                                                            >
                                                                              <img src="../Delhivery.jpg" alt="Avatar" class="rounded-circle"  />Delhivery Express
                                                                            </li>
                                                                            
                                                                          </ul>
                                                                        </td>
                                                                        <!--<td>-->
                                                                        <!--  <img src="../rattings.png" alt="Avatar"   />-->
                                                                        <!--</td>-->
                                                                        <td><input type="hidden" id="echargeable_weight_" value=""><span id="echargeable_weight_span_"></span></td>
                                                                        <td>
                                                                          <input type="hidden" id="eexpress_charge_" value=""><span id="eexpress_charge_span_"></span>
                                                                        </td>
                                                                        
                                                                      </tr>
                                                                    </tbody>
                                                                  </table>
                                                                </div>
                                                              </div>
                                                              <!--Only Surface-->
                                                              <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
                                                                <div class="table-responsive text-nowrap">
                                                                  <table class="table table-borderless">
                                                                    <thead>
                                                                      <tr>
                                                                        <th>Courier Partner</th>
                                                                        <!--<th>Ratings</th>-->
                                                                        <th>Chargeable Weight</th>
                                                                        <th>Charges</th>
                                                                        
                                                                      </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                      <tr>
                                                                        <td>
                                                                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                                            <li
                                                                              data-bs-toggle="tooltip"
                                                                              data-popup="tooltip-custom"
                                                                              data-bs-placement="top"
                                                                              class="avatar avatar-xs pull-up"
                                                                              title="Delhivery"
                                                                            >
                                                                              <img src="../Delhivery.jpg" alt="Avatar" class="rounded-circle"  />Delhivery
                                                                            </li>
                                                                            
                                                                          </ul>
                                                                        </td>
                                                                        <!--<td>-->
                                                                        <!--  <img src="../rattings.png" alt="Avatar"   />-->
                                                                        <!--</td>-->
                                                                        <td><input type="hidden" id="schargeable_weight_" value=""><span id="schargeable_weight_span_"></span></td>
                                                                        <td>
                                                                          <input type="hidden" id="ssurface_charge_" value=""><span id="ssurface_charge_span_"></span>
                                                                        </td>
                                                                        
                                                                      </tr>
                                                                    </tbody>
                                                                  </table>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
<?php
include('menu/footer.php');
?>

<script>
$(document).ready(function(){
    // alert();
    $(".pick_pincode").blur(function(){
        // alert();
        var pincode = $(".pick_pincode").val();

        if(pincode!='')
        {
        
            $.ajax({
                type:"POST",
                url:"shippingApi/shipping.php",
                data:{
                    pincode:pincode
                },
                beforeSend: function(){
                     $("body").css('opacity','0.3');
                   },
                   complete: function(){
                     $("body").css('opacity','1');
                   },
                success:function(response)
                {
                    console.log(response)
                    if(response=='Y')
                    {
                        // alert(response)
                                        $("#delivery_address").prop('disabled',false)   
                                        $("#pick_error").text('This pincode is pickupable')
                                        $("#pick_error").css('color','green')
                                        

                    }
                    else
                    {
                        $("#delivery_address").prop('disabled',true)   
                        $("#pick_error").text('This pincode is not pickupable')
                        $("#pick_error").css('color','red')
                    }
                    
                    
                }
            })    
        
        }
        else
        {
            alert('Enter Pincode')
            $("#pick_error").text('')

        }
    })
    
    $(".del_pincode").blur(function(){
        // alert();
        var pincode = $(".del_pincode").val();

        if(pincode!='')
        {
        
            $.ajax({
                type:"POST",
                url:"shippingApi/shipping.php",
                data:{
                    pincode:pincode
                },
                beforeSend: function(){
                     $("body").css('opacity','0.3');
                   },
                   complete: function(){
                     $("body").css('opacity','1');
                   },
                success:function(response)
                {
                    console.log(response)
                    if(response=='Y')
                    {
                        // alert(response)
                                        $("#delivery_address").prop('disabled',false)   
                                        $("#del_error").text('This pincode is deliverable')
                                        $("#del_error").css('color','green')
                                        

                    }
                    else
                    {
                        $("#delivery_address").prop('disabled',true)   
                        $("#del_error").text('This pincode is not deliverable')
                        $("#del_error").css('color','red')  
                        
                    }
                    
                    
                }
            })    
        
        }
        else
        {
            alert('Enter Pincode')
            $("#del_error").text('')

        }
    })
})
</script>

<script>
    function myFunction(){
        var shipment_type = $("input[name='shipment_type']:checked").val();
        var pick_pincode = $(".pick_pincode").val();
        var del_pincode = $(".del_pincode").val();
        var weight = $("#weight").val();
        var payment_mode = $("input[name='payment_mode']:checked").val();
        var dangerus_good = $("input[name='dangerus_good']:checked").val();
        
        if(dangerus_good=='Y')
        {
            var total_amount = Number($("#total_amount").val())+Number($("#total_amount").val())*(0.02);
        }
        else if (dangerus_good =='N')
        {
            var total_amount = $("#total_amount").val();
        }
        
        $.ajax({
            type:"POST",
            url:"shippingApi/rate_calculator_express.php",
            data:{
                shipment_type:shipment_type,pick_pincode:pick_pincode,del_pincode:del_pincode,weight:weight,payment_mode:payment_mode,total_amount:total_amount
            },
            beforeSend: function(){
                 $("body").css('opacity','0.3');
              },
              complete: function(){
                 $("body").css('opacity','1');
              },
            success:function(response)
            {
                // console.log(response)
                var res = JSON.parse(response)
                if(res.status=='Y')
                {
                    var acTotal_aount = res.totalCharge;
                    var express_string = "Express Charge Will Be ₹";
                    var express_rate = express_string.concat(" ", acTotal_aount);
                    
                    $("#chargeable_weight_").val(res.chargeableWeight)   
                    $("#chargeable_weight_span_").text(res.chargeableWeight)
                    
                    $("#echargeable_weight_").val(res.chargeableWeight)   
                    $("#echargeable_weight_span_").text(res.chargeableWeight)
                    
                    $("#schargeable_weight_").val(res.chargeableWeight)   
                    $("#schargeable_weight_span_").text(res.chargeableWeight)
                    
                    $("#express_charge_").val(acTotal_aount)   
                    $("#express_charge_span_").html(express_rate);
                    
                    $("#eexpress_charge_").val(acTotal_aount)   
                    $("#eexpress_charge_span_").html(express_rate);
                    
                }
            }
        })
        $.ajax({
            type:"POST",
            url:"shippingApi/rate_calculator_surface.php",
            data:{
                shipment_type:shipment_type,pick_pincode:pick_pincode,del_pincode:del_pincode,weight:weight,payment_mode:payment_mode,total_amount:total_amount
            },
            beforeSend: function(){
                 $("body").css('opacity','0.3');
              },
              complete: function(){
                 $("body").css('opacity','1');
              },
            success:function(responsee)
            {
                console.log(responsee)
                var ress = JSON.parse(responsee)
                if(ress.status=='Y')
                {
                    var acTotal_aount_surface = ress.totalCharge;
                    var surface_string = "Surface Charge Will Be ₹";
                    var surface_rate = surface_string.concat(" ", acTotal_aount_surface);
                    
                    $("#surface_chargeable_weight_").val(ress.chargeableWeight)   
                    $("#surface_chargeable_weight_span_").text(ress.chargeableWeight)
                    $("#surface_charge_").val(acTotal_aount_surface)   
                    $("#surface_charge_span_").html(surface_rate);
                    
                    $("#ssurface_charge_").val(acTotal_aount_surface)   
                    $("#ssurface_charge_span_").html(surface_rate);
                    
                }
            }
        })
    }
</script>