// function loader
function loader(){
    return `<div class="d-flex justify-content-center align-items-center main-loader" style="position: absolute; top: 50%; left: 50%; z-index: 9; transform: translate(-50%, -50%);"><div class="loading">
                <span></span>
                <span></span>
                <span></span>
            </div></div>`;
}


// function danger toasts
function dangerToast(message){
    let number = 1 + Math.floor(Math.random() * 100);
    $('body').prepend(`<div class="bs-toast toast toast-placement-ex m-2 fade bg-danger danger-toast`+number+` show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" style="position: fixed; top: 0px; right: 0px; z-index: 9;">
      <div class="toast-header">
        <i class="bi bi-x-circle-fill me-2"></i>
        <div class="me-auto fw-medium">Alert</div>
        <small>0 mins ago</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body text-white">
          `+message+`
      </div>
    </div>`);
    setTimeout(function(){
        $('.danger-toast'+number).fadeOut(1000);
    }, 15000);
}


// Blur body
function blurBody(){
    $('body').css('opacity', '0.5');
    $('body').addClass('pointer-events-none');
    $('input').each(function(){
        $(this).attr('tabindex', '-1');
        $(this).prop('readonly', true);
    });
    $('select').each(function(){
        $(this).attr('tabindex', '-1');
        $(this).prop('readonly', true);
    });
}


// Normal body
function backNormalBody(){
    $('body').css('opacity', '1');
    $('body').removeClass('pointer-events-none');
    $('input').each(function(){
        $(this).removeAttr('tabindex');
        $(this).prop('readonly', false);
    });
    $('select').each(function(){
        $(this).removeAttr('tabindex');
        $(this).prop('readonly', false);
    });
}


// user tab change
$('#useraddForm').on("submit", function(e){
    let thival = $(this).find("button[type=submit]:focus").attr('id');
    if(thival == "navpills1-btn"){
        e.preventDefault();
        $('.addus-link').removeClass('active');
        $('#navpills2-tab').addClass('active');
        $('.tab-pane').removeClass('active');
        $('#navpills2').addClass('active');
    }else if(thival == "navpills2-btn"){
        e.preventDefault();
        $('.addus-link').removeClass('active');
        $('#navpills3-tab').addClass('active');
        $('.tab-pane').removeClass('active');
        $('#navpills3').addClass('active');
    }
});


// user tab change
$('#navpills2-prevbtn').click(function(){
    $('.addus-link').removeClass('active');
    $('#navpills1-tab').addClass('active');
    $('.tab-pane').removeClass('active');
    $('#navpills1').addClass('active');
});


// user tab change
$('#navpills3-prevbtn').click(function(){
    $('.addus-link').removeClass('active');
    $('#navpills2-tab').addClass('active');
    $('.tab-pane').removeClass('active');
    $('#navpills2').addClass('active');
});


// for broker commission
$('select[name=type]').change(function(){
    let BranchType = $(this).val();
    if(BranchType == "agent"){
        $('input[name=broker_commission]').prop('disabled', false);
        $('select[name=broker_commission_type]').prop('disabled', false);
        $('input[name=broker_commission]').removeClass('bg-light');
        $('select[name=broker_commission_type]').removeClass('bg-light');
    }else if(BranchType == "branch"){
        $('input[name=broker_commission]').prop('disabled', true);
        $('select[name=broker_commission_type]').prop('disabled', true);
        $('input[name=broker_commission]').addClass('bg-light');
        $('select[name=broker_commission_type]').addClass('bg-light');
    }
});


// view password
$('.itspassword').next('span').click(function(){
    let Input = $(this).prev();
    if(Input.attr('type') == "text"){
        Input.attr('type', 'password');
        $(this).children('i').addClass('bi-eye-slash-fill');
        $(this).children('i').removeClass('bi-eye-fill');
    }else if(Input.attr('type') == "password"){
        Input.attr('type', 'text');
        $(this).children('i').addClass('bi-eye-fill');
        $(this).children('i').removeClass('bi-eye-slash-fill');
    }
});


