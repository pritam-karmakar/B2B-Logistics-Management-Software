<?php
if(empty($_GET) && !array_key_exists('orders', $_GET)){
    echo '<script type="text/javascript" language="javascript">window.location="all_orders?orders=manifested";</script>';
}else{
    $ordersType = $_GET['orders'];
    $page = $_GET['page'];
}
include('menu/header.php');
include('menu/navbar.php');

    if(isset($_GET['lr']) && isset($_GET['payment_mode']))
    {
        extract($_GET);
        if(!empty($lr) && !empty($payment_mode))
        {
            $order_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("lr","=",$lr),array("payment_mode","=",$payment_mode),array("status","=","Complete","OR","status","=","MANIFESTED"),array("user_type","=","users"),array("type_id","=",$user_id),array("lr","=",$lr),array("payment_mode","=",$payment_mode));
            $intrans_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("lr","=",$lr),array("payment_mode","=",$payment_mode),array("status","!=","Complete"),array("status","!=","MANIFESTED"),array("status","!=","DELIVERED"));
            $intrans_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("lr","=",$lr),array("payment_mode","=",$payment_mode),array("status","=","DELIVERED"));
        }
        elseif(empty($lr)&& !empty($payment_mode))
        {
            $order_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("payment_mode","=",$payment_mode),array("status","=","Complete","OR","status","=","MANIFESTED"),array("user_type","=","users"),array("type_id","=",$user_id),array("payment_mode","=",$payment_mode));
            $intrans_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("payment_mode","=",$payment_mode),array("status","!=","Complete"),array("status","!=","MANIFESTED"),array("status","!=","DELIVERED"));
            $intrans_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("payment_mode","=",$payment_mode),array("status","=","DELIVERED"));
        }
        elseif(!empty($lr) && empty($payment_mode))
        {
            $order_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("lr","=",$lr),array("status","=","Complete","OR","status","=","MANIFESTED"),array("user_type","=","users"),array("type_id","=",$user_id),array("lr","=",$lr));
            $intrans_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("lr","=",$lr),array("status","!=","Complete"),array("status","!=","MANIFESTED"),array("status","!=","DELIVERED"));
            $delveri_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("lr","=",$lr),array("status","=","DELIVERED"));
        }
        else
        {
            $order_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("status","=","Complete","OR","status","=","MANIFESTED"),array("user_type","=","users"),array("type_id","=",$user_id));
            $intrans_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("status","!=","Complete"),array("status","!=","MANIFESTED"),array("status","!=","DELIVERED"));
            $delveri_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("status","=","DELIVERED"));
        }
    }
    else
    {
        $order_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("status","=","Complete","OR","status","=","MANIFESTED","AND","user_type","=","users","AND","type_id","=",$user_id,"OR","status","=","Created"),array("user_type","=","users"),array("type_id","=",$user_id));
        $intrans_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("status","!=","Complete"),array("status","!=","MANIFESTED"),array("status","!=","DELIVERED"),array("status","!=","Created"));
        $delveri_cond = array(array("user_type","=","users"),array("type_id","=",$user_id),array("status","=","DELIVERED"));
    }
    const dataShow = 25;
    if(empty($page)){
        $page = 1;
    }else{
        $page = $page;
    }
    $offset = ($page - 1) * dataShow;
    $limit = $offset.','.dataShow;
    $order_details = $query->getData('*','orders','',$order_cond,'id','DESC',$limit);
    $orderDetailsCount = $query->getData('COUNT(`id`) as "manifestedOrdersCount"','orders','',$order_cond,'id','DESC','')[0]['manifestedOrdersCount'];

    $intrans_details = $query->getData('*','orders','',$intrans_cond,'id','DESC',$limit);
    $intransDetailsCount = $query->getData('COUNT(`id`) as "IntransitOrdersCount"','orders','',$intrans_cond,'id','DESC','')[0]['IntransitOrdersCount'];
    
    $delveri_details = $query->getData('*','orders','',$delveri_cond,'id','DESC',$limit);
    $deliveryDetailsCount = $query->getData('COUNT(`id`) as "deliveredOrdersCount"','orders','',$delveri_cond,'id','DESC','')[0]['deliveredOrdersCount'];
    if(isset($_GET['lr']) && isset($_GET['payment_mode'])){
        if($order_details != 0){
            $ordersType = "manifested";
        }elseif($intrans_details != 0){
            $ordersType = "in-transit";
        }elseif($delveri_details != 0){
            $ordersType = "delivered";
        }
    }
