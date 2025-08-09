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
	    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="GET" class="row mb-3">
	        <div class="col-xl-4 col-sm-6 form-group">
	            <label>Choose user</label>
	            <select class="form-control" name="orderUsersorBranches">
	                <option value="" hidden>Choose one user</option>
	                <?php
	                    $getuser = $query->getData('*','users','',array('delete_status'=>'show'),'id','DESC','');
	                    if($getuser != 0){
	                        foreach($getuser as $user){
	               ?>
	                    <option value="<?= $user['username']; ?>" <?php if(!empty($orderUsersorBranches) && $orderUsersorBranches == $user['username']){ echo 'selected'; } ?>><?= "Name: ".$user['party_name'].", Username: ".$user['username']." ( mobile no.: ".$user['mobile_no']." )"; ?></option>
	               <?php
	                        }
	                    }
	                ?>
	            </select>
			</div>
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>One Date / Start Date</label>
	            <input type="date" class="form-control" name="startDate" value="<?php if(!empty($startDate)){ echo $startDate; } ?>" required>
			</div>
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>End Date</label>
	            <input type="date" class="form-control" name="endDate" value="<?php if(!empty($endDate)){ echo $endDate; } ?>" required>
			</div>
	        <div class="col-xl-2 col-sm-6 form-group d-flex align-items-end">
	            <button class="btn me-1 shadow btn-block" style="background-color: #28a745; color: #fff;">Search</button>
			</div>
	    </form>
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title"><?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches."<span style='text-transform: lowercase;'>'s</span>"; }else{ echo 'All Users'; } ?> Outstanding Report</h3>
		            <form action="act" method="POST">
	                    <input type="text" hidden class="form-control" name="ordersOfUser" value="<?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches; } ?>">
	                    <input type="date" hidden class="form-control" name="startDate" value="<?php if(!empty($startDate)){ echo $startDate; } ?>">
		                <input type="date" hidden class="form-control" name="endDate" value="<?php if(!empty($endDate)){ echo $endDate; } ?>">
		                <button class="btn btn-info btn-sm" name="exportUsersOrders" type="submit">Export All <i class="bi bi-cloud-download-fill"></i></button>
		            </form>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th class="text-center" hidden>Sl No.</th>
                    				<th class="text-center">Ledger Name</th>
                                    <th class="text-center">Mobile No.</th>
                                    <th class="text-center">Bill Date</th>
                                    <!--<th class="text-center">Due Date</th>-->
                                    <!--<th class="text-center">BType</th>-->
                                    <!--<th class="text-center">GRNo</th>-->
                                    <!--<th class="text-center">GrDate</th>-->
                                    <!--<th class="text-center">DRno</th>-->
                                    <!--<th class="text-center">DRDate</th>-->
                                    <th class="text-center">Upto7Days</th>
                                    <th class="text-center">Upto14</th>
                                    <th class="text-center">Upto21</th>
                                    <th class="text-center">Upto28</th>
                                    <th class="text-center">Upto35</th>
                                    <th class="text-center">Upto42</th>
                                    <th class="text-center">Upto49</th>
                                    <th class="text-center">Upto56</th>
                                    <th class="text-center">Upto63</th>
                                    <th class="text-center">Upto70</th>
                                    <th class="text-center">Upto77</th>
                                    <th class="text-center">Upto84</th>
                                    <th class="text-center">Upto91</th>
                                    <th class="text-center">Above 91Days</th>
                                    <th class="text-center">Total Amount</th>
                                    <th class="text-center">Clear Amount</th>
                                    <th class="text-center">User Type</th>
                                    <th class="text-center">Name - Username</th>
                                    <th class="text-center">ToDate</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                                <?php
                                    $outStandQuery = $query->getData("*","outstanding_report",[array("LEFT","stationary_invoices","stationary_invoices","id","outstanding_report","invoice_id")],array("outstanding_report`.`status"=>"Not Clear"),"outstanding_report`.`id","DESC","");
                                    if($outStandQuery != 0):
                                        $sl = 1;
                                        foreach($outStandQuery as $outReport):
                                            $visibleDetails = $query->getData("*",$outReport['user_type'],"",array("id"=>$outReport['type_id']),"id","DESC","1")[0];
                                            $dateDiff = str_replace("-", "", date_diff(date_create(date("Y-m-d")),date_create($outReport['bill_generation_date']))->format("%r%a"));
                                            if($outReport['user_type'] == "branches"):
                                                $name = $visibleDetails['branch_name'];
                                                $username = $visibleDetails['branch_user_name'];
                                            else:
                                                $name = $visibleDetails['party_name'];
                                                $username = $visibleDetails['username'];
                                            endif;
                                ?>
                                            <tr>
                                                <td class="text-center" hidden><?= $sl; ?></td>
                                                <td class="text-center"><?= $outReport['name']; ?></td>
                                                <td class="text-center"><?= $visibleDetails['mobile_no']; ?></td>
                                                <td class="text-center"><?= $outReport['invoice_date']; ?></td>
                                                <?php
                                                    for($i = 1; $i <= 14; $i++):
                                                        // if()
                                                        echo '<td class="text-center">'.$i.'</td>';
                                                    endfor;
                                                ?>
                                                <td class="text-center">₹<?= $outReport['outstanding_price']; ?></td>
                                                <td class="text-center">₹<?php if(empty($outReport['cleared_price'])){ echo 0; }else{ echo $outReport['cleared_price']; } ?></td>
                                                <td class="text-center"><?= ucwords(trim(trim($outReport['user_type'], "s"), "es")); ?></td>
                                                <td class="text-center"><?= $name." - ".$username; ?></td>
                                                <td class="text-center"><?= $outReport['invoice_date']; ?></td>
                                            </tr>
                                <?php
                                        endforeach;
                                        $sl++;
                                    endif;
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