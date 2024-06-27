<?php 

namespace Api;

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class Auth {

    public int $id;
    public string $name;
    public string $email;
    public string $password;

    private object $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function login() {
        $conn = $this->conn;
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
        $conn = $this->conn;
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
        $conn = $this->conn;
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