// at change of freight
$('select[name=freight_type]').change(function(){
    $('body').css('opacity', '0.8');
    $('body').addClass('pointer-events-none');
    let freightType = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'get3plsFor='+freightType,
        success: function(resultData){
            $('select[name=threepl]').html(resultData);
            $('body').css('opacity', '1');
            $('body').removeClass('pointer-events-none');
        }
    });
});


// appointment status change
$('.appointStatus').change(function(){
    if(confirm('Are you sure to want to change the status of this appintment?')){
        let appSts = $(this).val();
        $.ajax({
            type: "post",
            url: "actions",
            data: "appointmentStatus="+appSts,
            success: function(data){
                if(parseInt(data) == 0){
                    alert("Something went wrong! Please! contact with administrator");
                }
            }
        });
    }else{
        location.reload();
    }
});


// on update of single LR
$('select[name=lr_payment_mode]').change(function(){
    let thisval = $(this).val();
    if(thisval == "CoD"){
        $('input[name=profit_amount]').addClass('bg-light');
        $('input[name=profit_amount]').prop('disabled', true);
        $('input[name=profit_amount]').prop('required', false);
        $('input[name=cod_amount]').removeClass('bg-light');
        $('input[name=cod_amount]').prop('disabled', false);
        $('input[name=cod_amount]').prop('required', true);
    }else if(thisval == "Franchise-ToPay"){
        $('input[name=cod_amount]').addClass('bg-light');
        $('input[name=cod_amount]').prop('disabled', true);
        $('input[name=cod_amount]').prop('required', false);
        $('input[name=profit_amount]').removeClass('bg-light');
        $('input[name=profit_amount]').prop('disabled', false);
        $('input[name=profit_amount]').prop('required', true);
    }else{
        $('input[name=cod_amount]').addClass('bg-light');
        $('input[name=cod_amount]').prop('disabled', true);
        $('input[name=cod_amount]').prop('required', false);
        $('input[name=profit_amount]').addClass('bg-light');
        $('input[name=profit_amount]').prop('disabled', true);
        $('input[name=profit_amount]').prop('required', false);
    }
});

// topay balance keyup
$('input[name=toPayClearAm]').keyup(function(){
    let tisDi = $(this).val();
    let tisDuAm = $(this).parent('div').parent('div').children('div.form-group').children('input[name=toPayDueAm]').val();
    let restAm = Number(tisDuAm)-Number(tisDi);
    
    if(tisDuAm == 0){
        $(this).val(null);
    }else if(restAm >= 0){
        $(this).parent('div').parent('div').children('div.form-group').children('input[name=toPayRestAm]').val(restAm);
    }else{
        let newDi = tisDi.slice(0, tisDuAm.length);
        if(tisDuAm < newDi){
            newDi = newDi.slice(0, -1);
        }
        $(this).val(newDi);
        let prevRestAm = Number(tisDuAm)-Number(newDi);
        $(this).parent('div').parent('div').children('div.d-flex').children('div.form-group').children('input[name=toPayRestAm]').val(prevRestAm);
    }
});


// franchise topay balance keyup
$('input[name=franToPayClearAm]').keyup(function(){
    let tisDi = $(this).val();
    let tisDuAm = $(this).parent('div').parent('div').children('div.form-group').children('input[name=franToPayDueAm]').val();
    let restAm = Number(tisDuAm)-Number(tisDi);
    
    if(tisDuAm == 0){
        $(this).val(null);
    }else if(restAm >= 0){
        $(this).parent('div').parent('div').children('div.form-group').children('input[name=franToPayRestAm]').val(restAm);
    }else{
        let newDi = tisDi.slice(0, tisDuAm.length);
        if(tisDuAm < newDi){
            newDi = newDi.slice(0, -1);
        }
        $(this).val(newDi);
        let prevRestAm = Number(tisDuAm)-Number(newDi);
        $(this).parent('div').parent('div').children('div.d-flex').children('div.form-group').children('input[name=franToPayRestAm]').val(prevRestAm);
    }
});


