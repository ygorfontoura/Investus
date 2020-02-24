<div id="menu" class="d-flex justify-content-center h3 align-content-center">
    <ul class="align-self-center">
        <li class="d-inline mr-3"><a href="#home">InvestUs</a></li>
        <li class="d-inline mr-3"><a href="#whyus">Why us?</a></li>
        <li class="d-inline mr-3"><a href="#aboutus">About Us</a></li>
        <?php
            if(!ISSET($_SESSION['user_id'])) {
                ?>
            <li class="d-inline mr-3"><a href="<?=ROOT?>auth/login">Login</a></li>
            <?php } else { ?>
                <li class="d-inline mr-3"><a href="<?=ROOT?>dashboard">Dashboard</a></li>
                <li class="d-inline mr-3"><a href="<?=ROOT?>auth/logout">Logout</a></li>
        <?php } ?>
    </ul>
</div>