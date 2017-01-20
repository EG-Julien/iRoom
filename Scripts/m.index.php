<?php

$screen_name = "senseo";
$user = "root";
$statusfile = realpath(dirname(__FILE__))."/status.txt";

$allowed = array("s", "c", "b", "r", "a");
$list = shell_exec("sudo ls /var/run/screen/S-".$user);
if (strpos($list, $screen_name) == FALSE) {
        exec('sudo screen -dmS '.$screen_name.' /dev/ttyUSB0 115200');
        sleep(1);
        exec('sudo daemon screen -r '.$screen_name);
        exec('sudo screen -S arduino -X eval "stuff i"');
        sleep(5);
        header('Location: '.$_SERVER['PHP_SELF']);
}
elseif (isset($_GET['data'])) {
        while ($message[1] != "louis") {
                exec('sudo screen -S '.$screen_name.' -X hardcopy '.$statusfile);
                $serial = exec('sudo tail -1 '.$statusfile);
                $message = explode("jean", $serial);
        }
        echo $message[0];
}
elseif (isset($_GET['send'])) {
        if (in_array($_GET['send'], $allowed))
                exec('sudo screen -S '.$screen_name.' -X eval "stuff '.$_GET['send'].'"');
}
else {
?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <title>Senseo</title>
        <link type="text/css" rel="stylesheet" href="http://cdn.jsdelivr.net/animatecss/0.1/animate.min.css" />
        <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
        <style>
        * {
                padding: 0;
                margin: 0;
        }
        body {
                background-color: #eee;
                padding-top: 80px;
                font-family: "Arial" ;
                width: 500px;
                margin: auto;
        }
        #header {
                text-align: center;
                margin-bottom: 80px;
        }
        #state {
                background-color: white;
                height: 100px;
                border-radius: 25px;
                padding: 25px;
        }
        #state h3 {
                color: grey;
                font-style: italic;
                margin-bottom: 25px;
        }
        #senseo {
                text-align: center;
        }
        #smallbuttons {
                margin-top: 10px;
        }
        #footer {
                margin-top: 25px;
                text-align: center;
        }
        .button {
                -webkit-appearance: none;
                background-color: #0079d7;
                width: 120px;
                color: white;
                padding: 10px;
                border-radius: 25px;
                border:0;
                transition-duration: 0.5s;
        }
        .button:hover {
                background-color: #003965;
        }
        .firstbutton,.stop {
                font-size: 1.5em;
                background-color: #00d323;
                width: 250px;
                height: 50px;
        }
        .firstbutton:hover {
                background-color: #006e12;
        }
        .stop {
                background-color: #a40101;
        }
        .stop:hover {
                background-color: #520000;
        }
        .hide {
                display: none;
        }
        @media only screen
        and (min-device-width : 320px)
        and (max-device-width : 480px) {
                body {
                        width: 95%;
                        font-size: 2em;
                }
                #state {
                        background-color: white;
                        border-radius: 50px;
                        height: 200px;
                }
                #footer,#state {
                        margin-top: 70px;
                }
                #smallbuttons {
                        margin-top: 40px;
                }
                .button {
                        width: 30%;
                        color: white;
                        padding: 30px;
                        border-radius: 100px;
                        font-size: 1em;
                        border:0;
                        transition-duration: 0.5s;
                }
                .firstbutton,.stop {
                        font-size: 2.5em;
                        width: 80%;
                        height: 150px;
                        border-radius: 100px;
                }
        }
        </style>
</head>
<body>
        <div id="header" class="animated bounceInDown">
                <h1>Senseo online</h1>
        </div>
        <div id="state" class="animated fadeIn">
                <h3>Senseo says :</h3>
                <h2 id="senseo">Coffee machine waiting for orders !</h2>
        </div>
        <div id="footer">
                <div id="buttons" class="animated fadeInDown">
                        <input class="button firstbutton" type="button" onclick="data('s');" value="Make a coffee"/>
                        <br/>
                        <div id="smallbuttons">
                                <input class="button" type="button" onclick="data('b');" value="Preheat"/>
                                <input class="button" type="button" onclick="data('c');" value="Add some water"/>
                                <input class="button" type="button" onclick="data('r');" value="Monitor sensors"/>
                        </div>
                        <br />
                </div>
                <div id="stop" class="hide">
                        <input class="button stop" type="button" onclick="data('a')" value="Return standby"/>
                </div>
        </div>
<script>
var senseotext='Coffee machine waiting for orders !';
var i=0;
function getserial() {
        $("#senseo").load("?data");
        var senseotext = ($("#senseo").text());
        stopbutton(senseotext);
}
function data(cmd) {
        $.get("?send="+cmd);
}
function stopbutton(text) {
        if(text != 'Coffee machine waiting for orders !') {
                $("#stop").fadeIn();
        }
        else {
                if (i>1) {
                        $("#stop").removeClass("hide");
                        i++;
                }
                else $("#stop").fadeOut();
        }
}
window.setInterval(function(){getserial()}, 100);
getserial();
</script>
</body>
</html>
<?php
}

    ?>

RAW Paste Data
<?php

$screen_name = "senseo";
$user = "root";
$statusfile = realpath(dirname(__FILE__))."/status.txt";

