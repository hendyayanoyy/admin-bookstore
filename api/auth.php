<?php 

namespace Api;

include '../config.php';

class Auth {

    public int $id;
    public string $name;
    public string $email;
    public string $password;

    public function __construct() {}

    public function login() {
        $conn = $GLOBALS['conn'];
        $query = "SELECT * FROM members WHERE email = '$this->email'";
        $result = mysqli_query($conn, $query);
        $result = $result->fetch_assoc();

        if ($result && password_verify($this->password, $result['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function register() {
        $conn = $GLOBALS['conn'];
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $query = "INSERT INTO members (nama, email, password) VALUES ('$this->name', '$this->email', '$password')";
        $register = mysqli_query($conn, $query);
        if ($register) {
            return true;
        } else {
            return false;
        }
    }

    public function getProfile() {
        $conn = $GLOBALS['conn'];
        $query = "SELECT * FROM members WHERE email = '$this->email'";
        $result = mysqli_query($conn, $query);
        $result = $result->fetch_assoc();
        return $result;
    }

    public function _map_profile($profile): array {
        return [
            'id' => $profile['id'],
            'nama' => $profile['nama'],
            'email' => $profile['email'],
        ];
    }
}