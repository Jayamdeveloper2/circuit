var table_column = [
    {
        data: "serial_no",
        title: "S.No",
        is_default: true,
        dt: true,
        width: "30px",
    },
    {
        data: "web_title",
        title: "Title",
        is_default: true,
        dt: true,
        width: "250px",
    },

    {
        data: "web_name",
        title: "Desc",
        is_default: true,
        dt: true,
        width: "250px",
    },

    {
        data: "display_order",
        title: "Display Order",
        is_default: true,
        dt: true,
        width: "70px",
    },

    {
        data: "is_active",
        width: "50px",
        className: "text-center",
        title: "Status",
        is_default: false,
        dt: true,
        render: function (data, type, row) {
            return `
          <div class="cus-toggle">
            <label>Inactive</label>
            <label class="cus-switch">
              <input type="checkbox" ${data == 1 ? "checked" : ""} data-pid="${
                    row["web_video_id"]
                    }" class="video_status" >
              <span class="cus-slider round"></span>
            </label>
            <label>Active</label>
          </div>`;
        },
    },
    {
        data: "web_video_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
      <button data-pid="${row["web_video_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-video" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
          <button data-pid="${row["web_video_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-video " type="button" ><i class="fi fi-sr-trash"></i> Delete</button>
      `;
        },
    },
];

var dt = {
    table: "#video_table",
    column: table_column,
    url: "getVideo",
};

var k = common.dataTable(dt);


// Add and Edit
$(document).on("click", ".edit-video", function () {
    var vbk = "show";
    $(".video-form")[0].reset();
    var pid = $(this).data("pid");
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".video-form input[name=web_video_id]").val(pid);
    var result = common.ajax_fech("getVideo", {web_video_id: pid});
    let last_count = (pid > 0) ? Number(result["last_count"]) : (Number(result["last_count"]) + 1);
    $("#order_count").text(last_count);
    $(".video-form input[name=display_order]").data('last_count', last_count).val(last_count);

    if (pid > 0) {
        if (result["code"] == 200 && result["data"].length != 0) {
            $(".video-form input[name=web_video_id]").val(
                    result["data"][0]["web_video_id"]
                    );

            $(".video-form input[name=display_order]").val(
                    result["data"][0]["display_order"]
                    );

            $(".video-form input[name=web_title]").val(
                    result["data"][0]["web_title"]
                    );

            $(".video-form input[name=web_name]").val(
                    result["data"][0]["web_name"]
                    );


            $(".video-form input[name=web_url]").val(
                    result["data"][0]["web_url"]
                    );

        } else {
            vbk = "hide";
            Swal2("error", "Something Error", "Try Some again time");
        }
    }
    $("#video-modal").modal(vbk);
});

// From Submit
$(".video-form").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission
    // Submit the form via AJAX if validation passes
    const formData = new FormData(this);
    formData.append("for", "edit");
    common
            .ajax_save_file("saveVideo", formData)
            .then(function (response) {
                if (response.code == 200) {
                    reloadDataTable(k);
                    Swal2("success", "Success", "Successfully User Saved").then(() => {
                        $("#video-modal").modal("hide");
                    });
                } else {
                    Swal2("error", "Something Error", response.message);
                }
            })
            .catch(function (error) {
                reloadDataTable(k);
                Swal2("error", "Something Error", "Try Some again time");
            });
});

// Delete
$(document).on("click", ".del-video", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_video_id: pid,
        is_deleted: 1,
        for : "delete",
    };

    swal
            .fire({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#fec801",
                confirmButtonText: "Yes, delete it!",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    common
                            .ajax_save("saveVideo", update_data)
                            .then(function (response) {
                                if (response.code == 200) {
                                    reloadDataTable(k, true);
                                    Swal2("success", "Deleted!", "Successfully deleted");
                                } else {
                                    Swal2("error", "Something Error", response.message);
                                }
                            })
                            .catch(function (error) {
                                reloadDataTable(k);
                                console.error("Error:", error);
                                Swal2("error", "Something Error", "Try Some again time");
                            });
                }
            });
});

//status update
$(document).on("change", ".video_status", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_video_id: pid,
        for : "status",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common
            .ajax_save("saveVideo", update_data)
            .then(function (response) {
                reloadDataTable(k);
                if (response.code == 200) {
                    Swal2("success", "Success", "Successfully Status Updated");
                } else {
                    Swal2("error", "Failed", "Please Try Again");
                }
            })
            .catch(function (error) {
                reloadDataTable(k);
                Swal2("error", "Something Error", "Please Try Again");
            });
});


$('.video-form input[name=display_order]').on('input', function () {
    let val = $(this).val().replace(/\D/g, ''); // remove non-digits
    let last_count = $(this).data('last_count');
    // Convert to number
    val = parseInt(val, 10);

    // Validate range
    if (val > last_count)
        val = last_count;
    if (val < 1 || isNaN(val))
        val = '';

    $(this).val(val);
});

$(document).on("change", "#video_status_master", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_content_id: 22,
        for : "status",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common
            .ajax_save("saveVideomaster", update_data)
            .then(function (response) {
                reloadDataTable(k);
                if (response.code == 200) {
                    Swal2("success", "Success", "Successfully Status Updated");
                } else {
                    Swal2("error", "Failed", "Please Try Again");
                }
            })
            .catch(function (error) {
                reloadDataTable(k);
                Swal2("error", "Something Error", "Please Try Again");
            });
});