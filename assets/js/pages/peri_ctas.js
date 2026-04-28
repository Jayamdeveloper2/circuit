$(document).ready(function () {
    let lastCount = 0;

    const table = $('#ctaTable').DataTable({
        ajax: {
            url: "getPERICTAs",
            type: "POST",
            dataSrc: function(json) {
                lastCount = parseInt(json.last_count) || 0;
                return json.data;
            },
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") }
        },
        columns: [
            { data: "serial_no" },
            { 
                data: "icon",
                render: (data) => `<i class="fa-solid ${data} fa-2x"></i>`
            },
            { data: "title" },
            { 
                data: "description", 
                render: (data) => `<span class="text-muted small">${data.length > 50 ? data.substring(0, 50) + '...' : data}</span>` 
            },
            { data: "display_order" },
            {
                data: "web_peri_cta_id",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-info edit-btn" data-id="${data}" style="border-radius: 4px; padding: 4px 8px; background-color: #0d8cf0; border-color: #0d8cf0;"><i class="fa fa-edit text-white"></i></button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}" style="border-radius: 4px; padding: 4px 8px; background-color: #ff0000; border-color: #ff0000;"><i class="fa fa-trash text-white"></i></button>
                    `;
                }
            }
        ],
        drawCallback: function(settings) {
            if(settings.json && settings.json.csrf_hash) {
                $('meta[name="csrf-token-hash"]').attr("content", settings.json.csrf_hash);
            }
        }
    });

    // Add button
    $('.add-btn').on('click', function () {
        $('.cta-form')[0].reset();
        $('[name="web_peri_cta_id"]').val(0);
        $('[name="display_order"]').val(lastCount + 1);
        $('.theme-color-select').val('var(--blue)').trigger('change');
        $('.link-select').val('contact.php?subject=PERI Training Inquiry').trigger('change');
        $('#ctaModal').modal('show');
    });

    // Theme Color Sync
    $('.theme-color-select').on('change', function() {
        const val = $(this).val();
        const input = $('[name="theme_color"]');
        if (val === 'other') {
            input.removeClass('d-none').val('').focus();
        } else {
            input.addClass('d-none').val(val);
        }
    });

    // Link Sync
    $('.link-select').on('change', function() {
        const val = $(this).val();
        const input = $('[name="link"]');
        if (val === 'other') {
            input.removeClass('d-none').val('').focus();
        } else {
            input.addClass('d-none').val(val);
        }
    });

    // Edit button
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        $.ajax({
            url: "getPERICTAs",
            type: "POST",
            data: { web_peri_cta_id: id },
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    const d = res.data;
                    const form = $('.cta-form');
                    form.find('[name="web_peri_cta_id"]').val(d.web_peri_cta_id);
                    form.find('[name="title"]').val(d.title);
                    form.find('[name="description"]').val(d.description);
                    form.find('[name="icon"]').val(d.icon);
                    
                    // Set Theme Color
                    const select = $('.theme-color-select');
                    const input = form.find('[name="theme_color"]');
                    input.val(d.theme_color);
                    
                    if (select.find(`option[value="${d.theme_color}"]`).length > 0) {
                        select.val(d.theme_color);
                        input.addClass('d-none');
                    } else {
                        select.val('other');
                        input.removeClass('d-none');
                    }

                    // Set Link
                    const lSelect = $('.link-select');
                    const lInput = form.find('[name="link"]');
                    lInput.val(d.link);
                    
                    if (lSelect.find(`option[value="${d.link}"]`).length > 0) {
                        lSelect.val(d.link);
                        lInput.addClass('d-none');
                    } else {
                        lSelect.val('other');
                        lInput.removeClass('d-none');
                    }

                    form.find('[name="link_text"]').val(d.link_text);
                    form.find('[name="display_order"]').val(d.display_order);
                    form.find('[name="is_active"]').val(d.is_active);
                    $('#ctaModal').modal('show');
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    // Submit form
    $('.cta-form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('for', 'edit');

        $.ajax({
            url: "savePERICTAs",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    $('#ctaModal').modal('hide');
                    table.ajax.reload();
                    if(typeof Swal2 === 'function') {
                        Swal2("success", "Success", "Action card saved successfully");
                    } else if (typeof Swal === 'function') {
                        Swal.fire("Success", "Action card saved successfully", "success");
                    } else {
                        alert("Action card saved successfully");
                    }
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    // Delete
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this card?')) {
            $.ajax({
                url: "savePERICTAs",
                type: "POST",
                data: { web_peri_cta_id: id, for: 'delete' },
                headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
                success: function (res) {
                    if (res.status == 'success') {
                        table.ajax.reload();
                        if(typeof Swal2 === 'function') {
                            Swal2("success", "Deleted", "Card removed");
                        } else if (typeof Swal === 'function') {
                            Swal.fire("Deleted", "Card removed", "success");
                        } else {
                            alert("Card removed");
                        }
                    }
                    if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
                }
            });
        }
    });
});