// submit form of role
$('#submitRoleForm').on("submit", function(e){
    if($(this).find("button[type=submit]:focus").attr('name') == "opModSub"){
        e.preventDefault();
        $('.openRoleMod').click();
    }
});


// ticket tab
$(document).ready(function(){
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'ticketType=Open',
        success: function(result){
            $('#ticket-show').html(result);
        }
    });
    $('.ticket-link').click(function(){
        let ticketType = $.trim($(this).text());
        $('.ticket-link').removeClass('active');
        $(this).parent('li').children('a').addClass('active');
        $('.card-title').text(ticketType+' Tickets');
        $.ajax({
            type: 'post',
            url: 'actions',
            data: 'ticketType='+ticketType,
            success: function(result){
                $('#ticket-show').html(result);
            }
        });
    });
});


// user panel gst type
$('select[name=gst_type]').change(function(){
    let gstType = $(this).val();
    if(gstType == "Regular"){
        if($(this).parent('div').next('div').is(':empty')){
            $(this).parent('div').next('div').append(`<label>GST No.</label><input type="text" class="form-control" placeholder="Enter GST No." name="gst_number" required>`);
        }
    }else if(gstType == "Unregistered"){
        $(this).parent('div').next('div').empty();
    }
});


// input number only in text field
$('.txtNumeric').keypress(function(e){
    var charCode = (e.which) ? e.which : event.keyCode;
    if(String.fromCharCode(charCode).match(/[^0-9]/g)){
        return false;
    }
});


// reset form
// $('button[type=reset]').click(function(){
//     if(confirm('Are you sure to want to reset this form?')){
//         let myForm = document.querySelector("form");
//         //Extract Each Element Value
//         alert(myForm.elements.lengths);
//         for(var i = 0; i < myForm.elements.length; i++) {
//             myForm.elements[i].value = ' ';
//         }
//     }
// });


// branch shipping charge
$('input[name=branch_charge]').change(function(){
    if($(this).is(':checked')){
        $('button[name=branchChargeButton]').click();
    }
});


// off branch charge shipping
$('.btn-close').click(function(){
    $('input[name=branch_charge]').prop('checked', false);
    $('.modal-off').click();
});


// branch status change
$('.branchStatus').change(function(){
    let thisId = $(this).val();
    let status;
    if($(this).is(':checked')){
        status = 'Unblock';
    }else{
        status = 'Block';
    }
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'branchStatus='+status+'&thisBranchId='+thisId,
        success:function(result){
            if(parseInt(result) == 0){
                alert('Something went wrong! Please contact with administrators');
            }
        }
    });
});


// employee status change
$('.employeeStatus').change(function(){
    let thisId = $(this).val();
    let status;
    if($(this).is(':checked')){
        status = 'Unblock';
    }else{
        status = 'Block';
    }
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'employeeStatus='+status+'&thisemployeeId='+thisId,
        success:function(result){
            if(parseInt(result) == 0){
                alert('Something went wrong! Please contact with administrators');
            }
        }
    });
});


// user status change
$('.userStatus').change(function(){
    let thisId = $(this).val();
    let status;
    if($(this).is(':checked')){
        status = 'Unblock';
    }else{
        status = 'Block';
    }
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'userStatus='+status+'&thisUserId='+thisId,
        success:function(result){
            if(parseInt(result) == 0){
                alert('Something went wrong! Please contact with administrators');
            }
        }
    });
});


// ware house status change
$('.wareHouseStatus').change(function(){
    let thisWareHouseId = $(this).val();
    let wareHouseStatus;
    if($(this).is(':checked')){
        wareHouseStatus = 'Unblock';
    }else{
        wareHouseStatus = 'Block';
    }
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'wareHouseStatus='+wareHouseStatus+'&thisWareHouseId='+thisWareHouseId,
        success:function(result){
            if(parseInt(result) == 0){
                alert('Something went wrong! Please contact with administrators');
            }
        }
    });
});


// party type changing with function for credit limit
$('select[name=party_type]').change(function(){
    let valueofparty = $(this).val();
    if(valueofparty == "TBB"){
        $('#credit_limit').append(`<label>Credit Limit</label>
                		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Credit Limit" name="credit_limit" required>`);
    }else{
        $('#credit_limit').empty();
    }
});


