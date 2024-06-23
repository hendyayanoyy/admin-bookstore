<?php

namespace Helpers;

class Helper {

    public function __construct() {}

    public static function getMember() {
        if(isset($_SESSION['email'])) {
            $query_user = "SELECT * FROM members WHERE email = '" . $_SESSION['email'] . "'";
            $result_user = mysqli_query($GLOBALS['conn'], $query_user);
            $user = $result_user->fetch_assoc();

            return $user;
        }

        return [];
    }

    public static function getMemberById(int $id): array {
        $query_user = "SELECT * FROM members WHERE id = $id";
        $result_user = mysqli_query($GLOBALS['conn'], $query_user);
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