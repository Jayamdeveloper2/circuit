$(document).ready(function () {
  let featureEditor;
  let lastCount = 0;

  ClassicEditor.create(document.querySelector("#web_features_editor"))
    .then((editor) => {
      featureEditor = editor;
    })
    .catch((error) => {
      console.error(error);
    });

  const table = $("#plannedTable").DataTable({
    ajax: {
      url: "api/getPlannedShowcase",
      type: "POST",
      dataSrc: function (json) {
        lastCount = parseInt(json.last_count) || 0;
        return json.data;
      },
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content"),
      },
    },
    columns: [
      { data: "serial_no" },
      {
        data: "web_tag",
        render: (data) =>
          `<span class="badge badge-lg badge-info-light">${data}</span>`,
      },
      {
        data: "web_title",
        render: (data) => `<span class="fw-bold">${data}</span>`,
      },
      {
        data: "theme_class",
        render: (data) => `<code class="small text-muted">${data}</code>`,
      },
      { data: "display_order" },
      {
        data: "is_active",
        render: function (data, type, row) {
          return `<div class="form-check form-switch p-0" style="min-height: auto;">
                        <input class="form-check-input status-toggle" type="checkbox" data-id="${row.web_planned_showcase_id}" ${data == 1 ? "checked" : ""} style="margin-left: 0;">
                    </div>`;
        },
      },
      {
        data: "web_planned_showcase_id",
        render: function (data) {
          return `
                        <button class="btn btn-sm btn-primary-light edit-btn" data-id="${data}" title="Edit"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger-light delete-btn" data-id="${data}" title="Delete"><i class="fa fa-trash"></i></button>
                    `;
        },
      },
    ],
    drawCallback: function (settings) {
      if (settings.json && settings.json.csrf_hash) {
        $('meta[name="csrf-token-hash"]').attr(
          "content",
          settings.json.csrf_hash,
        );
      }
    },
  });

  // Add button
  $(".add-planned-btn").on("click", function () {
    $(".planned-form")[0].reset();
    $('[name="web_planned_showcase_id"]').val(0);
    $('[name="display_order"]').val(lastCount + 1);
    if (featureEditor) featureEditor.setData("");
    $("#plannedModal").modal("show");
  });

  // Edit button
  $(document).on("click", ".edit-btn", function () {
    const id = $(this).data("id");
    $.ajax({
      url: "api/getPlannedShowcase",
      type: "POST",
      data: { web_planned_showcase_id: id },
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content"),
      },
      success: function (res) {
        if (res.status == "success") {
          const d = res.data;
          const form = $(".planned-form");
          form
            .find('[name="web_planned_showcase_id"]')
            .val(d.web_planned_showcase_id);
          form.find('[name="web_tag"]').val(d.web_tag);
          form.find('[name="web_title"]').val(d.web_title);
          form.find('[name="web_tech_line"]').val(d.web_tech_line);
          form.find('[name="web_footer"]').val(d.web_footer);
          form.find('[name="theme_class"]').val(d.theme_class);
          form.find('[name="anchor_id"]').val(d.anchor_id);
          form.find('[name="display_order"]').val(d.display_order);
          form
            .find(`[name="is_active"][value="${d.is_active}"]`)
            .prop("checked", true);

          if (featureEditor) {
            featureEditor.setData(d.web_features || "");
          }

          $("#plannedModal").modal("show");
        }
        if (res.csrf_hash)
          $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
      },
    });
  });

  // Submit form
  $(".planned-form").on("submit", function (e) {
    e.preventDefault();

    // Sync CKEditor data
    if (featureEditor) {
      $("#web_features_editor").val(featureEditor.getData());
    }

    let formData = new FormData(this);
    formData.append("for", "edit");

    $.ajax({
      url: "api/savePlannedShowcase",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content"),
      },
      success: function (res) {
        if (res.status == "success") {
          $("#plannedModal").modal("hide");
          table.ajax.reload();
          Swal2("success", "Success", "Planned design saved successfully");
        }
        if (res.csrf_hash)
          $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
      },
    });
  });

  // Toggle status
  $(document).on("change", ".status-toggle", function () {
    const id = $(this).data("id");
    const status = $(this).is(":checked") ? 1 : 0;
    $.ajax({
      url: "api/savePlannedShowcase",
      type: "POST",
      data: { web_planned_showcase_id: id, is_active: status, for: "status" },
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content"),
      },
      success: function (res) {
        if (res.status == "success") {
          Swal2("success", "Updated", "Visibility updated");
        }
        if (res.csrf_hash)
          $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
      },
    });
  });

  // Delete
  $(document).on("click", ".delete-btn", function () {
    const id = $(this).data("id");
    if (confirm("Are you sure you want to delete this design?")) {
      $.ajax({
        url: "api/savePlannedShowcase",
        type: "POST",
        data: { web_planned_showcase_id: id, for: "delete" },
        headers: {
          "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content"),
        },
        success: function (res) {
          if (res.status == "success") {
            table.ajax.reload();
            Swal2("success", "Deleted", "Design removed");
          }
          if (res.csrf_hash)
            $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
        },
      });
    }
  });
});
