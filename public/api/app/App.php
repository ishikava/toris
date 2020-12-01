<?php


namespace App;


class App
{

    public static $config;
    public static $log;
    public static $router;

    public function __construct()
    {
        self::$config = new Config();

        self::$log = new Logger();

        self::$router = new Router();

        //debug
        if (self::$config->get('display_errors')) {
            ini_set("display_errors", "1");
            error_reporting(E_ALL);
        } else {
          ini_set("display_errors", "0");
          error_reporting(E_NONE);
        }

        //timezone
        ini_set("date.timezone", "Europe/Moscow");

        //хук для api
        if (stripos(self::$router->uri[0], '/api') !== false) {

            if (self::$router->uri[0] == "/api") {
                self::$router->uri[0] = '/api/index';
            }

            if (file_exists(__DIR__ . '/..' . self::$router->uri[0] . '.php')) {

                $postgres = pg_connect(self::$config->get('pgstring'));

                $error = null;
                $result = [];

                require_once __DIR__ . '/..' . self::$router->uri[0] . '.php';

                $output = json_encode(
                    [
                        "JSONRPC" => "2.0",
                        "code" => 20000,
                        "data" => $result
                    ]
                    , JSON_UNESCAPED_UNICODE);


                // Allow from any origin
                if (isset($_SERVER['HTTP_ORIGIN'])) {
                    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
                    // you want to allow, and if so:
                    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                    header('Access-Control-Allow-Credentials: true');
                    header('Access-Control-Max-Age: 86400');    // cache for 1 day
                }

                // Access-Control headers are received during OPTIONS requests
                if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                        // may also be using PUT, PATCH, HEAD etc
                        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
                    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
                    exit;
                }

                header('Content-Type: application/json; charset=utf-8');
                header('Content-Length: ' . strlen($output));
                echo $output;
                exit;

            } else {
                App::$log->log('error', '404 Not Found');
                header("HTTP/1.1 404 Not Found");
                echo '404 Not Found';
                exit;
            }
        }

        $route = array_search(self::$router->uri[0], array_column(self::$router->routes, 'uri'));

        if ($route === false) {
            App::$log->log('error', '404 Not Found');
            header("HTTP/1.1 404 Not Found");
            echo '404 Not Found';
            exit;
        }

    }

}
