<?php
    require_once("Server.php");

    $Server = new Server("root", "Serial", 115200);
    $data = $Server->getSerial();

    if (isset($_POST['get'])) {
        echo($data);
    }

    if (isset($_POST['send'])) {
        $Server->setSerial($_POST['send']);
        unset($_POST);
    }