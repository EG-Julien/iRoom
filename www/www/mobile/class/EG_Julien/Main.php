<?php

/**
* Main class
*/
class Main
{

    function __construct($DB, $user)
    {
        $this->DB = $DB;
        $this->user = $user;
    }

    function getMobileUser($passwd) {
        if (empty($passwd)) {
            return false;
        } else {
            $q = $this->DB->prepare("SELECT * FROM users WHERE password = '" . $passwd ."'");
            $q->execute();

            $user = $q->fetch();

            if (empty($user)) {
                return false;
            } else {
                return $user;
            }
        }
    }

    function getPage($page) {
        if (empty($page)) {
            $page = "Home";
        }
        $page = ucwords((str_replace("/", " ", $page)));
        return $page;
    }

    function privatePage() {
        if (!isset($_SESSION['user'])) {
            die('<h1>Forbidden Access ! <small>You need to be <a href="/login">connected</a> to access at this page !</small></h1>');
            return false;
        } else {
            return true;
        }
    }

    public function flash($type, $msg){
        $_SESSION['flash'][$type] = $msg;
    }

    function getUser() {
        return $this->user;
    }

    function getLogin($user, $password) {
        if (!empty($user) && !empty($password)) {
            $a = [
                $user,
                $password
            ];
            $q = $this->DB->prepare("SELECT * FROM users WHERE login OR email = ? AND password = ?");
            $q->execute($a);
            $user = $q->fetch();

            if (!empty($user)) {
                $_SESSION['user'] = $user;
                $q = $this->DB->prepare("UPDATE users SET last_login = NOW(), last_ip = ?");
                $q->execute([$_SERVER['REMOTE_ADDR']]);
                header("Location: server/setup");
                $_SESSION['flash']['success'] = "You're now connected as " . $_SESSION['user']->login;
                return true;
            } else {
                $_SESSION['flash']['danger'] = "<strong>Ohh snap ! </strong>Your login or password is wrong !";
                return false;
            }
        } else {
            $_SESSION['flash']['danger'] = "<strong>Ohh snap ! </strong>Your login or password is wrong !";
            return false;
        }
    }

    function Rooter($page) {
        if (!empty($page)) {
            if (file_exists("views/$page.php")) {
                return "views/$page";
            } elseif ($page == "logout") {
                $_SESSION['flash']['success'] = "You're now deconected !";
                unset($_SESSION['user']);
                return "views/login";
            } else {
                return "assets/errors/404";
            }
        } else {
            if (isset($_SESSION['user'])) {
                return "views/server/setup";
            } else {
                return "views/login";
            }
        }
    }

    function debug($msg) {
        echo "<pre>" . print_r($msg, true) . "</pre>";
    }

    function str_random($length){
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }
}