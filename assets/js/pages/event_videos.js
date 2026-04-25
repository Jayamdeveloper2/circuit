var table_column = [
    { data: "serial_no", title: "S.No", width: "40px" },
    { data: "video_title", title: "Title", width: "200px" },
    {
        data: "video_url",
        title: "Icon",
        width: "150px",
        render: d => `<i class="${d} fs-4 text-primary"></i> <span class="ms-2">${d}</span>`
    },
    { data: "display_order", title: "Order", width: "50px" },
    {
        data: "video_id",
        title: "Action",
        width: "100px",
        render: id => `
            <button data-id="${id}" class="btn btn-danger-light btn-sm del-video">
                Delete
            </button>`
    }
];

var dt = {
    table: "#event_video_table",
    column: table_column,
    url: "getEventVideos",
    data_src: {
        web_event_id: $("#web_event_id").val()
    }
};

var k = common.dataTable(dt);

// ADD
$(".add-video").on("click", () => {
    $(".video-form")[0].reset();
    let result = common.ajax_fech("getEventVideos", {
        web_event_id: $("#web_event_id").val()
    });

    let last_count = result.last_count + 1;
    $("#order_count").text(last_count);
    $(".video-form input[name=display_order]")
        .data("last_count", last_count)
        .val(last_count);

    $("#video-modal").modal("show");
});

// SAVE
$(".video-form").on("submit", function (e) {
    e.preventDefault();

    let data = $(this).serializeArray();
    data.push({ name: "for", value: "edit" });

    common.ajax_save("saveEventVideo", data)
        .then(() => {
            reloadDataTable(k);
            $("#video-modal").modal("hide");
            Swal2("success", "Success", "Industrial application icon added successfully");
        });
});


// DELETE
$(document).on("click", ".del-video", function () {
    common.ajax_save("saveEventVideo", {
        video_id: $(this).data("id"),
        for: "delete",
        is_deleted: 1
    }).then(() => reloadDataTable(k));
});

$('.video-form input[name=display_order]').on('input', function () {
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
