<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>

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
                            <h3 class="page-title"><?= $breadcrumb ?? "PERI Content" ?></h3>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="box shadow-none">
                                <form class="form form-content">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="cus-toggle mb-4">
                                                    <label class="form-label fw-bold mb-0">Show Section</label>
                                                    <div class="d-flex align-items-center">
                                                        <label class="cus-switch mb-0">
                                                            <input type="checkbox" name="missionStatus" id="missionStatus" value="1"
                                                                <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                            <span class="cus-slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden" value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Intro Paragraph</label>
                                                    <textarea class="form-control" rows="6" name="web_content_2" placeholder="Enter the main description..."><?= $data['web_content_2'] ?></textarea>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Badge Text</label>
                                                    <input type="text" name="web_content_3" value="<?= $data['web_content_3'] ?>"
                                                        class="form-control" placeholder="e.g. Being Established">
                                                        <p class="text-muted small mt-1">This text appears inside the pulsing status badge.</p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <input type="hidden" name="web_content_id" value="<?= $data['web_content_id'] ?>">
                                        <button type="submit" class="btn btn-primary shadow-none">
                                            <i class="ti-save-alt me-1"></i> Save Content
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
        </div>

        <!-- Footer -->
        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>

        <!-- Toggle Script -->
        <script>
            const missionStatus = document.getElementById('missionStatus');
            const missionStatusHidden = document.getElementById('missionStatusHidden');

            missionStatus.addEventListener('change', function() {
                missionStatusHidden.value = this.checked ? '1' : '0';
            });
        </script>
    </div>
</body>
</html>