// branch credit for credit limit
$('select[name=credit_type]').change(function(){
    let valueofparty = $(this).val();
    if(valueofparty == "TBB"){
        $('#credit_limit').append(`<label>Credit Limit</label>
                		                    <input type="text" class="form-control numeric-decimal" placeholder="Enter Credit Limit" name="credit_limit" required>`);
    }else{
        $('#credit_limit').empty();
    }
});


// dependant dropdown of Cities on zone-master-pincodes
$('#state').change(function(){
    var state = $(this).val();
    $.ajax({
        type: 'POST',
        url: 'actions',
        data: 'fetchStateForCity='+state,
        success: function(result){
            $('#city').html(result);
        }
    });
});
    

$('.modState').change(function(){
    var state = $(this).val();
    var cityId = "modCityId"+$(this).attr('id').split('_')[1];
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'fetchStateForCity='+state,
        success: function(result){
            $('#cityId').html(result);
        }
    });
});


// fetch salary for employee
$('#employee').change(function(){
    var employee = $(this).val();
    $.ajax({
        type: 'POST',
        url: 'actions',
        data: 'getSalaryofEmp='+employee,
        success: function(resp){
            $('#salary').val(resp);
        }
    });
});


// fetch users based on type on task page
$('#table').change(function(){
    var table = $(this).val();
    $.ajax({
        type: 'POST',
        url: 'actions',
        data: 'getTable='+table,
        success: function(resp){
            $('#tableReponse').html(resp);
        }
    });
});


// change password
$(document).ready(function(){
    $("#change_password").prop("disabled",true);
    $("#password, #confirm_password").keyup(function(){
        var password = $("#password").val();
        var confirmPassword = $("#confirm_password").val();
        if (password !== '' && confirmPassword !== '') {
            if (password !== confirmPassword) {
                $("#message").text("Password and confirm password should be same").attr("class", "text-danger");
                $("#change_password").prop("disabled",true);
            } else if (password.length < 6 || confirmPassword.length < 6) {
                $("#message").text("Password length should be at least 6 characters").attr("class", "text-danger");
                $("#change_password").prop("disabled",true);
            } else {
                $("#message").text("Password Matched").attr("class", "text-success");
                $("#change_password").prop("disabled",false);
            }
        } else {
            $("#message").text("Please enter both Password and Confirm Password").attr("class", "text-primary");
        }
    });
});


// generate label
function genLabel(genId){
    $('#genLabel'+genId).html(`<span class="spinner-border spinner-border-sm text-dark" style="margin: 1px 28px;"></span>`);
    $('#genLabel'+genId).attr('disabled', true);
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'throwOrderLabel='+genId,
        success: function(result){
            if(parseInt(result) == 0){
                alert('Something went wrong! Please! contact with administrator');
                $('#genLabel'+genId).attr('disabled',false);
                $('#genLabel'+genId).text('Generate label');
            }else{
                $('#genLabel'+genId).parent('td').children('.gn-btn').attr('data-bs-toggle','modal');
                $('#genLabel'+genId).parent('td').children('.gn-btn').attr('data-bs-target','.bd-example-modal-generate-label'+genId);
                $('.bd-example-modal-generate-label'+genId).children('div.modal-dialog').children('div.card-normal').children('div.modal-content').children('div.modal-body').html(result);
                $('#genLabel'+genId).parent('td').children('.gn-btn').click();
                $('#genLabel'+genId).attr('disabled',false);
                $('#genLabel'+genId).text('Generate label');
            }
        }
    });
}


// user mobile no. checking
$('#userMobileNo').blur(function(){
    let mobNo = $(this).val();
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'checkMobUser='+mobNo,
        success: function(data){
            if(parseInt(data) == 1){
                if($('#userMobileNo').parent('div').children('span').hasClass('usmobexts') == false){
                    $('#userMobileNo').parent('div').append(`<span class='usmobexts d-flex justify-content-end text-danger'>This mobile number already exists</span>`);
                    $('#navpills1-btn').attr('disabled', true);
                }
            }else{
                $('.usmobexts').remove();
                if($('span').hasClass('usemailexts') == false && $('span').hasClass('usphexts') == false){
                    $('#navpills1-btn').attr('disabled', false);
                }
            }
        }
    });
});


