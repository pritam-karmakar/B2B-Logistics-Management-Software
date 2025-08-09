<?php
include('menu/header.php');
include('menu/navbar.php');
if($get_user_details[0]['branch_charge'] =='yes'){
    $frights = $query->getData("*","branches_fright_master","",array("branch_id"=>$user_id),"id","DESC","1");
}else{
    $frights = $query->getData('*','default_fright_master','','','id','DESC','1')[0];
}
?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-light">Rate Chart</span></h4>
            <div class="row">
                <div class="card">
                    <div class="card-body">
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
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_n1" value="<?= $frights['n1_to_n1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_n1" value="<?= $frights['n2_to_n1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_n1" value="<?= $frights['e_to_n1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_n1" value="<?= $frights['ne_to_n1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_n1" value="<?= $frights['w2_to_n1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_n1" value="<?= $frights['s1_to_n1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_n1" value="<?= $frights['s2_to_n1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_n1" value="<?= $frights['central_to_n1']; ?>" readonly>
    		                </div>
    		            </div>
    		            <div class="row mb-2">
    		                <div class="col-2 d-flex justify-content-center align-items-center">
    		                    <strong style="font-size: large;">N2</strong>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_n2" value="<?= $frights['n1_to_n2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_n2" value="<?= $frights['n2_to_n2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_n2" value="<?= $frights['ne_to_n2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_n2" value="<?= $frights['w1_to_n2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_n2" value="<?= $frights['w2_to_n2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_n2" value="<?= $frights['s1_to_n2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_n2" value="<?= $frights['s2_to_n2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_n2" value="<?= $frights['central_to_n2']; ?>" readonly>
    		                </div>
    		            </div>
    		            <div class="row mb-2">
    		                <div class="col-2 d-flex justify-content-center align-items-center">
    		                    <strong style="font-size: large;">E</strong>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_e" value="<?= $frights['n1_to_e']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_e" value="<?= $frights['n2_to_e']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_e" value="<?= $frights['e_to_e']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_e" value="<?= $frights['ne_to_e']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_e" value="<?= $frights['w1_to_e']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_e" value="<?= $frights['w2_to_e']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_e" value="<?= $frights['s1_to_e']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_e" value="<?= $frights['s2_to_e']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_e" value="<?= $frights['central_to_e']; ?>" readonly>
    		                </div>
    		            </div>
    		            <div class="row mb-2">
    		                <div class="col-2 d-flex justify-content-center align-items-center">
    		                    <strong style="font-size: large;">NE</strong>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_ne" value="<?= $frights['n1_to_ne']; ?>" readonly> 
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_ne" value="<?= $frights['n2_to_ne']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_ne" value="<?= $frights['e_to_ne']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_ne" value="<?= $frights['ne_to_ne']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_ne" value="<?= $frights['w1_to_ne']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_ne" value="<?= $frights['w2_to_ne']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_ne" value="<?= $frights['s1_to_ne']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_ne" value="<?= $frights['s2_to_ne']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_ne" value="<?= $frights['central_to_ne']; ?>" readonly>
    		                </div>
    		            </div>
    		            <div class="row mb-2">
    		                <div class="col-2 d-flex justify-content-center align-items-center">
    		                    <strong style="font-size: large;">W1</strong>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_w1" value="<?= $frights['n1_to_w1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_w1" value="<?= $frights['n2_to_w1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_w1" value="<?= $frights['e_to_w1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_w1" value="<?= $frights['ne_to_w1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_w1" value="<?= $frights['w1_to_w1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_w1" value="<?= $frights['w2_to_w1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_w1" value="<?= $frights['s1_to_w1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_w1" value="<?= $frights['s2_to_w1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_w1" value="<?= $frights['central_to_w1']; ?>" readonly>
    		                </div>
    		            </div>
    		            <div class="row mb-2">
    		                <div class="col-2 d-flex justify-content-center align-items-center">
    		                    <strong style="font-size: large;">W2</strong>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_w2" value="<?= $frights['n1_to_w2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_w2" value="<?= $frights['n2_to_w2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_w2" value="<?= $frights['e_to_w2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_w2" value="<?= $frights['ne_to_w2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_w2" value="<?= $frights['w1_to_w2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_w2" value="<?= $frights['w2_to_w2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_w2" value="<?= $frights['s1_to_w2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_w2" value="<?= $frights['s2_to_w2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_w2" value="<?= $frights['central_to_w2']; ?>" readonly>
    		                </div>
    		            </div>
    		            <div class="row mb-2">
    		                <div class="col-2 d-flex justify-content-center align-items-center">
    		                    <strong style="font-size: large;">S1</strong>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_s1" value="<?= $frights['n1_to_s1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_s1" value="<?= $frights['n2_to_s1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_s1" value="<?= $frights['e_to_s1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_s1" value="<?= $frights['ne_to_s1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_s1" value="<?= $frights['w1_to_s1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_s1" value="<?= $frights['w2_to_s1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_s1" value="<?= $frights['s1_to_s1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_s1" value="<?= $frights['s2_to_s1']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_s1" value="<?= $frights['central_to_s1']; ?>" readonly>
    		                </div>
    		            </div>
    		            <div class="row mb-2">
    		                <div class="col-2 d-flex justify-content-center align-items-center">
    		                    <strong style="font-size: large;">S2</strong>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_s2" value="<?= $frights['n1_to_s2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_s2" value="<?= $frights['n2_to_s2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_s2" value="<?= $frights['e_to_s2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_s2" value="<?= $frights['ne_to_s2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_s2" value="<?= $frights['w1_to_s2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_s2" value="<?= $frights['w2_to_s2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_s2" value="<?= $frights['s1_to_s2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_s2" value="<?= $frights['s2_to_s2']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_s2" value="<?= $frights['central_to_s2']; ?>" readonly>
    		                </div>
    		            </div>
    		            <div class="row mb-2">
    		                <div class="col-2 d-flex justify-content-center align-items-center">
    		                    <strong style="font-size: large;">Central</strong>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n1_to_central" value="<?= $frights['n1_to_central']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="n2_to_central" value="<?= $frights['n2_to_central']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="e_to_central" value="<?= $frights['e_to_central']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="ne_to_central" value="<?= $frights['ne_to_central']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w1_to_central" value="<?= $frights['w1_to_central']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="w2_to_central" value="<?= $frights['w2_to_central']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s1_to_central" value="<?= $frights['s1_to_central']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="s2_to_central" value="<?= $frights['s2_to_central']; ?>" readonly>
    		                </div>
    		                <div class="col-1">
    		                    <input type="text" class="form-control txtNumeric" name="central_to_central" value="<?= $frights['central_to_central']; ?>" readonly>
    		                </div>
    		            </div>
    		        </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('menu/footer.php');
?>
  