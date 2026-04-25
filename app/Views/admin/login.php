<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php if (!empty(LOGO)) : ?>
<link rel="icon" href="<?= LOGO ?>">
<?php endif; ?>

<title><?= COMPANY ?><?= isset($title) && $title ? " - " . $title : "" ?></title>

<link rel="stylesheet" href="<?= CSS_PATH ?>/src/css/vendors_css.css">
<link rel="stylesheet" href="<?= CSS_PATH ?>/src/css/style.css">
<link rel="stylesheet" href="<?= CSS_PATH ?>/css/custom.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>

<style>

body{
font-family:'Open Sans',sans-serif;
background: url('<?= CSS_PATH ?>/images/login-bg.png') center center/cover no-repeat;
min-height:100vh;
display:flex;
align-items:center;
justify-content:center;
}

/* container */
.container{
max-width:1200px;
}

/* login card */
.bg-white{
background:rgba(255,255,255,0.95) !important;
backdrop-filter:blur(12px);
}

/* card style */
.rounded10{
border-radius:14px !important;
}

.shadow-lg{
box-shadow:0 20px 50px rgba(0,0,0,0.25);
}

/* title */
.content-top-agile h2{
font-size:28px;
font-weight:700;
letter-spacing:1px;
}

/* inputs */
.form-control{
height:48px;
border-radius:8px;
border:1px solid #e4e7f2;
}

.form-control:focus{
border-color:#667eea;
box-shadow:0 0 0 3px rgba(102,126,234,.15);
}

/* icon */
.input-group-text{
border-radius:8px;
}

/* password icon */
.password-toggle-icon{
cursor:pointer;
}

/* button */
.btn-primary{
height:48px;
font-weight:600;
border-radius:8px;
background:#f25146!important;
border:none;
transition:all .3s ease;
}

.btn-primary:hover{
background:#f25146;
transform:translateY(-2px);
box-shadow:0 10px 25px rgba(0,0,0,0.25);
}

.btn-danger{
border-radius:8px;
}

/* spacing */
.p-40{
padding:35px;
}

/* mobile */
@media(max-width:768px){

.content-top-agile h2{
font-size:24px;
}

.p-40{
padding:25px;
}

}

</style>

</head>


<body class="hold-transition theme-primary">

<div class="container h-p100">
<div class="row align-items-center justify-content-md-center h-p100">

<!-- ================= Forgot Password ================= -->

<div class="col-12 forgot-panel d-none">

<div class="row justify-content-center g-0">
<div class="col-lg-5 col-md-6 col-12">

<div class="bg-white rounded10 shadow-lg">

<div class="content-top-agile p-20 pb-0 text-center">
<h2 class="text-primary fw-800">Forgot Password ?</h2>
<p class="mb-0 text-fade">Enter your email to reset your password.</p>
</div>

<div class="p-40">

<form data-current-state="1" data-validate class="forgot-form">

<div class="form-group user_email">
<div class="input-group mb-3">

<span class="input-group-text bg-transparent">
<i class="fa fa-user text-fade"></i>
</span>

<input type="email"
name="user_email"
class="form-control ps-15 bg-transparent"
placeholder="Enter Email"
required>

</div>
</div>


<div class="form-group user_otp">

<div class="input-group mb-3">

<input type="text"
name="user_otp"
minlength="6"
maxlength="6"
class="form-control ps-15 text-center"
placeholder="OTP">

</div>

<div class="text-end">
<a class="text-success resetotp-btn">Resend OTP ?</a>
</div>

</div>


<div class="form-group user_password">

<div class="input-group mb-3">

<span class="input-group-text bg-transparent">
<i class="fa fa-key text-fade"></i>
</span>

<input type="password"
name="pass_word"
class="form-control ps-15 bg-transparent password-field"
placeholder="Password">

<span class="input-group-text bg-transparent toggle-password">
<i class="fas fa-eye text-fade password-toggle-icon"></i>
</span>

</div>

</div>


<div class="row">

<div class="col-12 d-flex justify-content-between">

<button type="button"
class="btn btn-danger go_to_login mt-10">
Back to Login
</button>

<button type="submit"
class="btn btn-primary reset-pass-btn mt-10">
Reset Password
</button>

</div>

</div>

</form>

</div>
</div>
</div>
</div>

</div>

<!-- ================= Login ================= -->

<div class="col-12 login-panel">

<div class="row justify-content-center g-0">
<div class="col-lg-5 col-md-6 col-12">

<div class="bg-white rounded10 shadow-lg">

<div class="content-top-agile p-20 pb-0 text-center">

<?php if (!empty(LOGO)) : ?>
<img src="<?= LOGO ?>" style="height:60px;margin-bottom:10px;">
<?php endif; ?>

<h2 class="text-primary fw-800"><?= COMPANY ?></h2>
<p class="mb-0 text-fade"></p>

</div>

<div class="p-40">

<form data-validate action="" class="login-form">

<div class="form-group">

<div class="input-group mb-3">

<span class="input-group-text bg-transparent">
<i class="fa fa-user text-fade"></i>
</span>

<input type="text"
name="user_email"
class="form-control ps-15 bg-transparent"
placeholder="User Id"
required
autocomplete="username"
style="text-transform:none;">

</div>

</div>


<div class="form-group">

<div class="input-group mb-3">

<span class="input-group-text bg-transparent">
<i class="fa fa-key text-fade"></i>
</span>

<input type="password"
name="user_password"
class="form-control ps-15 bg-transparent password-field"
placeholder="Password"
required>

<span class="input-group-text bg-transparent toggle-password">
<i class="fas fa-eye text-fade password-toggle-icon"></i>
</span>

</div>

</div>


<div class="row">

<div class="col-12 text-center">

<button type="submit"
class="btn btn-primary w-p100 mt-10">
SIGN IN
</button>

</div>

</div>

</form>

</div>
</div>
</div>
</div>

</div>

</div>
</div>


<!-- JS -->

<script src="<?= CSS_PATH ?>/src/js/vendors.min.js?t=<?= APP_VERSION ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?= CSS_PATH ?>/js/common.js?t=<?= APP_VERSION ?>"></script>
<script src="<?= CSS_PATH ?>/js/login.js?t=<?= APP_VERSION ?>"></script>
<script src="<?= CSS_PATH ?>/js/validation.js?t=<?= APP_VERSION ?>"></script>

<script>

$(document).on('click','.toggle-password .password-toggle-icon',function(){

var input=$(this).closest('.input-group').find('.password-field');

if(input.attr('type')==='password'){
input.attr('type','text');
$(this).removeClass('fa-eye').addClass('fa-eye-slash');
}else{
input.attr('type','password');
$(this).removeClass('fa-eye-slash').addClass('fa-eye');
}

});

$(document).on('submit','.login-form',function(){

var input=$(this).find('input[name="user_email"]');

if(input.length){
input.val(input.val().toLowerCase());
}

});

</script>

</body>
</html>