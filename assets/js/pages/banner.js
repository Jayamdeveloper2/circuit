var table_column = [
    {
        data: "serial_no",
        title: "S.No",
        is_default: true,
        dt: true,
        width: "30px",
    },
    // {
    //     data: "web_title",
    //     className: "text-start",
    //     title: "Title",
    //     is_default: true,
    //     dt: true,
    //     width: "240px",
    // },

    {
        data: "web_image",
        width: "200px",
        className: "text-center",
        title: "Image",
        is_default: false,
        dt: true,
        render: function (data, type, row) {
            return `
          <img width='50' src='${row['web_image']}'>`;
        },
    },

    {
        data: "display_order",
        title: "Display Order",
        is_default: true,
        dt: true,
        width: "100px",
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
                    row["web_banner_id"]
                    }" class="banner_status" >
              <span class="cus-slider round"></span>
            </label>
            <label>Active</label>
          </div>`;
        },
    },
    {
        data: "web_banner_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
      <button data-pid="${row["web_banner_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-banner" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
          <button data-pid="${row["web_banner_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-banner " type="button" ><i class="fi fi-sr-trash"></i> Delete</button>
      `;
        },
    },
];

var dt = {
    table: "#banner_table",
    column: table_column,
    url: "getBanner",
};

var k = common.dataTable(dt);



// Add and Edit
$(document).on("click", ".edit-banner", function () {

    let pid = $(this).data("pid");
    let vbk = "show";

    $(".banner-form")[0].reset();
    $("#web_image").attr("src", "");
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".banner-form input[name=web_banner_id]").val(pid);

    let result = common.ajax_fech("getBanner", { web_banner_id: pid });

    let last_count = pid > 0 ? Number(result.last_count) : Number(result.last_count) + 1;
    $("#order_count").text(last_count);
    $(".banner-form input[name=display_order]").data('last_count', last_count).val(last_count);

    if (pid > 0 && result.code == 200 && result.data.length) {

        let data = result.data[0];

        $(".banner-form input[name=web_title]").val(data.web_title);
        $(".banner-form input[name=display_order]").val(data.display_order);
        $(".banner-form textarea[name=web_content]").val(data.web_content);
        $(".banner-form textarea[name=web_description]").val(data.web_description);
        $("#web_image").attr("src", data.web_image);

        /* 🔥 BUTTON URL FIX */
        // normalize URL before setting
let btnUrl = data.button_url || "";

// remove trailing slash
btnUrl = btnUrl.replace(/\/$/, "");

// find matching option
$("#button_url option").each(function () {
    let optVal = $(this).val().replace(/\/$/, "");
    if (optVal === btnUrl) {
        $("#button_url").val($(this).val());
    }
});


    } else if (pid > 0) {
        vbk = "hide";
        Swal2("error", "Error", "Unable to load banner data");
    }

    $("#banner-modal").modal(vbk);
});


// From Submit
$(".banner-form").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("for", "edit");

    common.ajax_save_file("saveBanner", formData)
        .then(res => {
            reloadDataTable(k);

            if (res.code == 200) {
                Swal2("success", "Success", "Banner saved successfully")
                    .then(() => $("#banner-modal").modal("hide"));
            } else {
                Swal2("error", "Error", res.message);
            }
        })
        .catch(() => {
            reloadDataTable(k);
            Swal2("error", "Error", "Try again later");
        });
});


// Delete
$(document).on("click", ".del-banner", function () {
    let pid = $(this).data("pid");

    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.isConfirmed) {

            common.ajax_save("saveBanner", {
                web_banner_id: pid,
                is_deleted: 1,
                for: "delete"
            }).then(res => {
                reloadDataTable(k);

                if (res.code == 200) {
                    Swal2("success", "Deleted", "Banner deleted");
                } else {
                    Swal2("error", "Error", res.message);
                }
            });
        }
    });
});


//status update
$(document).on("change", ".banner_status", function () {
    let pid = $(this).data("pid");

    common.ajax_save("saveBanner", {
        web_banner_id: pid,
        is_active: $(this).prop("checked") ? 1 : 0,
        for: "status"
    }).then(res => {
        reloadDataTable(k);
        Swal2(res.code == 200 ? "success" : "error",
              res.code == 200 ? "Updated" : "Failed",
              "");
    });
});


// Image
$("input[name=web_image]").on("change", function (e) {
    const file = e.target.files[0];
    const allowed = /\.(jpg|jpeg|png)$/i;

    if (!file || !allowed.test(file.name)) {
        $("#web_image").attr("src", "");
        $("#photo-msg").text("Only JPG, JPEG, PNG allowed");
        return;
    }

    $("#photo-msg").text("");

    const reader = new FileReader();
    reader.onload = e => $("#web_image").attr("src", e.target.result);
    reader.readAsDataURL(file);
});


$('.banner-form input[name=display_order]').on('input', function () {
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