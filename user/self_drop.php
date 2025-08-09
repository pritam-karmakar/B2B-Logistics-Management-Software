<?php
include('menu/header.php');
include('menu/navbar.php');
?>


        <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Self Drop</span></h4>
            <!-- Responsive Table -->
            <div class="card">
                <div class="card-body">
                    <!--<div class="row">-->
                        
                    <!--    <div class="col-md-3 mb-3 ">-->
                    <!--        <input type="text" class="form-control" placeholder="Search by Self drop id">-->
                    <!--    </div>-->
                    <!--    <div class="col-md-3 mb-3 ">-->
                    <!--        <select class="form-control">-->
                    <!--            <option value="" >--Select Dispatch Status-- </option>-->
                    <!--            <option value="Dispatched">Dispatched</option>-->
                    <!--            <option value="WIP">WIP</option>-->
                    <!--            <option value="Completed">Completed</option>-->
                    <!--            <option value="Cancelled">Cancelled</option>-->
                    <!--        </select>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-2 mb-3 ">-->
                    <!--        <input type="date" class="form-control" placeholder="Created On" >-->
                    <!--    </div>-->
                    <!--    <div class="col-md-3 mb-3 ">-->
                    <!--        <select class="form-control">-->
                    <!--                <option value="">--Select Payment Status--</option>-->
                    <!--                <option value="Paid">Paid</option>-->
                    <!--                <option value="Pending">Pending</option>-->
                    <!--            </select>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-1">-->
                    <!--        <button class="btn btn-outline-primary" type="submit">Search</button>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center" >SELF DROP ID</th>
                                    <th class="text-center" >LR Num</th>
                                    <th class="text-center" >Master Waybill</th>
                                    <th class="text-center" >DISPATCH STATUS</th>
                                    <th class="text-center" >DROP LOCATION</th>
                                    <th class="text-center" >CREATED ON</th>
                                    <th class="text-center" >EXPECTED AMOUNT</th>
                                    <th class="text-center" >PAYMENT STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sl=1;
                                $order_cond = array("user_type"=>"users","type_id"=>$user_id,"status"=>"Complete","selfdrop"=>"Y");
                                $order_details = $query->getData('*','orders','',$order_cond,'order_date','DESC','');
                                foreach($order_details as $orders)
                                {
                                    $consgn_cond = array("order_id"=>$orders['order_id']);
                                    $get_consignee_details = $query->getData('*','consignee_details','',$consgn_cond,'','','');
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php if($orders['selfdrop_dis_status']=="Pending"){echo 'Pending';}else{echo $orders['selfdrop_id'];} ?></td>
                                        <td class="text-center"><?php echo  $orders['lr']; ?></td>
                                        <td class="text-center"><?php echo   $orders['master_waybill']; ?></td>
                                        <td class="text-center"><?php echo  $orders['selfdrop_dis_status']; ?></td>
                                        <td class="text-center"><?php if($orders['selfdrop_dis_status']=="Pending"){echo 'Pending';}else{echo $orders['selfdrop_location'];} ?></td>
                                        <td class="text-center"><?php echo  $orders['selfdrop_date']; ?></td>
                                        <td class="text-center"><?php if($orders['selfdrop_dis_status']=="Pending"){echo 'Pending';}else{echo $orders['selfdrop_amount'];} ?></td>
                                        <td class="text-center"><?php if($orders['selfdrop_dis_status']=="Pending"){echo 'Pending';}else{echo $orders['selfdrop_pay_status'];} ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ Responsive Table -->
        </div>
    </div>
<?php
include('menu/footer.php');
?>
