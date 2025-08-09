<?php
    include("assets/header.php");
    include("assets/sidebar.php");
    if($_GET['visible'] != "users" && $_GET['visible'] != "branches"){
        echo '<script>window.location = "ledger?visible=users";</script>';
    }else{
        extract($_GET);
    }
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
	    <form action="ledger" method="GET" class="row d-flex justify-content-end mb-3">
	        <input type="hidden" name="visible" value="<?= $visible; ?>">
	        <div class="col-xl-6 col-sm-6 form-group">
	            <label>Choose <?= $visible; ?> One</label>
	            <select class="form-control form-control-sm" id="single-select" name="UsersorBranches">
	                <option value="" hidden>Choose one</option>
	                <?php
	                    if(!empty($visible)){
    	                    $getuser = $query->getData('*',$visible,'',array('delete_status'=>'show'),'id','DESC','');
    	                    if($getuser != 0){
    	                        foreach($getuser as $user){
    	                            if($visible == "users"){
    	                                $uName = $user['username'];
    	                                $pName = $user['party_name'];
    	                            }elseif($visible == "branches"){
    	                                $uName = $user['branch_user_name'];
    	                                $pName = $user['branch_name'];
    	                            }
	               ?>
	                    <option value="<?= $uName; ?>" <?php if(!empty($UsersorBranches) && $UsersorBranches == $uName){ echo 'selected'; } ?>><?= "Name: ".$pName.", Username: ".$uName." ( mobile no.: ".$user['mobile_no']." )"; ?></option>
	               <?php
    	                        }
    	                    }
	                    }
	                ?>
	            </select>
			</div>
	        <div class="col-xl-2 col-sm-6 form-group d-flex align-items-end mb-1">
	            <button class="btn btn-xs me-1 shadow btn-block" type="submit" style="background-color: #28a745; color: #fff;">Search</button>
			</div>
	    </form>
		<div class="row">
		    <div class="card">
		        <form action="act" method="POST" class="card-header d-flex" style="justify-content: space-between;">
		            <h3 class="card-title">All Transactions <?php if(!empty($_GET['visible']) && !empty($_GET['thatType'])){ echo 'of '.ucwords(rtrim(rtrim($visible,"s"), "es")).': '.$name."  & Id: ".$thatType; } ?></h3>
                    <input type="text" hidden class="form-control" name="visible" value="<?= $visible; ?>">
                    <input type="text" hidden class="form-control" name="usersorBranches" value="<?php if(!empty($UsersorBranches)){ echo $UsersorBranches; } ?>">
	                <button class="btn-sm btn btn-info" name="exportLedger" type="submit">Export <i class="bi bi-cloud-download-fill"></i></button>
		        </form>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example5" class="display table" style="min-width: 845px">
                    		<thead>
                    			<tr>
                    				<th class="text-center" hidden>Sl No.</th>
                    			    <?php if(empty($thatType)){ ?>
                        				<th class="text-center">User Type</th>
                        				<th class="text-center">User Details</th>
                        			<?php } ?>
                    				<th class="text-center">Date & Time</th>
                    				<th class="text-center">Transaction Id</th>
                    				<th class="text-center">Remarks</th>
                    				<th class="text-center">Transaction Type</th>
                    				<th class="text-center">Credit Amount</th>
                    				<th class="text-center">Debit Amount</th>
                    				<th class="text-center">Balance</th>
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
                		            if($visible == "users" || $visible == "branches"){
                                        $showusercond["user_type"] = $visible;
                                    }
                                    if(!empty($UsersorBranches)){
                                          if($visible == "users"){
                                              $visibleusername = "username";
                                          }elseif($visible == "branches"){
                                              $visibleusername = "branch_user_name";
                                          }
                                          $showusercond['user_id'] = $query->getData('`id`',$visible,'',array($visibleusername=>$UsersorBranches),'id','DESC','1')[0]['id'];
                                    }
                                    $gettxns = $query->getData("*","transactions","",$showusercond,"id","DESC",$limit);
                                    $txnCount = $query->getData("COUNT(`id`) as 'ordersCount'","transactions","",$showusercond,"","","")[0]['ordersCount'];
                                    if($gettxns != 0){
                                        foreach($gettxns as $var){
                                            $getuser = $query->getData("*",$var['user_type'],"",array("id"=>$var['user_id']),"","","")[0];
                    		    ?>
                        			<tr>
                        				<td class="text-center" hidden><?= $sl; ?></td>
                        			    <?php if(empty($thatType)){ ?>
                            				<td class="text-center"><?= ucwords(rtrim(rtrim($var['user_type'], "s"), "es")); ?></td>
                            				<td class="text-center"><?php if($var['user_type'] == "branches"){ echo $getuser['branch_name']."<br/><b>Username:</b> ".$getuser['branch_user_name']; }else{ echo $getuser['party_name']."<br/><b>Username:</b> ".$getuser['username']; }echo "<br/><b>Mobile:</b> ".$getuser['mobile_no']."<br/><b>Email Id:</b> ".$getuser['email']; ?></td>
                            			<?php } ?>
                        				<td class="text-center"><?= $var['date_time']; ?></td>
                        				<td class="text-center"><?= $var['txn_id']; ?></td>
                        				<td class="text-center"><?= $var['details']; ?></td>
                        				<td class="text-center"><?= $var['status']; ?></td>
                        				<td class="text-center">₹<?php if($var['status'] == "Credit"){ echo $var['amount']; }else{ echo 0; } ?></td>
                        				<td class="text-center">₹<?php if($var['status'] == "Debit"){ echo $var['amount']; }else{ echo 0; } ?></td>
                        				<td class="text-center">₹<?= $var['balance']; ?></td>
                        				<!--<td class="text-center"><span class="badge badge-sm badge-<?php //if($var['status'] == "Credit"){ echo 'success'; }else{ echo 'danger'; } ?>"><?= $var['status'];?></span></td>-->
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
                        $pageCount = ceil($txnCount/dataShow);
                        if($txnCount != 0){
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