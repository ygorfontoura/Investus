<?php include("assets/php/functions.php");?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- CSS RELATED -->
<link rel="stylesheet" href="<?=ROOT?>assets/css/reset.css">
<link rel="stylesheet" href="<?=ROOT?>assets/css/main.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- SCRIPTS JS -->
<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- CHART JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<!-- FONT AWESOME -->
<script src="https://kit.fontawesome.com/d722b21c7a.js" crossorigin="anonymous"></script>
<!-- BOOTSTRAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script src="<?=ROOT?>assets/js/main.js"></script>
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