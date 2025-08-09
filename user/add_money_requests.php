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
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"></span>
            </h4>
            <!-- Responsive Table -->
            <div class="card">
                <div class="card-header mb-3">
                    <div class="row">
                        <div class="col-md-10 d-flex justify-content-start">
                            <h5>My Transaction</h5>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr class="text-nowrap table-secondary">
                                <th class="text-center">Date</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Transaction Id</th>
                                <th class="text-center">Status</th>
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
                                $where = array('type'=>'users','type_id'=>$user_id);
                		        $requests = $query->getData('*','add_money_requests','',$where,'id','DESC',$limit);
                		        $requestsCount = $query->getData('COUNT(`id`) as "requestsCount"','add_money_requests','',$where,'id','DESC','')[0]['requestsCount'];
                		        if($requests != 0)
                		        {
                    	            foreach($requests as $getreqs)
                    	            {
                    		?>
                            <tr>
                                <td class="text-center"><?= date("d-M-Y", strtotime($getreqs['date'])); ?></td>
                                <td class="text-center"><?= $getreqs['amount']; ?></td>
                                <td class="text-center"><?= $getreqs['txn_id']; ?></td>
                                <td class="text-center"><span class="badge bg-<?php if($getreqs['status']=='Pending'){echo'primary';}elseif($getreqs['status']=='Approved'){echo'success';}elseif($getreqs['status']=='Rejected'){echo'danger';} ?>"><?= $getreqs['status']; ?></span></td>
                    		</tr>
                		    <?php
                    		        $sl++;
                        		    }
                    		    }
                			?>
                    	</tbody>
                    </table>
                </div>
                <?php
                    $pageCount = ceil($requestsCount/dataShow);
                    if($requestsCount != 0){
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
            <!--/ Responsive Table -->
        </div>
    </div>

<?php
    include('menu/footer.php');
?>