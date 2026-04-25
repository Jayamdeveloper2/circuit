<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
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

    .cus-switch input:checked+.cus-slider {
        background-color: #2196F3;
    }

    .cus-switch input:checked+.cus-slider:before {
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
        <!-- Left side column. contains the logo and sidebar -->



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h3 class="page-title"> <?= $breadcrumb ?? "" ?></h3>

                        </div>
                        <div>

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


                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-end align-items-center">
                                                        <label class="cus-switch mb-0">
                                                            <input type="checkbox" id="missionStatus"
                                                                <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                            <span class="cus-slider round"></span>
                                                        </label>

                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden"
                                                            value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Content</label>
                                                    <div class="input-group mb-3">
                                                        <textarea type="text" class="form-control" rows="5" name="web_content_1"><?= $data['web_content_1'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Content</label>
                                                    <div class="input-group mb-3">
                                                        <textarea type="text" class="form-control" rows="5" name="web_content_2"><?= $data['web_content_2'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Content</label>
                                                    <div class="input-group mb-3">
                                                        <textarea type="text" class="form-control" rows="5" name="web_content_3"><?= $data['web_content_3'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>


                            <!-- /.box-body -->
                            <div class="box-footer text-end">
                                <input type="hidden" name="web_content_id" value="<?= $data['web_content_id'] ?>">
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
    <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>
    <script src="<?= CSS_PATH ?>/plugins/wysiwyag/jquery.richtext.js"></script>
    <script>
        // $('textarea[name=web_content_1]').richText();
        // $('textarea[name=web_content_2]').richText();
        // $('textarea[name=web_content_3]').richText();

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
    </script>
    <!-- Toggle Script -->
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
</body>

</html>