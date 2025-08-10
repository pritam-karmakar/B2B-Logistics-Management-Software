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
                    if(isset($_POST['lrn']))
                    {
                            $lrn = $_POST['lrn'];
                            $order_cond = array("lr"=>$lrn);
                            $order_details = $query->getData('*','orders','',$order_cond,'','','');
                            if($order_details!=0)
                            {
                                $cft_type = $order_details[0]['cft_type'];
                                
                                $cond =array("api_token_name"=>$cft_type);
                                $get_3pl = $query->getData("*","3pls","",$cond,"","","")[0];
                                $cftregistered_name = $get_3pl['registered_name'];
                                $cfttoken = $get_3pl['api_token'];
                                $cftpassword = $get_3pl['password'];
                                
                                $loginFields = array(
                                    "username" => $cftregistered_name,
                                    "password" => $cftpassword
                                 );
                                 $sb = curl_init();
                                 curl_setopt($sb, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
                                 curl_setopt($sb, CURLOPT_POSTFIELDS, json_encode($loginFields));
                                 curl_setopt($sb, CURLOPT_RETURNTRANSFER, true);
                                 curl_setopt($sb, CURLOPT_HTTPHEADER, array(
                                  "accept: application/json",
                                  "cache-control: no-cache",
                                  "content-type: application/json"
                                 ));
                                 $response = curl_exec($sb);
                                 $error = curl_error($sb);
                                 curl_close($sb);
                                 if($error){
                                  echo $error;
                                 }
                                 else
                                {
                                     $resp = json_decode($response);
                                     $jwt = $resp->jwt;
                                     $sb = curl_init();
                                     curl_setopt($sb, CURLOPT_URL, "https://btob.api.delhivery.com/v3/track/$lrn");
                                     curl_setopt($sb, CURLOPT_RETURNTRANSFER, true);
                                     curl_setopt($sb, CURLOPT_HTTPHEADER, array(
                                      "Authorization: Bearer $jwt",
                                      "accept: application/json",
                                      "cache-control: no-cache",
                                      "content-type: application/json"
                                     ));
                                     $response = curl_exec($sb);
                                     $error = curl_error($sb);
                                    curl_close($sb);
                                    if($error){
                                      echo $error;
                                     }
                                     else{
                                        $res_array = json_decode($response);
                                        ?>
                                        <div class="comment-respond mt-45 mb-45">
                                            <form action="" method="post" class="comment-form">
                                                <div class="row gx-2 d-flex justify-content-center">
                                                    <div class="col-xl-6">
                                                        <div class="contacts-name">
                                                            <input name="lrn" type="text" placeholder="Enter LR No/ Tracking Number*" value="<?php if(isset($_POST['lrn'])){echo $_POST['lrn']; }?>" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-2">
                                                        <button class="theme-btn" type="submit" style="padding: 8px 32px;">Track<span class="icon"><i class="fa-solid fa-angle-right"></i></span></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row gx-2 d-flex justify-content-center  mt-15">
                                            
                                                <div class="col-md-4">
                                                    <p style="font-weight:bold">LRN : <?= $lrn;?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p style="font-weight:bold">Master Waybill : <?= $res_array->data->wbns[0]->wbn;?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p style="font-weight:bold">Last Updated : <?= $res_array->data->wbns[0]->timestamp; ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Status: <?php echo  $res_array->data->wbns[0]->status; ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Location: <?= $res_array->data->wbns[0]->location; ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Remarks: <?= $res_array->data->wbns[0]->scan_remark; ?></p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                                
                                        
                            <?php
                                       
                                    }
                                }
                            }
                            else
                            {
                                echo "<script>alert('No LR Found!!');window.location='".$_SERVER['HTTP_REFERER']."';</script>";
                            }
                        }
                        else
                        {
                    ?>
                            <div class="comment-respond mt-45 mb-45">
                                <form action="" method="post" class="comment-form">
                                    <div class="row gx-2 d-flex justify-content-center">
                                        <div class="col-xl-6">
                                            <div class="contacts-name">
                                                <input name="lrn" type="text" placeholder="Enter LR No/ Tracking Number*"  required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-2">
                                            <button class="theme-btn" type="submit" style="padding: 8px 32px;">Track<span class="icon"><i class="fa-solid fa-angle-right"></i></span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php include 'assets/footer.php'; ?>
