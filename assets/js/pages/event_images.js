var table_column = [
    { data: "serial_no", title: "S.No", width: "40px" },
    { data: "web_title", title: "Title", width: "150px" },
    {
        data: "image_url",
        title: "Image",
        render: d => `<img src="${d}" width="80">`
    },
    { data: "display_order", title: "Order", width: "60px" },
    {
        data: "is_active",
        title: "Status",
        render: function(d, type, row) {
            return `
            <label class="cus-switch">
                <input type="checkbox"
                    ${d == 1 ? 'checked' : ''}
                    class="img_status"
                    data-id="${row.image_id}">
                <span class="cus-slider round"></span>
            </label>`;
        }
    },   
    {
        data: "image_id",
        title: "Action",
        render: id => `
        <button data-id="${id}" class="btn btn-danger-light btn-sm del-img">
            Delete
        </button>`
    }
];

var dt = {
    table: "#event_image_table",
    column: table_column,
    url: "getEventImages",
    data_src: {
        web_event_id: $("#web_event_id").val()
    }
};

var k = common.dataTable(dt);

// ADD
$(".add-image").on("click", () => {
     $(".image-form")[0].reset();
    let result = common.ajax_fech("getEventImages", {
        web_event_id: $("#web_event_id").val()
    });

    let last_count = result.last_count + 1;
    $("#order_count").text(last_count);
    $(".image-form input[name=display_order]")
        .data("last_count", last_count)
        .val(last_count);

    $("#image-modal").modal("show");
});

// SAVE
$(".image-form").on("submit", function (e) {
    e.preventDefault();
    let fd = new FormData(this);
    fd.append("for", "edit");

    common.ajax_save_file("saveEventImage", fd)
        .then(() => {
            reloadDataTable(k);
            $("#image-modal").modal("hide");
            Swal2("success", "Success", "What we offer image added successfully");
        });
});

// DELETE
$(document).on("click", ".del-img", function () {
    common.ajax_save("saveEventImage", {
        image_id: $(this).data("id"),
        for: "delete",
        is_deleted: 1
    }).then(() => reloadDataTable(k));
});

$(document).on("change", ".img_status", function () {

    let id = $(this).data("id");
    let status = $(this).prop("checked") ? 1 : 0;

    common.ajax_save("saveEventImage", {
        image_id: id,
        is_active: status,
        for: "status"
    })
    .then(() => {
        reloadDataTable(k);
        Swal2("success", "Success", "What we offer image status updated");
    });
});

$('.image-form input[name=display_order]').on('input', function () {
    let val = $(this).val().replace(/\D/g, '');
    let last_count = Number($(this).data('last_count'));
    if (isNaN(last_count) || last_count < 1) last_count = 1;

    val = parseInt(val, 10);

    if (isNaN(val) || val < 1) {
        val = '';
    } else if (val > last_count) {
        val = last_count;
    }
    $(this).val(val);
});
