<?php
    require_once("Server.php");
    require_once("Main.php");

    $DB = new PDO('mysql:dbname=iserver;host=localhost', "root", "root");
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $Main = new Main($DB, "root");

    if (isset($_POST['login'])) {
        if (!empty($_POST['login'])) {
            $user = $Main->getMobileUser(sha1($_POST['login']));

            if ($user != false) {
                echo "$user->id\n";
                echo "$user->login\n";
                echo "$user->email\n";
                echo "$user->password\n";
                echo "$user->last_login\n";
                echo "$user->last_ip\n";
            } else {
                echo "false";
            }
        } else {
            echo "false";
        }
    }