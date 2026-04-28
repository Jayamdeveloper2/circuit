$(document).ready(function () {
    let lastCount = 0;

    const table = $('#anchorTable').DataTable({
        ajax: {
            url: "getPERIAnchors",
            type: "POST",
            dataSrc: function(json) {
                lastCount = parseInt(json.last_count) || 0;
                return json.data;
            },
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") }
        },
        columns: [
            { data: "serial_no" },
            { data: "title" },
            { 
                data: "description", 
                render: (data) => `<span class="text-muted small">${data.substring(0, 40)}...</span>` 
            },
            { 
                data: "anchor_link", 
                render: (data) => `<code class="small text-primary">${data}</code>` 
            },
            { data: "display_order" },
            {
                data: "web_peri_anchor_id",
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
        $('.anchor-form')[0].reset();
        $('[name="web_peri_anchor_id"]').val(0);
        $('[name="display_order"]').val(lastCount + 1);
        $('#anchorModal').modal('show');
    });

    // Edit button
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        $.ajax({
            url: "getPERIAnchors",
            type: "POST",
            data: { web_peri_anchor_id: id },
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    const d = res.data;
                    const form = $('.anchor-form');
                    form.find('[name="web_peri_anchor_id"]').val(d.web_peri_anchor_id);
                    form.find('[name="title"]').val(d.title);
                    form.find('[name="description"]').val(d.description);
                    form.find('[name="anchor_link"]').val(d.anchor_link);
                    form.find('[name="anchor_text"]').val(d.anchor_text);
                    form.find('[name="display_order"]').val(d.display_order);
                    $('#anchorModal').modal('show');
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    // Submit form
    $('.anchor-form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('for', 'edit');

        $.ajax({
            url: "savePERIAnchors",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    $('#anchorModal').modal('hide');
                    table.ajax.reload();
                    Swal2("success", "Success", "Anchor card saved successfully");
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    // Toggle status
    $(document).on('change', '.status-toggle', function () {
        const id = $(this).data('id');
        const status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: "savePERIAnchors",
            type: "POST",
            data: { web_peri_anchor_id: id, is_active: status, for: 'status' },
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    // Delete
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this card?')) {
            $.ajax({
                url: "savePERIAnchors",
                type: "POST",
                data: { web_peri_anchor_id: id, for: 'delete' },
                headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
                success: function (res) {
                    if (res.status == 'success') {
                        table.ajax.reload();
                        Swal2("success", "Deleted", "Card removed");
                    }
                    if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
                }
            });
        }
    });
});