?>
    <style>
        .dwn-btn{
            background-color: #f54f03;
            color: #fff;
        }
        .dwn-btn:hover{
            background-color: #e94900;
            color: #fff;
        }
    </style>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Orders</span></h4>
            <!-- Responsive Table -->
            <div class="card">
                <div class="card-header">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item">
                                 <button onclick="window.location.href='all_orders?orders=manifested'" type="button" class="nav-link <?php if($ordersType == "manifested"){ echo 'active'; } ?>" role="tab" data-bs-toggle="tab">
                                     Manifested
                                    &nbsp;<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary"><?= $orderDetailsCount; ?></span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button onclick="window.location.href='all_orders?orders=in-transit'" type="button" class="nav-link <?php if($ordersType == "in-transit"){ echo 'active'; } ?>" role="tab" data-bs-toggle="tab">
                                    In-Transit
                                    &nbsp;<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary"><?= $intransDetailsCount; ?></span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button onclick="window.location.href='all_orders?orders=delivered'" type="button" class="nav-link <?php if($ordersType == "delivered"){ echo 'active'; } ?>" role="tab" data-bs-toggle="tab">
                                    Delivered
                                    &nbsp;<span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-primary"><?= $deliveryDetailsCount; ?></span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    
                    <form action="all_orders" method="GET">
                        <div class="row">
                            <div class="col-md-5 mb-3 ">
                                <input class="form-control" name="lr" placeholder="Search by LR Number">
                            </div>
                            <div class="col-md-5 mb-3 ">
                                <div class="input-group">
                                    <select class="form-control" name="payment_mode">
                                        <option value="">All Payments </option>
                                        <option value="CoD">COD</option>
                                        <option value="Prepaid">Prepaid</option>
                                        <option value="To-Pay">To-Pay</option>
                                        <option value="Franchise-ToPay">Franchise-ToPay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-outline-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="card-body">
                <?php if($ordersType == "manifested"){ ?>
                    <div class="tab-content" style="padding:5px;">
                        <div class="show" role="tabpanel">
                            <form action="action" method="POST">
                                <div class="row">
                                    <div class="col-md-2 d-flex justify-content-start mb-3">
                                        <button class="btn btn-danger" id="modal_pick" type="submit" name="create_selfdrop">Create Self Drop</button>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-start align-items-center mb-3">
                                        <div class="dropdown" id="multipleLrsB">
                                            <button type="button" class="btn btn-secondary btn-sm shadow sharp me-1 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-printer"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" type="submit" name="multipleWaybill" target="_blank"><span>WAYBILL COPY</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabelA4" target="_blank"><span>Shipping Label (A4)</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel4*2" target="_blank"><span>Shipping Label (4"x2")</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel4*2d5" target="_blank"><span>Shipping Label (4"x2.5")</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel3*2" target="_blank"><span>Shipping Label (3"x2")</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive text-nowrap">
                                   <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th class="text-center">
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input all_check" type="checkbox"  style="width: 18px; height: 18px; margin: 0px 10px 0px 0px;">
                                                        <label class="form-check-label">All Selfdrop</label>
                                                    </div>
                                                </th>
                                                <th class="text-center" >
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input allLRsChecks" <?php if($order_details == 0){ echo "disabled"; } ?> type="checkbox" style="width: 18px; height: 18px; margin: 0px 10px 0px 0px;">
                                                        <label class="form-check-label">Multiple Label</label>
                                                    </div>
                                                </th>
                                                <th class="text-center" >LR/AWB NO.</th>
                                                <th class="text-center" >ACTION</th>
                                                <th class="text-center" >MANIFESTED DATE</th>
                                                <th class="text-center" >CONSIGNEE</th>
                                                <th class="text-center" >TYPE</th>
                                                <th class="text-center" >BOX</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sl=1;
                                            ?>
                                            <input type="hidden" class="count_data" value="<?php if($order_details !=0 ) {echo count($order_details);} else{echo 0;} ?>">
                                            <input type="hidden" class="count_lrs" value="<?php if($order_details !=0 ) {echo count($order_details);} else{echo 0;} ?>">
                                            <?php
                                            foreach($order_details as $orders)
                                            {
                                                $consgn_cond = array("order_id"=>$orders['order_id']);
                                                $get_consignee_details = $query->getData('*','consignee_details','',$consgn_cond,'','','');
                                                $box_cond = array("order_id"=>$orders['order_id']);
                                                $get_box_details = $query->getData('*','box_details','',$box_cond,'','','');
                                                foreach($get_box_details as $boxes){
                                                    $orders['box_count'] = $orders['box_count']+$boxes['qty'];
                                                }
                                                $getwarehouse = $query->getData('*','warehouses','',array('id'=>$orders['warehouse_id']),'id','DESC','1')[0];
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php if ($orders['selfdrop']=='N'){
                                                        ?>
                                                        <div class="form-check form-check-inline mt-3">
                                                            <input type="hidden" id="selfdrop<?php echo $sl; ?>" value="<?= $orders['selfdrop']; ?>" >
                                                            <input class="form-check-input checkdt" type="checkbox" id="checkdt<?php echo $sl; ?>" name="order_id[]" value="<?= $orders['order_id']; ?>" >
                                                            <label class="form-check-label" ></label>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check form-check-inline mt-3">
                                                            <input type="hidden" id="labelCopy<?php echo $sl; ?>" value="<?= $orders['lr']; ?>" >
                                                            <input class="form-check-input checkSinglr" type="checkbox" id="checkSinglr<?php echo $sl; ?>" name="lrs[]" value="<?= $orders['lr']; ?>" >
                                                            <label class="form-check-label" ></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><a type="button" style="color: #fff;" onclick="window.location='track/<?= $orders['lr']; ?>'" class="btn btn-info shadow btn-sm sharp me-1"><?= $orders['lr']; ?></a></td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                          <button type="button" class="btn btn-secondary btn-sm shadow sharp me-1 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="bx bx-printer"></i>
                                                          </button>
                                                          <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="waybill/waybill?lr=<?= $orders['lr']; ?>"  target="_blank"><span>WAYBILL COPY</span></a>
                                                            <a class="dropdown-item" href="label/A4?lr=<?= $orders['lr']; ?>"  target="_blank"><span>Shipping Label (A4)</span></a>
                                                            <a class="dropdown-item" href="label/sm?lr=<?= $orders['lr']; ?>"  target="_blank"><span>Shipping Label (4"x2")</span></a>
                                                            <a class="dropdown-item" href="label/md?lr=<?= $orders['lr']; ?>"  target="_blank"><span>Shipping Label (4"x2.5")</span></a>
                                                            <a class="dropdown-item" href="label/std?lr=<?= $orders['lr']; ?>" target="_blank"><span>Shipping Label (3"x2")</span></a>
                                                          </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><?= $orders['order_date']; ?></td>
                                                    <td class="text-center"><?= $get_consignee_details[0]['name'].','.$get_consignee_details[0]['address'].','.$get_consignee_details[0]['city'].','.$get_consignee_details[0]['state']; ?></td>
                                                    <td class="text-center"><?= $orders['payment_mode']; ?></td>
                                                    <td class="text-center"><?= $orders['box_count']; ?></td>
                                                    
                                                </tr>
                                            <?php
                                                $sl++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php }elseif($ordersType == "in-transit"){ ?>
                    <div class="tab-content" style="padding:5px;">
                        <div class="show" role="tabpanel">
                            <form action="action" method="POST">
                                <div class="row">
                                    <div class="col-md-2 d-flex justify-content-start align-items-center mb-3">
                                        <div class="dropdown" id="multipleLrsB">
                                            <button type="button" class="btn btn-secondary btn-sm shadow sharp me-1 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-printer"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" type="submit" name="multipleWaybill" target="_blank"><span>WAYBILL COPY</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabelA4" target="_blank"><span>Shipping Label (A4)</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel4*2" target="_blank"><span>Shipping Label (4"x2")</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel4*2d5" target="_blank"><span>Shipping Label (4"x2.5")</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel3*2" target="_blank"><span>Shipping Label (3"x2")</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th class="text-center" >
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input allLRsChecks" <?php if($intrans_details == 0){ echo "disabled"; } ?> type="checkbox" style="width: 18px; height: 18px; margin: 0px 10px 0px 0px;">
                                                        <label class="form-check-label">Multiple Label</label>
                                                    </div>
                                                </th>
                                                <th class="text-center" >LR/AWB NO.</th>
                                                <th class="text-center" >ACTION</th>
                                                <th class="text-center" >MANIFESTED DATE</th>
                                                <th class="text-center" >CONSIGNEE</th>
                                                <th class="text-center" >TYPE</th>
                                                <th class="text-center" >BOX</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sl=1;
                                            ?>
                                            <input type="hidden" class="count_lrs" value="<?php if($intrans_details !=0 ) {echo count($intrans_details);} else{echo 0;} ?>">
                                            <?php
                                            foreach($intrans_details as $intrans_detail)
                                            {
                                                $intrans_consgn_cond = array("order_id"=>$intrans_detail['order_id']);
                                                $intrans_consignee_details = $query->getData('*','consignee_details','',$intrans_consgn_cond,'','','');
                                                $intrans_box_cond = array("order_id"=>$intrans_detail['order_id']);
                                                $intrans_get_box_details = $query->getData('*','box_details','',$intrans_box_cond,'','','');
                                                foreach($intrans_get_box_details as $boxes){
                                                    $intrans_detail['box_count'] = $intrans_detail['box_count']+$boxes['qty'];
                                                }
                                                $getwarehouse = $query->getData('*','warehouses','',array('id'=>$intrans_detail['warehouse_id']),'id','DESC','1')[0];
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-check form-check-inline mt-3">
                                                            <input type="hidden" id="labelCopy<?php echo $sl; ?>" value="<?= $intrans_detail['lr']; ?>" >
                                                            <input class="form-check-input checkSinglr" type="checkbox" id="checkSinglr<?php echo $sl; ?>" name="lrs[]" value="<?= $intrans_detail['lr']; ?>" >
                                                            <label class="form-check-label" ></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><a type="button" style="color: #fff;" onclick="window.location='track/<?= $intrans_detail['lr']; ?>'" class="btn btn-info shadow btn-sm sharp me-1"><?= $intrans_detail['lr']; ?></a></td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                          <button type="button" class="btn btn-secondary btn-sm shadow sharp me-1 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="bx bx-printer"></i>
                                                          </button>
                                                          <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="waybill/waybill?lr=<?= $intrans_detail['lr']; ?>"><span>WAYBILL COPY</span></a>
                                                            <a class="dropdown-item" href="label/A4?lr=<?= $intrans_detail['lr']; ?>"  target="_blank"><span>Shipping Label (A4)</span></a>
                                                            <a class="dropdown-item" href="label/sm?lr=<?= $intrans_detail['lr']; ?>"  target="_blank"><span>Shipping Label (4"x2")</span></a>
                                                            <a class="dropdown-item" href="label/md?lr=<?= $intrans_detail['lr']; ?>"  target="_blank"><span>Shipping Label (4"x2.5")</span></a>
                                                            <a class="dropdown-item" href="label/std?lr=<?= $intrans_detail['lr']; ?>" target="_blank"><span>Shipping Label (3"x2")</span></a>
                                                          </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><?= $intrans_detail['order_date']; ?></td>
                                                    <td class="text-center"><?= $intrans_consignee_details[0]['name'].','.$intrans_consignee_details[0]['address'].','.$intrans_consignee_details[0]['city'].','.$intrans_consignee_details[0]['state']; ?></td>
                                                    <td class="text-center"><?= $intrans_detail['payment_mode']; ?></td>
                                                    <td class="text-center"><?= $intrans_detail['box_count']; ?></td>
                                                </tr>
                                            <?php
                                                $sl++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php }elseif($ordersType == "delivered"){ ?>
                    <div class="tab-content" style="padding:5px;">
                        <div class="show" role="tabpanel">
                            <form action="action" method="POST">
                                <div class="row">
                                    <div class="col-md-2 d-flex justify-content-start align-items-center mb-3">
                                        <div class="dropdown" id="multipleLrsB">
                                            <button type="button" class="btn btn-secondary btn-sm shadow sharp me-1 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-printer"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" type="submit" name="multipleWaybill" target="_blank"><span>WAYBILL COPY</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabelA4" target="_blank"><span>Shipping Label (A4)</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel4*2" target="_blank"><span>Shipping Label (4"x2")</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel4*2d5" target="_blank"><span>Shipping Label (4"x2.5")</span></button>
                                                <button class="dropdown-item" type="submit" name="multipleLabel3*2" target="_blank"><span>Shipping Label (3"x2")</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th class="text-center" >
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input allLRsChecks" <?php if($delveri_details == 0){ echo "disabled"; } ?> type="checkbox" style="width: 18px; height: 18px; margin: 0px 10px 0px 0px;">
                                                        <label class="form-check-label">Multiple Label</label>
                                                    </div>
                                                </th>
                                                <th class="text-center" >LR/AWB NO.</th>
                                                <th class="text-center" >ACTION</th>
                                                <th class="text-center" >MANIFESTED DATE</th>
                                                <th class="text-center" >CONSIGNEE</th>
                                                <th class="text-center" >TYPE</th>
                                                <th class="text-center" >BOX</th>
                                                <th class="text-center" >POD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sl=1;
                                            ?>
                                            <input type="hidden" class="count_lrs" value="<?php if($delveri_details !=0 ) {echo count($delveri_details);} else{echo 0;} ?>">
                                            <?php
                                            foreach($delveri_details as $delveri_detail)
                                            {
                                                $delveri_consgn_cond = array("order_id"=>$delveri_detail['order_id']);
                                                $delveri_consignee_details = $query->getData('*','consignee_details','',$delveri_consgn_cond,'','','');
                                                $delveri_box_cond = array("order_id"=>$delveri_detail['order_id']);
                                                $delveri_get_box_details = $query->getData('*','box_details','',$delveri_box_cond,'','','');
                                                foreach($delveri_get_box_details as $boxes){
                                                    $delveri_detail['box_count'] = $delveri_detail['box_count']+$boxes['qty'];
                                                }
                                                $getwarehouse = $query->getData('*','warehouses','',array('id'=>$delveri_detail['warehouse_id']),'id','DESC','1')[0];
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-check form-check-inline mt-3">
                                                            <input type="hidden" id="labelCopy<?php echo $sl; ?>" value="<?= $delveri_detail['lr']; ?>" >
                                                            <input class="form-check-input checkSinglr" type="checkbox" id="checkSinglr<?php echo $sl; ?>" name="lrs[]" value="<?= $delveri_detail['lr']; ?>" >
                                                            <label class="form-check-label" ></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><a type="button" style="color: #fff;" onclick="window.location='track/<?= $delveri_detail['lr']; ?>'" class="btn btn-info shadow btn-sm sharp me-1"><?= $delveri_detail['lr']; ?></a></td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                          <button type="button" class="btn btn-secondary btn-sm shadow sharp me-1 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="bx bx-printer"></i>
                                                          </button>
                                                          <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="waybill/waybill?lr=<?= $delveri_detail['lr']; ?>" target="_blank"><span>WAYBILL COPY</span></a>
                                                            <a class="dropdown-item" href="label/A4?lr=<?= $delveri_detail['lr']; ?>"  target="_blank"><span>Shipping Label (A4)</span></a>
                                                            <a class="dropdown-item" href="label/sm?lr=<?= $delveri_detail['lr']; ?>"  target="_blank"><span>Shipping Label (4"x2")</span></a>
                                                            <a class="dropdown-item" href="label/md?lr=<?= $delveri_detail['lr']; ?>"  target="_blank"><span>Shipping Label (4"x2.5")</span></a>
                                                            <a class="dropdown-item" href="label/std?lr=<?= $delveri_detail['lr']; ?>" target="_blank"><span>Shipping Label (3"x2")</span></a>
                                                          </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><?= $delveri_detail['order_date']; ?></td>
                                                    <td class="text-center"><?= $delveri_consignee_details[0]['name'].','.$delveri_consignee_details[0]['address'].','.$delveri_consignee_details[0]['city'].','.$delveri_consignee_details[0]['state']; ?></td>
                                                    <td class="text-center"><?= $delveri_detail['payment_mode']; ?></td>
                                                    <td class="text-center"><?= $delveri_detail['box_count']; ?></td>
                                                    
                                                    <td class="text-center">
                                                        <button id="getPOD<?= $delveri_detail['lr']; ?>" title="Download POD" type="button" onclick='getPOD(<?= $delveri_detail["lr"]; ?>)' class="btn btn-success btn-sm me-1 shadow"><i class='bi bi-boxes'></i></button>
                                                    </td>
                                                </tr>
                                            <?php
                                                $sl++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php }
                        if($ordersType == "manifested"){
                            $countOrders = $orderDetailsCount;
                        }elseif($ordersType == "in-transit"){
                            $countOrders = $intransDetailsCount;
                        }elseif($ordersType == "delivered"){
                            $countOrders = $deliveryDetailsCount;
                        }
                        $pageCount = ceil($countOrders/dataShow);
                        if($countOrders != 0){
                            foreach($_GET as $getKey => $getVal){
                                if($getKey != "page"){
                                    $GetArr = $GetArr.$getKey."=".$getVal."&";
                                }
                            }
                    ?>
                        <ul class='newpagination d-flex justify-content-end'>
                            <li><a href='<?php if($page != 1){ echo CurrentPageURL."?".$GetArr."page=1"; }else{ echo 'javascript:void(0)'; } ?>'><i class='fa-solid fas fa-angle-double-left'></i></a></li>
                            <li><a href='<?php if($page != 1){ echo CurrentPageURL."?".$GetArr."page=".($page-1); }else{ echo 'javascript:void(0)'; } ?>'>Prev</a></li>
                    <?php
                        for($i = 1; $i <= $pageCount; $i++):
                            if($page <= 5 && $pageCount > 7){
                                for($i = 1; $i <= 5; $i++):
                    ?>
                                    <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$i; ?>" class="<?php if($page == $i){ echo 'active'; } ?>"><?= $i; ?></a></li>
                    <?php
                                endfor;
                    ?>
                                    <span class="ellipsis dot">…</span>
                                    <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$pageCount; ?>"><?= $pageCount; ?></a></li>
                    <?php
                                break;
                            }elseif($page > 5 && $page <= $pageCount-5 && $pageCount > 7){
                    ?>
                                <li><a href="<?= CurrentPageURL."?".$GetArr."page=1"; ?>">1</a></li>
                                <span class="ellipsis dot">…</span>
                    <?php
                                for($j = $page-2; $j <= $page+2; $j++):
                    ?>
                                <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$j; ?>" class="<?php if($page == $j){ echo 'active'; } ?>"><?= $j; ?></a></li>
                    <?php
                                endfor;
                    ?>
                                <span class="ellipsis dot">…</span>
                                <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$pageCount; ?>"><?= $pageCount; ?></a></li>
                    <?php
                                break;
                            }elseif($page > $pageCount-5 && $pageCount > 7){
                    ?>
                                <li><a href="<?= CurrentPageURL."?".$GetArr."page=1"; ?>">1</a></li>
                                <span class="ellipsis dot">…</span>
                    <?php
                                for($k = $pageCount-4; $k <= $pageCount; $k++):
                    ?>
                                    <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$k; ?>" class="<?php if($page == $k){ echo 'active'; } ?>"><?= $k; ?></a></li>
                    <?php
                                endfor;
                                break;
                            }else{
                                for($l = 1; $l <= $pageCount; $l++):
                    ?>
                                    <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$l; ?>" class="<?php if($page == $l){ echo 'active'; } ?>"><?= $l; ?></a></li>
                    <?php
                                endfor;
                                break;
                            }
                        endfor;
                    ?>
                            <li><a href='<?php if($page != $pageCount){ echo CurrentPageURL."?".$GetArr."page=".($page + 1); }else{ echo 'javascript:void(0)'; } ?>'>Next</a></li>
                            <li><a href='<?php if($page != $pageCount){ echo CurrentPageURL."?".$GetArr."page=".$pageCount; }else{ echo 'javascript:void(0)'; } ?>'><i class='fa-solid fas fa-angle-double-right'></i></a></li>
                        </ul>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <!--/ Responsive Table -->
        </div>
    </div>
<?php
include('menu/footer.php');
?>

<script>
    $(document).ready(function(){
        $("#modal_pick").hide();
        $("#multipleLrsB").hide();
        // selfdrop
        $(".all_check").click(function(){
            if($(".all_check").is(':checked'))
            {
                $('.checkdt').prop('checked',true);
                $("#modal_pick").show();
            }
            else
            {
                $('.checkdt').prop('checked',false);
                $("#modal_pick").hide();
                
            }
        });
        // multiple lr selection
        $(".allLRsChecks").click(function(){
            if($(".allLRsChecks").is(':checked'))
            {
                $('.checkSinglr').prop('checked',true);
                $("#multipleLrsB").show();
            }
            else
            {
                $('.checkSinglr').prop('checked',false);
                $("#multipleLrsB").hide();
                
            }
        });
        // for selfdrop
        $(".checkdt").click(function(){
            var count_data = $(".count_data").val();
            var abc = 0;
            for(var t=1;t<=count_data;t++)
            {
                if($('#checkdt'+t).is(':checked'))
                {
                    abc = 1+ abc;
                }

            }
            if(abc > 0)
            {
                $("#modal_pick").show();
            }
            else
            {
                $("#modal_pick").hide();
            }
            if(abc == count_data)
            {
                $(".all_check").prop('checked',true);
            }
            else
            {
                $(".all_check").prop('checked',false);
                
            }
        });
        // for multiple lrs
        $(".checkSinglr").click(function(){
            var count_lrs = $(".count_lrs").val();
            var abc = 0;
            for(var t=1;t<=count_lrs;t++)
            {
                if($('#checkSinglr'+t).is(':checked'))
                {
                    abc = 1+ abc;
                }

            }
            if(abc > 0)
            {
                $("#multipleLrsB").show();
            }
            else
            {
                $("#multipleLrsB").hide();
            }
            if(abc == count_lrs)
            {
                $(".allLRsChecks").prop('checked',true);
            }
            else
            {
                $(".allLRsChecks").prop('checked',false);
                
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        var count_data = $(".count_data").val();
        if(count_data==0){
             $(".all_check").prop('disabled',true);
        }
    });
</script>
<script>
    // generate label
    function genLabel(genId){
        $('#genLabel'+genId).html(`<span class="spinner-border spinner-border-sm text-dark" style="margin: 1px 28px;"></span>`);
        $('#genLabel'+genId).attr('disabled', true);
        $.ajax({
            type: 'post',
            url: 'action.php',
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

</script>