<?php 

namespace Helpers;

session_start();

use Helpers\JWTHelper;

class SessionHelper {

    public function getToken($email) {
        $jwt = new JWTHelper();
        $token = $jwt->generateToken($email);

        return $token;
    }

    public function cek_login_exists() {
        $jwt = new JWTHelper();
        $authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? false;

        if(!$authorization) {
            return false;
        }

        $jwt->token = str_replace('Bearer ', '', $authorization);
        $authorization = $jwt->checkToken();

        if($authorization) {
            return $authorization;
        }

        return false;
    }

    public function cek_login_admin() {
        if(isset($_SESSION['username']) || isset($_SESSION['email'])) {
            return true;
        }

        return false;
    }

}