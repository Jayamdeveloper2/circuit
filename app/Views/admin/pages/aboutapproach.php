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
    .ck-editor__editable { min-height: 250px !important; }
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

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Section Title</label>
                                                    <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?? '' ?>" class="form-control" placeholder="Our <span>Approach</span>">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="form-label">Approach Points (Bulleted List)</label>
                                                    <textarea name="web_content_2" rows="10" class="form-control"><?= $data['web_content_2'] ?? '' ?></textarea>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="form-label">Final Bold Statement</label>
                                                    <textarea name="web_content_3" rows="2" class="form-control"><?= $data['web_content_3'] ?? '' ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Section Image</label>
                                                    <div class="product-img text-start">
                                                        <div class="input-group">
                                                            <input type="file" name="web_image_1" class="form-control" accept=".jpg,.jpeg,.png">
                                                        </div>
                                                        <img id="web_logo_1" src="<?= $data['image'] ?? '' ?>" height="200" class="mt-2" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer text-end">
                                        <input type="hidden" name="web_content_id" value="6">
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
                common.initEditor('textarea[name=web_content_2]');

                const missionStatus = document.getElementById('missionStatus');
                const missionStatusHidden = document.getElementById('missionStatusHidden');
                if(missionStatus && missionStatusHidden) {
                    missionStatus.addEventListener('change', function() {
                        missionStatusHidden.value = this.checked ? '1' : '0';
                    });
                }

                $('input[name=web_image_1]').on("change", function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) { $('#web_logo_1').attr("src", e.target.result); };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
    </div>
</body>
</html>
