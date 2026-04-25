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
    .founder-image{
        text-align: center;
    font-size: smaller;
    padding: 8px;
    color: #8f8e8e;
    }
</style>
    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">

        <div class="wrapper">
            <div id="loader"></div>

            <?php include APPPATH . "/Views/admin/common/top.php"; ?>
            <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>
            <!-- Left side column. contains the logo and sidebar -->

            <style>

                .avator-container {
                    max-width: 960px;
                    margin: 0 auto;
                    padding: 0;
                }

                .avatar-upload {
                    position: relative;
                    max-width: 205px;
                    margin: 0 auto;
                }
                .avatar-upload .avatar-edit {
                    position: absolute;
                    right: 12px;
                    z-index: 1;
                    top: 10px;
                }
                .avatar-upload .avatar-edit input {
                    display: none;
                }
                .avatar-upload .avatar-edit input + label {
                    display: inline-block;
                    width: 34px;
                    height: 34px;
                    margin-bottom: 0;
                    border-radius: 100%;
                    background: #ffeae5;
                    border: 1px solid transparent;
                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                    cursor: pointer;
                    font-weight: normal;
                    transition: all 0.2s ease-in-out;
                }
                .avatar-upload .avatar-edit input + label:hover {
                    background: #f1f1f1;
                    border-color: #d6d6d6;
                }
                .avatar-upload .avatar-edit input + label:after {
                    content: "\f303"; /* fa-pencil */
                    font-family: "Font Awesome 5 Free";
                    font-weight: 900; /* Solid icons need this */
                    color: #ff562f;
                    position: absolute;
                    top: 5px;
                    left: 0;
                    right: 0;
                    font-size: 16px;
                    text-align: center;
                    margin: auto;
                }
                .avatar-upload .avatar-preview {
                    width: 192px;
                    height: 192px;
                    position: relative;
                    /* Square or rectangular, so remove border-radius or set to a small value */
                    border-radius: 8px;
                    border: 6px solid #0052cc3d;
                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
                }
                .avatar-upload .avatar-preview > div {
                    width: 100%;
                    height: 100%;
                    border-radius: 8px;
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                }

            </style>


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

                                                <div class="col-4">
                                                    <div class="col-12">
                                                        <div class="avator-container">
                                                            <div class="avatar-upload">
                                                                <div class="avatar-edit">
                                                                    <input type='file' id="imageUpload" name="web_image_1" accept=".png, .jpg, .jpeg" />
                                                                    <label for="imageUpload"></label>
                                                                   
                                                                </div>
                                                                
                                                                <div class="avatar-preview">
                                                                    <div id="imagePreview" style="background-image: url(<?=$data['image']??''?>);">
                                                                    </div>
                                                                </div><p class=founder-image> (530px X 516px)</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Founder Name</label>
                                                            <div class="input-group mb-3">                                                           
                                                                <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control"  >
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Founder Position</label>
                                                            <div class="input-group mb-3">                                                           
                                                                <input type="text" name="web_content_2" value="<?= $data['web_content_2'] ?>" class="form-control"  >
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
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
                                                
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">LinkedIn</label>
                                                            <div class="input-group mb-3">                                                           
                                                                <input type="text" name="web_content_3" value="<?= $data['web_content_3'] ?>" class="form-control"  >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-md-12">-->
                                                    <!--    <div class="form-group">-->
                                                    <!--        <label class="form-label">linked in</label>-->
                                                    <!--        <div class="input-group mb-3">                                                           -->
                                                    <!--            <input type="text" name="web_content_5" value="<?= $data['web_content_5'] ?>" class="form-control"  >-->
                                                    <!--        </div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Content</label>
                                                            <div class="input-group mb-3">                                                          
                                                                <textarea type="text" class="form-control" rows="20"  name="web_content_4"><?= $data['web_content_4'] ?></textarea>
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
                $('textarea[name=web_content_4]').richText();
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                            $('#imagePreview').hide();
                            $('#imagePreview').fadeIn(650);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("#imageUpload").change(function () {
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