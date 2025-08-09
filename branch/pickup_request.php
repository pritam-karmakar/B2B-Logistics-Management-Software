<?php
if(!empty($_GET) && array_key_exists('page', $_GET)){
    $page = $_GET['page'];
}
include('menu/header.php');
include('menu/navbar.php');
?>
    
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pick Up Request</span></h4>
            
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>New Request</h3>
                        </div>
                        <div class="card-body">
                            <form action="act" method="POST" class="row">
                                <?php
                                if($get_user_details[0]['threepl']=='all')
                                {
                                    ?>
                                    <div class="form-group mb-2">
                                        <label for="" class="form-label">Choose CFT <span>*</span></label>
                                        <select id="" name="cft" class="form-control" required>
                                            <option value="" hidden>Choose CFT</option>
                                            <?php
                                            $get_all_threepl = $query->getData("*","3pls","","","","","");
                                            foreach($get_all_threepl as $threepl)
                                            {
                                                ?><option value="<?= $threepl['id']; ?>" ><?= $threepl['api_token_name']; ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    $condit =array("branches`.`id"=>$user_id);
                                    $join= array('0'=>array('LEFT','3pls','3pls','id','branches','threepl'));
                                    $get_3pl = $query->getData("*","branches",$join,$condit,"","","1")[0];
                                    ?><input type="hidden" id="cft" name="cft" class="form-control" value="<?= $get_3pl['id']; ?>"  ><?php
                                }
                                ?>
                                <div class="form-group mb-2">
                                    <label for="select2Basic" class="form-label">Warehouse Location <span>*</span></label>
                                    <select id="select2Basic" name="pickup_location" class="select2 form-select form-select-lg" required>
                                        <option value="" hidden>Select a Warehouse</option>
                                        <?php
                                            $selware = $query->getData("*","warehouses","",array("type"=>"branches","type_id"=>$user_id),"id","DESC","");
                                            foreach($selware as $ware){
                                        ?>
                                            <option value="<?= $ware['id']; ?>"><?= $ware['warehouse_name']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="defaultInput" class="form-label">Expected packages <span>*</span></label>
                                    <input  id="defaultInput" type="text" class="form-control" name="expected_package_count" placeholder="Enter Package Count" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label  class="form-label">Pickup Date <span>*</span></label>
                                    <input type="date" class="form-control" name="pickup_date" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="form-label">Pickup Time <span>*</span></label>
                                    <input type="time" class="form-control" name="pickup_time" required>
                                    <!--<select class="form-select" id="defaultSelect">-->
                                    <!--    <option value="01:00 pm - 03:00 pm">01:00 pm - 03:00 pm</option>-->
                                    <!--    <option value="03:00 pm - 06:00 pm">03:00 pm - 06:00 pm</option>-->
                                    <!--    <option value="06:00 pm - 09:00 pm">06:00 pm - 09:00 pm</option>-->
                                    <!--    <option value="09:00 pm - 11:59 pm">09:00 pm - 11:59 pm</option>-->
                                    <!--</select>-->
                                </div>
                                <div class="text-end">
                                    <button type="submit" onclick="return confirm('Are you sure to want to create pickup request')" name="createPickupRequest" class="btn btn-label-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th class="text-center">REQUEST ID</th>
                                            <th class="text-center">WAREHOUSE LOCATION</th>
                                            <th class="text-center">PICKUP DATE & TIME</th>
                                            <!--<th class="text-center">STATUS</th>-->
                                            <!--<th class="text-center">ACTION</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sl = 1;
                                            const dataShow = 25;
                                            if(empty($page)){
                                                $page = 1;
                                            }else{
                                                $page = $page;
                                            }
                                            $offset = ($page - 1) * dataShow;
                                            $limit = $offset.','.dataShow;
                                            $pickup_request = $query->getData("*","pickup_request","",array("type"=>"branches","type_id"=>$user_id),"id","DESC",$limit);
                                            $pickupRequestCount = $query->getData("COUNT(`id`) as 'pickupRequestCount'","pickup_request","",array("type"=>"branches","type_id"=>$user_id),"id","DESC","")[0]['pickupRequestCount'];
                                            foreach($pickup_request as $pick){
                                                $get_warehouses = $query->getData("*","warehouses","",array("id"=>$pick['pickup_location']),"","","");
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $pick['pickup_id']; ?></td>
                                                <td class="text-center"><?= $get_warehouses[0]['warehouse_name'].'-'.$get_warehouses[0]['address']; ?></td>
                                                <td class="text-center"><?= date("d/m/Y", strtotime($pick['pickup_date'])).' - '.$pick['pickup_time']; ?></td>
                                                <!--<td class="text-center"><span class="badge bg-primary">Requested</span></td>-->
                                                <!--<td class="text-center"><button type="button" class="btn rounded-pill btn-danger">Cancel</button></td>-->
                                            </tr>
                                        <?php
                                            $sl++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                                $pageCount = ceil($pickupRequestCount/dataShow);
                                if($pickupRequestCount != 0){
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
                </div>
            </div>
        </div>
    </div>
<?php
include('menu/footer.php');
?>