// user phone checking
$('#userPhone').blur(function(){
    let mobNo = $(this).val();
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'checkMobUser='+mobNo,
        success: function(data){
            if(parseInt(data) == 1){
                if($('#userPhone').parent('div').children('span').hasClass('usphexts') == false){
                    $('#userPhone').parent('div').append(`<span class='usphexts d-flex justify-content-end text-danger'>This phone number already exists</span>`);
                    $('#navpills1-btn').attr('disabled', true);
                }
            }else{
                $('.usphexts').remove();
                if($('span').hasClass('usemailexts') == false && $('span').hasClass('usmobexts') == false){
                    $('#navpills1-btn').attr('disabled', false);
                }
            }
        }
    });
});


// user email checking
$('#userEmail').blur(function(){
    let userEmail = $(this).val();
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'checkEmail='+userEmail+'&search=users',
        success: function(data){
            if(parseInt(data) == 1){
                if($('#userEmail').parent('div').children('span').hasClass('usemailexts') == false){
                    $('#userEmail').parent('div').append(`<span class='usemailexts d-flex justify-content-end text-danger'>This email already exists</span>`);
                    $('#navpills1-btn').attr('disabled', true);
                }
            }else{
                $('.usemailexts').remove();
                if($('span').hasClass('usphexts') == false && $('span').hasClass('usmobexts') == false){
                    $('#navpills1-btn').attr('disabled', false);
                }
            }
        }
    });
});


// branch mobile no. checking
$('#branchMobileNo').blur(function(){
    let mobNo = $(this).val();
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'checkMobBranch='+mobNo,
        success: function(data){
            if(parseInt(data) == 1){
                if($('#branchMobileNo').parent('div').children('span').hasClass('brchmobexts') == false){
                    $('#branchMobileNo').parent('div').append(`<span class='brchmobexts d-flex justify-content-end text-danger'>This mobile number already exists</span>`);
                    $('button[name=submitaBranch]').attr('disabled', true);
                }
            }else{
                $('.brchmobexts').remove();
                if($('span').hasClass('brchphexts') == false && $('span').hasClass('brchemlexts') == false){
                    $('button[name=submitaBranch]').attr('disabled', false);
                }
            }
        }
    });
});


// branch phone no. checking
$('#branchPhoneNo').blur(function(){
    let mobNo = $(this).val();
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'checkMobBranch='+mobNo,
        success: function(data){
            if(parseInt(data) == 1){
                if($('#branchPhoneNo').parent('div').children('span').hasClass('brchphexts') == false){
                    $('#branchPhoneNo').parent('div').append(`<span class='brchphexts d-flex justify-content-end text-danger'>This phone number already exists</span>`);
                    $('button[name=submitaBranch]').attr('disabled', true);
                }
            }else{
                $('.brchphexts').remove();
                if($('span').hasClass('brchmobexts') == false && $('span').hasClass('brchemlexts') == false){
                    $('button[name=submitaBranch]').attr('disabled', false);
                }
            }
        }
    });
});


// user email checking
$('#branchEmail').blur(function(){
    let branchEmail = $(this).val();
    $.ajax({
        type: 'post',
        url: 'actions',
        data: 'checkEmail='+branchEmail+'&search=branches',
        success: function(data){
            if(parseInt(data) == 1){
                if($('#branchEmail').parent('div').children('span').hasClass('brchemlexts') == false){
                    $('#branchEmail').parent('div').append(`<span class='brchemlexts d-flex justify-content-end text-danger'>This email already exists</span>`);
                    $('button[name=submitaBranch]').attr('disabled', true);
                }
            }else{
                $('.brchemlexts').remove();
                if($('span').hasClass('brchmobexts') == false && $('span').hasClass('brchphexts') == false){
                    $('button[name=submitaBranch]').attr('disabled', false);
                }
            }
        }
    });
});


