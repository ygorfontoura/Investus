<ul class="d-flex justify-content-center">
    <li class="d-inline mr-3"><a href="<?=ROOT?>">Home</a></li>
    <li class="d-inline mr-3"><a href="#">Trending Stocks</a></li>
    <?php
        if(!ISSET($_SESSION['user_id'])) {
            ?>
        <li class="d-inline mr-3"><a href="<?=ROOT?>auth/login">Login</a></li>
        <?php } else { ?>
            <li class="d-inline mr-3"><a href="<?=ROOT?>dashboard">Dashboard</a></li>
            <li class="d-inline mr-3"><a href="<?=ROOT?>auth/logout">Logout</a></li>
    <?php } ?>
    <li class="d-inline"><a href="<?=ROOT?>aboutus">About Us</a></li>
</ul>