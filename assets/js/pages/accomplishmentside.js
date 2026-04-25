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
        className: "text-start",
        title: "Title",
        is_default: true,
        dt: true,
        width: "500px",
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
              <input type="checkbox" ${data == 1 ? "checked" : ""} data-pid="${row["web_approach_id"]
                }" class="approach_status" >
              <span class="cus-slider round"></span>
            </label>
            <label>Active</label>
          </div>`;
        },
    },
    {
        data: "web_approach_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
      <button data-pid="${row["web_approach_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-approach" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
          <button data-pid="${row["web_approach_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-approach " type="button" ><i class="fi fi-sr-trash"></i> Delete</button>
      `;
        },
    },
];

var dt = {
    table: "#approach_table",
    column: table_column,
    url: "getApproach",
};

var k = common.dataTable(dt);


// Add and Edit
$(document).on("click", ".edit-approach", function () {

    const pid = $(this).data("pid");

    $(".approach-form")[0].reset();
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".approach-form input[name=web_approach_id]").val(pid);
    $("#web_image_preview").attr("src", "");
    $("#web_image_1_preview").attr("src", "");
    $("#web_image_2_preview").attr("src", "");

    let fields = ['web_content', 'web_content_1', 'web_content_2', 'web_content_3', 'web_content_4', 'web_content_5', 'web_content_6', 'web_content_7'];
    for (let field of fields) {
        $('.approach-form textarea[name="' + field + '"]').val('').trigger('change');
    }

    const result = common.ajax_fech("getApproach", { web_approach_id: pid });

    let last_count = pid > 0
        ? result.last_count
        : result.last_count + 1;

    $("#order_count").text(last_count);

    $(".approach-form input[name=display_order]")
        .data("last_count", last_count)
        .val(last_count);

    $("#approach-modal").modal("show");

    if (pid > 0 && result.code === 200 && result.data.length) {
        $(".approach-form input[name=web_title]").val(result.data[0].web_title);
        $(".approach-form input[name=display_order]").val(result.data[0].display_order);

        // Populate all rich text inputs in a loop
        for (let i = 0; i <= 7; i++) {
            let field = i === 0 ? 'web_content' : 'web_content_' + i;
            let val = result.data[0][field] || '';
            $('.approach-form textarea[name="' + field + '"]').val(val).trigger('change');
        }

        $("#web_image_preview").attr("src", result.data[0].web_image || "");
        $("#web_image_1_preview").attr("src", result.data[0].web_image_1 || "");
        $("#web_image_2_preview").attr("src", result.data[0].web_image_2 || "");
    }
});



// From Submit
$(".approach-form").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission
    // Submit the form via AJAX if validation passes
    const formData = new FormData(this);
    formData.append("for", "edit");
    common
        .ajax_save_file("saveApproach", formData)
        .then(function (response) {
            if (response.code == 200) {
                reloadDataTable(k);
                Swal2("success", "Success", "Successfully User Saved").then(() => {
                    $("#approach-modal").modal("hide");
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
$(document).on("click", ".del-approach", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_approach_id: pid,
        is_deleted: 1,
        for: "delete",
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
                    .ajax_save("saveApproach", update_data)
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
$(document).on("change", ".approach_status", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_approach_id: pid,
        for: "status",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common
        .ajax_save("saveApproach", update_data)
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

// Image preview handlers
$("input[name=web_image]").on("change", function (event) {
    handleImagePreview(event, "#web_image_preview", "#photo-msg");
});
$("input[name=web_image_1]").on("change", function (event) {
    handleImagePreview(event, "#web_image_1_preview", "#photo-msg_1");
});
$("input[name=web_image_2]").on("change", function (event) {
    handleImagePreview(event, "#web_image_2_preview", "#photo-msg_2");
});

function handleImagePreview(event, previewId, errorMsgId) {
    const file = event.target.files[0];
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    const errorMsg = $(errorMsgId);
    if (file) {
        if (!allowedExtensions.test(file.name)) {
            errorMsg.text("Invalid file type! Only jpg, jpeg, and png are allowed.");
            $(previewId).attr("src", "");
            return;
        }
        errorMsg.text("");
        const reader = new FileReader();
        reader.onload = function (e) {
            $(previewId).attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        $(previewId).attr("src", "");
        errorMsg.text("");
    }
}


$('.approach-form input[name=display_order]').on('input', function () {
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

$(function (e) {
    $('textarea[name=web_content]').richText();
    $('textarea[name=web_content_1]').richText();
    $('textarea[name=web_content_2]').richText();
    $('textarea[name=web_content_3]').richText();
    $('textarea[name=web_content_4]').richText();
    $('textarea[name=web_content_5]').richText();
    $('textarea[name=web_content_6]').richText();
    $('textarea[name=web_content_7]').richText();
});