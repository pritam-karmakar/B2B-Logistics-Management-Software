window.onload = function() {
    sessionStorage.removeItem("OriginPincode");
    sessionStorage.removeItem("DestinationPincode");
};


// input numerics only
$('.numeric-input').keypress(function(e){
    var charCode = (e.which) ? e.which : event.keyCode;
    if(String.fromCharCode(charCode).match(/[^0-9]/g)){
        return false;
    }
});


// only decimal numbers
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.numeric-decimal');

    inputs.forEach(input => {
        input.addEventListener('input', function (e) {
            let value = e.target.value;

            // Allow 1 to 10 digits, optionally followed by a decimal point and up to two digits
            if (!/^\d{1,10}(\.\d{0,2})?$/.test(value)) {
                value = value.slice(0, -1); // Remove the last character if it doesn't match the pattern
            }

            e.target.value = value;
        });
    });
});


// add new box details field
$("#add_weight").click(function(){
    let diemension_no = $("#diemension_no").val();
    diemension_no++;
    $("#diemension_no").val(diemension_no);
    let dimension_row = `<div class="row pt-2" id="row`+diemension_no+`">
            <div class="col-lg-2"> 
              <div class="form-group">
                <label class="control-label mb-1">Qty <span class="text-danger">*</span></label>
                <input name="qty[]" id="count`+diemension_no+`" type="text" placeholder="Qty" class="count form-control" >
              </div>
              <span class="text-danger qty-error d-flex justify-content-end" style="font-size: 12px;"></span>
            </div> 
            <div class="col-lg-3">   
                <div class="form-group">
                    <label class="control-label mb-1">Length <span class="text-danger">*</span></label>
                    <input name="length[]" id="length`+diemension_no+`" type="text" placeholder="Length" class="form-control w-95" >
                </div>
                <span class="text-danger length-error d-flex justify-content-end" style="font-size: 12px;"></span>
            </div>
            <div class="col-lg-3">   
                <div class="form-group">
                    <label class="control-label mb-1">Width <span class="text-danger">*</span></label>
                    <input name="width[]" id="width`+diemension_no+`" type="text" placeholder="Width" class="form-control w-95" >
              </div>
              <span class="text-danger width-error d-flex justify-content-end" style="font-size: 12px;"></span>
           </div>
            <div class="col-lg-3">    
                <div class="form-group"> 
                    <label class="control-label mb-1">Height <span class="text-danger">*</span></label>
                    <input name="height[]" id="height`+diemension_no+`" type="text" placeholder="Height" class="form-control w-95">
                </div>
                <span class="text-danger height-error d-flex justify-content-end" style="font-size: 12px;"></span>
            </div> 
            <div class="col-lg-1 d-flex justify-content-end align-items-center" style="padding-top: 1.5rem;">  
                <div class="text-center">
                    <button id="remove_weight`+diemension_no+`" type="button" class=" btn btn-danger btn-xs" style="padding: 2px 4px"><i class="bx bxs-minus-circle"></i></button>
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


// checking origin pincode function
function OriginPincodeCheck(OriginPincode){
    if(OriginPincode.length == 6){
        blurBody();
        $.ajax({
            type: 'POST',
            url: 'return-actions',
            data: 'OriginPincodeChecking='+OriginPincode,
            success: function(data){
                backNormalBody();
                if(data == 0){
                    sessionStorage.setItem('OriginPincode', 0);
                    $('.origin-error').removeClass('text-primary');
                    $('.origin-error').addClass('text-danger');
                    $('.origin-error').html('Pincode is not serviceable!');
                }else{
                    sessionStorage.setItem('OriginPincode', 1);
                    $('.origin-error').removeClass('text-danger');
                    $('.origin-error').addClass('text-primary');
                    $('.origin-error').html(data);
                }
            },
            error: function(error){
                backNormalBody();
                dangerToast('An error occurred!');
            }
        });
    }else{
        sessionStorage.setItem('OriginPincode', 0);
        $('.origin-error').removeClass('text-primary');
        $('.origin-error').addClass('text-danger');
        $('.origin-error').html('Invalid Pincode!');
    }
    return sessionStorage.getItem('OriginPincode');
}


// checking destination pincode fucntion
function DestinationPincodeCheck(DestinationPincode){
    if(DestinationPincode.length == 6){
        blurBody();
        $.ajax({
            type: 'POST',
            url: 'return-actions',
            data: 'DestinationPincodeChecking='+DestinationPincode,
            success: function(result){
                backNormalBody();
                if(result == 0){
                    sessionStorage.setItem('DestinationPincode', 0);
                    $('.destination-error').removeClass('text-primary');
                    $('.destination-error').addClass('text-danger');
                    $('.destination-error').html('Pincode is not serviceable!');
                    $('.destination-oda').html('');
                }else{
                    let data = $.parseJSON(result);
                    sessionStorage.setItem('DestinationPincode', 1);
                    $('.destination-error').removeClass('text-danger');
                    $('.destination-error').addClass('text-primary');
                    $('.destination-error').html(data[0]);
                    if(data[1] === 'true'){
                        $('.destination-oda').html('ODA Charges');
                    }else{
                        $('.destination-oda').html('');
                    }
                }
            },
            error: function(error){
                backNormalBody();
                dangerToast('An error occurred!');
            }
        });
    }else{
        sessionStorage.setItem('DestinationPincode', 0);
        $('.destination-error').removeClass('text-primary');
        $('.destination-error').addClass('text-danger');
        $('.destination-error').html('Invalid Pincode!');
        $('.destination-oda').html('');
    }
    return sessionStorage.getItem('DestinationPincode');
}


// checking origin pincode
$('input[name=OriginPincode]').blur(function(){
    let OriginPincode = $(this).val();
    OriginPincodeCheck(OriginPincode);
});


// checking destination pincode
$('input[name=DestinationPincode]').blur(function(){
    let DestinationPincode = $(this).val();
    DestinationPincodeCheck(DestinationPincode);
});


// Calculate Freight Charges
$('button[name=CalculateFreight]').click(function(){
    const OriginPincode = $('input[name=OriginPincode]').val();
    const DestinationPincode = $('input[name=DestinationPincode]').val();
    let checkofOriginPincode = sessionStorage.getItem('OriginPincode');
    let checkofDestinationPincode = sessionStorage.getItem('DestinationPincode');
    let isValid = true;
    if(checkofOriginPincode === 0 || checkofOriginPincode === null){
        checkofOriginPincode = OriginPincodeCheck(OriginPincode);
    }
    if(checkofDestinationPincode === 0 || checkofDestinationPincode === null){
        checkofDestinationPincode = DestinationPincodeCheck(DestinationPincode);
    }
    if(Number(checkofOriginPincode) === 0){
        isValid = false;
    }
    if(Number(checkofDestinationPincode) === 0){
        isValid = false;
    }
    const paymentMode = $('select[name=payment-mode]').val();
    if(paymentMode == '' || paymentMode == 0){
        $('.payment-mode-error').html('Invalid Payment mode!');
        isValid = false;
    }else{
        $('.payment-mode-error').html('');
    }
    const cftType = $('select[name=cftType]').val();
    if(cftType == '' || cftType == 0){
        $('.cft-error').html('Invalid CFT Type!');
        isValid = false;
    }else{
        $('.cft-error').html('');
    }
    const totalWeight = $('input[name=totalWeight]').val();
    if(totalWeight == '' || totalWeight == 0){
        $('.total-weight-error').html('Invalid Total Weight!');
        isValid = false;
    }else{
        $('.total-weight-error').html('');
    }
    const totalBoxes = $('input[name=totalBoxes]').val();
    if(totalBoxes == '' || totalBoxes == 0){
        $('.total-boxes-error').html('Invalid Total Boxes!');
        isValid = false;
    }else{
        $('.total-boxes-error').html('');
    }
    const dimention = $('select[name=dimention]').val();
    if(dimention == '' || dimention == 0){
        $('.dimention-error').html('Invalid Dimention!');
        isValid = false;
    }else{
        $('.dimention-error').html('');
    }
    const invoiceAmount = $('input[name=invoiceAmount]').val();
    if(invoiceAmount == '' || invoiceAmount == 0){
        $('.invoice-amount-error').html('Invalid Invoice Amount!');
        isValid = false;
    }else{
        $('.invoice-amount-error').html('');
    }
    const insurance = $('input[name="insurance"]:checked').val();
    if(!insurance){
        $('.insurance-error').html('Invalid Insurance Type!');
        isValid = false;
    }else{
        $('.insurance-error').html('');
    }
    const pickupType = $('input[name="pickupType"]:checked').val();
    if(!pickupType){
        $('.pickup-type-error').html('Invalid Pickup Type!');
        isValid = false;
    }else{
        $('.pickup-type-error').html('');
    }
    let qty = 0;
    let Qty = [];
    $('input[name^="qty"]').each(function(){
        if($(this).val() == '' || $(this).val() == 0){
            $(this).parent('.form-group').parent('.col-lg-2').children('.qty-error').html('Invalid Qty!');
            isValid = false;
        }else{
            qty = Number(qty)+Number($(this).val());
            Qty.push($(this).val());
            $(this).parent('.form-group').parent('.col-lg-2').children('.qty-error').html('');
        }
    });
    let Length = [];
    $('input[name^="length"]').each(function(){
        if($(this).val() == '' || $(this).val() == 0){
            $(this).parent('.form-group').parent('.col-lg-3').children('.length-error').html('Invalid Length!');
            isValid = false;
        }else{
            Length.push($(this).val());
            $(this).parent('.form-group').parent('.col-lg-3').children('.length-error').html('');
        }
    });
    let Width = [];
    $('input[name^="width"]').each(function(){
        if($(this).val() == '' || $(this).val() == 0){
            $(this).parent('.form-group').parent('.col-lg-3').children('.width-error').html('Invalid Width!');
            isValid = false;
        }else{
            Width.push($(this).val());
            $(this).parent('.form-group').parent('.col-lg-3').children('.width-error').html('');
        }
    });
    let Height = [];
    $('input[name^="height"]').each(function(){
        if($(this).val() == '' || $(this).val() == 0){
            $(this).parent('.form-group').parent('.col-lg-3').children('.height-error').html('Invalid Height!');
            isValid = false;
        }else{
            Height.push($(this).val());
            $(this).parent('.form-group').parent('.col-lg-3').children('.height-error').html('');
        }
    });
    if((totalBoxes != '' || Number(totalBoxes) != 0) && (qty != '' || Number(qty) != 0) && (Number(totalBoxes) != Number(qty))){
        $('.total-boxes-error').html('Total Boxes should be same as all qty!');
        isValid = false;
    }else if((totalBoxes != '' || Number(totalBoxes) != 0) && (qty != '' || Number(qty) != 0) && (Number(totalBoxes) == Number(qty))){
        $('.total-boxes-error').html('');
    }
    if(isValid != false){
        $(this).attr('disabled', true);
        $(this).addClass('freight-loader-button');
        $(this).html(`<div class="spinner-border text-white" role="status"></div>`);
        $('.freight-calculation-card').css('opacity', '0.5');
        $('.freight-calculation-card').parent('.card').prepend(loader('absolute'));
        setTimeout(function(){
            $.ajax({
                type: 'POST',
                url: 'return-actions',
                data: {
                    'OriginPincode': OriginPincode,
                    'DestinationPincode': DestinationPincode,
                    'cftType': cftType,
                    'paymentMode': paymentMode,
                    'totalWeight': totalWeight,
                    'totalBoxes': totalBoxes,
                    'dimention': dimention,
                    'invoiceAmount': invoiceAmount,
                    'insurance': insurance,
                    'pickupType': pickupType,
                    'qty': Qty,
                    'length': Length,
                    'width': Width,
                    'height': Height,
                    'freight-calculation': true
                },
                success: function(response){
                    $('button[name=CalculateFreight]').attr('disabled', false);
                    $('button[name=CalculateFreight]').removeClass('freight-loader-button');
                    $('button[name=CalculateFreight]').html('Calculate Freight');
                    $('.freight-calculation-card').css('opacity', '1');
                    $('.freight-calculation-card').parent('.card').children('.main-loader').remove();
                    if(response != false){
                        let result = JSON.parse(response);
                        $('#basic-freight').text(result.frightCharge);
                        $('#fuel-surcharge').text(result.fuel_surcharge);
                        $('#awb-charge').text(result.awb_charge);
                        $('#fov-surcharge').text(result.fob_surcharge);
                        $('#handeling-charge').text(result.handeling_charge);
                        $('#cartage-charge').text(result.cartage_charge);
                        $('#damrage-surcharge').text(result.damage_surcharge);
                        $('#oda-surcharge').text(result.oda_surcharge);
                        $('#packaging-surcharge').text(result.packaging_surcharge);
                        $('#special-delhivery').text(result.special_delivery_charge);
                        $('#cod-charge').text(result.cod_charge);
                        $('#pickup-charge').text(result.pickup_charge);
                        $('#pre-tax-freight-charge').text(result.before_gst_total_charge);
                        $('#gst-charge').text(result.gst_charge);
                        $('#total-charge').text(result.total_charge);
                    }else{
                        dangerToast('An error occurred!');
                    }
                },
                error: function(error){
                    $('button[name=CalculateFreight]').attr('disabled', false);
                    $('button[name=CalculateFreight]').removeClass('freight-loader-button');
                    $('button[name=CalculateFreight]').html('Calculate Freight');
                    $('.freight-calculation-card').css('opacity', '1');
                    $('.freight-calculation-card').parent('.card').children('.main-loader').remove();
                    dangerToast('An error occurred!');
                }
            })
        }, 2000);
    }
});










