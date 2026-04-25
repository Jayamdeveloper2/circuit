<!DOCTYPE html>
<html lang="en">
    <?php include APPPATH . "/Views/admin/common/header.php"; ?>
    <link href="<?= CSS_PATH ?>/plugins/wysiwyag/richtext.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">

    <style>
        /* Custom Toggle Switch CSS */
        .cus-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .cus-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .cus-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .cus-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .cus-switch input:checked + .cus-slider {
            background-color: #2196F3;
        }

        .cus-switch input:checked + .cus-slider:before {
            transform: translateX(26px);
        }

        .cus-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>

    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">

        <div class="wrapper">
            <div id="loader"></div>

            <?php include APPPATH . "/Views/admin/common/top.php"; ?>
            <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <div class="container-full">
                    <!-- Page Header -->
                    <div class="content-header">
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                <h3 class="page-title"><?= $breadcrumb ?? "Donation Form" ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <form class="form looks-content-form">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="cus-toggle mb-3">
                                        <label class="form-label mb-0">Page Status</label>
                                        <label class="cus-switch">
                                           <input type="checkbox" id="public_function_manageid" data-section="25" <?= (isset($donatemaster['status']) && $donatemaster['status']==1) ? 'checked' : '' ?>>

                                            <span class="cus-slider"></span>
                                        </label>
                                    </div>  

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
            <script src="<?= base_url('assets/js/pages/involvedlist.js') ?>"></script>

            <!-- Toggle JS -->
            
        </div>
    </body>
</html>
