<?php

/**
* Server's
*/
class Server {

    function __construct($user, $screen, $status) {
        $this->user = $user;
        $this->screen = $screen;
        $this->status = realpath("/var/www/status.txt");
    }

    function setSerial($cmd) {
        exec('sudo screen -S ' . $this->screen . ' -X eval "stuff ' . $cmd . '"');
    }

    function getSerial() {
        exec('sudo screen -S ' . $this->screen . ' -X hardcopy ' . $this->status);
        $serial = shell_exec('sudo tail -n 14 ' . $this->status);
        return $serial;
    }

    function getServer($port, $speed) {
        $screens = exec("sudo ls /var/run/screen/S-" . $this->user);
        if (strpos($screens, $this->screen) == FALSE) {
            exec('sudo screen -dmS ' . $this->screen . ' /dev/' . $port . ' ' . $speed);
            sleep(1);
            exec('sudo daemon screen -r ' . $this->screen);
            return false;
        } else {
            return true;
        }
    }
}