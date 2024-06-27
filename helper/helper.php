<?php

namespace Helpers;

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class Helper {

    public function __construct() {}

    public static function getMember() {
        if(isset($_SESSION['email'])) {
            $query_user = "SELECT * FROM members WHERE email = '" . $_SESSION['email'] . "'";
            $result_user = mysqli_query(getConnection(), $query_user);
            $user = $result_user->fetch_assoc();

            return $user;
        }

        return [];
    }

    public static function getMemberById(int $id): array {
        $query_user = "SELECT * FROM members WHERE id = $id";
        $result_user = mysqli_query(getConnection(), $query_user);
        $user = $result_user->fetch_assoc();
        if($user) {
            $user = [
                'id' => (int) $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
            ];
        }

        return $user ?? [];
    }

    public static function getMemberByEmail(string $email): array {
        $query_user = "SELECT * FROM members WHERE email = '$email'";
        $result_user = mysqli_query(getConnection(), $query_user);
        $user = $result_user->fetch_assoc();
        if($user) {
            $user = [
                'id' => (int) $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
            ];
        }

        return $user ?? [];
    }

}