$(document).ready(function () {
  $("form[data-validate]").each(function () {
    initializeFormValidation($(this));
  });
});

function initializeFormValidation($form) {
  $form.on("submit", function (event) {
    event.preventDefault();
  });

  $form.find("button[type=submit]").on("click", function () {
    validateForm($form);
  });

  $form.find("input, select, textarea").on("input blur change", function () {
    validateField($(this));
  });
}

function validateForm($form) {
  let isValid = true;

  $form.find("input, select, textarea").each(function () {
    if (!validateField($(this))) {
      isValid = false;
    }
  });

  return isValid;
}

function validateField($field) {
  const isRequired = $field.prop("required");
  const pattern = $field.attr("pattern");
  var con_div;

  switch ($field[0].type) {
    case "radio":
      // Find the group of radio buttons with the same name
      const name = $field.attr("name");
      const isChecked = $('input[name="' + name + '"]:checked').length > 0;

      con_div = $field.closest(".form-group").find(".invalid-feedback");

      if (isRequired && !isChecked) {
        markInvalid($field, con_div);
        return false;
      }
      break;

    default:
      con_div = $field.next(".invalid-feedback");

      const value = $field.val();
      if ($field.hasClass("select2-hidden-accessible")) {
        $field = $field.next(".select2-container");
      }

      if (isRequired && (!value || value.trim() === "")) {
        markInvalid($field, con_div);
        return false;
      }

      if (pattern && !new RegExp(pattern).test(value)) {
        markInvalid($field, con_div);
        return false;
      }
      break;
  }

  markValid($field, con_div);
  return true;
}

function markValid($field, $errorMessage) {
  $field.removeClass("is-invalid").addClass("is-valid");
  $errorMessage.hide();
}

function markInvalid($field, $errorMessage) {
  $field.removeClass("is-valid").addClass("is-invalid");
  $errorMessage.show();
}

function resetForm($form) {
  $form[0].reset();
  $form.find(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
  $form.find(".invalid-feedback").hide();
}