// perticular image file remove in edit user page
$('.imgDel').click(function(){
    $(this).parent('div').remove();
});


// view all order filters
$('#visibleType').change(function(){
    let orderUserType = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'orderUserType='+orderUserType,
        success: function(result){
            $('select[name=orderUsersorBranches]').html(result);
        }
    });
});


// get users or branches for save pickup order
$('#usertype').change(function(){
    let orderUserType = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'orderUserType='+orderUserType,
        success: function(result){
            $('select[name=username]').html(result);
        }
    });
});


// order for user
$('#username').change(function(){
    blurBody();
    const usertype = $('#usertype').val();
    const username = $('#username').val();
    $('body').before(loader());
    setTimeout(function(){
        window.location.href = 'save-pickup-order?usertype='+usertype+'&username='+username;
    }, 2000);
});


// fetchLrs for broker commission
$("select[name=broker]").change(function(){
    let broker = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'broker='+broker,
        success: function(result){
            $('#commissionLR').html(result);
        }
    });
});


// get commission amount
$('button[name=getCommissionAmount]').click(function(){
    blurBody();
    let commissionBroker = $("select[name=broker]").val();
    let commissionlRs = [];
    $('select[name^="commissionLRs"]').each(function(){
        commissionlRs.push($(this).val());
    });
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'commissionBroker='+commissionBroker+'&commissionlRs='+commissionlRs,
        success: function(result){
            backNormalBody();
            $('input[name=commissionAmount]').prop('readonly' ,true);
            $('input[name=commissionAmount]').val(result);
        }
    });
})


// cod remittance user filters
$('#codVisibleType').change(function(){
    let orderUserType = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'orderUserType='+orderUserType,
        success: function(result){
            $('select[name=codUsersorBranches]').html(result);
        }
    });
});


// franchise to pay remittance user filters
$('#frantopayVisibleType').change(function(){
    let frantoPayUsersorBranches = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'frantopayVisibleType='+frantoPayUsersorBranches,
        success: function(result){
            $('select[name=frantoPayUsersorBranches]').html(result);
        }
    });
});


// cod remittance get user's cod lrs filters
$('select[name=codUsersorBranches]').change(function(){
    let codVisibleType = $('#codVisibleType').val();
    let orderUserIs = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'codLRs='+orderUserIs+'&codVisibleType='+codVisibleType,
        success: function(result){
            $('#codlR').html(result);
        }
    });
});


// franchise to pay remittance get user's cod lrs filters
$('select[name=frantoPayUsersorBranches]').change(function(){
    let frantopayVisibleType = $('#frantopayVisibleType').val();
    let frantoPayUsersorBranches = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'frantopayLRs='+frantoPayUsersorBranches+'&frantopayVisibles='+frantopayVisibleType,
        success: function(result){
            $('#frantoPayLR').html(result);
        }
    });
});


// get cod amount for cod remittance
$('button[name=getCODTotalAmount]').click(function(){
    blurBody();
    let codlRs = [];
    $('select[name^="codLR"]').each(function(){
        codlRs.push($(this).val());
    });
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'codLRAmount='+codlRs,
        success: function(result){
            backNormalBody();
            $('input[name=codAmount]').val(result);
        }
    });
});


// get profit amount for franchise-topay remittance
$('button[name=getFTPTotalAmount]').click(function(){
    blurBody();
    let frantoPayLR = [];
    $('select[name^="frantoPayLR"]').each(function(){
        frantoPayLR.push($(this).val());
    });
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'frantoPayLRAmount='+frantoPayLR,
        success: function(result){
            backNormalBody();
            $('input[name=frantoPayAmount]').val(result);
        }
    });
});


// get users for to pay
$('#toPayvisibleType').change(function(){
    let orderUserType = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'toPayUserType='+orderUserType,
        success: function(result){
            $('select[name=toPayUsersorBranches]').html(result);
        }
    });
});


