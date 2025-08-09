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
		            <h3 class="card-title">My Salary Payments History</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>Employee Code</th>
                    				<th>Employee Name</th>
                    				<th>Year</th>
                    				<th>Month</th>
                    				<th>Payment Date</th>
                    				<th>Payslip</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $join = array("0"=>array("LEFT","employees","salary","emp_id","employees","id"));
                    		        $condArr = array("salary`.`emp_id"=>$ltl_emp_id);
                    		        $salary = $query->getData("`salary`.*,`employees`.`employee_name`,`employees`.`employee_code`","salary",$join,$condArr,"salary`.`id","DESC","");
                    		        foreach($salary as $getsal){
                    		    ?>
                    			<tr>
                    				<td><?= $getsal['employee_code']; ?></td>
                    				<td><?= $getsal['employee_name']; ?></td>
                    				<td><?= $getsal['year']; ?></td>
                    				<td><?= $getsal['month']; ?></td>
                    				<td><?= date("d-M-Y", strtotime($getsal['payment_date'])); ?></td>
                    				<td>
                    				    <form action="actions" method="POST">
                    				        <input type="hidden" name="empCode" value="<?= $getsal['employee_code']; ?>">
                    				        <input type="hidden" name="salaryMonth" value="<?= $getsal['month']; ?>">
                    				        <input type="hidden" name="salaryYear" value="<?= $getsal['year']; ?>">
                    				        <input type="submit" class="btn btn-primary btn-sm" name="salSlipSubmit" value="Generate Slip">
                    				    </form>
                    				</td>
                    			</tr>
                    			<?php
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