$allowed = array("s", "c", "b", "r", "a");
$list = shell_exec("sudo ls /var/run/screen/S-".$user);
if (strpos($list, $screen_name) == FALSE) {
    exec('sudo screen -dmS '.$screen_name.' /dev/ttyUSB0 115200');
    sleep(1);
    exec('sudo daemon screen -r '.$screen_name);
    exec('sudo screen -S arduino -X eval "stuff i"');
    sleep(5);
    header('Location: '.$_SERVER['PHP_SELF']);
}
elseif (isset($_GET['data'])) {
    while ($message[1] != "louis") {
        exec('sudo screen -S '.$screen_name.' -X hardcopy '.$statusfile);
        $serial = exec('sudo tail -1 '.$statusfile);
        $message = explode("jean", $serial);
    }
    echo $message[0];
}
elseif (isset($_GET['send'])) {
    if (in_array($_GET['send'], $allowed))
        exec('sudo screen -S '.$screen_name.' -X eval "stuff '.$_GET['send'].'"');
}
else {
?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Senseo</title>
    <link type="text/css" rel="stylesheet" href="http://cdn.jsdelivr.net/animatecss/0.1/animate.min.css" />
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <style>
    * {
        padding: 0;
        margin: 0;
    }
    body {
        background-color: #eee;
        padding-top: 80px;
        font-family: "Arial" ;
        width: 500px;
        margin: auto;
    }
    #header {
        text-align: center;
        margin-bottom: 80px;
    }
    #state {
        background-color: white;
        height: 100px;
        border-radius: 25px;
        padding: 25px;
    }
    #state h3 {
        color: grey;
        font-style: italic;
        margin-bottom: 25px;
    }
    #senseo {
        text-align: center;
    }
    #smallbuttons {
        margin-top: 10px;
    }
    #footer {
        margin-top: 25px;
        text-align: center;
    }
    .button {
        -webkit-appearance: none;
        background-color: #0079d7;
        width: 120px;
        color: white;
        padding: 10px;
        border-radius: 25px;
        border:0;
        transition-duration: 0.5s;
    }
    .button:hover {
        background-color: #003965;
    }
    .firstbutton,.stop {
        font-size: 1.5em;
        background-color: #00d323;
        width: 250px;
        height: 50px;
    }
    .firstbutton:hover {
        background-color: #006e12;
    }
    .stop {
        background-color: #a40101;
    }
    .stop:hover {
        background-color: #520000;
    }
    .hide {
        display: none;
    }
    @media only screen
    and (min-device-width : 320px)
    and (max-device-width : 480px) {
        body {
            width: 95%;
            font-size: 2em;
        }
        #state {
            background-color: white;
            border-radius: 50px;
            height: 200px;
        }
        #footer,#state {
            margin-top: 70px;
        }
        #smallbuttons {
            margin-top: 40px;
        }
        .button {
            width: 30%;
            color: white;
            padding: 30px;
            border-radius: 100px;
            font-size: 1em;
            border:0;
            transition-duration: 0.5s;
        }
        .firstbutton,.stop {
            font-size: 2.5em;
            width: 80%;
            height: 150px;
            border-radius: 100px;
        }
    }
    </style>
</head>
<body>
    <div id="header" class="animated bounceInDown">
        <h1>Senseo online</h1>
    </div>
    <div id="state" class="animated fadeIn">
        <h3>Senseo says :</h3>
        <h2 id="senseo">Coffee machine waiting for orders !</h2>
    </div>
    <div id="footer">
        <div id="buttons" class="animated fadeInDown">
            <input class="button firstbutton" type="button" onclick="data('s');" value="Make a coffee"/>
            <br/>
            <div id="smallbuttons">
                <input class="button" type="button" onclick="data('b');" value="Preheat"/>
                <input class="button" type="button" onclick="data('c');" value="Add some water"/>
                <input class="button" type="button" onclick="data('r');" value="Monitor sensors"/>
            </div>
            <br />
        </div>
        <div id="stop" class="hide">
            <input class="button stop" type="button" onclick="data('a')" value="Return standby"/>
        </div>
    </div>
<script>
var senseotext='Coffee machine waiting for orders !';
var i=0;
function getserial() {
    $("#senseo").load("?data");
    var senseotext = ($("#senseo").text());
    stopbutton(senseotext);
}
function data(cmd) {
    $.get("?send="+cmd);
}
function stopbutton(text) {
    if(text != 'Coffee machine waiting for orders !') {
        $("#stop").fadeIn();
    }
    else {
        if (i>1) {
            $("#stop").removeClass("hide");
            i++;
        }
        else $("#stop").fadeOut();
    }
}
window.setInterval(function(){getserial()}, 100);
getserial();
</script>
</body>
</html>
<?php
}
?>
create new paste  /  api  /  trends  /  syntax languages  /  faq  /  tools  /  privacy  /  cookies  /  contact  /  dmca  /  advertise on pastebin  /  scraping  /  go
Site design & logo © 2016 Pastebin; user contributions (pastes) licensed under cc by-sa 3.0 -- Dedicated Server Hosting by Steadfast
Anonymous guest user
