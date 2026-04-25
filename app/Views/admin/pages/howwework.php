<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>

<link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">

<style>
    .cus-switch { position: relative; display: inline-block; width: 50px; height: 24px; }
    .cus-switch input { opacity: 0; width: 0; height: 0; }
    .cus-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
    .cus-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    .cus-switch input:checked+.cus-slider { background-color: #2196F3; }
    .cus-switch input:checked+.cus-slider:before { transform: translateX(26px); }
    .cus-toggle { display: flex; align-items: center; justify-content: space-between; }
</style>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">
        <div id="loader"></div>

        <?php include APPPATH . "/Views/admin/common/top.php"; ?>
        <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

        <div class="content-wrapper">
            <div class="container-full">
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <form class="form form-content">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="cus-toggle mb-3">
                                                    <label class="form-label fw-bold mb-0">Enable/Disable Section</label>
                                                    <div class="d-flex align-items-center">
                                                        <label class="cus-switch mb-0">
                                                            <input type="checkbox" name="missionStatus" id="missionStatus" value="1"
                                                                <?= (isset($data['status']) && $data['status'] == 1) ? 'checked' : '' ?>>
                                                            <span class="cus-slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden"
                                                            value="<?= (isset($data['status']) && $data['status'] == 1) ? '1' : '0' ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Section Title</label>
                                                    <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?? '' ?>" class="form-control" placeholder="How We Work">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="box box-bordered border-primary">
                                                    <div class="box-header with-border">
                                                        <h4 class="box-title">Card 1</h4>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label class="form-label">Card 1 Icon (FontAwesome)</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text bg-white"><i class="<?= $data['web_content_6'] ?? 'fas fa-file-invoice' ?> icon-preview-1"></i></span>
                                                                <input type="text" name="web_content_6" value="<?= $data['web_content_6'] ?? 'fas fa-file-invoice' ?>" class="form-control icon-input-1">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Card 1 Title</label>
                                                            <input type="text" name="web_content_2" value="<?= $data['web_content_2'] ?? '' ?>" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Card 1 Content</label>
                                                            <textarea name="web_content_3" rows="5" class="form-control"><?= $data['web_content_3'] ?? '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="box box-bordered border-primary">
                                                    <div class="box-header with-border">
                                                        <h4 class="box-title">Card 2</h4>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label class="form-label">Card 2 Icon (FontAwesome)</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text bg-white"><i class="<?= $data['web_content_7'] ?? 'fas fa-microchip' ?> icon-preview-2"></i></span>
                                                                <input type="text" name="web_content_7" value="<?= $data['web_content_7'] ?? 'fas fa-microchip' ?>" class="form-control icon-input-2">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Card 2 Title</label>
                                                            <input type="text" name="web_content_4" value="<?= $data['web_content_4'] ?? '' ?>" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Card 2 Content</label>
                                                            <textarea name="web_content_5" rows="5" class="form-control"><?= $data['web_content_5'] ?? '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer text-end">
                                        <input type="hidden" name="web_content_id" value="9">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-save-alt"></i> Save Updates
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>
        <script>
            $(document).ready(function() {
                const missionStatus = document.getElementById('missionStatus');
                const missionStatusHidden = document.getElementById('missionStatusHidden');

                missionStatus.addEventListener('change', function() {
                    missionStatusHidden.value = this.checked ? '1' : '0';
                });

                // Icon Preview Logic
                $(document).on('input', '.icon-input-1', function() {
                    $('.icon-preview-1').attr('class', $(this).val() + ' icon-preview-1');
                });
                $(document).on('input', '.icon-input-2', function() {
                    $('.icon-preview-2').attr('class', $(this).val() + ' icon-preview-2');
                });
            });
        </script>
    </div>
</body>
</html>
