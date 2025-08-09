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
		            <h3 class="card-title">Branches Fright Master</h3>
		            <a href="default-fright-master" type="button" class="btn btn-outline-warning btn-sm">Edit Default Fright <i class="fas fa-pencil"></i></a>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th>Branch Name</th>
                    				<th>Branch User Name</th>
                    				<th>Contact Person</th>
                    				<th>Phone No.</th>
                    				<th>Email Id</th>
                    				<th>Address</th>
                    				<th>Fright</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $condArr = array('delete_status'=>'show');
                    		        $branches = $query->getData('*','branches','',$condArr,'id','DESC','');
                    		        foreach($branches as $getbranches){
                    		    ?>
                    			<tr>
                    				<td><?= $getbranches['branch_name']; ?></td>
                    				<td><?= $getbranches['branch_user_name']; ?></td>
                    				<td><?= $getbranches['contact_person']; ?></td>
                    				<td><?= $getbranches['phone_no']; ?></td>
                    				<td><?= $getbranches['email']; ?></td>
                    				<td><?= $getbranches['address']; ?></td>
                    				<td>
                    				    <div class="d-flex">
										    <a type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg<?= $getbranches['id']; ?>" class="btn btn-warning shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
										</div>
                    				</td>
                    			</tr>
                    			
                    			<div class="modal fade bd-example-modal-lg<?= $getbranches['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <?php
                            		        $arnew = array("branch_id"=>$getbranches['id']);
                            		        $frights = $query->getData('*','branches_fright_master','',$arnew,'','','')[0];
                            		    ?>
                        		        <div class="card-normal">
                                            <form action="actions" method="POST">
                                                <input type="hidden" value="<?= $getbranches['branch_user_name']; ?>" name="branchUserName">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit default fright master for <?= $getbranches['branch_name']; ?> (<?= $getbranches['branch_user_name'];  ?>)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">Zones</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">N1</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">N2</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">E</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">NE</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">W1</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">W2</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">S1</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">S2</strong>
                                        		                </div>
                                        		                <div class="col-1 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">Central</strong>
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">N1</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_n1" value="<?= $frights['n1_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_n1" value="<?= $frights['n2_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_n1" value="<?= $frights['e_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_n1" value="<?= $frights['ne_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_n1" value="<?= $frights['w2_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_n1" value="<?= $frights['s1_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_n1" value="<?= $frights['s2_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_n1" value="<?= $frights['central_to_n1']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">N2</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_n2" value="<?= $frights['n1_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_n2" value="<?= $frights['n2_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_n2" value="<?= $frights['ne_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_n2" value="<?= $frights['w1_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_n2" value="<?= $frights['w2_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_n2" value="<?= $frights['s1_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_n2" value="<?= $frights['s2_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_n2" value="<?= $frights['central_to_n2']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">E</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_e" value="<?= $frights['n1_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_e" value="<?= $frights['n2_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_e" value="<?= $frights['e_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_e" value="<?= $frights['ne_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_e" value="<?= $frights['w1_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_e" value="<?= $frights['w2_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_e" value="<?= $frights['s1_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_e" value="<?= $frights['s2_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_e" value="<?= $frights['central_to_e']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">NE</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_ne" value="<?= $frights['n1_to_ne']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_ne" value="<?= $frights['n2_to_ne']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_ne" value="<?= $frights['e_to_ne']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_ne" value="<?= $frights['ne_to_ne']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_ne" value="<?= $frights['w1_to_ne']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_ne" value="<?= $frights['w2_to_ne']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_ne" value="<?= $frights['s1_to_ne']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_ne" value="<?= $frights['s2_to_ne']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_ne" value="<?= $frights['central_to_ne']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">W1</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_w1" value="<?= $frights['n1_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_w1" value="<?= $frights['n2_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_w1" value="<?= $frights['e_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_w1" value="<?= $frights['ne_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_w1" value="<?= $frights['w1_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_w1" value="<?= $frights['w2_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_w1" value="<?= $frights['s1_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_w1" value="<?= $frights['s2_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_w1" value="<?= $frights['central_to_w1']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">W2</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_w2" value="<?= $frights['n1_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_w2" value="<?= $frights['n2_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_w2" value="<?= $frights['e_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_w2" value="<?= $frights['ne_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_w2" value="<?= $frights['w1_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_w2" value="<?= $frights['w2_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_w2" value="<?= $frights['s1_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_w2" value="<?= $frights['s2_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_w2" value="<?= $frights['central_to_w2']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">S1</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_s1" value="<?= $frights['n1_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_s1" value="<?= $frights['n2_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_s1" value="<?= $frights['e_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_s1" value="<?= $frights['ne_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_s1" value="<?= $frights['w1_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_s1" value="<?= $frights['w2_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_s1" value="<?= $frights['s1_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_s1" value="<?= $frights['s2_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_s1" value="<?= $frights['central_to_s1']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">S2</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_s2" value="<?= $frights['n1_to_s2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_s2" value="<?= $frights['n2_to_s2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_s2" value="<?= $frights['e_to_s2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_s2" value="<?= $frights['ne_to_s2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_s2" value="<?= $frights['w1_to_s2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_s2" value="<?= $frights['w2_to_s2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_s2" value="<?= $frights['s1_to_s2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_s2" value="<?= $frights['s2_to_s2']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_s2" value="<?= $frights['central_to_s2']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-2 d-flex justify-content-center align-items-center">
                                        		                    <strong style="font-size: large;">Central</strong>
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_central" value="<?= $frights['n1_to_central']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_central" value="<?= $frights['n2_to_central']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_central" value="<?= $frights['e_to_central']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_central" value="<?= $frights['ne_to_central']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_central" value="<?= $frights['w1_to_central']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_central" value="<?= $frights['w2_to_central']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_central" value="<?= $frights['s1_to_central']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_central" value="<?= $frights['s2_to_central']; ?>">
                                        		                </div>
                                        		                <div class="col-1">
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_central" value="<?= $frights['central_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                                		</div>
                                                    </div>
                                    		        <div class="modal-footer d-flex" style="justify-content: space-between;">
                                    		            <button class="btn btn-danger btn-sm" type="reset">Reset <i class="bi bi-repeat"></i></button>
                                    		            <button class="btn btn-warning btn-sm" type="submit" name="saveChangesFrightMaster">Save Changes <i class="bi bi-pen-fill"></i></button>
                                    		        </div>
                                                </div>
                                            </form>
                        		        </div>
                        		        <div class="card-mobile">
                                            <form action="actions" method="POST">
                                                <input type="hidden" value="<?= $getbranches['branch_user_name']; ?>" name="branchUserName">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit default fright master for <?= $getbranches['branch_name']; ?> (<?= $getbranches['branch_user_name'];  ?>)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : N1</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_n1" value="<?= $frights['n1_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_n2" value="<?= $frights['n1_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_e" value="<?= $frights['n1_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_ne" value="<?= $frights['n1_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_w1" value="<?= $frights['n1_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_w2" value="<?= $frights['n1_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_s1" value="<?= $frights['n1_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_s2" value="<?= $frights['n1_to_s2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n1_to_central" value="<?= $frights['n1_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <hr style="margin: 30px 0px;"/>
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : N2</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_n1" value="<?= $frights['n2_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_n2" value="<?= $frights['n2_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_e" value="<?= $frights['n2_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_ne" value="<?= $frights['n2_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_w1" value="<?= $frights['n2_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_w2" value="<?= $frights['n2_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_s1" value="<?= $frights['n2_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_s2" value="<?= $frights['n2_to_s2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="n2_to_central" value="<?= $frights['n2_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <hr style="margin: 30px 0px;"/>
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : E</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_n1" value="<?= $frights['e_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_e" value="<?= $frights['e_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_ne" value="<?= $frights['e_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_w1" value="<?= $frights['e_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_w2" value="<?= $frights['e_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_s1" value="<?= $frights['e_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="e_to_central" value="<?= $frights['e_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <hr style="margin: 30px 0px;"/>
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : NE</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_n1" value="<?= $frights['ne_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_n2" value="<?= $frights['ne_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_e" value="<?= $frights['ne_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_ne" value="<?= $frights['ne_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_w1" value="<?= $frights['ne_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_w2" value="<?= $frights['ne_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_s1" value="<?= $frights['ne_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_s2" value="<?= $frights['ne_to_s2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="ne_to_central" value="<?= $frights['ne_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <hr style="margin: 30px 0px;"/>
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : W1</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_e" value="<?= $frights['w1_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_ne" value="<?= $frights['w1_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_w1" value="<?= $frights['w1_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_w2" value="<?= $frights['w1_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_s1" value="<?= $frights['w1_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_s2" value="<?= $frights['w1_to_s2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w1_to_central" value="<?= $frights['w1_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <hr style="margin: 30px 0px;"/>
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : W2</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_n1" value="<?= $frights['w2_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_n2" value="<?= $frights['w2_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_e" value="<?= $frights['w2_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_ne" value="<?= $frights['w2_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_w1" value="<?= $frights['w2_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_w2" value="<?= $frights['w2_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_s1" value="<?= $frights['w2_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_s2" value="<?= $frights['w2_to_s2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="w2_to_central" value="<?= $frights['w2_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <hr style="margin: 30px 0px;"/>
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : S1</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_n1" value="<?= $frights['s1_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_n2" value="<?= $frights['s1_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_e" value="<?= $frights['s1_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_ne" value="<?= $frights['s1_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_w1" value="<?= $frights['s1_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_w2" value="<?= $frights['s1_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_s1" value="<?= $frights['s1_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_s2" value="<?= $frights['s1_to_s2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s1_to_central" value="<?= $frights['s1_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <hr style="margin: 30px 0px;"/>
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : S2</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_n1" value="<?= $frights['s2_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_n2" value="<?= $frights['s2_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_e" value="<?= $frights['s2_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_ne" value="<?= $frights['s2_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_w1" value="<?= $frights['s2_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_w2" value="<?= $frights['s2_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_s1" value="<?= $frights['s2_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_s2" value="<?= $frights['s2_to_s2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="s2_to_central" value="<?= $frights['s2_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                        		            <hr style="margin: 30px 0px;"/>
                                        	                <div class="row">
                                        	                    <strong style="font-size: large;">From Zones : Central</strong>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        	                    <div class="col-3">
                                                                    <strong style="font-size: large;">N1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_n1" value="<?= $frights['central_to_n1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">N2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_n2" value="<?= $frights['central_to_n2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">E</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_e" value="<?= $frights['central_to_e']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">NE</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_ne" value="<?= $frights['central_to_ne']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-3">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_w1" value="<?= $frights['central_to_w1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">W2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_w2" value="<?= $frights['central_to_w2']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S1</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_s1" value="<?= $frights['central_to_s1']; ?>">
                                        		                </div>
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">S2</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_s2" value="<?= $frights['central_to_s2']; ?>">
                                        		                </div>
                                        	                </div>
                                        		            <div class="row mb-2">
                                        		                <div class="col-3">
                                                                    <strong style="font-size: large;">Central</strong>
                                        		                    <input type="text" class="form-control txtNumeric" name="central_to_central" value="<?= $frights['central_to_central']; ?>">
                                        		                </div>
                                        		            </div>
                                    		            </div>
                                                    </div>
                                    		        <div class="modal-footer d-flex" style="justify-content: space-between;">
                                    		            <button class="btn btn-danger btn-sm" type="reset">Reset <i class="bi bi-repeat"></i></button>
                                    		            <button class="btn btn-warning btn-sm" type="submit" name="saveChangesFrightMaster">Save Changes <i class="bi bi-pen-fill"></i></button>
                                    		        </div>
                                                </div>
                                            </form>
                        		        </div>
                                    </div>
                                </div>
                    			
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