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
		            <h3 class="card-title">Employee Salary</h3>
		        </div>
		        <form action="actions.php" method="POST" enctype="multipart/form-data">
		            <div class="card-body">
		                <div class="row">
    		                <div class="col-md-2">
    		                    <label>Select Employee</label>
    		                    <div class="input-group">
                                    <select class="form-control form-control-sm" name="employee" id="employee" required>
                                        <option value="" hidden>Choose Employee</option>
                                        <?php
                                            $getemp = $query->getData("*","employees","",array("delete_status"=>"show"),"","","");
                                            foreach($getemp as $emp){
                                        ?>
                                            <option value="<?= $emp['id']; ?>"><?= $emp['employee_name']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
    	                        </div>
    	                    </div>
    		                <div class="col-md-2">
                                <label>Salary</label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-sm" id="salary" name="salary" readonly>
                                </div>
		                    </div>
    		                <!--<div class="col-md-1">-->
                      <!--          <label>Allowances</label>-->
                      <!--          <div class="input-group">-->
                                    <input type="hidden" class="form-control form-control-sm" id="allowances" name="allowances" readonly>
                      <!--          </div>-->
		                    <!--</div>-->
    		                <div class="col-md-2">
                                <label>Overtime Days</label>
                                <div class="input-group">
                                    <input type="hidden" class="form-control form-control-sm" id="ot_day" name="ot_day" readonly>
                                    <!--x-->
                                    <input type="number" class="form-control form-control-sm" name="nos_ot_days" >
                                </div>
		                    </div>
    		                <div class="col-md-2">
                                <label>Overtime Hours</label>
                                <div class="input-group">
                                    <input type="hidden" class="form-control form-control-sm" id="ot_hour" name="ot_hour" readonly>
                                    <!--x-->
                                    <input type="number" class="form-control form-control-sm" name="nos_ot_hours">
                                </div>
		                    </div>
    		                <div class="col-md-2">
    		                    <label>Select Month</label>
    		                    <div class="input-group">
                                    <select name="month" class="form-control form-control-sm" required>
                                        <option value="" hidden>Choose Month</option>
                                        <option value="January" <?php if(date("n")==2){echo "selected";} ?>>January</option>
                                        <option value="February" <?php if(date("n")==3){echo "selected";} ?>>February</option>
                                        <option value="March" <?php if(date("n")==4){echo "selected";} ?>>March</option>
                                        <option value="April" <?php if(date("n")==5){echo "selected";} ?>>April</option>
                                        <option value="May" <?php if(date("n")==6){echo "selected";} ?>>May</option>
                                        <option value="June" <?php if(date("n")==7){echo "selected";} ?>>June</option>
                                        <option value="July" <?php if(date("n")==8){echo "selected";} ?>>July</option>
                                        <option value="August" <?php if(date("n")==9){echo "selected";} ?>>August</option>
                                        <option value="September" <?php if(date("n")==10){echo "selected";} ?>>September</option>
                                        <option value="October" <?php if(date("n")==11){echo "selected";} ?>>October</option>
                                        <option value="November" <?php if(date("n")==12){echo "selected";} ?>>November</option>
                                        <option value="December" <?php if(date("n")==1){echo "selected";} ?> >December</option>
                                    </select>
    	                        </div>
    	                    </div>
    		                <div class="col-md-2">
                                <label>Year</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="year" value="<?= date("Y"); ?>" readonly>
                                    <button class="btn btn-primary btn-sm" type="submit" name="submitSalary">Submit</button>
                                </div>
		                    </div>
		                </div>
		            </div>
                </form>
                <hr>
               <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display">
                    		<thead>
                    			<tr>
                    				<th>Employee Code</th>
                    				<th>Employee Name</th>
                    				<th>Action</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                                    $getemps = $query->getData("*","employees","","","","","");
                                    foreach($getemps as $var){
                    		    ?>
                        			<tr>
                        				<td><?= $var['employee_code']; ?></td>
                    				    <td><?= $var['employee_name']; ?></td>
                        				<td><a href="salary-master?ref=<?= $emp['employee_code']; ?>" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-eye"></i></a></td>
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