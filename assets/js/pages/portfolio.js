$(function () {
  "use strict";

  let portfolioTable = $("#portfolio_table").DataTable({
    ajax: {
      url: "api/getPortfolioDomain",
      type: "POST",
      data: function (d) {
        // Add any extra params if needed
      },
    },
    columns: [
      { data: "serial_no", title: "SL" },
      {
        data: "web_image",
        title: "Image",
        render: function (data) {
          return `<img src="${data}" height="50" style="object-fit:cover; border-radius:4px;">`;
        },
      },
      { data: "web_title", title: "Title" },
      { data: "web_content", title: "Subtitle" },
      { data: "web_url", title: "Link/Anchor" },
      { data: "display_order", title: "Order" },
      {
        data: "is_active",
        title: "Status",
        render: function (data, type, row) {
          let checked = data == 1 ? "checked" : "";
          return `<div class="cus-toggle">
                                <label class="cus-switch mb-0">
                                    <input type="checkbox" class="status-toggle" data-id="${row.web_portfolio_domain_id}" ${checked}>
                                    <span class="cus-slider round"></span>
                                </label>
                            </div>`;
        },
      },
      {
        data: null,
        title: "Action",
        className: "text-center",
        render: function (data, type, row) {
          return `<button class="btn btn-sm btn-info edit-portfolio" data-id="${row.web_portfolio_domain_id}"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger delete-portfolio" data-id="${row.web_portfolio_domain_id}"><i class="fa fa-trash"></i></button>`;
        },
      },
    ],
    drawCallback: function (settings) {
      let json = settings.json;
      if (json && json.last_count) {
        $("#order_count").text(json.last_count);
      }
    },
  });

  // Add/Edit modal
  $(document).on("click", ".edit-portfolio", function () {
    let id = $(this).data("id");
    let modal = $("#portfolio-modal");
    let form = modal.find("form");
    form[0].reset();
    modal.find("#web_image_prev").addClass("d-none").attr("src", "");

    if (id != -1) {
      $.post(
        "api/getPortfolioDomain",
        { web_portfolio_domain_id: id },
        function (res) {
          if (res.status == "success" && res.data.length > 0) {
            let row = res.data[0];
            form
              .find('[name="web_portfolio_domain_id"]')
              .val(row.web_portfolio_domain_id);
            form.find('[name="web_title"]').val(row.web_title);
            form.find('[name="web_content"]').val(row.web_content);
            form.find('[name="web_url"]').val(row.web_url);
            form.find('[name="display_order"]').val(row.display_order);
            modal.find(".modal-name").text("Edit");
            modal
              .find("#web_image_prev")
              .removeClass("d-none")
              .attr("src", row.web_image);
            modal.modal("show");
          }
        },
      );
    } else {
      form.find('[name="web_portfolio_domain_id"]').val(-1);
      let nextOrder = parseInt($("#order_count").text()) || 0;
      form.find('[name="display_order"]').val(nextOrder + 1);

      modal.find(".modal-name").text("Add");
      modal.modal("show");
    }
  });

  // Save
  $(".portfolio-form").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("for", "edit");

    $.ajax({
      url: "api/savePortfolioDomain",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (res) {
        if (res.status == "success") {
          $("#portfolio-modal").modal("hide");
          portfolioTable.ajax.reload();
          $.toast({
            heading: "Success",
            text: "Domain data saved successfully",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "success",
            hideAfter: 3500,
          });
        } else {
          alert(res.message);
        }
      },
    });
  });

  // Delete
  $(document).on("click", ".delete-portfolio", function () {
    let id = $(this).data("id");
    if (confirm("Are you sure you want to delete this domain tile?")) {
      $.post(
        "api/savePortfolioDomain",
        { web_portfolio_domain_id: id, for: "delete" },
        function (res) {
          if (res.status == "success") {
            portfolioTable.ajax.reload();
          }
        },
      );
    }
  });

  // Status toggle
  $(document).on("change", ".status-toggle", function () {
    let id = $(this).data("id");
    let status = $(this).is(":checked") ? 1 : 0;
    $.post(
      "api/savePortfolioDomain",
      { web_portfolio_domain_id: id, is_active: status, for: "status" },
      function (res) {
        if (res.status != "success") {
          alert("Failed to update status");
        }
      },
    );
  });
});
