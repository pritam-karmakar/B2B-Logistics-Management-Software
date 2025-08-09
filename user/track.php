<?php
if(isset($_GET['lrn'])){
    include('menu/header.php');
    include('menu/navbar.php');
    $lrn = $_GET['lrn'];
    $order_details = $query->getData("*, (SELECT SUM(`qty`) FROM `box_details` WHERE `order_id` = `orders`.`order_id`) as 'total_boxes'","orders",[array("LEFT","consignee_details","consignee_details","order_id","orders","order_id")],array("user_type"=>"users","type_id"=>$user_id,"lr"=>$lrn),"","","");
    if($order_details != 0){
        $trackingDetails = $query->getData("*","order_tracking_details","",["lr"=>$lrn],"id","DESC","");
?>
        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold mb-4 py-2">Order & Tracking Details</h4>
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5 class="card-title"><strong>Order Details</strong></h5>
                                <hr/>
                            </div>
                            <div class="card-body pb-0">
                                <div class="pb-2" style="font-size: 1.4rem;"><b>LR No. :</b> <?= $lrn; ?></div>
                                <div class="d-flex pb-2" style="flex-direction: column;"><b>Master AWB : </b><?= $order_details[0]['master_waybill']; ?></div>
                                <div class="d-flex pb-2" style="justify-content: space-between;">
                                    <div class="d-flex" style="flex-direction: column;"><b>Payment Type : </b><?= $order_details[0]['payment_mode']; ?></div>
                                    <div class="d-flex" style="flex-direction: column; align-items: center"><b>Charged Weight : </b><b style="font-size: 1.3rem;"><?= (empty($order_details[0]['vol_weight']) || $order_details[0]['vol_weight'] == 0)? $order_details[0]['weight'] : $order_details[0]['vol_weight']; ?> Kg</b></div>
                                </div>
                                <div class="d-flex pb-2" style="flex-direction: column;"><b>No of Boxes : </b> <?= $order_details[0]['total_boxes']; ?></div>
                                <div class="d-flex pb-2" style="justify-content: space-between;">
                                    <div class="d-flex" style="flex-direction: column;"><b>CFT Type : </b><?= $order_details[0]['cft_type']; ?></div>
                                    <div class="d-flex pb-2" style="flex-direction: column; align-items: center"><b>Insurance : </b><?= $order_details[0]['insurance']; ?></div>
                                </div>
                                <?php if($order_details[0]['status'] == "In Transit"): ?>
                                    <div class="d-flex pb-2" style="flex-direction: column;"><b>Expected Delhivery Date : </b> <?= $order_details[0]['expected_delivery_date']; ?></div>
                                <?php endif; ?>
                                <div class="d-flex pb-4" style="flex-direction: column;"><b>Consignee Details : </b>
                                    <div><b>Name : </b><?= $order_details[0]['name']; ?></div>
                                    <div><b>Company Details : </b><?= $order_details[0]['company']; ?></div>
                                    <div><b>Mobile number : </b><?= $order_details[0]['phone']; ?></div>
                                    <div><b>Email address : </b><?= $order_details[0]['email']; ?></div>
                                    <div><b>Address : </b><?= $order_details[0]['address']; ?>, <?= $order_details[0]['city']; ?>, <?= $order_details[0]['state']; ?></div>
                                </div>
                                <!--<hr/>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div>
                            <div class="card-header pb-0">
                                <h5 class="card-title"><strong>Tracking Details</strong></h5>
                                <hr/>
                            </div>
                            <div class="card-body tracking-scrollbar" style="padding-left: 20px;">
                                <div class="row col-md-12">
                                    <?php
                                        if($trackingDetails != 0):
                                            foreach($trackingDetails as $track): ?>
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="d-flex" style="justify-content: space-between;">
                                                            <div class="d-flex col-md-2" style="flex-direction: column;">Status : <b><?= $track['status']; ?></b></div>
                                                            <div class="d-flex col-md-5" style="flex-direction: column;">Location : <b><?= $track['location']; ?></b><?= date_format(date_create($track['date_time']), "d M, Y H:i a"); ?></div>
                                                            <div class="d-flex col-md-5" style="flex-direction: column;">Remarks : <b><?= $track['scan_remark']; ?></b></div>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            endforeach;
                                        else:
                                            echo '<div class="d-flex justify-content-center">No Tracking Details Found !</div>';
                                        endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }else{
        echo "<script>alert('LR not found!');window.location='".$_SERVER['HTTP_REFERER']."';</script>";
    }
    include('menu/footer.php');
}else{
    echo "<script>alert('LR not found!');window.location='".$_SERVER['HTTP_REFERER']."';</script>";
}
?>