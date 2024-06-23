<?php 

include 'banks.php';
header('Content-Type: application/json');

use Api\Banks;
$banks = new Banks();

function getBanks() {
    $banks = new Banks();
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $list = $banks->getBanks();
        if($list) {
            echo json_encode([
                'data' => array_map(function($bank) use($banks) {
                    return $banks->_map_banks($bank);
                }, $list),
                'code' => 200,
                'message' => 'Success',
            ]);
            header('status: 200');
            return;
        }

        echo json_encode([
            'code' => 404,
            'message' => 'Not Found'
        ]);
        header('status: 404');
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    header('status: 405');
    return;
}

function detailBank() {
    $banks = new Banks();
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $detail = $banks->detailBank($_GET['id']);
        if($detail) {
            echo json_encode([
                'data' => $banks->_map_banks($detail),
                'code' => 200,
                'message' => 'Success',
            ]);
            header('status: 200');
            return;
        }

        echo json_encode([
            'code' => 404,
            'message' => 'Not Found'
        ]);
        header('status: 404');
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    header('status: 405');
    return;
}

switch($_GET['action']) {
    case 'list':
        getBanks();
        break;
    case 'detail':
        detailBank();
        break;
    default:
        echo json_encode([
            'code' => 404,
            'message' => 'Not Found'
        ]);
        header('status: 404');
        break;
}
