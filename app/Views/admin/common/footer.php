<footer class="main-footer">

    &copy; <script>
        document.write(new Date().getFullYear())
        </script> Developed by <a target="_blank" href="https://jayamwebsolutions.com/">Jayam Web Solutions</a>
</footer>

<!-- Side panel -->
<!-- quick_user_toggle -->
<div class="modal modal-right fade" id="quick_user_toggle" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content slim-scroll3">
            <div class="modal-body p-30 bg-white">
                <div class="d-flex align-items-center justify-content-between pb-30">
                    <h4 class="m-0">User Profile
                    </h4>
                    <a href="#" class="btn btn-icon btn-danger-light btn-sm no-shadow" data-bs-dismiss="modal">
                        <span class="fa fa-times"></span>
                    </a>
                </div>
                <div>
                    <div class="d-flex flex-row">
                        <div class=""><img src="<?= CSS_PATH . "/images/avatar/man.png" ?>" alt="user" class="rounded bg-success-light" style="width:100px" width="100"></div>
                        <div class="ps-20">
                            <h5 class="mb-0"><?= session()->get('user_name') ?> <?= session()->get('user_last_name') ?></h5>
                            <a href="mailto:dummy@gmail.com"><span  > <?= session()->get('user_email') ?></span></a>
                            <p class="my-5 badge badge-info"><?= session()->get('user_type') ?></p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider my-20"></div>
                <div>

                    <div class="d-flex align-items-center mb-30">
                        <div class="me-15 bg-primary-light h-50 w-50 l-h-60 rounded text-center">
                            <i style="font-size: 25px;" class="fas fa-unlock-alt"></i>
                        </div>
                        <div class="d-flex flex-column fw-500">
                            <a  data-bs-target="#user-change-password" data-bs-toggle="modal" class="text-dark hover-danger mb-1 fs-16">Change Password</a>
                            <span class="text-fade">forgot Password</span>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-30">
                        <div class="me-15 bg-primary-light h-50 w-50 l-h-60 rounded text-center">
                            <i style="font-size: 25px;" class="fas fa-envelope"></i>
                        </div>
                        <div class="d-flex flex-column fw-500">
                            <a data-bs-target="#user-change-email" data-bs-toggle="modal" class="text-dark hover-danger mb-1 fs-16">Change Email</a>
                            <span class="text-fade">Update admin email</span>
                        </div>
                    </div>



                </div>


            </div>
            <div class="modal-footer modal-footer-uniform">
                <a href="<?= base_url(ADMIN_NAME . '/logout') ?>" class="btn btn-danger-light mt-5 w-100"><i class="fa fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- /quick_user_toggle -->

<!-- Password Change -->
<div class="modal modal-right fade" id="user-change-password" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content slim-scroll3">
            <div class="modal-body p-20 bg-white">
                <div class="d-flex align-items-center justify-content-between pb-30">
                    <h4 class="m-0">Change Password
                    </h4>
                    <a href="#" class="btn btn-icon btn-danger-light btn-sm no-shadow" data-bs-dismiss="modal">
                        <span class="fa fa-times"></span>
                    </a>
                </div>

                <div>
                    <form data-validate class="user_change_password_form">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="form-label">Old Password<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="user_old_pass"
                                               class="form-control" required="" 
                                               aria-invalid="false">
                                    </div>
                                    <div class="invalid-feedback">This field is required</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="form-label">New Password<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="user_new_pass"
                                               class="form-control" required=""

                                               aria-invalid="false">
                                    </div>
                                    <div class="invalid-feedback">This field is required</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer modal-footer-uniform w-100 p-0">
                            <input type="hidden" name="m_material_id" value="-1">
                            <button type="button" class="btn btn-primary-light"
                                    data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>


                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Email Change -->
<div class="modal modal-right fade" id="user-change-email" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content slim-scroll3">
            <div class="modal-body p-20 bg-white">
                <div class="d-flex align-items-center justify-content-between pb-30">
                    <h4 class="m-0">Change Email
                    </h4>
                    <a href="#" class="btn btn-icon btn-danger-light btn-sm no-shadow" data-bs-dismiss="modal">
                        <span class="fa fa-times"></span>
                    </a>
                </div>

                <div>
                    <form data-validate class="user_change_email_form">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="form-label">New Email<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="email" name="user_new_email" value="<?= session()->get('user_email') ?>"
                                               class="form-control" required="" 
                                               aria-invalid="false">
                                    </div>
                                    <div class="invalid-feedback">This field is required</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer modal-footer-uniform w-100 p-0">
                            <button type="button" class="btn btn-primary-light"
                                    data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Change Email</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Page Content overlay -->


    <!-- Vendor JS -->
    <script src="<?= CSS_PATH ?>/src/js/vendors.min.js?t=<?= APP_VERSION ?>"></script>
    <script src="<?= CSS_PATH ?>/src/js/pages/chat-popup.js?t=<?= APP_VERSION ?>"></script>
    <script src="<?= CSS_PATH ?>/icons/feather-icons/feather.min.js?t=<?= APP_VERSION ?>"></script>

    <!-- EV Admin App -->


    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="<?= CSS_PATH ?>/vendor_components/datatable/datatables.min.js?t=<?= APP_VERSION ?>"></script>

    <!-- EV Admin App -->

    <script src="<?= CSS_PATH ?>/src/js/pages/data-table.js?t=<?= APP_VERSION ?>"></script>

    <script src="<?= CSS_PATH ?>/src/js/template.js?t=<?= APP_VERSION ?>"></script>
    <script src="<?= CSS_PATH ?>/js/common.js?t=<?= APP_VERSION ?>"></script>
    <script src="<?= CSS_PATH ?>/js/validation.js?t=<?= APP_VERSION ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>  
    <script type="text/javascript" charset="utf8" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let current_user_id = "<?= session()->get('m_user_type_id') ?>";
        let cus_body = $("body");

        document.addEventListener("DOMContentLoaded", function () {
            if ($(window).width() > 475) {
                cus_body.addClass(localStorage.getItem('slideState') ?? "");
            }

            cus_body.addClass(localStorage.getItem('skin') ?? "");
        });

        $(".c-menu-btn").on("click", function () {
            if (cus_body.hasClass('sidebar-collapse sidebar-open')) {

                localStorage.setItem('slideState', '');
                cus_body.removeClass('sidebar-collapse sidebar-open');
            } else {
                cus_body.addClass('sidebar-collapse sidebar-open');
                localStorage.setItem('slideState', 'sidebar-collapse sidebar-open');
            }
        }
        );

        $('[data-mainsidebarskin="toggle"]').on('click', function () {
            var $sidebar = $('body')
            if (cus_body.hasClass('dark-skin')) {
                localStorage.setItem('skin', 'light-skin');
                cus_body.removeClass('dark-skin')
                cus_body.addClass('light-skin')
            } else {
                localStorage.setItem('skin', 'dark-skin');
                cus_body.removeClass('light-skin')
                cus_body.addClass('dark-skin')
            }
        })

        $('#toggleFullscreen').on('click', function () {
            screenfull.toggle($('#container')[0]);
        });
    </script>