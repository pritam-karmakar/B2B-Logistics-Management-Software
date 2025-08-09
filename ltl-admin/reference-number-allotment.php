<?php
if(!array_key_exists('visible', $_GET)){
    echo '<script type="text/javascript" language="javascript">window.location="reference-number-allotment?visible=users";</script>';
}elseif(empty($_GET['visible'])){
    echo '<script>window.location = "reference-number-allotment?visible=users";</script>';
}elseif($_GET['visible'] != "users" && $_GET['visible'] != "branches"){
    echo '<script>window.location = "reference-number-allotment?visible=users";</script>';
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
		    <?php if(empty($username)){ ?>
    		    <div class="card">
    		        <div class="card-header">
    		            <h3 class="card-title">All <?= trim(ucwords($visible), 's').'<span style="text-transform: lowercase;">\'s</span>'; ?> to Allotments</h3>
    		        </div>
    		        <div class="card-body">
    		             <div class="table-responsive">
                        	<table id="example3" class="display" style="width:100%">
                        		<thead>
                        			<tr>
                        				<th class="text-center"><?= ucwords($visible); ?> Details</th>
                        				<th class="text-center">Contact Details</th>
                        				<th class="text-center">Contact Person</th>
                        				<th class="text-center">Address</th>
                        				<th class="text-center">Action</th>
                        			</tr>
                        		</thead>
                        		<tbody>
                        		    <?php
                        		        $users = $query->getData('*',$visible,'',array('delete_status'=>'show'),'id','DESC','');
                        		        if($users != 0){
                            		        foreach($users as $getusers){
                            		            if($visible == "users"){
                	                                $uName = $getusers['username'];
                	                                $pName = $getusers['party_name'];
                	                            }elseif($visible == "branches"){
                	                                $uName = $getusers['branch_user_name'];
                	                                $pName = $getusers['branch_name'];
                	                            }
                        		    ?>
                        			<tr>
                        				<td class="text-center"><?= "<b>Name: </b>".$pName."<br/><b>Username: </b>".$uName; ?></td>
                        				<td class="text-center"><?= "<b>Mobile no.: </b>".$getusers['mobile_no']."<br/><b>Email Id: </b>".$getusers['email']; ?></td>
                        				<td class="text-center"><?= $getusers['contact_person_name']; ?></td>
                        				<td class="text-center"><?= $getusers['address']; ?></td>
                        				<td class="text-center">
                        				    <button type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-allotment-<?= $uName; ?>" class="btn btn-warning shadow sharp btn-xs me-1" title="Add allotment number"><i class="bi bi-reply-fill"></i></button>
                        				    <a href="reference-number-allotment?visible=<?= $visible; ?>&username=<?= $uName; ?>" type="button" class="btn btn-info shadow sharp btn-xs me-1" title="Alloted numbers"><i class="bi bi-person-rolodex"></i></a>
                        				</td>
                        			</tr>
                        			
                        			<div class="modal fade bd-example-modal-allotment-<?= $uName; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add allotment number to <?= $getusers['party_name']." (".$getusers['username'].")"; ?></h5>
                                                    <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                                                </div>
                                                <form action="act" method="POST">
                                                    <input type="hidden" name="userType" value="<?= $visible; ?>">
                                                    <input type="hidden" name="userIs" value="<?= $uName; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 form-group">
                                                                <label>Start allotment no.</label>
                                                                <input type="text" class="form-control form-control-sm txtNumeric" name="startAllotmentNo" placeholder="Enter Start Allotment">
                                                            </div>
                                                            <div class="col-md-6 form-group mb-3">
                                                                <label>End allotment no.</label>
                                                                <input type="text" class="form-control form-control-sm txtNumeric" name="endAllotmentNo" placeholder="Enter End Allotment">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light btn-sm" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="addAllotment" class="btn btn-sm" style="background-color: #28a745; color: #fff;">Add allotment</button>
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
                        </div>
    		        </div>
    		    </div>
    		<?php } ?>
    		    <div class="card">
    		        <div class="card-header">
    		            <h3 class="card-title">All Allotments <?php if(!empty($username)){ ?><span style="text-transform: lowercase;"> of <?= $visible."</span> (".$username.")"; ?><?php } ?></h3>
    		        </div>
    		        <div class="card-body">
    		            <div class="table-responsive">
                        	<table id="example3" class="display" style="width:100%">
                        		<thead>
                        			<tr>
                        				<th class="text-center">User Type</th>
                        				<th class="text-center">User Details</th>
                        				<th class="text-center">Start Allotment No.</th>
                        				<th class="text-center">End Allotment No.</th>
                        			</tr>
                        		</thead>
                        		<tbody>
                        		    <?php
                        		        $arr;
                            		    if(!empty($username)){
                            		        if($visible == "users"){
                                                $user_name_type = 'username';
                                            }elseif($visible == "branches"){
                                                $user_name_type = 'branch_user_name';
                                            }
                            		        $type_id = $query->getData('*',$visible,'',array($user_name_type=>$username),'id','DESC','1')[0]['id'];
                            		        $arr = array('user_type'=>$visible,'type_id'=>$type_id);
                            		    }
                        		        $allots = $query->getData('*','reference_number_allotment','',$arr,'id','DESC','');
                        		        if($allots != 0){
                            		        foreach($allots as $getallots){
                            		            $getusers = $query->getData('*',$getallots['user_type'],'',array('id'=>$getallots['type_id']),'id','DESC','1')[0];
                            		            if($getallots['user_type'] == "users"){
                	                                $uName = $getusers['username'];
                	                                $pName = $getusers['party_name'];
                	                            }elseif($getallots['user_type'] == "branches"){
                	                                $uName = $getusers['branch_user_name'];
                	                                $pName = $getusers['branch_name'];
                	                            }
                        		    ?>
                        			<tr>
                        			    <td class="text-center"><?= ucwords(trim(trim($getallots['user_type'], 's'), 'es')); ?></td>
                        				<td class="text-center"><?= "<b>Name: </b>".$pName."<br/><b>Username: </b>".$uName; ?></td>
                        				<td class="text-center"><?= $getallots['start_allotment_no']; ?></td>
                        				<td class="text-center"><?= $getallots['end_allotment_no']; ?></td>
                        			</tr>
                    				<?php
                            		        }
                        		        }
                    				?>
                        		</tbody>
                        	</table>
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