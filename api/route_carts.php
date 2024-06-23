<?php 

include 'carts.php';
header('Content-Type: application/json');

use Api\Carts;

$carts = new Carts();

function getLists() {
    $carts = $GLOBALS['carts'];
    
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $carts->member_id = $_GET['member_id'] ?? null;
        $list = $carts->getLists();
        if(empty($list)) {
            echo json_encode([
                'code' => 404,
                'message' => 'Not Found'
            ]);
            return;
        }

        echo json_encode([
            'data' => array_map(function($cart) use($carts) {
                return $carts->_map_carts($cart);
            }, $list),
            'code' => 200,
            'message' => 'Success Get Data',
        ]);
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    return;
}

function addCarts() {
    $carts = $GLOBALS['carts'];
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $carts->member_id = $_POST['member_id'] ?? null;
        $carts->book_id = $_POST['book_id'] ?? null;
        $create = $carts->createCarts();

        if($create) {
            echo json_encode([
                'code' => 201,
                'message' => 'Success Create Carts',
            ]);
            return;
        }

        echo json_encode([
            'code' => 500,
            'message' => 'Failed Create Carts',
        ]);
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    return;
}

function deleteCarts() {
    $carts = $GLOBALS['carts'];
    
    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $carts->id = $_GET['id'] ?? null;
        $delete = $carts->deleteCart();
        if($delete) {
            echo json_encode([
                'code' => 200,
                'message' => 'Success Delete Carts',
            ]);
            return;
        }

        echo json_encode([
            'code' => 500,
            'message' => 'Failed Delete Carts',
        ]);
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    return;
}

switch($_GET['action']) {
    case 'list':
        getLists();
        break;
    case 'create':
        addCarts();
        break;
    case 'delete':
        deleteCarts();
        break;

    default:
        echo json_encode([
            'code' => 404,
            'message' => 'Not Found'
        ]);
        break;
}