// get users for franchise to pay
$('#franToPayvisibleType').change(function(){
    let orderUserType = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'toPayUserType='+orderUserType,
        success: function(result){
            $('select[name=franToPayUsersorBranches]').html(result);
        }
    });
});


// get users / branches due of to pay
$('select[name=toPayUsersorBranches]').change(function(){
    let user = $(this).val();
    let userType = $('#toPayvisibleType').val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'toPayuser='+user+'&toPayuserType='+userType,
        success: function(data){
            let Ar = data.split(',');
            $('input[name=toPayDueAm]').val(Ar[0]);
            $('#walletBal').text(Ar[1]);
        }
    });
});


// get users / branches due of franchise to pay
$('select[name=franToPayUsersorBranches]').change(function(){
    let user = $(this).val();
    let userType = $('#franToPayvisibleType').val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'frantoPayuser='+user+'&frantoPayuserType='+userType,
        success: function(data){
            let Ar = data.split(',');
            $('input[name=franToPayDueAm]').val(Ar[0]);
            $('#walletBal').text(Ar[1]);
        }
    });
});


// to fetch lr filter user
$('#LRvisibleType').change(function(){
    let orderUserType = $(this).val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'orderUserType='+orderUserType,
        success: function(result){
            $('select[name=LRuserIs]').html(result);
        }
    });
});


// fetch type's lrs
$('select[name=LRuserIs]').change(function(){
    let LRuserIs = $(this).val();
    let visible = $('#LRvisibleType').val();
    $.ajax({
        type: 'post',
        url: 'act',
        data: 'LRuserIs='+LRuserIs+'&visible='+visible,
        success: function(result){
            $('select[name=lr]').html(result);
        }
    });
});


//download of pod
function downloadURI(uri, name) {
  var link = document.createElement("a");
  link.download = name;
  link.href = uri;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}


// get pod
function getPOD(LRPOD){
    if(confirm('Are you sure to want to download POD?')){
        $('#getPOD'+LRPOD).html(`<span class="spinner-border spinner-border-sm text-white" style="margin-top: 1px;"></span>`);
        $('#getPOD'+LRPOD).attr('disabled', true);
        $.ajax({
            type: 'post',
            url: '../user/act',
            data: 'lrPOD='+LRPOD,
            success: function(result){
                if(parseInt(result) == 0){
                    alert('POD not found for this order');
                    $('#getPOD'+LRPOD).html(`<i class='bi bi-boxes'></i>`);
                    $('#getPOD'+LRPOD).attr('disabled', false);
                }else{
                    let compDown = downloadURI(result, "helloWorld.png");
                    alert('POD successfully downloaded');
                    $('#getPOD'+LRPOD).html(`<i class='bi bi-boxes'></i>`);
                }
            }
        });
    }
}


// check all bill
$('#checkAlldataOfTable').click(function(){
    if($(this).is(':checked')){
        $('.customCheckBoxOne').prop('checked', true);
        $('button[name=viewbillSubmit]').prop('disabled', false);
        $('button[name=sendEmailbillSubmit]').prop('disabled', false);
    }else{
        $('.customCheckBoxOne').prop('checked', false);
        $('button[name=viewbillSubmit]').prop('disabled', true);
        $('button[name=sendEmailbillSubmit]').prop('disabled', true);
    }
});


// check single bill
$('.customCheckBoxOne').click(function(){
    for(let i = 1; i <= $('.customCheckBoxOne').length; i++){
        if($('#customCheckBox'+i).prop('checked') == false){
            $('#checkAlldataOfTable').prop('checked', false);
            break;
        }else{
            $('#checkAlldataOfTable').prop('checked', true);
        }
    }
});


