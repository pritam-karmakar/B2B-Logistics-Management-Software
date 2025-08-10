<?php
    include 'assets/header.php';
    include("b2b/database/db.php");
    include("b2b/functions/all-functions.php");
    $query = new query();
    $newfunc = new allfunctions();
?>
    <style>
        .theme-btn{
            gap:30px!important;
        }
    </style>
    <!-- Page Header Start -->
    <div class="page-breadcrumb-area page-bg" style="background-image: url('images/section-bg/transportation-logistics.jpg')">
        <div class="page-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-wrapper">
                        <div class="page-heading">
                            <h3 class="page-title">Track Shipment</h3>
                        </div>
                        <div class="breadcrumb-list">
                            <ul>
                                <li><a href="index">Home</a></li>
                                <li class="active"><a href="#">Track Shipment</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="contact-form-area">
        <!-- Submit form Start -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == "POST")
            {
                
                extract($_POST);
                $cond =array("id"=>$cft);
                $get_3pl = $query->getData("*","3pls","",$cond,"","","")[0];
                
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
                curl_setopt($cs, CURLOPT_HTTPHEADER, array(
                    "accept: application/json",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ));
                $response = curl_exec($cs);
                $error = curl_error($cs);
                curl_close($cs);
                if($error){
                    echo $error;
                }
                else{
                    $resp = json_decode($response);
                    $jwt = $resp->jwt;
                    $cf = curl_init();
                    curl_setopt($cf, CURLOPT_URL, "https://ltl-serviceability.delhivery.com/serviceability/$pin/details/?pincode=$pin");
                    curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
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
                        // print_r($resp);
                        if($resp->success == 1)
                        {
                            $cf = curl_init();
                            curl_setopt($cf, CURLOPT_URL, "https://ltl-retail.delhivery.com/v3/retail/pincode-mapping/$pin?oda_config=DLV");
                            curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
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
                                
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <span class="text-dark"><?= $resp->data[0]->pincode; ?> is valid pincode, serviceability listed below</span>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-end">
                                                <a href="serviceability" class="btn btn-dark"><i class="fa fa-reply"></i>&nbsp;Back</a>
                                            </div>
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
                }
            }
                    ?>
                            <div class="comment-respond mt-45 mb-45">
                                <form action="" method="post" class="comment-form">
                                    <div class="row gx-2 d-flex justify-content-center">
                                        <div class="col-xl-6">
                                            <div class="contacts-name">
                                                <input name="pincode" type="text" placeholder="Enter PIN Code*"  required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-2">
                                            <button class="btn btn-success" type="submit" style="padding: 16px 42px; margin-left: 0.5rem;">Check<span class="icon"><i class="fa-solid fa-angle-right"></i></span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    
                </div>
            </div>
        </div>
    </div>

<?php include 'assets/footer.php'; ?>

<script>
    function validatePhoneNumberKey(event) {
        var charCode = event.which || event.keyCode;

        if ((charCode >= 48 && charCode <= 57) || // Digits
            charCode === 8 || // Backspace
            charCode === 9 || // Tab
            charCode === 46 || // Delete
            charCode === 37 || // Left arrow
            charCode === 39) { // Right arrow
            return true;
        } else {
            event.preventDefault();
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