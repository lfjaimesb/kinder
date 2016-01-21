<?php
namespace Control;
use Core\Control;
use Lib\Jwt\JWT;
use Lib\Jwt\ExpiredException;
use Core\Config;

class App extends Control{
    public $Response = [];
    public $json = true;
    public $UserToken = [];

    function before($funcion){
        if($funcion != "authenticate"){
            try {
                $secretKey = base64_decode(Config::Reader("SALT"));
                $header = apache_request_headers();

                $header["Authorization"] = trim(str_replace("Bearer","",$header["Authorization"]));
                $jwt = JWT::decode($header["Authorization"], $secretKey,array('HS512'));

                $this->UserToken = $jwt;
            } catch (ExpiredException $e) {
                $this->Response["error"] = $e->getMessage();
                return false;
            }
        }

        return true;
    }

    function after(){
        if($this->json){
            if(isset($this->Response["error"])){
                header('HTTP/1.0 406 Not Acceptable');
            }

            header('Content-type: application/json');
            echo json_encode($this->Response);
        }
    }
}

?>