// check single bill too
$('.customCheckBoxOne').click(function(){
    for(let i = 1; i <= $('.customCheckBoxOne').length; i++){
        if($('#customCheckBox'+i).prop('checked') == true){
            $('button[name=viewbillSubmit]').prop('disabled', false);
            $('button[name=sendEmailbillSubmit]').prop('disabled', false);
            break;
        }else{
            $('button[name=viewbillSubmit]').prop('disabled', true);
            $('button[name=sendEmailbillSubmit]').prop('disabled', true);
        }
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


// X for emp files
$('button[name=crossForImg]').click(function(){
    $(this).parent('div').remove();
});



// checking reference alloted number
// $('input[name=endAllotmentNo]').blur(function(){
//     $('body').css('opacity', 0.3);
//     $('body').addClass('pointer-events-none');
//     $('body').before(`<div class="d-flex justify-content-center align-items-center body-before-loader" style="position: absolute; top: 50%; left: 46%; z-index: 9999;"><div class="loading">
//     <span></span>
//     <span></span>
//     <span></span>
//   </div></div>`);
//     $(this).parent('.col-md-6').parent('.row').parent('.modal-body').parent('.modal-content').addClass('pointer-events-none');
//     let startAllotmentNo = $(this).parent('.col-md-6').parent('.row').children('.col-md-6').children('input[name=startAllotmentNo]').val();
//     let endAllotmentNo = $(this).val();
//     if(startAllotmentNo != 0){
//         if(parseInt(startAllotmentNo) > parseInt(endAllotmentNo)){
//             $('body').css('opacity', '1');
//             $('body').removeClass('pointer-events-none');
//             $('.body-before-loader').remove();
//             $(this).parent('.col-md-6').parent('.row').parent('.modal-body').parent('.modal-content').removeClass('pointer-events-none');
//             if(!$(this).parent('div').children('span').hasClass('alloterr')){
//                 $(this).after(`<span class='text-danger alloterr'>End no. can't be smaller than start no.</span>`);
//             }
//         }else{
//             $.ajax({
//                 type: 'post',
//                 url: 'act',
//                 data: 'startAllotmentNo='+startAllotmentNo+'&endAllotmentNo='+endAllotmentNo,
//                 success: function(result){
//                     if(parseInt(result) == 1){
//                         $('body').css('opacity', '1');
//                         $('body').removeClass('pointer-events-none');
//                         $(this).parent('.col-md-6').parent('.row').parent('.modal-body').parent('.modal-content').removeClass('pointer-events-none');
//                         $('.body-before-loader').remove();
//                         if(!$(this).parent('div').children('span').hasClass('alloterr')){
//                             $(this).after(`<span class='text-danger alloterr'>This number can't be alloted</span>`);
//                         }
//                     }else if(parseInt(result) == 0){
//                         $('body').css('opacity', '1');
//                         $('body').removeClass('pointer-events-none');
//                         $(this).parent('.col-md-6').parent('.row').parent('.modal-body').parent('.modal-content').removeClass('pointer-events-none');
//                         $('.body-before-loader').remove();
//                         if(!$(this).parent('div').children('span').hasClass('alloterr')){
//                             $(this).after(`<span class='text-success alloterr'>This number can be alloted</span>`);
//                         }
//                     }
//                 }
//             });
//         }
//     }
// });


// checking first reference number
// $('input[name=startAllotmentNo]').blur(function(){
//     let startAllotmentNo = $(this).val();
//     $('body').css('opacity', 0.3);
//     $('body').addClass('pointer-events-none');
//     $(this).parent('.modal-content').addClass('pointer-events-none');
//     $.ajax({
//         type: 'post',
//         url: 'act',
//         data: 'refAllotmentNo='+startAllotmentNo,
//         success: function(result){
//             $('body').css('opacity', '1');
//             $('body').removeClass('pointer-events-none');
//             $(this).parent('.modal-content').removeClass('pointer-events-none');
//             if(parseInt(result) === 1){
//                 $(this).parent('.col-md-6').children('.allotStarterr').text("This number is already alloted!");
//                 $(this).parent('.modal-content').children('.modal-footer').children('button[name=addAllotment]').prop('disabled', true);
//             }else if(parseInt(result) === 0){
//                 $(this).parent('.from-group').children('.allotStarterr').empty();
//                 $(this).parent('.modal-content').children('.modal-footer').children('button[name=addAllotment]').prop('disabled', false);
//             }
//         }
//     });
// });







