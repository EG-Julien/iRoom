udo<?php

    header("Access-Control-Allow-Origin: *");

    require_once "class/EG_Julien/Server.php";

    $DB = new PDO('mysql:dbname=iserver;host=localhost', "root", "root");
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $Server = new Server("root", "Serial", "115200");

    $Server->getServer('ttyAMA0', 115200);

    /**
    * @init var
    * Methods / Protocols / API Version
    **/

    $Methods = ['post', 'get'];
    $Protocols = ['json', 'data', 'start', 'auth'];
    $Datas = ['all', 'degrees', 'intdegrees', 'tension', 'light', 'door', 'a_status', 'b_status', 'white', 'blue', 'green', 'red'];

    $version = '2.0';

    /**
    * @init URL params :
    *
    * Methods get => /get/json/data
    *
    * Methods post => /post/data/token/data
    *
    * Errors verification :
    **/

    if (!isset($_GET['p'])) {
        $page = 'null';
    } else {
        $page = $_GET['p'];
    }

    if ($page != 'null') {
        $request = explode("/", $page);

        $request_lenght = count($request) - 1;

        $method = $request[1];
        $protocol = $request[2];

        if (in_array($method, $Methods) == FALSE) {
            $errors = ['methods' => 'Unregonized method !'];
        } elseif (in_array($protocol, $Protocols) == FALSE) {
            $errors = ['protocols' => 'Unregonized protocol !'];
        } elseif ($method == 'get' && ($request_lenght > 3 || $request_lenght < 3)) {
            $errors = ['request_lenght' => 'Not enought or too few arguments in your request !'];
        } elseif ($method == 'post' && ($request_lenght > 4 || $request_lenght < 4)) {
            $errors = ['request_lenght' => 'Not enought or too few arguments in your request !'];
        }

        if ($method == 'post' && $request_lenght == 4 && $protocol == 'data' && strlen($request[3]) == 40 && isset($request[4])) {
            $user = $request[3];
            $data = $request[4];

            $q = $DB->prepare("SELECT login FROM users WHERE password = ?");
            $q->execute([$user]);
            $result = $q->fetch();

            if (isset($result) && $result != FALSE) {
                $json = [
                    'api' => 'iServer API',
                    'version' => $version,
                    'timestamp' => time(),
                    'status' => 'success',
                    'user' => $result,
                    'response' => ['data_posted' => $data]
                ];

                $data = str_replace("$", "/", $data);
                $Server->setSerial($data);

                echo json_encode($json);
            } else {
                $errors = ['user' => 'User not found in the DB'];
            }

        } elseif ($method == 'get' && $request_lenght == 3 && $protocol == 'json' && isset($request[3])) {

            $what = $request[3];

            if (in_array($what, $Datas) == TRUE) {

                $data = $Server->getSerial();
                $data = explode("\n", $data);

                for ($i=0; $i < count($Datas); $i++) {
                    if ($what == $Datas[$i]) {
                        if ($i == 0) {
                            $return = [
                                $Datas[1] => $data[1],
                                $Datas[1] => $data[2],
                                $Datas[2] => $data[3],
                                $Datas[3] => $data[4],
                                $Datas[4] => $data[5],
                                $Datas[5] => $data[6],
                                $Datas[6] => $data[7],
                                $Datas[7] => $data[8],
                                $Datas[8] => $data[9],
                                $Datas[9] => $data[10],
                                $Datas[10] => $data[11]
                            ];
                        } else {
                            $return = [$what => $data[$i]];
                        }
                        $json = [
                            'api' => 'iServer API',
                            'version' => $version,
                            'timestamp' => time(),
                            'status' => 'success',
                            'response' => $return
                        ];
                    }
                }

                echo json_encode($json);
            } else {
                $errors = ['data_get' => 'An error has been detected in your API syntax !'];
            }
        } elseif ($method == 'get' && $protocol == 'auth' && $request_lenght == 3 && isset($request[3])) {
            $q = $DB->prepare('SELECT * FROM users WHERE password = ?');
            $q->execute([$request[3]]);
            $auth = $q->fetch();

            if (!empty($auth)) {
                echo json_encode($auth);
            } else {
                $errors = ['get_auth' => 'Invalid token given in parameter !'];
            }
        } else {
            $errors = ['post_request' => 'An error has been detected in your API syntax !'];
        }

        if (isset($errors)) {
            echo json_encode($errors);
        }

    } else {
        $errors = ['request_error' => 'You need ask something to have a response !'];

        echo json_encode($errors);
    }