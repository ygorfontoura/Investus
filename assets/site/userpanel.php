<div class="pl-5 pr-5 text-white">
    <?php 
        if(empty($action)) $action = "analyses";

        require("view/dashboard/".$action.".php");
       
    ?>
</div>