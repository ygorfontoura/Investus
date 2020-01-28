<?php include("assets/php/functions.php");?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="<?=ROOT?>assets/css/reset.css">
<link rel="stylesheet" href="<?=ROOT?>assets/css/main.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/d722b21c7a.js" crossorigin="anonymous"></script>
<style>
    .loginAreaBgc{
        background-image:url("<?= getBackground("assets/images/backgrounds/backgrounds.json", "login")?>")
    }
    .dashboardBgc{
        background:  linear-gradient(
                    rgba(0, 0, 0, 0.5), 
                    rgba(0, 0, 0, 0.5)
                    ), url("<?= getBackground("assets/images/backgrounds/backgrounds.json", "dashboard")?>");
        background-attachment: fixed !important;
        background-size: cover !important;
    }
</style>