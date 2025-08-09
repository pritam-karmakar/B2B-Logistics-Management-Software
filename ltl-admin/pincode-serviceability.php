<?php
include ("assets/header.php");
include ("assets/sidebar.php");
?>
<style>
    .color-success{
        color: #008000;
        font-size: 24px;
    }
    .color-danger{
        color: #ff0000;
        font-size: 24px;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <?php
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            extract($_POST);
            $cond = array("id" => "1");
            $get_3pl = $query->getData("*", "3pls", "", $cond, "", "", "")[0];

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
            )
            );
            $response = curl_exec($cs);
            $error = curl_error($cs);
            curl_close($cs);
            if($error) {
                echo $error;
            } else {
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
                if ($error) {
                    echo $error;
                } else {
                    $resp = json_decode($response);
                    if ($resp->success == 1) {
                        $cf = curl_init();
                        curl_setopt($cf, CURLOPT_URL, "https://ltl-retail.delhivery.com/v3/retail/pincode-mapping/$pin?oda_config=DLV");
                        curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($cf, CURLOPT_HTTPHEADER, array(
                            "Authorization: Bearer $jwt",
                            "accept: application/json",
                            "cache-control: no-cache",
                            "content-type: application/json"
                        )
                        );
                        $oda_response = curl_exec($cf);
                        $oda_error = curl_error($cf);
                        curl_close($cf);
                        if ($oda_error) {
                            echo $oda_error;
                        } else {
                            ?>
                            
                            <form class="row d-flex justify-content-center mb-4" method="POST" action="">
                                <div class="col-md-4 form-group">
                                    <label>Pin Code Serviceability</label>
                                    <input type="text" maxlength="6" class="form-control form-control-sm txtNemuric" name="pin" value="<?= $pin; ?>" placeholder="Enter PIN Code to Check">
                                </div>
                                <div class="col-md-1 form-group d-flex align-items-end">
                                    <button type="submit" class="btn btn-block btn-xs"
                                        style="background-color: #28a745; color: #fff;">Search</button>
                                </div>
                            </form>

                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="text-dark"><?= $resp->data[0]->pincode; ?> is a valid pincode, serviceability listed below</span>
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
                                                    <th class="d-flex justify-content-center">ODA</th>
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
                                                            echo '<i class="bi bi-check-circle-fill color-success"></i>';
                                                        } else {
                                                            echo '<i class="bi bi-x-circle-fill color-danger"></i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if (in_array('Pre-paid', $payment_types)) {
                                                           echo '<i class="bi bi-check-circle-fill color-success"></i>';
                                                        } else {
                                                             echo '<i class="bi bi-x-circle-fill color-danger"></i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if (in_array('Cash', $payment_types)) {
                                                          echo '<i class="bi bi-check-circle-fill color-success"></i>';
                                                        } else {
                                                             echo '<i class="bi bi-x-circle-fill color-danger"></i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if (in_array('REPL', $payment_types)) {
                                                           echo '<i class="bi bi-check-circle-fill color-success"></i>';
                                                        } else {
                                                             echo '<i class="bi bi-x-circle-fill color-danger"></i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if (in_array('Pickup', $payment_types)) {
                                                           echo '<i class="bi bi-check-circle-fill color-success"></i>';
                                                        } else {
                                                             echo '<i class="bi bi-x-circle-fill color-danger"></i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if ($resp->data[0]->fm_serviceable == 1) {
                                                           echo '<i class="bi bi-check-circle-fill color-success"></i>';
                                                        } else {
                                                             echo '<i class="bi bi-x-circle-fill color-danger"></i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if ($oda_response == 'true') {
                                                           echo '<i class="bi bi-check-circle-fill color-success"></i>';
                                                        } elseif ($oda_response == 'false') {
                                                            echo '<i class="bi bi-x-circle-fill color-danger"></i>';
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
                    } else {
                        echo
                            '<script>
                                alert("No service available for the entered pin code.");
                                window.location= "pincode-serviceability";
                            </script>';
                    }

                }
            }
        } else {
            ?>
            <form class="row d-flex justify-content-center mb-4" method="POST" action="">
                <div class="col-md-4 form-group">
                    <label>Pin Code Serviceability</label>
                    <input type="text" maxlength="6" class="form-control form-control-sm txtNemuric" name="pin"
                        placeholder="Enter PIN Code to Check">
                </div>
                <div class="col-md-1 form-group d-flex align-items-end">
                    <button type="submit" class="btn btn-block btn-xs"
                        style="background-color: #28a745; color: #fff;">Search</button>
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</div>

<?php
include ("assets/footer.php");
?>