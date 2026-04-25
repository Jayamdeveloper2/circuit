<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-hash" content="<?= csrf_hash() ?>">
    <?php if (LOGO != "") { ?>
    <link rel="icon" href="<?= LOGO ?>">
    <?php } ?>
    <title><?= COMPANY ?> <?= isset($title) ? " - " . $title : "" ?> </title>
    <!-- Vendors Style-->
    <link rel="stylesheet" href="<?= CSS_PATH ?>/src/css/vendors_css.css?t=<?=APP_VERSION?>">
    <!-- Style-->
    <link rel="stylesheet" href="<?= CSS_PATH ?>/src/css/style.css?t=<?=APP_VERSION?>">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/src/css/skin_color.css?t=<?=APP_VERSION?>">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/css/custom.css?t=<?=APP_VERSION?>">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <!-- <link href="<?= CSS_PATH ?>/plugins/select2.min.css" rel="stylesheet" /> -->
    <!-- <link rel="stylesheet" href="<?= CSS_PATH ?>/plugins/select2/css/select2.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   
    <link href="<?= CSS_PATH ?>/icons/uicons-regular-straight/css/uicons-regular-straight.css?t=<?=APP_VERSION?>" rel="stylesheet">
    <link href="<?= CSS_PATH ?>/icons/uicons-bold-rounded/css/uicons-bold-rounded.css?t=<?=APP_VERSION?>" rel="stylesheet">
    <link href="<?= CSS_PATH ?>/icons/uicons-solid-straight/css/uicons-solid-straight.css?t=<?=APP_VERSION?>" rel="stylesheet">
    <link href="<?= CSS_PATH ?>/icons/uicons-solid-rounded/css/uicons-solid-rounded.css?t=<?=APP_VERSION?>" rel="stylesheet">
    <link href="<?= CSS_PATH ?>/icons/bootstrap-icons-1.11.3/font/bootstrap-icons.css?t=<?=APP_VERSION?>" rel="stylesheet">
 
</head> 