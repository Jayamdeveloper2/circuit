// Form Submit
$(".form-smtp").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission
    // Submit the form via AJAX if validation passes
    const formData = new FormData(this);
    formData.append("for", "edit");
    common
        .ajax_save_file("saveSmtp", formData)
        .then(function (response) {
            if (response.code == 200) {
                Swal2("success", "Success", "Successfully SMTP Setting Saved");
            } else {
                Swal2("error", "Something Error", response.message);
            }
        })
        .catch(function (error) {
            Swal2("error", "Something Error", "Try Some again time");
        });
});

// Password toggle
$(document).on('click', '.toggle-password .password-toggle-icon', function () {
    var input = $(this).closest('.input-group').find('.password-field');
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
    }
});
