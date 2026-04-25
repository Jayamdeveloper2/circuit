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
        width: "240px",
    },

    {
        data: "web_image",
        width: "200px",
        className: "text-center",
        title: "Image",
        is_default: false,
        dt: true,
        render: function (data, type, row) {
            return (row['web_image']) ? ` 
          <img width='50' src='${row['web_image']}'>` : "";

        },
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
              <input type="checkbox" ${data == 1 ? "checked" : ""} data-pid="${row["web_menu_id"]
                }" class="menu_status" >
              <span class="cus-slider round"></span>
            </label>
            <label>Active</label>
          </div>`;
        },
    },

    {
        data: "web_menu_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
      <button data-pid="${row["web_menu_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-menu" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
           `;
        },
    },
];

var dt = {
    table: "#menu_table",
    column: table_column,
    url: "getMenu",
};

var k = common.dataTable(dt);


// Add and Edit
$(document).on("click", ".edit-menu", function () {
    var vbk = "show";
    $(".menu-form")[0].reset();
    $("#web_image").attr("src", "");
    var pid = $(this).data("pid");
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".menu-form input[name=web_menu_id]").val(pid);
    var result = common.ajax_fech("getMenu", { web_menu_id: pid });
    let last_count = (pid > 0) ? Number(result["last_count"]) : (Number(result["last_count"]) + 1);
    $("#order_count").text(last_count);
    $(".menu-form input[name=display_order]").data('last_count', last_count).val(last_count);

    $(".menu-form input[name=meta_title]").closest(".row").show();
    $(".menu-form textarea[name=meta_desc]").closest(".row").show();
    $(".menu-form textarea[name=meta_key]").closest(".row").show();

    if (pid > 0) {
        if (result["code"] == 200 && result["data"].length != 0) {
            $(".menu-form input[name=web_menu_id]").val(
                result["data"][0]["web_menu_id"]
            );
            $(".menu-form input[name=web_title]").val(
                result["data"][0]["web_title"]
            );

            $(".menu-form input[name=display_order]").val(
                result["data"][0]["display_order"]
            );

            $(".menu-form textarea[name=web_content]").val(
                result["data"][0]["web_content"]
            );


            $(".menu-form input[name=meta_title]").val(
                result["data"][0]["meta_title"]
            );

            $(".menu-form textarea[name=meta_desc]").val(
                result["data"][0]["meta_desc"]
            );

            $(".menu-form textarea[name=meta_key]").val(
                result["data"][0]["meta_key"]
            );


            $("#web_image").attr("src", result["data"][0]["web_image"]);
        } else {
            vbk = "hide";
            Swal2("error", "Something Error", "Try Some again time");
        }
    }
    $("#menu-modal").modal(vbk);
});

// From Submit
$(".menu-form").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission
    // Submit the form via AJAX if validation passes
    const formData = new FormData(this);
    formData.append("for", "edit");
    common
        .ajax_save_file("saveMenu", formData)
        .then(function (response) {
            if (response.code == 200) {
                reloadDataTable(k);
                Swal2("success", "Success", "Successfully User Saved").then(() => {
                    $("#menu-modal").modal("hide");
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


// Image
$("input[name=web_image]").on("change", function (event) {
    const file = event.target.files[0];
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    const errorMsg = $("#photo-msg");
    if (file) {
        if (!allowedExtensions.test(file.name)) {
            errorMsg.text("Invalid file type! Only jpg, jpeg, and png are allowed.");
            $("#web_image").attr("src", "");
            return;
        }
        // Clear error message and show preview
        errorMsg.text("");
        const reader = new FileReader();
        reader.onload = function (e) {
            $("#web_image").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        $("#web_image").attr("src", "");
        errorMsg.text("");
    }
});

//status update
$(document).on("change", ".menu_status", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_menu_id: pid,
        for: "edit",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common
        .ajax_save("saveMenu", update_data)
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


