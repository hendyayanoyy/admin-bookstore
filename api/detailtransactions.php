<?php

namespace Api;

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Api\Books;

class DetailTransactions {

    public int $id;
    public int $transaction_id;
    public int $book_id;
    public int $quantity;
    public float $price;

    private object $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function getDetailTransactions() {
        $query = "SELECT * FROM transaction_details";

        if($this->transaction_id) {
            $query .= " WHERE transaction_id = $this->transaction_id";
        }

        $result = mysqli_query($this->conn, $query);
        $detail = $result->fetch_all(MYSQLI_ASSOC);
        return $detail;
    }

    public function createDetailTransaction() {
        $query = "INSERT INTO transaction_details (transaction_id, book_id, quantity, price) VALUES ($this->transaction_id, $this->book_id, $this->quantity, $this->price)";
        
        $result = mysqli_query($this->conn, $query);

        if($result) return true;

        return false;
    }

    public function _map_detail_transaction($detail) {
        $detail['id'] = (int)$detail['id'];
        $detail['quantity'] = (int)$detail['quantity'];
        $detail['price'] = (double)$detail['price'];
        $detail['book_id'] = (int)$detail['book_id'];
        $detail['transaction_id'] = (int)$detail['transaction_id'];
    
        $books = new Books();
        $books->id = $detail['book_id'];
        $detail_book = $books->detailBook($books->id);
        $detail['book'] = $books->_map_books($detail_book);
    
        return $detail;
    }
}
