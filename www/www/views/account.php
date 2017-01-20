<?php $Main->privatePage(); ?>
<h1>Account</h1>

<div class="row padding">
    <div class="col-xs-12 col-lg-6">
        <h4>Username : <small><?= $_SESSION['user']->login; ?></small></h4>
        <h4>Email : <small><?= $_SESSION['user']->email; ?></small></h4>
        <h4>Last connection : <small><?= $_SESSION['user']->last_login; ?></small></h4>
        <h4>Last connection ip's : <small><?= $_SESSION['user']->last_ip; ?></small></h4>
    </div>
</div>