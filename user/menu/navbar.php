        <!-- Navbar -->
          <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                
                <div class="nav-item navbar-search-wrapper mb-0 d-none d-md-inline-block">
                    <form action="track">
                        <div class="input-group input-group-merge">
                          <input type="text" class="form-control" placeholder="Enter LRN to Track" aria-label="" aria-describedby="basic-addon-search31" style="width:350px;" name="lrn" required>
                          <button type="submit" class="input-group-text" id="basic-addon-search31" style="background-color: #696cff !important;color: #fff;"><i class="bx bx-search"></i></button>
                        </div>
                    </form>
                </div>
                
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <!--<li class="nav-item lh-1 me-3">-->
                <!--  <a href="new_rate_calculator" class="btn btn-sm rounded-pill btn-primary" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<span>Rate Calculator</span>">-->
                <!--      <i class="bx bx-calculator" style='font-size:25px;'></i></a>-->
                <!--</li>-->
                <li class="nav-item lh-1 me-3">
                  <a href="add_money" class="btn btn-sm rounded-pill btn-primary" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<span>Add Money</span>">
                      <i class="bx bx-wallet" style='font-size:25px;'></i></a>
                </li>
                <li class="nav-item lh-1 me-3">
                  <a class="nav-link fs-5" ><?= '₹'.$get_user_details[0]['wallet_balance']; ?></a>
                </li>
                

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <i class="bx bxs-user-circle" style="font-size: 40px;"></i>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3 d-flex align-items-center">
                            <div class="avatar avatar-online">
                              <i class="bx bxs-user-circle" style="font-size: 40px;"></i>
                            </div>
                          </div>
                          <div class="flex-grow-1" style="display: flex; flex-direction: column;">
                            <span class="fw-semibold d-block mt-2">
                                <?= $get_user_details[0]['party_name']; ?>
                            </span>
                            <small style="font-size: smaller;">
                                <?= $get_user_details[0]['username']; ?>
                            </small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="my_profile">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                        <a  class="dropdown-item" href="change_password">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Change Password</span>
                        </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="transaction">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-transfer me-2"></i>
                          <span class="flex-grow-1 align-middle">Transaction</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="add_money_requests">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-transfer me-2"></i>
                          <span class="flex-grow-1 align-middle">Money Requests</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>