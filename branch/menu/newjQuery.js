// function loader
function loader(position){
    return `<div class="d-flex justify-content-center align-items-center main-loader" style="position: `+position+`; top: 50%; left: 50%; z-index: 9999; transform: translate(-50%, -50%);">
        <div class="loader">
            <div class="ball-spin-fade-loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>`;
}


// blur body
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


// normal body
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


// go to user order
$("select[name=orderForUser]").on("change", function(){
    let orderForUser = $(this).val();
    blurBody();
    $('body').prepend(loader('fixed'));
    setTimeout(function(){
        window.location.href = "create_users_order?orderForUser="+orderForUser;
    }, 2000);
});


$('button[name=uploadSubmit]').on("click", function(event){
    if(($('select[name=warehouse]').val()) == "" && ($('input[name=upload_order_file]').val()) == ""){
        event.preventDefault();
    }else{
        $('button[name=uploadSubmit]').html(`<span class="spinner-border spinner-border-sm text-white" style="margin: 4px 20px;"></span>`);
        $('button[name=uploadSubmit]').attr('disabled', true);
        $('button[name=uploadBulkSubmit]').click();
    }
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
        $('#getPOD'+LRPOD).html(`<span class="spinner-border spinner-border-sm text-white" style="margin: 4px 1px;"></span>`);
        $('#getPOD'+LRPOD).attr('disabled', true);
        $.ajax({
            type: 'post',
            url: 'act',
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


// Allow 1 to 10 digits, optionally followed by a decimal point and up to two digits
// Remove the last character in IF Condition if doesn't match the pattern
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.numeric-decimal');
    inputs.forEach(input => {
        input.addEventListener('input', function (e) {
            let value = e.target.value;
            if (!/^\d{1,10}(\.\d{0,2})?$/.test(value)) {
                value = value.slice(0, -1); 
            }
            e.target.value = value;
        });
    });
});


// input number only
$(document).ready(function(){
    $(".txtNumeric").keypress(function(e) {
        var charCode = (e.which) ? e.which : event.keyCode;
        if(String.fromCharCode(charCode).match(/[^0-9]/g)){
            return false;
        }
    });
});



// function danger toasts
function dangerToast(message){
    let number = 1 + Math.floor(Math.random() * 100);
    $('body').prepend(`<div class="bs-toast toast toast-placement-ex top-0 end-0 m-2 fade bg-danger danger-toast`+number+` show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
      <div class="toast-header">
        <i class="bx bxs-x-circle me-2"></i>
        <div class="me-auto fw-medium">Alert</div>
        <small>0 mins ago</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
          `+message+`
      </div>
    </div>`);
    setTimeout(function(){
        $('.danger-toast'+number).fadeOut(1000);
    }, 15000);
}


// function warning toasts
function warningToast(message){
    let number = 1 + Math.floor(Math.random() * 100);
    $('body').prepend(`<div class="bs-toast toast toast-placement-ex top-0 end-0 m-2 fade bg-warning warning-toast`+number+` show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
      <div class="toast-header">
        <i class='bx bxs-info-circle me-2'></i>
        <div class="me-auto fw-medium">Alert</div>
        <small>0 mins ago</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
          `+message+`
      </div>
    </div>`);
    setTimeout(function(){
        $('.warning-toast'+number).fadeOut(1000);
    }, 15000);
}