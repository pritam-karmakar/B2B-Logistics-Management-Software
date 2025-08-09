<?php
include('menu/header.php');
include('menu/navbar.php');
?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Pincode Serviceability</span></h4>
            
            <?php
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                extract($_POST);
                $get_3pl = $query->getData("*","3pls","",array("id"=>"2"),"id","DESC","1")[0];
                
                $registered_name = $get_3pl['registered_name'];
                $token = $get_3pl['api_token'];
                $password = $get_3pl['password'];
                
                $loginFields = array(
                    "username" => $registered_name,
                    "password" => $password
                );
                $cs = curl_init();
                curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
                curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
                curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false);  
                    curl_setopt($cs, CURLOPT_CONNECTTIMEOUT ,0); 
                    curl_setopt($cs, CURLOPT_TIMEOUT, 400);
                curl_setopt($cs, CURLOPT_HTTPHEADER, array(
                    "accept: application/json",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ));
                $responselg = curl_exec($cs);
                $errorlg = curl_error($cs);
                curl_close($cs);
                if($errorlg){
                    echo $errorlg;
                }
                else{
                    $jwt = json_decode($responselg)->jwt;
                    if(!empty($jwt)){
                        $cf = curl_init();
                        curl_setopt($cf, CURLOPT_URL, "https://ltl-serviceability.delhivery.com/serviceability/$pin/details/?pincode=$pin");
                        curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);  
                            curl_setopt($cf, CURLOPT_CONNECTTIMEOUT ,0); 
                            curl_setopt($cf, CURLOPT_TIMEOUT, 400);
                        curl_setopt($cf, CURLOPT_HTTPHEADER, array(
                            "Authorization: Bearer $jwt",
                            "accept: application/json",
                            "cache-control: no-cache",
                            "content-type: application/json"
                        ));
                        $response = curl_exec($cf);
                        $error = curl_error($cf);
                        curl_close($cf);
                        if($error){
                            echo $error;
                        }
                        else
                        {
                            $resp = json_decode($response);
                            if($resp->success == 1)
                            {
                                $cf = curl_init();
                                curl_setopt($cf, CURLOPT_URL, "https://ltl-retail.delhivery.com/v3/retail/pincode-mapping/$pin?oda_config=DLV");
                                curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);  
                                curl_setopt($cf, CURLOPT_CONNECTTIMEOUT ,0);
                                curl_setopt($cf, CURLOPT_TIMEOUT, 400);
                                curl_setopt($cf, CURLOPT_HTTPHEADER, array(
                                    "Authorization: Bearer $jwt",
                                    "accept: application/json",
                                    "cache-control: no-cache",
                                    "content-type: application/json"
                                ));
                                $oda_response = curl_exec($cf);
                                $oda_error = curl_error($cf);
                                curl_close($cf);
                                if($oda_error){
                                    echo $oda_error;
                                }
                                else
                                {
                                    ?>
                                    
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <form action="serviceability" method="POST">
                                                <div class="row">
                                                    <div class="col-4 form-group">
                                                        <input type="text" maxlength="6" class="form-control" id="pin" name="pin" value="<?= $pin; ?>" placeholder="Enter a pincode" required>
                                                    </div>
                                                    <div class="col-4 form-group">
                                                        <button type="submit" class="btn btn-success">Check</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <span class="text-dark"><?= $resp->data[0]->pincode; ?> is valid pincode, serviceability listed below</span>
                                                </div>
                                                <!--<div class="col-md-2 d-flex justify-content-end">-->
                                                <!--    <a href="serviceability" class="btn btn-dark"><i class="fa fa-reply"></i>&nbsp;Back</a>-->
                                                <!--</div>-->
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">PINCODE</th>
                                                            <th class="text-center">STATE</th>
                                                            <th class="text-center">CITY</th>
                                                            <th class="text-center">COD</th>
                                                            <th class="text-center">PRE-PAID</th>
                                                            <th class="text-center">CASH</th>
                                                            <th class="text-center">REPL</th>
                                                            <th class="text-center">PICKUP</th>
                                                            <th class="text-center">FM</th>
                                                            <th class="text-center">ODA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center"><?= $resp->data[0]->pincode; ?></td>
                                                            <td class="text-center"><?= $resp->data[0]->state; ?></td>
                                                            <td class="text-center"><?= $resp->data[0]->city; ?></td>
                                                            <td class="text-center">
                                                                <?php  
                                                                $payment_types = json_decode($resp->data[0]->payment_type);
                                                                
                                                                if (in_array('COD', $payment_types)) {
                                                                    echo '<span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span>';
                                                                } else {
                                                                    echo '<span class="badge badge-center rounded-pill bg-danger"><i class="bx bx-x"></i></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php 
                                                                if (in_array('Pre-paid', $payment_types)) {
                                                                    echo '<span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span>';
                                                                } else {
                                                                    echo '<span class="badge badge-center rounded-pill bg-danger"><i class="bx bx-x"></i></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php 
                                                                if (in_array('Cash', $payment_types)) {
                                                                    echo '<span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span>';
                                                                } else {
                                                                    echo '<span class="badge badge-center rounded-pill bg-danger"><i class="bx bx-x"></i></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php 
                                                                if (in_array('REPL', $payment_types)) {
                                                                    echo '<span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span>';
                                                                } else {
                                                                    echo '<span class="badge badge-center rounded-pill bg-danger"><i class="bx bx-x"></i></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php 
                                                                if (in_array('Pickup', $payment_types)) {
                                                                    echo '<span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span>';
                                                                } else {
                                                                    echo '<span class="badge badge-center rounded-pill bg-danger"><i class="bx bx-x"></i></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php 
                                                                if ($resp->data[0]->fm_serviceable == 1) {
                                                                    echo '<span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span>';
                                                                } else {
                                                                    echo '<span class="badge badge-center rounded-pill bg-danger"><i class="bx bx-x"></i></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php 
                                                                if ($oda_response == 'true') {
                                                                    echo '<span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span>';
                                                                } elseif ($oda_response == 'false') {
                                                                    echo '<span class="badge badge-center rounded-pill bg-danger"><i class="bx bx-x"></i></span>';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    
                                }
                            }
                            else
                            {
                              echo
                                '<script>
                                    alert("No service available for the entered pin code.");
                                    window.location= "serviceability";
                                </script>';
                            }
    
                        }
                    }else{
                        echo
                            '<script>
                                alert("System can\'t take your request right now! Please! try again later.");
                                window.location= "serviceability";
                            </script>';
                    }
                }
            }
            else
            {
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="serviceability" method="POST">
                            <div class="row">
                                <div class="col-4 form-group">
                                    <input type="text" maxlength="6" class="form-control" id="pin" name="pin" placeholder="Enter a pincode" required>
                                </div>
                                <div class="col-4 form-group">
                                    <button type="submit" class="btn btn-success">Check</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
include('menu/footer.php');
?>
<script>
    function validatePhoneNumberKey(e) {
        var charCode = (e.which) ? e.which : event.keyCode;
        if(String.fromCharCode(charCode).match(/[^0-9]/g)){
            return false;
        }
    }
    document.getElementById("pin").addEventListener("keydown", validatePhoneNumberKey);
</script>
<script>
    function showWarning(message) {
        swal("Warning!", message, "warning");
    }
</script>