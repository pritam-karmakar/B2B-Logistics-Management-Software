<?php
if(!empty($_GET) && array_key_exists('page', $_GET)){
    $page = $_GET['page'];
}
include("assets/header.php");
include("assets/sidebar.php");
?>
<style>
    .dataTables_filter{
        display: none;
    }
</style>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">PIN Codes</h3>
		        </div>
		        <form action="actions.php" method="POST" enctype="multipart/form-data">
		            <div class="card-body">
		                <div class="row">
    		                <div class="col-md-3">
    		                    <label>Select State <span class="text-danger">*</span></label>
    		                    <div class="input-group">
                                    <select  name="state" class="form-control form-control-sm" required>
                                        <option value="" hidden>Choose State</option>
                                        <?php
                                            $getstates = $query->getData("*","states","","","","","");
                                            foreach($getstates as $state){
                                        ?>
                                            <option value="<?= $state['id']; ?>"><?= $state['state']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
    	                        </div>
    	                    </div>
    		                <div class="col-md-3">
    		                    <label>Enter City </label>
    		                    <div class="input-group">
                                    <!--<select id="city" name="city" class="form-control form-control-sm" >-->
                                    <!--    <option value="" hidden>Choose City</option>-->
                                    <!--</select>-->
                                    <input type="text" class="form-control form-control-sm"  name="city" placeholder="Enter City Name">
    	                        </div>
    	                    </div>
    		                <div class="col-md-3">
                                <label>PIN Code File <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" class="form-control form-control-sm" name="pincode" required>
								    <button class="btn btn-primary btn-sm" type="submit" name="submitPinCode">Submit</button>
                                </div>
		                    </div>
		                </div>
		            </div>
                </form>
		        <hr/>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example2" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>PIN Code</th>
                    				<th>City</th>
                    				<th>State</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $dataShow = 10;
                    		        if(empty($page)){
                        		        $page = 1;
                    		        }else{
                    		            $page = $page;
                    		        }
                    		        $offset = ($page - 1) * $dataShow;
                    		        $limit = $offset.','.$dataShow;
                    		        $joinCityState = array("0"=>array("LEFT","states","states","id","pincodes","state_id"),"1"=>array("LEFT","cities","cities","id","pincodes","city_id"));
                    		        $condArr = array('pincodes`.`delete_status'=>'show');
                                    $getpincodes = $query->getData("`pincodes`.*,`states`.`state`,`cities`.`city`","pincodes",$joinCityState,$condArr,"","",$limit);
                                    $countPincodes = $query->getData("COUNT(`id`) as 'totalPincodes'","pincodes",'',$condArr,"","","")[0]['totalPincodes'];
                                    if($getpincodes != 0){
                                        foreach($getpincodes as $var){
                    		    ?>
                        			<tr>
                        				<td><?= $var['pincode']; ?></td>
                        				<td><?= $var['city']; ?></td>
                        				<td><?= $var['state']; ?></td>
                        				<td>
                        				    <div class="d-flex">
    											<a href="#" class="btn btn-warning shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#modalofPinCode<?= $var['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
    											<form action="actions" method="POST">
    											    <input type="hidden" value="<?= $var['id']; ?>" name="pincodeId">
    											    <button type="submit" class="btn btn-danger shadow btn-xs sharp" name="deletePinCode" onclick="return confirm('Are you sure to want to delete this pincode?')">
    											        <i class="fa fa-trash"></i>
    											    </button>
    											</form>
    										</div>
                        				</td>
                        			</tr>
                        			
                        			<!-- Modal -->
                                    <div class="modal fade" id="modalofPinCode<?= $var['id']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="actions.php" method="POST">
                                                    <input type="hidden" name="pincodeId" value="<?= $var['id']; ?>" readonly>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Change State & City</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Update State</label>
                                                            <select name="state"  class="form-control form-control-sm modState">
                                                                <option value="" hidden>Choose State</option>
                                                                <?php
                                                                    $getstate = $query->getData("*","states","","","","","");
                                                                    foreach($getstate as $state){
                                                                ?>
                                                                    <option value="<?= $state['id']; ?>" <?php if($state['id'] == $var['state_id']){echo "selected";} ?>><?= $state['state']; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label>Update City</label>
                                                            <select name="city" class="form-control form-control-sm modCity" id="modCityId<?//= $var['id']; ?>">">
                                                                <option value="" hidden>Choose City</option>
                                                                <?php
                                                                    $getcity = $query->getData("*","cities","",array('state_id'=>$var['state_id']),"","","");
                                                                    foreach($getcity as $city){
                                                                ?>
                                                                    <option value="<?= $city['id']; ?>" <?php if($city['id'] == $var['city_id']){echo "selected";} ?>><?= $city['city']; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="changeCity" class="btn btn-warning btn-sm">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                    			<?php
                                        }
                                    }
                    			?>
                    		</tbody>
                    	</table>
                        <?php
                            $pageCount = ceil($countPincodes/$dataShow);
                            if($countPincodes != 0){
                        ?>
                            <ul class='newpagination d-flex justify-content-end'>
                                <li><a href='<?php if($page != 1){ echo CurrentPageURL."?page=1"; }else{ echo 'javascript:void(0)'; } ?>'><i class='fa-solid fas fa-angle-double-left'></i></a></li>
                                <li><a href='<?php if($page != 1){ echo CurrentPageURL."?page=".($page-1); }else{ echo 'javascript:void(0)'; } ?>'>Prev</a></li>
                        <?php
                            for($i = 1; $i <= $pageCount; $i++):
                                if($page <= 5 && $pageCount > 7){
                                    for($i = 1; $i <= 5; $i++):
                        ?>
                                        <li><a href="<?= CurrentPageURL."?page=".$i; ?>" class="<?php if($page == $i){ echo 'active'; } ?>"><?= $i; ?></a></li>
                        <?php
                                    endfor;
                        ?>
                                        <span class="ellipsis dot">…</span>
                                        <li><a href="<?= CurrentPageURL."?page=".$pageCount; ?>"><?= $pageCount; ?></a></li>
                        <?php
                                    break;
                                }elseif($page > 5 && $page <= $pageCount-5 && $pageCount > 7){
                        ?>
                                    <li><a href="<?= CurrentPageURL; ?>?page=1">1</a></li>
                                    <span class="ellipsis dot">…</span>
                        <?php
                                    for($j = $page-2; $j <= $page+2; $j++):
                        ?>
                                    <li><a href="<?= CurrentPageURL."?page=".$j; ?>" class="<?php if($page == $j){ echo 'active'; } ?>"><?= $j; ?></a></li>
                        <?php
                                    endfor;
                        ?>
                                    <span class="ellipsis dot">…</span>
                                    <li><a href="<?= CurrentPageURL."?page=".$pageCount; ?>"><?= $pageCount; ?></a></li>
                        <?php
                                    break;
                                }elseif($page > $pageCount-5 && $pageCount > 7){
                        ?>
                                    <li><a href="<?= CurrentPageURL; ?>?page=1">1</a></li>
                                    <span class="ellipsis dot">…</span>
                        <?php
                                    for($k = $pageCount-4; $k <= $pageCount; $k++):
                        ?>
                                        <li><a href="<?= CurrentPageURL."?page=".$k; ?>" class="<?php if($page == $k){ echo 'active'; } ?>"><?= $k; ?></a></li>
                        <?php
                                    endfor;
                                    break;
                                }else{
                                for($l = 1; $l <= $pageCount; $l++):
                        ?>
                                        <li><a href="<?= CurrentPageURL."?page=".$l; ?>" class="<?php if($page == $l){ echo 'active'; } ?>"><?= $l; ?></a></li>
                        <?php
                                endfor;
                                break;
                            }
                            endfor;
                        ?>
                                <li><a href='<?php if($page != $pageCount){ echo CurrentPageURL."?page=".($page + 1); }else{ echo 'javascript:void(0)'; } ?>'>Next</a></li>
                                <li><a href='<?php if($page != $pageCount){ echo CurrentPageURL."?page=".$pageCount; }else{ echo 'javascript:void(0)'; } ?>'><i class='fa-solid fas fa-angle-double-right'></i></a></li>
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

<!--**********************************
    Content body end
***********************************-->
<?php
    include("assets/footer.php");
?>