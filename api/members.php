<?php

namespace Api;

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class Members {

    public int $id;
    public string $nama;
    public string $email;
    public string $password;

    private object $conn;
    
    public function __construct() {
        $this->conn = getConnection();
    }

    public function detailMember(int $id = null): array {
        $conn = $this->conn;
        $query = "SELECT * FROM members WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $result = $result->fetch_assoc();
        if ($result) {
            return $result;
        }

        return [];
    }

    public function _map_members($member): array {
        $member = [
            'id' => (int) $member['id'],
            'nama' => $member['nama'],
            'email' => $member['email'],
        ];

        return $member;
    }

}