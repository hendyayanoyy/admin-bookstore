<?php

include 'books.php';
header('Content-Type: application/json');

use Api\Book;

$books = new Book();

function getBooks() {
    $books = $GLOBALS['books'];
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $list = $books->getBooks();

        if(empty($list)) {
            echo json_encode([
                'data' => [],
                'code' => 404,
                'message' => 'Not found',
            ]);

            header('status: 404');

            return;
        }

        echo json_encode([
            'data' => array_map(function($book) use($books) {
                return $books->_map_books($book);
            }, $list),
            'code' => 200,
            'message' => 'Success get data',
        ]);

        header('status: 200');

        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method not allowed',
    ]);

    header('status: 405');

    return;
}

function topBooks() {
    $books = $GLOBALS['books'];
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $list = $books->topBooks();

        if(empty($list)) {
            echo json_encode([
                'data' => [],
                'code' => 404,
                'message' => 'Not found',
            ]);

            header('status: 404');

            return;
        }

        echo json_encode([
            'data' => array_map(function($book) use($books) {
                return $books->_map_books($book);
            }, $list),
            'code' => 200,
            'message' => 'Success get data',
        ]);

        header('status: 200');

        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method not allowed',
    ]);

    header('status: 405');

    return;
}

function newsBooks() {
    $books = $GLOBALS['books'];
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $list = $books->newsBooks();

        if(empty($list)) {
            echo json_encode([
                'data' => [],
                'code' => 404,
                'message' => 'Not found',
            ]);

            header('status: 404');

            return;
        }

        echo json_encode([
            'data' => array_map(function($book) use($books) {
                return $books->_map_books($book);
            }, $list),
            'code' => 200,
            'message' => 'Success get data',
        ]);

        header('status: 200');

        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method not allowed',
    ]);

    header('status: 405');

    return;
}

function detailBook() {
    $books = $GLOBALS['books'];
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $book = $books->detailBook($_GET['id']);
        if(empty($book)) {
            echo json_encode([
                'data' => [],
                'code' => 404,
                'message' => 'Not found',
            ]);

            header('status: 404');

            return;
        }

        echo json_encode([
            'data' => $books->_map_books($book),
            'code' => 200,
            'message' => 'Success get data',
        ]);

        header('status: 200');

        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method not allowed',
    ]);

    header('status: 405');

    return;
}

switch($_GET['action']) {
    case 'read':
        getBooks();
        break;
    case 'top':
        topBooks();
        break;
    case 'new':
        newsBooks();
        break;
    case 'detail':
        detailBook();
        break;
    default:
        echo json_encode([
            'code' => 404,
            'message' => 'Not found',
        ]);
        break;
}