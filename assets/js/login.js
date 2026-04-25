$(".toggle-password").on("click", function () {
    const passwordInput = $("input[name=pass_word]");
    const toggleIcon = $("#password_show");
    // Toggle password visibility
    if (passwordInput.attr("type") === "password") {
        passwordInput.attr("type", "text");
        toggleIcon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
        passwordInput.attr("type", "password");
        toggleIcon.removeClass("fa-eye-slash").addClass("fa-eye");
    }
});

$(".login-form").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission
    // Submit the form via AJAX if validation passes
    common
            .ajax_save("loginCheck", $(this).serializeArray())
            .then(function (res) {
                if (res.code == 200) {
                    swal.fire({
                        title: "Login Successfully",
                        text: "",
                        icon: "success",
                        timer: 3000, // Time in milliseconds (5000 ms = 5 seconds)
                        timerProgressBar: true, // Optionally show a progress bar
                        didClose: () => {
                            window.location.href = res.data.redirect;
                        }

                    });
                } else {
                    swal.fire({title: res.message, icon: "error"});
                }
                console.log("Form data submitted successfully:", res);
            })
            .catch(function (error) {
                console.error("Error submitting form:", error);
                swal.fire({title: "Something Error", text: "Try Some again time", icon: "error"});

            });
});


$('.go_to_login').on('click', function () {
    $('.forgot-panel').addClass('d-none');
    $('.login-panel').removeClass('d-none');
});
$('.go_to_forgot').on('click', function () {
    $('.forgot-panel').removeClass('d-none');
    $('.login-panel').addClass('d-none');
    $('.forgot-form .user_email').removeClass('d-none');
    $('.forgot-form .user_otp,.forgot-form .user_password').addClass('d-none');
    $('.forgot-form input[name=user_otp],.forgot-form input[name=pass_word]').attr('required', false);
    $('.forgot-form input[name=user_email]').attr('required', true);
    resetForm($('.forgot-form'));
    $(".forgot-form").data('current-state', 1);
    $('.reset-pass-btn').html('Forgot Password');
});

$(".forgot-form").on("submit", function (event) {
    event.preventDefault();
    var cur_state = $(".forgot-form").data('current-state');
    commonOTP(cur_state);
});

$(".resetotp-btn").on("click", function () {
    commonOTP(1);
});


function commonOTP(cur_state) {

    var cur_url = cur_state == 1 ? 'getForgotOTP' : (cur_state == 2 ? 'checkOTP' : 'changePassword');
    if (cur_state == 1) {
        Swal.fire({
            title: 'Sent Mail...',
            html: 'Please wait...',
            allowOutsideClick: false, // Prevent closing by clicking outside
            didOpen: () => {
                Swal.showLoading();  // Show the loading spinner
            }
        });
    }
 
    common.ajax_save(cur_url, $('.forgot-form').serializeArray())
            .then(function (res) {
                console.log(res);
                if (res.code == 200 && res.status == 1) {
                    switch (res.cur_state) {
                        case 1:
                            $('.forgot-form .user_otp').removeClass('d-none');
                            $('.forgot-form .user_email,.forgot-form .user_password').addClass('d-none');
                            $('.forgot-form input[name=user_email],.forgot-form input[name=pass_word]').attr('required', false);
                            $('.forgot-form input[name=user_otp]').attr('required', true);
                            $(".forgot-form").data('current-state', 2);
                            $('.reset-pass-btn').html('Check OTP');
                            break;

                        case 2:
                            $('.forgot-form .user_password').removeClass('d-none');
                            $('.forgot-form .user_email,.forgot-form .user_otp').addClass('d-none');
                            $('.forgot-form input[name=user_email],.forgot-form input[name=user_otp]').attr('required', false);
                            $('.forgot-form input[name=pass_word]').attr('required', true);
                            $(".forgot-form").data('current-state', 3);
                            $('.reset-pass-btn').html('Change Password');
                            break;
                        case 3:
                            $('.forgot-panel').addClass('d-none');
                            $('.login-panel').removeClass('d-none');
                            break;

                    }
                    swal.fire({
                        title: res.message,
                        icon: "success"
                    });

                } else {
                    swal.fire({
                        title: res.message,
                        icon: "error"
                    });
                }
            })
            .catch(function (error) {
                swal.fire({
                    text: "Something Error",
                    icon: "error",

                })
            });
}
