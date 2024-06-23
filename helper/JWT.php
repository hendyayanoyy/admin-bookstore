<?php

namespace Helpers;

include 'helper.php';
include '../vendor/autoload.php';


use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Helpers\Helper;

$key = 'jwt-secret-flutter';

class JWTHelper {
    public string $token;
    public string $expire;

    public function __construct() {}

    public function generateToken($email = null) {
        $this->token = $this->encode($email);
        return [
            'access_token' => $this->token,
            'expire' => $this->expire
        ];
    }

    public function checkToken(): array|bool|object {
        $decode = $this->decode();
        if($decode == "invalid token") {
            return false;
        }

        return $decode->data;
    }

    private function decode() {
        try {
            $decoded = JWT::decode($this->token, new Key($GLOBALS['key'], 'HS256'));
            return $decoded;
        } catch(Exception $e) {
            return "invalid token";
        }
    }

    private function encode($email = null) {
        $key = $GLOBALS['key'];

        if($email) {
            $member = Helper::getMemberByEmail($email);
        }


        $expiry = time() + 3600;
        $payload = [
            'iss' => 'flutter.hendi-project.org',
            'aud' => 'flutter.hendi-project.com',
            'iat' => time(),
            'exp' => $expiry,
            'sub' => 'php.hendi-project.com',
            'data' => $member
        ];

        $this->expire = $expiry;
        return JWT::encode($payload, $key, 'HS256');
    }
}