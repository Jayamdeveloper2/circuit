<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
<style>
    .ck-editor__editable {
        min-height: 300px;
    }

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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h3 class="page-title"> <?= $breadcrumb ?? "" ?></h3>

                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                <h3 class="page-title"><?= isset($title) ? $title : "" ?></h3>
                            </div>
                            <div>
                                <button data-pid="-1" class="btn btn-primary edit-blog">
                                    <i class="fi fi-br-plus"></i> Add <?= isset($title) ? $title : "" ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">

                            <div class="col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="cus-toggle mb-3">
                                                <label class="form-label mb-0">Page Status</label>
                                                <label class="cus-switch">
                                                    <input type="checkbox" id="public_function_manageid" data-section="26" <?= (isset($blogdatamaster['status']) && $blogdatamaster['status'] == 1) ? 'checked' : '' ?>>

                                                    <span class="cus-slider"></span>
                                                </label>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="blog_table" class="text-fade table table-bordered display"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="blog-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                                    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-sm model_vs">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><span class="modal-name">Add</span>
                                                    <?= isset($title) ? $title : "" ?></h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form data-validate class="overflow-auto blog-form">
                                                <div class="modal-body">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Title</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="web_title" placeholder=""
                                                                            class="form-control" required=""
                                                                            data-validation-required-message="This field is required"
                                                                            aria-invalid="false">
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Category</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="web_cate_name" placeholder=""
                                                                            class="form-control" required=""
                                                                            data-validation-required-message="This field is required"
                                                                            aria-invalid="false">
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Author Name</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="web_arthur_name" placeholder=""
                                                                            class="form-control" required=""
                                                                            data-validation-required-message="This field is required"
                                                                            aria-invalid="false">
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Post Date</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="web_time" placeholder=""
                                                                            class="form-control" required=""
                                                                            data-validation-required-message="This field is required"
                                                                            aria-invalid="false">
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Description</label>
                                                                    <div class="input-group mb-3">
                                                                        <textarea class="form-control text-counter"
                                                                            name="web_desc" maxlength="200"
                                                                            rows="3"></textarea>
                                                                    </div>
                                                                    <div class="count-info"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Content</label>
                                                                    <div class="input-group mb-3">
                                                                        <textarea id="editor" class="form-control"
                                                                            name="web_content" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label class="form-label">Image</label>
                                                                    <div class="product-img text-start">
                                                                        <div class="input-group">
                                                                            <input type="file" name="web_image"
                                                                                class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif">
                                                                        </div>
                                                                        <div id="photo-msg" class="text-danger"></div>
                                                                        <img id="web_image" src="" height="120" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <h3 class="text-center text-primary">User Message</h3>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Client Name</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="web_client_name" placeholder=""
                                                                            class="form-control" required=""
                                                                            data-validation-required-message="This field is required"
                                                                            aria-invalid="false">
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Description</label>
                                                                    <div class="input-group mb-3">
                                                                        <textarea class="form-control text-counter"
                                                                            name="web_client_desc" maxlength="200"
                                                                            rows="3"></textarea>
                                                                    </div>
                                                                    <div class="count-info"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label class="form-label">User Image</label>
                                                                    <div class="product-img text-start">
                                                                        <div class="input-group">
                                                                            <input type="file" name="web_client_image"
                                                                                class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif">
                                                                        </div>
                                                                        <div id="photo-client-msg" class="text-danger"></div>
                                                                        <img id="web_client_image" src="" height="120" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label class="form-label">
                                                                        Meta Title
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="meta_title" placeholder=""
                                                                            class="form-control"

                                                                            aria-invalid="false">
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                </div>

                                                            </div>


                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label class="form-label">
                                                                        Meta Description
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <textarea type="text" name="meta_desc" placeholder=""
                                                                            class="form-control" rows="3"
                                                                            data-validation-required-message="This field is required"></textarea>
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                </div>

                                                            </div>


                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label class="form-label">
                                                                        Meta Keywords
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <textarea type="text" name="meta_key" placeholder=""
                                                                            class="form-control" rows="3"
                                                                            data-validation-required-message="This field is required"
                                                                            aria-invalid="false"></textarea>
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                </div>

                                                            </div>


                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label class="form-label">Display Order</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="display_order" placeholder=""
                                                                            class="form-control" required=""
                                                                            data-validation-required-message="This field is required"
                                                                            aria-invalid="false">
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                    <div class="count-info text-start fs-6">Last Order <span id="order_count"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer modal-footer-uniform w-100">
                                                    <input type="hidden" name="web_blog_id" value="-1">
                                                    <button type="button" class="btn btn-primary-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
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
            <script src="<?= CSS_PATH ?>/js/pages/blog.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>
                flatpickr("input[name=web_time]", {
                    enableTime: false,
                    dateFormat: "d/m/Y",
                    time_24hr: false
                });
                // Make sure editor content is properly submitted with the form
                document.querySelector('.blog-form').addEventListener('submit', function() {
                    const editorData = editor.getData();
                    document.querySelector('textarea[name="web_content"]').value = editorData;
                    // Clean up deleted images on form submission
                    cleanUpDeletedImages();
                });
                // If editing existing content, set the editor data when modal opens
                $(document).on('click', '.edit-blog', function() {
                    setTimeout(() => {
                        if (editor) {
                            const content = $('textarea[name="web_content"]').val();
                            editor.setData(content);
                            // Initialize uploaded images from existing content
                            updateUploadedImages(content);
                        }
                    }, 500);
                });
            </script>
            <script>
                // Array to track uploaded image URLs
                let uploadedImages = [];

                // Function to extract image URLs from editor content
                function getImageUrlsFromContent(content) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(content, 'text/html');
                    const images = doc.querySelectorAll('img');
                    return Array.from(images).map(img => img.src);
                }

                // Function to update uploadedImages array
                function updateUploadedImages(content) {
                    uploadedImages = getImageUrlsFromContent(content);
                }

                // Function to delete an image via AJAX
                function deleteImage(imageUrl) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '<?php echo base_url('manage-agri/delete-blog-content-image'); ?>', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                console.log('Image deleted:', imageUrl);
                            } else {
                                console.error('Failed to delete image:', imageUrl, xhr.status, xhr.responseText);
                            }
                        }
                    };
                    xhr.send(JSON.stringify({
                        url: imageUrl
                    }));
                }

                // Function to clean up deleted images
                function cleanUpDeletedImages() {
                    const currentContent = editor.getData();
                    const currentImages = getImageUrlsFromContent(currentContent);
                    const deletedImages = uploadedImages.filter(url => !currentImages.includes(url));
                    deletedImages.forEach(url => {
                        deleteImage(url);
                        uploadedImages = uploadedImages.filter(u => u !== url);
                    });
                }

                class MyUploadAdapter {
                    constructor(loader) {
                        this.loader = loader;
                    }
                    upload() {
                        return this.loader.file.then(file => new Promise((resolve, reject) => {
                            this._initRequest();
                            this._initListeners(resolve, reject, file);
                            this._sendRequest(file);
                        }));
                    }
                    abort() {
                        if (this.xhr) {
                            this.xhr.abort();
                        }
                    }
                    _initRequest() {
                        const xhr = this.xhr = new XMLHttpRequest();
                        xhr.open('POST', '<?php echo base_url('manage-agri/upload-blog-content-image'); ?>', true);
                        xhr.responseType = 'json';
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    }
                    _initListeners(resolve, reject, file) {
                        const xhr = this.xhr;
                        const loader = this.loader;
                        const genericErrorText = `Unable to upload file: ${file.name}.`;
                        xhr.addEventListener('error', () => {
                            console.error('Upload error:', xhr.status, xhr.statusText);
                            reject(genericErrorText);
                        });
                        xhr.addEventListener('abort', () => reject());
                        xhr.addEventListener('load', () => {
                            const response = xhr.response;
                            console.log('Server response:', response);
                            if (!response || response.error || !response.url) {
                                return reject(response && response.error ? response.error.message : genericErrorText);
                            }
                            // Add uploaded image to tracking array
                            uploadedImages.push(response.url);
                            resolve({
                                default: response.url
                            });
                        });
                        if (xhr.upload) {
                            xhr.upload.addEventListener('progress', evt => {
                                if (evt.lengthComputable) {
                                    loader.uploadTotal = evt.total;
                                    loader.uploaded = evt.loaded;
                                }
                            });
                        }
                    }
                    _sendRequest(file) {
                        const data = new FormData();
                        data.append('upload', file);
                        // Remove CSRF if disabled in CodeIgniter
                        // data.append('<?php echo csrf_token(); ?>', '<?php echo csrf_hash(); ?>');
                        this.xhr.send(data);
                    }
                }

                function MyCustomUploadAdapterPlugin(editor) {
                    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                        return new MyUploadAdapter(loader);
                    };
                }
                ClassicEditor
                    .create(document.querySelector('#editor'), {
                        extraPlugins: [MyCustomUploadAdapterPlugin],
                        image: {
                            toolbar: [
                                'imageTextAlternative',
                                'imageStyle:inline',
                                'imageStyle:block',
                                'imageStyle:side',
                                'imageStyle:alignLeft',
                                'imageStyle:full',
                                'imageStyle:alignRight',
                                '|',
                                'imageTextAlternative'
                            ]
                        },
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'link', '|',
                            'bulletedList', 'numberedList', '|',
                            'imageUpload', 'blockQuote', '|',
                            'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        window.editor = editor;
                        const hiddenInput = document.querySelector('#editor');
                        editor.model.document.on('change:data', () => {
                            hiddenInput.value = editor.getData();
                            // Check for deleted images on content change
                            cleanUpDeletedImages();
                        });
                    })
                    .catch(error => {
                        console.error('Editor initialization failed:', error);
                    });
            </script>
</body>

</html>