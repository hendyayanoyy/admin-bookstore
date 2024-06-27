<?php 

namespace Api;

include $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

class Books {
    public int $id;
    public string $title;
    public string $author;
    public string $description;
    public string $image;
    public int $year;
    public float $rating;
    public float $price;

    private object $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function getBooks(): array {
        $query = "SELECT * FROM books";

        $list_books = mysqli_query($this->conn, $query);
        $list_books = $list_books->fetch_all(MYSQLI_ASSOC);
        
        return $list_books;
    }

    public function topBooks(): array {
        // Implementasi logika untuk mendapatkan buku teratas
        $query = "SELECT * FROM books ORDER BY rating DESC LIMIT 6";

        $top_books = mysqli_query($this->conn, $query);
        $top_books = $top_books->fetch_all(MYSQLI_ASSOC);
        
        return $top_books;
    }

    public function newsBooks(): array {
        // Implementasi logika untuk mendapatkan buku teratas
        $query = "SELECT * FROM books ORDER BY id DESC LIMIT 6";

        $news_books = mysqli_query($this->conn, $query);
        $news_books = $news_books->fetch_all(MYSQLI_ASSOC);
        
        return $news_books;
    }

    public function detailBook(int $id): array {
        $query = "SELECT * FROM books WHERE id = $id";

        $detail_books = mysqli_query($this->conn, $query);
        $detail_books = $detail_books->fetch_assoc();
        
        return $detail_books;
    }

    public function _map_books(array $book): array {
        $book['id'] = (int)$book['id'];
        $book['rating'] = (double)$book['rating'];
        $book['year'] = (int)$book['year'];
        $book['price'] = (double)$book['price'];

        if($book['image']) {
            $book['image'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/assets/books/'.$book['image'];
        }

        if($book['description']) {
            $book['short_description'] = substr($book['description'], 0, 200).'...';
        }

        return $book;
    }

}