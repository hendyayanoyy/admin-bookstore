<?php 

namespace Api;

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Helpers\Helper;
use Api\Books;

class Carts {
    public int $id;
    public int $book_id;
    public int|null $member_id;

    private object $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function getLists(): array {
        $query = "SELECT * FROM carts";

        $user = null;
        if ($this->member_id) {
            $user = Helper::getMemberById($this->member_id);
        }
        
        if ($user) {
            $query .= " WHERE member_id = " . $user['id'];
        }

        $conn = $this->conn;
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $result;
    }

    public function detailCart(): array {
        $conn = $this->conn;
        $query = "SELECT * FROM carts WHERE id = " . $this->id;

        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($result);

        return $result ?? [];
    }

    public function cartExists(): array {
        $conn = $this->conn;
        $query = "SELECT * FROM carts WHERE book_id = " . $this->book_id . " AND member_id = " . $this->member_id;

        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($result);

        return $result ?? [];
    }

    public function createCarts(): bool {
        $conn = $this->conn;

        $book = new Books();
        $detail_book = $book->detailBook($this->book_id);
        if(!$detail_book) {
            return false;
        }

        $member = Helper::getMemberById($this->member_id);
        if(!$member) {
            return false;
        }


        $cart = $this->cartExists();
        if($cart) {
            return false;
        }


        $query = "INSERT INTO carts (book_id, member_id) VALUES (" . $this->book_id . ", " . $this->member_id . ")";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        }


        return true;
    }

    public function deleteCart(): bool {
        $conn = $this->conn;
        
        $cart = $this->detailCart();
        if(!$cart) {
            return false;
        }

        $query = "DELETE FROM carts WHERE id = " . $this->id;
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        }

        return true;
    }

    public static function deleteBatchCarts(array $book, $member): bool {
        $conn = getConnection();

        $query = "DELETE FROM carts WHERE book_id IN (" . implode(',', $book) . ") AND member_id = " . $member;
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        }

        return true;
    }

    public function _map_carts($cart):array {
        $cart['id'] = (int) $cart['id'];
        $cart['book_id'] = (int) $cart['book_id'];
        $cart['member_id'] = (int) $cart['member_id'];

        $book = new Books();
        $book->id = $cart['book_id'];
        $detail_book = $book->detailBook($book->id);
        $cart['book'] = $book->_map_books($detail_book);

        $member = Helper::getMemberById($cart['member_id']);
        $cart['member'] = $member;

        return $cart;
    }
}