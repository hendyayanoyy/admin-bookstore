<?php

namespace Api;

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class Banks {

    public int $id;
    public string $name;
    public string $code_bank;
    public float $admin_fee;
    public string $url;
    public string $signature;

    private object $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function getBanks(): array {
        $conn = $this->conn;
        $query = "SELECT * FROM banks";
        $result = mysqli_query($conn, $query);
        $result = $result->fetch_all(MYSQLI_ASSOC);
        if ($result) {
            return $result;
        }

        return [];
    }

    public function detailBank(int $id): array {
        $conn = $this->conn;
        $query = "SELECT * FROM banks WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $result = $result->fetch_assoc();
        if ($result) {
            return $result;
        }

        return [];
    }

    public function _map_banks($bank): array {
        $bank = [
            'id' => (int) $bank['id'],
            'name' => $bank['name'],
            'code_bank' => $bank['code_bank'],
            'admin_fee' => (double) $bank['admin_fee'],
        ];

        return $bank;
    }
}
