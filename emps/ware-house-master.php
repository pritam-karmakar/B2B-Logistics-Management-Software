<?php
extract($_GET);
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <form action="ware-house-master" method="GET" class="row mb-3">
                <div class="col-xl-2 col-sm-6 form-group">
                    <label>Choose user type</label>
                    <select class="form-control form-control-sm" name="visible" id="visibleType">
                        <option value="" hidden>Choose user type</option>
                        <option value="users" <?php if($visible == "users"){ echo 'selected'; } ?>>User</option>
                        <option value="branches" <?php if($visible == "branches"){ echo 'selected'; } ?>>Branch</option>
                    </select>
        		</div>
                <div class="col-xl-3 col-sm-6 form-group">
                    <label>Choose One</label>
                    <select class="form-control form-control-sm" id="single-select" name="orderUsersorBranches">
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
                            <option value="<?= $uName; ?>" <?php if(!empty($orderUsersorBranches) && $orderUsersorBranches == $uName){ echo 'selected'; } ?>><?= "Name: ".$uName.", Username: ".$uName." ( mobile no.: ".$user['mobile_no']." )"; ?></option>
                       <?php
        	                        }
        	                    }
                            }
                        ?>
                    </select>
        		</div>
                <div class="col-xl-2 col-sm-6 form-group">
                    <label>One Date / Start Date</label>
                    <input type="date" class="form-control form-control-sm" name="startDate" value="<?= $startDate; ?>">
        		</div>
                <div class="col-xl-2 col-sm-6 form-group">
                    <label>End Date</label>
                    <input type="date" class="form-control form-control-sm" name="endDate" value="<?= $endDate; ?>">
        		</div>
                <div class="col-xl-2 col-sm-6 form-group">
                    <label>Ware House Name</label>
                    <input type="text" class="form-control form-control-sm" name="wareHouseName" placeholder="Enter Warehouse name" value="<?= $wareHouseName; ?>">
        		</div>
                <div class="col-xl-1 col-sm-6 form-group d-flex align-items-end mb-1">
                    <button class="btn btn-xs me-1 shadow btn-block" type="submit" style="background-color: #28a745; color: #fff;">Search</button>
        		</div>
            </form>
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">All Ware Houses</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example5" class="display table" style="min-width: 845px">
                    		<thead>
                    			<tr>
                    				<th class="text-center" hidden>Sl No.</th>
                    				<th class="text-center">User Type & Details</th>
                    				<th class="text-center">Ware House Name</th>
                    				<th class="text-center">Pincode</th>
                    				<th class="text-center">Phone No.</th>
                    				<th class="text-center">Email Id</th>
                    				<th class="text-center">Full Address</th>
                    				<th class="text-center">Action</th>
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
                		              if($visible == "users" || $visible == "branches"){
                                          $showusercond["user_type"] = $visible;
                                      }
                                      if(!empty($orderUsersorBranches)){
                                          if($visible == "users"){
                                              $visibleusername = "username";
                                          }elseif($visible == "branches"){
                                              $visibleusername = "branch_user_name";
                                          }
                                          $showusercond['type_id'] = $query->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id'];
                                      }
                                      if(!empty($startDate) && empty($endDate)){
                                          $showusercond['order_date'] = $startDate;
                                      }
                                      if(!empty($wareHouseName)){
                                          unset($showusercond);
                                          if($visible == "users" || $visible == "branches"){
                                              $showusercond[] = array("user_type","=",$visible);
                                          }
                                          if(!empty($orderUsersorBranches)){
                                              if($visible == "users"){
                                                  $visibleusername = "username";
                                              }elseif($visible == "branches"){
                                                  $visibleusername = "branch_user_name";
                                              }
                                              $showusercond[] = array("type_id","=",$query->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id']);
                                          }
                                          $showusercond[] = array("warehouse_name","LIKE","%".$wareHouseName."%");
                                      }
                                      if(!empty($startDate) && !empty($endDate)){
                                          unset($showusercond);
                                          if($visible == "users" || $visible == "branches"){
                                              $showusercond[] = array("user_type","=",$visible);
                                          }
                                          if(!empty($orderUsersorBranches)){
                                              if($visible == "users"){
                                                  $visibleusername = "username";
                                              }elseif($visible == "branches"){
                                                  $visibleusername = "branch_user_name";
                                              }
                                              $showusercond[] = array("type_id","=",$query->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id']);
                                          }
                                          if(!empty($wareHouseName)){
                                              $showusercond[] = array("warehouse_name","LIKE","%".$wareHouseName."%");
                                          }
                                          $showusercond[] = array('order_date','BETWEEN',$startDate,"AND",$endDate);
                                      }
                    		        $ware = $query->getData('*','warehouses','',$showusercond,'id','DESC',$limit);
                    		        $WareHouseCount = $query->getData('COUNT(`id`) as "WareHouseCount"','warehouses','','','id','DESC','')[0]['WareHouseCount'];
                    		        if($ware != 0){
                        		        foreach($ware as $houses){
                        		            $thatuser = $query->getData('*',$houses['type'],'',array('id'=>$houses['type_id']),'id','DESC','1')[0];
                    		    ?>
                    			<tr>
                    				<td class="text-center" hidden><?= $sl; ?></td>
                    				<td class="text-center"><?php if($houses['type'] == "users"){ echo "<b>Name : </b>".$thatuser['party_name']."<br/><b>User name :</b> ".$thatuser['username']; }elseif($houses['type'] == "branches"){ echo "<b>Name : </b>".$thatuser['branch_name']."<br/><b>User name :</b> ".$thatuser['branch_user_name']; } ?></td>
                    				<td class="text-center"><?= $houses['warehouse_name']; ?></td>
                    				<td class="text-center"><?= $houses['pincode']; ?></td>
                    				<td class="text-center"><?= $houses['phone_number']; ?></td>
                    				<td class="text-center"><?= $houses['email']; ?></td>
                    				<td class="text-center"><?= $houses['address']; ?></td>
                    				<td class="text-center">
                    				    <div class="d-flex">
											<a href="edit-warehouse?warehouse_id=<?= $houses['id']; ?>" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
										</div>
                    				</td>
                    				<td class="text-center">
                		                <div class="form-group" style="display: flex;">
                                            <input type="checkbox" id="branchwise<?= $houses['id']; ?>" value="<?= $houses['id']; ?>" class="checkboxunblock wareHouseStatus" <?php if($houses['status'] == 'Unblock'){ echo 'checked'; } ?>>&nbsp;&nbsp;&nbsp;
                                            <label for="branchwise<?= $houses['id']; ?>" style="cursor: pointer;"></label>
                                        </div>
                    				</td>
                				<?php
                				        $sl++;
                        		        }
                    		        }
                				?>
                    			</tr>
                    		</tbody>
                    	</table>
                    </div>
                    <?php
                        $pageCount = ceil($WareHouseCount/dataShow);
                        if($WareHouseCount != 0){
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