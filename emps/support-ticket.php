<?php
if(!array_key_exists('tickets', $_GET)){
    echo '<script type="text/javascript" language="javascript">window.location="support-ticket?tickets=Open";</script>';
}elseif(empty($_GET['tickets'])){
    echo '<script type="text/javascript" language="javascript">window.location="support-ticket?tickets=Open";</script>';
}elseif($_GET['tickets'] != "Open" && $_GET['tickets'] != "Resolved" && $_GET['tickets'] != "Closed"){
    echo '<script type="text/javascript" language="javascript">window.location="support-ticket?tickets=Open";</script>';
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
		            <h3 class="card-title"><?= $tickets; ?> Tickets</h3>
		        </div>
		        <div class="card-body">
		            <ul class="nav nav-pills justify-content-start mb-4">
                    	<li class="nav-item">
                    		<a style="cursor: pointer;" href="support-ticket?tickets=Open" class="nav-link <?php if($tickets == "Open"){ echo 'active'; } ?>"><i class="bi bi-envelope-open-fill"></i>&nbsp; Open</a>
                    	</li>
                    	<li class="nav-item">
                    		<a style="cursor: pointer;" href="support-ticket?tickets=Resolved" class="nav-link <?php if($tickets == "Resolved"){ echo 'active'; } ?>"><i class="bi bi-patch-check-fill"></i>&nbsp; Resolved</a>
                    	</li>
                    	<li class="nav-item">
                    		<a style="cursor: pointer;" href="support-ticket?tickets=Closed" class="nav-link <?php if($tickets == "Closed"){ echo 'active'; } ?>"><i class="bi bi-slash-circle-fill"></i>&nbsp; Closed</a>
                    	</li>
                    </ul>
		            <div class="table-responsive">
                        <table id="example5" class="display table" style="min-width: 845px">
                        	<thead>
                        		<tr>
                        			<th class="text-center" hidden>Sl No.</th>
                        			<th class="text-center">Ticket & LR</th>
                        			<th class="text-center">User Details</th>
                        			<th class="text-center">Email</th>
                        			<th class="text-center">Category</th>
                        			<th class="text-center">Sub-Category</th>
                        			<th class="text-center">Ticket Created On</th>
                        			<th class="text-center">Last Update</th>
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
                                    $join = array('0'=>array('LEFT','ticket_category','tickets','ticket_category','ticket_category','id'),
                                                 '1'=>array('LEFT','ticket_subcategory','tickets','ticket_sub_category','ticket_subcategory','id'));
                                    $get_ticket_details = $query->getData("`tickets`.*,`ticket_category`.*,`ticket_subcategory`.*,`tickets`.`id` as 'ticketMainId'","tickets",$join,array("status"=>$tickets),"tickets`.`id","DESC",$limit);
                                    $ticketsCount = $query->getData("COUNT(`id`) as 'ticketsCount'","tickets","",array("status"=>$tickets),"tickets`.`id","DESC","")[0]['ticketsCount'];
                                    if($get_ticket_details !== 0){
                                        foreach($get_ticket_details as $ticket_details){
                                            $fetchAssoc = $query->getData("*",$ticket_details['type'],"",array("id"=>$ticket_details['type_id']),"id","DESC","")[0];
                                ?>              <tr>
                                                    <td class="text-center" hidden><?= $sl; ?></td>
                                                    <td class="text-center"><?= $ticket_details['ticket_code']; ?></td>
                                                    <td class="text-center">
                                                      <?php
                                                        if($ticket_details['type'] == "users"){
                                                            echo $fetchAssoc['party_name']."<br/><b>User Type:</b> ".ucwords(trim($ticket_details['type'],"s"))."<br/><b>Username: </b>".$fetchAssoc['username']."<br/><b>mob: </b>".$fetchAssoc['mobile_no'];
                                                        }elseif($ticket_details['type'] == "branches"){
                                                            echo $fetchAssoc['branch_name']."<br/><b>User Type:</b> ".ucwords(trim($ticket_details['type'],"es"))."<br/><b>Username: </b>".$fetchAssoc['branch_user_name']."<br/><b>mob: </b>".$fetchAssoc['mobile_no'];
                                                        }
                                                      ?>
                                                    </td>
                                                    <td class="text-center"><?= $ticket_details['email']; ?></td>
                                                    <td class="text-center"><?= $ticket_details['category']; ?></td>
                                                    <td class="text-center"><?= $ticket_details['subCategory']; ?></td>
                                                    <td class="text-center"><?= $ticket_details['created_on']; ?></td>
                                                    <td class="text-center"><?= $ticket_details['last_update']; ?></td>
                                                    <td class="text-center"><a href="" data-bs-target=".bd-example-modal-lg-<?= $ticket_details['ticketMainId']; ?>" data-bs-toggle="modal" class="btn btn-primary btn-xs shadow sharp me-1"><i class="fa fa-eye"></i></a></td>
                                                </tr>
                                                
                                                <div class="modal fade bd-example-modal-lg-<?= $ticket_details['ticketMainId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit ticket</h5>
                                                                <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                                                            </div>
                                                            <form action="actions" method="POST">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="ticketCode" value="<?= $ticket_details['ticket_code'] ?>">
                                                                    <div class="row">
                                                                        <b><?= ucwords(trim(trim($ticket_details['type'],"s"),"es")); ?>'s Remarks:</b>
                                                                        <p><?= $ticket_details['remarks']; ?></p>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group mb-2">
                                                                            <label>Status</label>
                                                                            <select class="form-control form-control-sm" name="ticketStatus">
                                                                                <option value="Open" <?php if($ticket_details['status'] == "Open"){ echo 'selected'; } ?>>Open</option>
                                                                                <option value="Resolved" <?php if($ticket_details['status'] == "Resolved"){ echo 'selected'; } ?>>Resolved</option>
                                                                                <option value="Closed" <?php if($ticket_details['status'] == "Closed"){ echo 'selected'; } ?>>Closed</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group mb-2">
                                                                            <label>Remarks</label>
                                                                            <textarea class="form-control" name="adminRemarks" placeholder="Enter Remarks"><?= $ticket_details['admin_remarks']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" name="editTicket" class="btn btn-warning btn-sm">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                <?php
                                        $sl++;
                                        }
                                    }
                                ?>
                        	</tbody>
                        </table>
                    </div>
                    <?php
                        $pageCount = ceil($ticketsCount/dataShow);
                        if($ticketsCount != 0){
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