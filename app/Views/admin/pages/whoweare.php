<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
<link href="<?= CSS_PATH ?>/plugins/wysiwyag/richtext.min.css" rel="stylesheet" type="text/css" />
<link href="<?= CSS_PATH ?>/plugins/wysiwyag/richtext.min.css" rel="stylesheet" type="text/css" />
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
        justify-content: flex-start;
        gap: 16px;
    }

    .row.align-center {
        align-items: center;
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
                            <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <form class="form form-content">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="cus-toggle mb-3">
                                                    <label class="form-label fw-bold mb-0">Status</label>
                                                    <div class="d-flex align-items-center">
                                                        <label class="cus-switch mb-0">
                                                            <input type="checkbox" name="missionStatus" id="missionStatus" value="1"
                                                                <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                            <span class="cus-slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden"
                                                            value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                                        <!-- Optional text next to switch -->
                                                        <!-- <span class="ms-2" id="statusText"><?= ($data['status'] == 1) ? 'Enabled (1)' : 'Disabled (0)' ?></span> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="col-md-12">-->
                                            <!--    <div class="row align-center">-->
                                                    <!-- Step 1 -->
                                            <!--        <div class="col-md-3">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Step 1 Title</label>-->
                                            <!--                <div class="input-group mb-3">-->
                                            <!--                    <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--        <div class="col-md-3">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Step 1 Count</label>-->
                                            <!--                <div class="input-group mb-3">-->
                                            <!--                    <input type="text" name="web_content_2" value="<?= $data['web_content_2'] ?>" class="form-control">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                                    <!-- Step 2 -->
                                            <!--        <div class="col-md-3">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Step 2 Title</label>-->
                                            <!--                <div class="input-group mb-3">-->
                                            <!--                    <input type="text" name="web_content_3" value="<?= $data['web_content_3'] ?>" class="form-control">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--        <div class="col-md-3">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Step 2 Count</label>-->
                                            <!--                <div class="input-group mb-3">-->
                                            <!--                    <input type="text" name="web_content_4" value="<?= $data['web_content_4'] ?>" class="form-control">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--    <div class="row align-center mt-2">-->
                                                    <!-- Step 3 -->
                                            <!--        <div class="col-md-3">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Step 3 Title</label>-->
                                            <!--                <div class="input-group mb-3">-->
                                            <!--                    <input type="text" name="web_content_5" value="<?= $data['web_content_5'] ?>" class="form-control">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--        <div class="col-md-3">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Step 3 Count</label>-->
                                            <!--                <div class="input-group mb-3">-->
                                            <!--                    <input type="text" name="web_content_6" value="<?= $data['web_content_6'] ?>" class="form-control">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                                    <!-- Step 4 -->
                                            <!--        <div class="col-md-3">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Step 4 Title</label>-->
                                            <!--                <div class="input-group mb-3">-->
                                            <!--                    <input type="text" name="web_content_7" value="<?= $data['web_content_7'] ?>" class="form-control">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--        <div class="col-md-3">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Step 4 Count</label>-->
                                            <!--                <div class="input-group mb-3">-->
                                            <!--                    <input type="text" name="web_content_8" value="<?= $data['web_content_8'] ?>" class="form-control">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                                <!-- Uncomment and adjust for image upload section if necessary -->
                                                <!--
                                            <!--    <div class="row align-center mt-4">-->
                                            <!--        <div class="col-md-6">-->
                                            <!--            <div class="form-group">-->
                                            <!--                <label class="form-label">Image </label>-->
                                            <!--                <div class="product-img text-start">-->
                                            <!--                    <div class="input-group">-->
                                            <!--                        <input type="file" name="web_image_1" class="form-control" accept=".jpg,.jpeg,.png">-->
                                            <!--                    </div>-->
                                            <!--                    <div id="photo-msg" class="text-danger"></div>-->
                                            <!--                    <img id="web_image" src="<?= $data['image'] ?? '' ?>" height="120" alt="">-->
                                            <!--                </div>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--    -->
                                            <!--</div>-->
<div class="col-md-12">
    <!-- All 8 Fields in One Row -->
    <div class="row align-center mb-3">
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label">Title 1</label>
                <div class="input-group">
                    <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control" placeholder="Years Combined Experience">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label">Count 1</label>
                <div class="input-group">
                    <input type="text" name="web_content_2" value="<?= $data['web_content_2'] ?>" class="form-control" placeholder="50+">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label">Title 2</label>
                <div class="input-group">
                    <input type="text" name="web_content_3" value="<?= $data['web_content_3'] ?>" class="form-control" placeholder="Client Satisfaction">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label">Count 2</label>
                <div class="input-group">
                    <input type="text" name="web_content_4" value="<?= $data['web_content_4'] ?>" class="form-control" placeholder="95%">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label">Title 3</label>
                <div class="input-group">
                    <input type="text" name="web_content_5" value="<?= $data['web_content_5'] ?>" class="form-control" placeholder="SMB Clients Served">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label">Count 3</label>
                <div class="input-group">
                    <input type="text" name="web_content_6" value="<?= $data['web_content_6'] ?>" class="form-control" placeholder="30+">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label">Title 4</label>
                <div class="input-group">
                    <input type="text" name="web_content_7" value="<?= $data['web_content_7'] ?>" class="form-control" placeholder="Projects Completed">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label">Count 4</label>
                <div class="input-group">
                    <input type="text" name="web_content_8" value="<?= $data['web_content_8'] ?>" class="form-control" placeholder="50+">
                </div>
            </div>
        </div>
    </div>
</div>


                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer text-end">
                                        <input type="hidden" name="web_content_id" value="<?= $data["web_content_id"] ?>">
                                        <button type="submit" class="btn btn-primary" fdprocessedid="7025s8j">
                                            <i class="ti-save-alt"></i> Save
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
        <!-- /.content-wrapper -->
        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= CSS_PATH ?>/plugins/wysiwyag/jquery.richtext.js"></script>
        <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>
        <script>
            $('textarea[name=web_content_2]').richText();
            $('textarea[name=web_content_3]').richText();
            // Image
            function handleImageInputChange(inputSelector, imgSelector, errorSelector) {
                $(inputSelector).on("change", function(event) {
                    const file = event.target.files[0];
                    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                    const errorMsg = $(errorSelector);
                    if (file) {
                        if (!allowedExtensions.test(file.name)) {
                            errorMsg.text("Invalid file type! Only jpg, jpeg, and png are allowed.");
                            $(imgSelector).attr("src", "");
                            return;
                        }
                        // Clear error message and show preview
                        errorMsg.text("");
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $(imgSelector).attr("src", e.target.result);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        $(imgSelector).attr("src", "");
                        errorMsg.text("");
                    }
                });
            }
            // Correct Mappings
            handleImageInputChange("input[name=web_image_1]", "#web_logo_1", "#logo-photo-msg-1");
            handleImageInputChange("input[name=web_image_2]", "#web_logo_2", "#logo-photo-msg-2");
            handleImageInputChange("input[name=web_image_3]", "#web_logo_3", "#logo-photo-msg-3");
        </script>
        <script>
            const missionStatus = document.getElementById('missionStatus');
            const missionStatusHidden = document.getElementById('missionStatusHidden');
            const statusText = document.getElementById('statusText');

            function updateStatusText() {
                if (missionStatus.checked) {
                    missionStatusHidden.value = '1';
                    if (statusText) statusText.textContent = 'Enabled (1)';
                } else {
                    missionStatusHidden.value = '0';
                    if (statusText) statusText.textContent = 'Disabled (0)';
                }
            }

            missionStatus.addEventListener('change', updateStatusText);
            updateStatusText();
        </script>
    </div>
</body>
</html>