<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <title>iServer | Mobile</title>
        <link rel="stylesheet" href="/assets/css/style.css">
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="target2">
            <div class="box-center-nobg">
                <h1>Loading ...</h1>
            </div>
        </div>
        <div id="log">
            <h1 class="center">Mobile App</h1>
            <div class="pad">
                <form class="login">
                    <input id="password" type="password" class="form-control" placeholder="Password" required><br>
                    <button id="login" class="btn btn-primary pull-right">Login</button>
                </form>
                <p class="lead" id="target">Enter your main password.</p>
                <br><br>
                <p class="lead center">You are on the mobile version of iServer website ! <a href="/login">Go to desktop version !</a></p>
            </div>
        </div>
        <script id="loading" type="x-tmpl-mustache">
            <p class="lead"> {{ result }} </p>
        </script>
        <script id="template" type="x-tmpl-mustache">
            <p><h1 class="center">iSever</h1>
            <p class="padding">User : {{ user }} <br> Date : {{ time }} </p>
                <div class="center">
                    Temperature : {{ temp }} °C<br>
                    Light : {{ light }} %<br>
                    Voltage :  {{ voltage }} V<br>
                    Door : {{ door }} %<br>
                    Alarm status : {{ alarm }} <br>
                    Buzzer status : {{ buzzer }} <br>
                </div>
                <br><br><br>
                <div class="center">
                    <button id="son" class="btn btn-danger">turn alarm {{ alarm_state }}</button>
                    <button id="reset" class="btn btn-success">reset</button>
                    <span class="padding"></span>
                    Colors : <button id="blue" class="btn btn-primary">blue {{ blue }}</button>
                    <button id="red" class="btn btn-danger">red {{ red }}</button>
                    <button id="green" class="btn btn-success">green {{ green }}</button>
                    <button id="white" class="btn btn-info">white {{ white }}</button>
                    <span class="padding"></span>
                    <button style="margin-left: 20px;" id="logout" class="btn btn-danger">Logout</button>
                </div>
            </p>
        </script>
    </body>
    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/mustache.js"></script>
    <script type="text/javascript" src="/assets/js/mobile.js"></script>
</html>
