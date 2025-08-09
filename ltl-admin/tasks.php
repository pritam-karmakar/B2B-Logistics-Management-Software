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
		            <h3 class="card-title">Task</h3>
		        </div>
		        <form action="actions.php" method="POST" enctype="multipart/form-data">
		            <div class="card-body">
		                <div class="row">
    		                <div class="col-md-3">
    		                    <label>Select User Type</label>
    		                    <div class="input-group">
                                    <select id="table" name="table" class="form-control form-control-sm" required>
                                        <option value="" hidden>Choose User Type</option>
                                        <option value="users">Users</option>
                                        <option value="branches">Branches</option>
                                    </select>
    	                        </div>
    	                    </div>
    		                <div class="col-md-3">
    		                    <label>Select Assignee</label>
    		                    <div class="input-group">
                                    <select id="tableReponse" name="tableReponse" class="form-control form-control-sm" required>
                                        <option value="" hidden>Choose Whom to Assign</option>
                                    </select>
    	                        </div>
    	                    </div>
		                </div>
		                <div class="row mt-3">
    		                <div class="col-md-6">
                                <label>Task</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="task" required>
								    <button class="btn btn-primary btn-sm" type="submit" name="submitTask">Submit</button>
                                </div>
		                    </div>
		                </div>
		            </div>
                </form>
		        <hr/>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example5" class="display table" style="min-width: 845px">
                    		<thead>
                    			<tr>
                    				<th>SL No.</th>
                    				<th>Task ID</th>
                    				<th>Task</th>
                    				<th>Assigned to</th>
                    				<th>Assignee Type</th>
                    				<th>Status</th>
                    				<th>Last Updated at</th>
                    				<th>Created at</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                                    const dataShow = 25;
                		            if(empty($page)){
                    		            $page = 1;
                		            }else{
                		                $page = $page;
                		            } 
                		            $offset = ($page - 1) * dataShow;
                		            $limit = $offset.','.dataShow;
                    		        $sl = 1+$offset;
                                    $gettasks = $query->getData("*","tasks","","","id","DESC",$limit);
                                    $tasksCount = $query->getData("COUNT(`id`) as 'TotalTasks'","tasks","","","id","DESC","")[0]['TotalTasks'];
                                    foreach($gettasks as $var){
                    		    ?>
                        			<tr>
                        				<td><?= $sl; ?></td>
                        				<td><?= $var['task_id']; ?></td>
                        				<td><?= $var['task']; ?></td>
                        				<td>
                        				    <?php
                        				        if($var['assignee_type']=="branches"){
                        				            $cond1 = array('id'=>$var['assigned_id']);
                        				            $getassignee1 = $query->getData("*","branches","",$cond1,"","","");
                        				            echo "{$getassignee1[0]['branch_name']} - ({$getassignee1[0]['branch_user_name']})";
                        				            
                        				        }
                        				        elseif($var['assignee_type']=="users"){
                        				            $cond2 = array('id'=>$var['assigned_id']);
                        				            $getassignee2 = $query->getData("*","users","",$cond2,"","","");
                        				            echo "{$getassignee2[0]['party_name']} - ({$getassignee2[0]['username']})";
                        				        }
                        				    ?>
                        				</td>
                        				<td>
                        				    <?php
                        				        if($var['assignee_type']=="branches"){
                        				            echo "Branch";
                        				        }
                        				        elseif($var['assignee_type']=="users"){
                        				            echo "User";
                        				        }
                        				    ?>
                        				</td>
                        				<td><?= $var['status']; ?></td>
                        				<td><?= date("d-M-y h:i A", strtotime($var['updated_at'])); ?></td>
                        				<td><?= date("d-M-y h:i A", strtotime($var['created_at'])); ?></td>
                        				<td>
                        				    <div class="d-flex">
    											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofTask<?= $var['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
    											<!--<form action="actions" method="POST">-->
    											<!--    <input type="hidden" value="" name="taskId">-->
    											<!--    <button type="submit" class="btn btn-danger shadow btn-xs sharp" name="deleteTask" onclick="return confirm('Are you sure to want to delete this task?')">-->
    											<!--        <i class="fa fa-trash"></i>-->
    											<!--    </button>-->
    											<!--</form>-->
    										</div>
                        				</td>
                        			</tr>
                        			
                        			<!-- Modal -->
                                    <div class="modal fade" id="modalofTask<?= $var['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions.php" method="POST">
                                                    <input type="hidden" name="taskId" value="<?= $var['id']; ?>" readonly>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Task</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Change Status</label>
                                                            <select name="status" id="<?= $var['id']; ?>" class="form-control form-control-sm">
                                                                <option value="" hidden>Choose Status</option>
                                                                <option value="Created" <?php if($var['status']=="Created"){echo "selected";} ?>>Created</option>
                                                                <option value="Working" <?php if($var['status']=="Working"){echo "selected";} ?>>Working</option>
                                                                <option value="Completed" <?php if($var['status']=="Completed"){echo "selected";} ?>>Completed</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label>Change Task Info</label>
                                                            <input type="text" class="form-control form-control-sm" name="modifiedTask" value="<?= $var['task']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="changeTask" class="btn btn-warning btn-sm">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                    			<?php
                    			    $sl++;
                                    }
                    			?>
                    		</tbody>
                    	</table>
                    </div>
                    <?php
                        $pageCount = ceil($tasksCount/dataShow);
                        if($tasksCount != 0){
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