<?php
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
		            <h3 class="card-title">Cashbook</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th class="text-center">SL No</th>
                    				<th class="text-center">Branch Details</th>
                    				<th class="text-center">Request No</th>
                    				<th class="text-center">LR No.</th>
                    				<th class="text-center">Amount</th>
                    				<th class="text-center">Transaction Ref No</th>
                    				<th class="text-center">Last Updated</th>
                    				<th class="text-center">Creation Time</th>
                    				<th class="text-center">Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                                <?php
                                    $sl = 1;
                                    $cashbook = $query->getData('*','cashbook','','','id','DESC','');
                    		        foreach($cashbook as $var){
                                        $branch = $query->getData('*','branches','',array('id'=>$var['entity_id']),'','','')[0];
                    		    ?>
                    			<tr>
                    				<td class="text-center"><?= $sl; ?></td>
                    				<td class="text-center"><?= $branch['branch_name']."<br/><b>Username: </b>".$branch['branch_user_name']."<br/><b>Mobile No.: </b>".$branch['mobile_no']; ?></td>
                    				<td class="text-center"><?= $var['req_no']; ?></td>
                    				<td class="text-center"><?= $var['lr_no']; ?></td>
                    				<td class="text-center"><?= $var['amount']; ?></td>
                    				<td class="text-center"><?= $var['ref_no']; ?></td>
                    				<td class="text-center"><?= date("d-m-y h:i:s A",strtotime($var['updated_at'])); ?></td>
                    				<td class="text-center"><?= date("d-m-y h:i:s A",strtotime($var['created_at'])); ?></td>
                    				<td class="text-center">
                        				<?php
                        				    if($var['approve_status'] == "Pending"){
                        				?>
                				        <div class="btn-group">
                				        <a href="actions?save=cashbooksubmit&&cshbk=<?= $var['id']; ?>&&option=Approve" onclick="return confirm('Are you sure to want to approve?')" class="btn btn-success btn-sm">Approve</a>
                				        <a href="actions?save=cashbooksubmit&&cshbk=<?= $var['id']; ?>&&option=Reject" onclick="return confirm('Are you sure to want to reject?')" class="btn btn-danger btn-sm">Reject</a>
                				        </div>
                        				<?php
                    				        }elseif($var['approve_status'] == "Approved"){
                    				            echo '<span class="text-success">Approved <i class="bi bi-patch-check-fill"></i></span>';
                    				        }elseif($var['approve_status'] == "Rejected"){
                    				            echo '<span class="text-danger">Rejected <i class="bi bi-x-circle-fill"></i></span>';
                    				        }
                    				    ?>
                    				</td>
                    			</tr>
                    			<?php
                    			    $sl++;
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