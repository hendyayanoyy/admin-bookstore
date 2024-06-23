<?php 

namespace Helpers;

use Helpers\JWTHelper;
$jwt = new JWTHelper();

class SessionHelper {

    public function getToken($email) {
        $jwt = $GLOBALS['jwt'];
        $token = $jwt->generateToken($email);

        return $token;
    }

    public function cek_login_exists() {
        $authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? false;

        if(!$authorization) {
            return false;
        }

        $jwt = $GLOBALS['jwt'];
        $jwt->token = str_replace('Bearer ', '', $authorization);
        $authorization = $jwt->checkToken();

        if($authorization) {
            return $authorization;
        }

        return false;
    }

}