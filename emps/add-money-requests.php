<?php
if(!empty($_GET) && array_key_exists('page', $_GET)){
    $page = $_GET['page'];
}
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">All Requests</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example5" class="display table" style="min-width: 845px">
                    		<thead>
                    			<tr>
                    				<th class="text-center" hidden>Sl No.</th>
                    				<th class="text-center">User Type</th>
                    				<th class="text-center">User Name</th>
                    				<th class="text-center">User Details</th>
                    				<th class="text-center">Date</th>
                    				<th class="text-center">Amount</th>
                    				<th class="text-center">Transaction Id</th>
                    				<th class="text-center">Action</th>
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
                    		        $addm = $query->getData('*','add_money_requests','','','id','DESC',$limit);
                    		        $addMoneyReqCount = $query->getData('COUNT(`id`) as "addMoneyReqCount"','add_money_requests','','','id','DESC','')[0]['addMoneyReqCount'];
                    		        foreach($addm as $addmoney){
                    		            $user_details = $query->getData('*',$addmoney['type'],'',array('id'=>$addmoney['type_id']),'id','DESC','1')[0];
                    		    ?>
                    			<tr>
                    				<td class="text-center" hidden><?= $sl; ?></td>
                    				<td class="text-center"><?= ucwords($addmoney['type']); ?></td>
                    				<td class="text-center"><?php if($addmoney['type'] == "users"){ echo $user_details['username']; }elseif($addmoney['type'] == "branches"){ echo $user_details['branch_user_name']; } ?></td>
                    				<td class="text-center">
                    				    <?php if($addmoney['type'] == "users"){ echo $user_details['party_name']; }elseif($addmoney['type'] == "branches"){ echo $user_details['branch_name']; } ?><br/>Mob: <?= $user_details['mobile_no']; ?><br/>Email: <?= $user_details['email']; ?>
                    				</td>
                    				<td class="text-center"><?= $addmoney['date']; ?></td>
                    				<td class="text-center"><?= $addmoney['amount']; ?></td>
                    				<td class="text-center"><?= $addmoney['txn_id']; ?></td>
                    				<td class="text-center">
                    				    <?php
                    				        if($addmoney['status'] == "Pending"){
                    				    ?>
                    				        <div class="btn-group">
                    				            <a href="actions?submit=Submit&&thisIs=<?= $addmoney['id']; ?>&&style=Reject" onclick="return confirm('Are you sure to want to reject?')" class="btn btn-danger btn-sm">Reject</a>
                    				            <a href="actions?submit=Submit&&thisIs=<?= $addmoney['id']; ?>&&style=Approve" onclick="return confirm('Are you sure to want to approve?')" class="btn btn-success btn-sm">Approve</a>
                    				        </div>
                    				    <?php
                    				        }elseif($addmoney['status'] == "Approved"){
                    				            echo '<span class="text-success">Approved <i class="bi bi-patch-check-fill"></i></span>';
                    				        }else{
                    				            echo '<span class="text-danger">Rejected <i class="bi bi-x-circle-fill"></i></span>';
                    				        }
                				        ?>
                    				</td>
                    			</tr>
                    			<?php
                    		        }
                    			?>
                    		</tbody>
                    	</table>
                    </div>
                    <?php
                        $pageCount = ceil($addMoneyReqCount/dataShow);
                        if($addMoneyReqCount != 0){
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

<!--**********************************
    Content body end
***********************************-->
<?php
include("assets/footer.php");
?>