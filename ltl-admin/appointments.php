<?php
if(!array_key_exists('visible', $_GET)){
    echo '<script type="text/javascript" language="javascript">window.location="appointments?visible=users";</script>';
}elseif(empty($_GET['visible'])){
    echo '<script>window.location = "appointments?visible=users";</script>';
}elseif($_GET['visible'] != "users" && $_GET['visible'] != "branches"){
    echo '<script>window.location = "appointments?visible=users";</script>';
}else{
    extract($_GET);
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
		            <h3 class="card-title">All <?= ucwords(rtrim(rtrim($visible, "s"), "es"))."'s"; ?> Appintments</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example5" class="display table" style="min-width: 845px">
                    		<thead>
                    			<tr>
                    			    <th class="text-center" hidden>Sl No.</th>
                    				<th class="text-center"><?= ucwords(rtrim(rtrim($visible, "s"), "es")); ?> Details</th>
                    				<th class="text-center">LR No.</th>
                                    <th class="text-center">Appointment Date </th>
                                    <th class="text-center">Slot Time </th>
                                    <th class="text-center">PO</th>
                                    <th class="text-center">Appointment ID</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Remark</th>
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
                    		        $appointments = $query->getData("`appointments`.*,`orders`.`lr`","appointments",array("0"=>array("LEFT","orders","orders","lr","appointments","lr_no")),array("appointments`.`user_type"=>$visible),"id","DESC",$limit);
                    		        $appointmentsCount = $query->getData("COUNT(`id`) as 'appointmentsCount'","appointments","",array("user_type"=>$visible),"id","DESC","")[0]['appointmentsCount'];
                    		        if($appointments != 0){
                                        foreach($appointments as $apps){
                    		    ?>
                                <tr>
                                    <td class="text-center" hidden><?= $sl; ?></td>
                                    <td class="text-center">
                                        <?php
                                            if($visible == "users"){
                                                $user = $query->getData("`party_name`,`username`",$visible,"",array("id"=>$apps['type_id']),"id","DESC","1")[0];
                                                echo $user['party_name']."<br/><b>Username : </b>".$user['username'];
                                            }elseif($visible == "users"){
                                                $branch = $query->getData("`branch_name`,`branch_user_name`",$visible,"",array("id"=>$apps['type_id']),"id","DESC","1")[0];
                                                echo $branch['branch_name']."<br/><b>Username : </b>".$branch['branch_user_name'];
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $apps['lr']; ?></td>
                                    <td class="text-center"><?= $apps['appointment_date']; ?></td>
                                    <td class="text-center"><?= $apps['start_time']." - ".$apps['end_time']; ?></td>
                                    <td class="text-center"><?= $apps['po']; ?></td>
                                    <td class="text-center"><?= $apps['appointment_id']; ?></td>
                                    <td class="text-center">
                                        <select class="form-control form-control-sm form-control-border appointStatus" data-initial-value="<?= $apps['status'].",".$apps['lr']; ?>" id="appointStatus-<?= $apps['lr']; ?>">
                                            <option value="requested,<?= $apps['id']; ?>" <?php if($apps['status'] == "requested"){ echo "selected"; } ?>>Requested</option>
                                            <option value="processing,<?= $apps['id']; ?>" <?php if($apps['status'] == "processing"){ echo "selected"; } ?>>Processing</option>
                                            <option value="completed,<?= $apps['id']; ?>" <?php if($apps['status'] == "completed"){ echo "selected"; } ?>>Completed</option>
                                        </select>
                                    </td>
                                    <td class="text-center"><?php if(empty($apps['remarks'])){  echo "No remarks";}else{ echo $apps['remarks']; } ?></td>
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
                        $pageCount = ceil($appointmentsCount/dataShow);
                        if($appointmentsCount != 0){
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