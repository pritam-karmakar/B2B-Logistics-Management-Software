<?php
include("assets/header.php");
include("assets/sidebar.php");
$frights = $query->getData('*','default_fright_master','','','','','')[0];
?>
<!--**********************************
    Content body start
***********************************-->

<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <form action="actions" method="POST" class="card card-normal">
		        <div class="card-header">
		            <h3 class="card-title">Edit Default Fright</h3>
		        </div>
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
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_n1" value="<?= $frights['n1_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_n2" value="<?= $frights['n1_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_e" value="<?= $frights['n1_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_ne" value="<?= $frights['n1_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_w1" value="<?= $frights['n1_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_w2" value="<?= $frights['n1_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_s1" value="<?= $frights['n1_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_s2" value="<?= $frights['n1_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n1_to_central" value="<?= $frights['n1_to_central']; ?>">
		                </div>
		            </div>
		            <div class="row mb-2">
		                <div class="col-2 d-flex justify-content-center align-items-center">
		                    <strong style="font-size: large;">N2</strong>
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_n1" value="<?= $frights['n2_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_n2" value="<?= $frights['n2_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_e" value="<?= $frights['n2_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_ne" value="<?= $frights['n2_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_w1" value="<?= $frights['n2_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_w2" value="<?= $frights['n2_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_s1" value="<?= $frights['n2_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_s2" value="<?= $frights['n2_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="n2_to_central" value="<?= $frights['n2_to_central']; ?>">
		                </div>
		            </div>
		            <div class="row mb-2">
		                <div class="col-2 d-flex justify-content-center align-items-center">
		                    <strong style="font-size: large;">E</strong>
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_n1" value="<?= $frights['e_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_e" value="<?= $frights['e_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_ne" value="<?= $frights['e_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_w1" value="<?= $frights['e_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_w2" value="<?= $frights['e_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_s1" value="<?= $frights['e_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_s2" value="<?= $frights['e_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="e_to_central" value="<?= $frights['e_to_central']; ?>">
		                </div>
		            </div>
		            <div class="row mb-2">
		                <div class="col-2 d-flex justify-content-center align-items-center">
		                    <strong style="font-size: large;">NE</strong>
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_n1" value="<?= $frights['ne_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_n2" value="<?= $frights['ne_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_e" value="<?= $frights['ne_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_ne" value="<?= $frights['ne_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_w1" value="<?= $frights['ne_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_w2" value="<?= $frights['ne_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_s1" value="<?= $frights['ne_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_s2" value="<?= $frights['ne_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="ne_to_central" value="<?= $frights['ne_to_central']; ?>">
		                </div>
		            </div>
		            <div class="row mb-2">
		                <div class="col-2 d-flex justify-content-center align-items-center">
		                    <strong style="font-size: large;">W1</strong>
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_n2" value="<?= $frights['w1_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_e" value="<?= $frights['w1_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_ne" value="<?= $frights['w1_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_w1" value="<?= $frights['w1_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_w2" value="<?= $frights['w1_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_s1" value="<?= $frights['w1_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_s2" value="<?= $frights['w1_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w1_to_central" value="<?= $frights['w1_to_central']; ?>">
		                </div>
		            </div>
		            <div class="row mb-2">
		                <div class="col-2 d-flex justify-content-center align-items-center">
		                    <strong style="font-size: large;">W2</strong>
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_n1" value="<?= $frights['w2_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_n2" value="<?= $frights['w2_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_e" value="<?= $frights['w2_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_ne" value="<?= $frights['w2_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_w1" value="<?= $frights['w2_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_w2" value="<?= $frights['w2_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_s1" value="<?= $frights['w2_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_s2" value="<?= $frights['w2_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="w2_to_central" value="<?= $frights['w2_to_central']; ?>">
		                </div>
		            </div>
		            <div class="row mb-2">
		                <div class="col-2 d-flex justify-content-center align-items-center">
		                    <strong style="font-size: large;">S1</strong>
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_n1" value="<?= $frights['s1_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_n2" value="<?= $frights['s1_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_e" value="<?= $frights['s1_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_ne" value="<?= $frights['s1_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_w1" value="<?= $frights['s1_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_w2" value="<?= $frights['s1_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_s1" value="<?= $frights['s1_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_s2" value="<?= $frights['s1_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s1_to_central" value="<?= $frights['s1_to_central']; ?>">
		                </div>
		            </div>
		            <div class="row mb-2">
		                <div class="col-2 d-flex justify-content-center align-items-center">
		                    <strong style="font-size: large;">S2</strong>
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_n1" value="<?= $frights['s2_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_n2" value="<?= $frights['s2_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_e" value="<?= $frights['s2_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_ne" value="<?= $frights['s2_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_w1" value="<?= $frights['s2_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_w2" value="<?= $frights['s2_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_s1" value="<?= $frights['s2_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_s2" value="<?= $frights['s2_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="s2_to_central" value="<?= $frights['s2_to_central']; ?>">
		                </div>
		            </div>
		            <div class="row mb-2">
		                <div class="col-2 d-flex justify-content-center align-items-center">
		                    <strong style="font-size: large;">Central</strong>
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_n1" value="<?= $frights['central_to_n1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_n2" value="<?= $frights['central_to_n2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_e" value="<?= $frights['central_to_e']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_ne" value="<?= $frights['central_to_ne']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_w1" value="<?= $frights['central_to_w1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_w2" value="<?= $frights['central_to_w2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_s1" value="<?= $frights['central_to_s1']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_s2" value="<?= $frights['central_to_s2']; ?>">
		                </div>
		                <div class="col-1">
		                    <input type="text" class="form-control numeric-decimal" name="central_to_central" value="<?= $frights['central_to_central']; ?>">
		                </div>
		            </div>
		        </div>
		        <div class="card-footer d-flex" style="justify-content: space-between;">
		            <button class="btn btn-danger btn-sm" type="submit" name="resetDefaultFreight">Reset <i class="bi bi-repeat"></i></button>
		            <button class="btn btn-warning btn-sm" type="submit" name="saveChangesDeafultFright">Save Changes <i class="bi bi-pen-fill"></i></button>
		        </div>
		    </form>
		    <!--<form action="actions" method="POST" class="card card-mobile">-->
		    <!--    <div class="card-header">-->
		    <!--        <h3 class="card-title">Edit Default Fright Master</h3>-->
		    <!--    </div>-->
		    <!--    <div class="card-body">-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : N1</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_n1" value="<?= $frights['n1_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_n2" value="<?= $frights['n1_to_n2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_e" value="<?= $frights['n1_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_ne" value="<?= $frights['n1_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_w1" value="<?= $frights['n1_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_w2" value="<?= $frights['n1_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_s1" value="<?= $frights['n1_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_s2" value="<?= $frights['n1_to_s2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n1_to_central" value="<?= $frights['n1_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--        <hr style="margin: 30px 0px;"/>-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : N2</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_n1" value="<?= $frights['n2_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_n2" value="<?= $frights['n2_to_n2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_e" value="<?= $frights['n2_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_ne" value="<?= $frights['n2_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_w1" value="<?= $frights['n2_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_w2" value="<?= $frights['n2_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_s1" value="<?= $frights['n2_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_s2" value="<?= $frights['n2_to_s2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="n2_to_central" value="<?= $frights['n2_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--        <hr style="margin: 30px 0px;"/>-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : E</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_n1" value="<?= $frights['e_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_e" value="<?= $frights['e_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_ne" value="<?= $frights['e_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_w1" value="<?= $frights['e_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_w2" value="<?= $frights['e_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_s1" value="<?= $frights['e_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_n2" value="<?= $frights['e_to_n2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="e_to_central" value="<?= $frights['e_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--        <hr style="margin: 30px 0px;"/>-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : NE</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_n1" value="<?= $frights['ne_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_n2" value="<?= $frights['ne_to_n2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_e" value="<?= $frights['ne_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_ne" value="<?= $frights['ne_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_w1" value="<?= $frights['ne_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_w2" value="<?= $frights['ne_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_s1" value="<?= $frights['ne_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_s2" value="<?= $frights['ne_to_s2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="ne_to_central" value="<?= $frights['ne_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--        <hr style="margin: 30px 0px;"/>-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : W1</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_n1" value="<?= $frights['w1_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_e" value="<?= $frights['w1_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_ne" value="<?= $frights['w1_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_w1" value="<?= $frights['w1_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_w2" value="<?= $frights['w1_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_s1" value="<?= $frights['w1_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_s2" value="<?= $frights['w1_to_s2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w1_to_central" value="<?= $frights['w1_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--        <hr style="margin: 30px 0px;"/>-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : W2</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_n1" value="<?= $frights['w2_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_n2" value="<?= $frights['w2_to_n2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_e" value="<?= $frights['w2_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_ne" value="<?= $frights['w2_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_w1" value="<?= $frights['w2_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_w2" value="<?= $frights['w2_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_s1" value="<?= $frights['w2_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_s2" value="<?= $frights['w2_to_s2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="w2_to_central" value="<?= $frights['w2_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--        <hr style="margin: 30px 0px;"/>-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : S1</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_n1" value="<?= $frights['s1_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_n2" value="<?= $frights['s1_to_n2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_e" value="<?= $frights['s1_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_ne" value="<?= $frights['s1_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_w1" value="<?= $frights['s1_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_w2" value="<?= $frights['s1_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_s1" value="<?= $frights['s1_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_s2" value="<?= $frights['s1_to_s2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s1_to_central" value="<?= $frights['s1_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--        <hr style="margin: 30px 0px;"/>-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : S2</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_n1" value="<?= $frights['s2_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_n2" value="<?= $frights['s2_to_n2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_e" value="<?= $frights['s2_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_ne" value="<?= $frights['s2_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_w1" value="<?= $frights['s2_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_w2" value="<?= $frights['s2_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_s1" value="<?= $frights['s2_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_s2" value="<?= $frights['s2_to_s2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="s2_to_central" value="<?= $frights['s2_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--        <hr style="margin: 30px 0px;"/>-->
	     <!--           <div class="row">-->
	     <!--               <strong style="font-size: large;">From Zones : Central</strong>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
	     <!--               <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_n1" value="<?= $frights['central_to_n1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">N2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_n2" value="<?= $frights['central_to_n2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">E</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_e" value="<?= $frights['central_to_e']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">NE</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_ne" value="<?= $frights['central_to_ne']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-3">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_w1" value="<?= $frights['central_to_w1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">W2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_w2" value="<?= $frights['central_to_w2']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S1</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_s1" value="<?= $frights['central_to_s1']; ?>">-->
		    <!--            </div>-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">S2</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_s2" value="<?= $frights['central_to_s2']; ?>">-->
		    <!--            </div>-->
	     <!--           </div>-->
		    <!--        <div class="row mb-2">-->
		    <!--            <div class="col-3">-->
      <!--                      <strong style="font-size: large;">Central</strong>-->
		    <!--                <input type="text" class="form-control numeric-decimal" name="central_to_central" value="<?= $frights['central_to_central']; ?>">-->
		    <!--            </div>-->
		    <!--        </div>-->
		    <!--    </div>-->
		    <!--    <div class="card-footer d-flex" style="justify-content: space-between;">-->
		    <!--        <button class="btn btn-danger btn-sm" type="submit" name="resetDefaultFreight">Reset <i class="bi bi-repeat"></i></button>-->
		    <!--        <button class="btn btn-warning btn-sm" type="submit" name="saveChangesDeafultFright">Save Changes <i class="bi bi-pen-fill"></i></button>-->
		    <!--    </div>-->
		    <!--</form>-->
		</div>
	</div>
</div>

<!--**********************************
    Content body end
***********************************-->

<?php
include("assets/footer.php");
?>