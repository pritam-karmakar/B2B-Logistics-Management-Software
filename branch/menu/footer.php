        <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  
                  <a href="https://www.kingfishlogistics.in" target="_blank" class="footer-link fw-bolder">Kingfish Logistics</a>
                  
                </div>
                <a href="https://www.casfus.com" class="footer-link me-4" target="_blank">Powered By <span class="fw-bolder">Casfus Technologies</span></a>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

     <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/libs/hammer/hammer.js"></script>
  <script src="../assets/vendor/libs/i18n/i18n.js"></script>
  <script src="../assets/vendor/libs/typeahead-js/typeahead.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/vendor/libs/select2/select2.js"></script>
  <script src="../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
  <script src="../assets/js/forms-selects.js"></script>
  <script src="../assets/js/forms-tagify.js"></script>
  
  <script src="../assets/vendor/libs/moment/moment.js"></script>
  <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
  <script src="../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
  <script src="../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
  <script src="../assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
  <script src="../assets/vendor/libs/pickr/pickr.js"></script>
  <script src="../assets/js/forms-pickers.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>
  <script src="menu/newjQuery.js"></script>
  

  <!-- Page JS -->
  <script src="../assets/js/dashboards-analytics.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#change_password").prop("disabled",true);
            $("#password, #confirm_password").keyup(function(){
                var password = $("#password").val();
                var confirmPassword = $("#confirm_password").val();
        
                if (password !== '' && confirmPassword !== '') {
                    if (password !== confirmPassword) {
                        $("#message").text("Password and confirm password should be same").attr("class", "text-danger");
                        $("#change_password").prop("disabled",true);
                    } else if (password.length < 6 || confirmPassword.length < 6) {
                        $("#message").text("Password length should be at least 6 characters").attr("class", "text-danger");
                        $("#change_password").prop("disabled",true);
                    } else {
                        $("#message").text("Password Matched").attr("class", "text-success");
                        $("#change_password").prop("disabled",false);
                    }
                } else {
                    $("#message").text("Please enter both Password and Confirm Password").attr("class", "text-primary");
                }
            });
        });
    </script> 
  </body>
</html>