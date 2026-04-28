$(function () {
    "use strict";

    let table = $('#domainTable').DataTable({
        "ajax": {
            "url": "api/getDomainServices",
            "type": "POST",
            "dataSrc": "data",
            "headers": { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") }
        },
        "columns": [
            { "data": "serial_no" },
            {
                "data": "image",
                "render": function (data) {
                    if (data) {
                        return `<img src="${main_url}assets/img/${data}" style="height: 40px; border-radius: 4px;">`;
                    }
                    return '<span class="text-muted">No Image</span>';
                }
            },
            { "data": "title_eb" },
            { "data": "section_anchor" },
            { "data": "display_order" },
            {
                "data": null,
                "render": function (data) {
                    let checked = data.is_active == 1 ? 'checked' : '';
                    return `<label class="cus-switch">
                                <input type="checkbox" onchange="toggleStatus(${data.web_service_details_id}, this.checked)" ${checked}>
                                <span class="cus-slider"></span>
                            </label>`;
                }
            },
            {
                "data": null,
                "render": function (data) {
                    return `<button class="btn btn-sm btn-info edit-btn" onclick="editSection(${data.web_service_details_id})" style="border-radius: 4px; padding: 4px 8px; background-color: #0d8cf0; border-color: #0d8cf0;"><i class="fa fa-edit text-white"></i></button>
                            <button class="btn btn-sm btn-danger delete-btn" onclick="deleteSection(${data.web_service_details_id})" style="border-radius: 4px; padding: 4px 8px; background-color: #ff0000; border-color: #ff0000;"><i class="fa fa-trash text-white"></i></button>`;
                }
            }
        ],
        "order": [[4, 'asc']],
        "drawCallback": function(settings) {
            if(settings.json && settings.json.csrf_hash) {
                $('meta[name="csrf-token-hash"]').attr("content", settings.json.csrf_hash);
            }
        }
    });

    // Add Section Button
    $('.add-btn').on('click', function () {
        $('#domainForm')[0].reset();
        $('input[name="web_service_details_id"]').val(0);
        $('#whatWeDesignList, #deliverablesList, #technologiesList').empty();
        $('#svcImgPreview').addClass('d-none');
        $('#domainModal').modal('show');
    });

    // Hero Form Submit
    $('#heroForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('status', $('#heroStatus').is(':checked') ? 1 : 0);
        
        $.ajax({
            url: "api/saveDomainHero",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    Swal2('success', 'Success', 'Successfully Saved');
                } else {
                    Swal2('error', 'Failed', res.message);
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    // Domain Form Submit
    $('#domainForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            url: "api/saveDomainServices",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    $('#domainModal').modal('hide');
                    table.ajax.reload();
                    Swal2('success', 'Success', 'Successfully Saved');
                } else {
                    Swal2('error', 'Failed', res.message);
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    window.addListItem = function (containerId, inputName, value = '') {
        $(`#${containerId}`).append(`
            <div class="dynamic-list-item">
                <input type="text" name="${inputName}" class="form-control" value="${value}" required>
                <button type="button" class="btn btn-sm btn-danger-light" onclick="$(this).parent().remove()"><i class="fa fa-times"></i></button>
            </div>
        `);
    };

    window.editSection = function (id) {
        $.ajax({
            url: "api/getDomainServices",
            type: "POST",
            data: { web_service_details_id: id },
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    let data = res.data;
                    $('input[name="web_service_details_id"]').val(data.web_service_details_id);
                    $('input[name="section_anchor"]').val(data.section_anchor);
                    $('input[name="title_eb"]').val(data.title_eb);
                    $('input[name="heading"]').val(data.heading);
                    $('textarea[name="description"]').val(data.description);
                    $('input[name="theme_color"]').val(data.theme_color);
                    $('input[name="display_order"]').val(data.display_order);
                    
                    if (data.image) {
                        $('#svcImgPreview').attr('src', main_url + 'assets/img/' + data.image).removeClass('d-none');
                    } else {
                        $('#svcImgPreview').addClass('d-none');
                    }

                    $('#whatWeDesignList, #deliverablesList, #technologiesList').empty();
                    data.what_we_design.forEach(item => addListItem('whatWeDesignList', 'what_we_design[]', item));
                    data.deliverables.forEach(item => addListItem('deliverablesList', 'deliverables[]', item));
                    data.technologies.forEach(item => addListItem('technologiesList', 'technologies[]', item));

                    $('#domainModal').modal('show');
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    };

    window.deleteSection = function (id) {
        if (confirm('Are you sure you want to delete this section?')) {
            $.ajax({
                url: "api/saveDomainServices",
                type: "POST",
                data: { for: 'delete', web_service_details_id: id },
                headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
                success: function (res) {
                    if (res.status == 'success') {
                        table.ajax.reload();
                        Swal2('success', 'Deleted', 'Successfully Deleted');
                    }
                    if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
                }
            });
        }
    };

    window.toggleStatus = function (id, status) {
        $.ajax({
            url: "api/saveDomainServices",
            type: "POST",
            data: { for: 'status', web_service_details_id: id, is_active: status ? 1 : 0 },
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    Swal2('success', 'Success', 'Status Updated');
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    };


    window.previewSvc = function (input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#svcImgPreview').attr('src', e.target.result).removeClass('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    };
});
