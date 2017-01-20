<?php
    session_start();

    $speed = 115200;
    $com = "ttyACM0";

    include "class/EG_Julien/Main.php";
    include "class/EG_Julien/Server.php";

    $DB = new PDO('mysql:dbname=iserver;host=localhost', "root", "root");
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $Main = new Main($DB, "root");
    $Server = new Server("root", "Com", "status.txt");

    if (isset($_POST['login']) && isset($_POST['password'])) {
        $Main->getLogin($_POST['login'], sha1($_POST['password']));
    }

    if (!isset($_GET['p'])) {
        $page = $Main->Rooter("login");
    } else {
        $page = $Main->Rooter($_GET['p']);
    }

    if (isset($page)) {
        if ($page == "views/mobile/console" || $page == "views/mobile/login") {
            include "$page.php";
        } else {
            include "assets/doc/header.php";
            include "$page.php";
            if ($page == "views/server/setup") {
                } else {
                    include "assets/doc/footer.php";
                }
        }
    } else {
 ?>
 <!DOCTYPE html>
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
     <head>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
         <title>iServer | Errors</title>
         <link rel="stylesheet" href="assets/css/style.css">
         <!--[if lt IE 9]>
           <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
         <![endif]-->
     </head>
     <body>
        <div class="container center">
            <h1>Oops an error is occuring !</h1>
            <h1><small>Please retry later !</small></h1>
        </div>
     </body>
 </html>
<?php } ?>