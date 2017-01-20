<?php $Main->privatePage(); ?>
<?php

    $Server = new Server("root", "Com", "status.txt");

    $screen = $Server->getServer($com, $speed);

 ?>


 <h1>Server's Info</h1>
 <p class="lead">Here are all informations about the server sttings</p>

 <div class="padding">
     <h3 class="lead">IP : <small><?= $_SERVER['SERVER_ADDR']; ?></small></h3>
     <h3 class="lead">Server name : <small><a href="//<?= $_SERVER['SERVER_NAME']; ?>:<?= $_SERVER['SERVER_PORT']; ?>"><?= $_SERVER['SERVER_NAME']; ?>:<?= $_SERVER['SERVER_PORT']; ?></a></small></h3>
     <h3 class="lead">Current client IP : <small><?= $_SERVER['REMOTE_ADDR']; ?></small></h3>
     <h3 class="lead">Global variable <small>SESSION</small></h3>
     <?= $Main->debug($_SESSION); ?>
     <h3 class="lead"><small>SERVER</small></h3>
     <?= $Main->debug($_SERVER); ?>
</div>
<h2>Serial</h2>
<div class="padding">
    <h3 class="lead">Serial port : <?= $com; ?></h3>
    <h3 class="lead">Baud rate : <?= $speed; ?> bps</h3>
</div>