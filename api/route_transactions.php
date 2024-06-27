<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
header('Content-Type: application/json');
use Api\Transactions;
use Api\Payments;

function getTransactions() {
    $transactions = new Transactions();
    
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $transactions->member_id = $_GET['member_id'] ?? null;
        $list = $transactions->getTransactions();

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
            'data' => array_map(function($transaction) use($transactions) {
                return $transactions->_map_transaction($transaction);
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

function detailTransaction() {
    $transactions = new Transactions();

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $transaction = $transactions->detailTransaction($_GET['id']);
        if(empty($transaction)) {
            echo json_encode([
                'data' => [],
                'code' => 404,
                'message' => 'Not found',
            ]);

            header('status: 404');

            return;
        }

        echo json_encode([
            'data' => $transactions->_map_transaction($transaction),
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

function createTransaction() {
    $transactions = new Transactions();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $transactions->total = $_POST['total']; 
        $transactions->detail = json_decode($_POST['detail']);
        $transactions->member_id = $_POST['member_id'];
        $transaction = $transactions->createTransaction();
        
        if($transaction) {
            echo json_encode([
                'data' => $transaction,
                'code' => 201,
                'message' => 'Success create transaction',
            ]);
            header('status: 201');
            return;
        }

        echo json_encode([
            'data' => [],
            'code' => 412,
            'message' => 'Failed create transaction',
        ]);
        header('status: 412');
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method not allowed',
    ]);
    header('status: 405');
    return;
}

function createPayments() {
    $payments = new Payments();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $payments->transaction_id = $_POST['transaction_id'];
        $payments->total = $_POST['total'];
        $payments->bank_id = $_POST['bank_id'];
        $payments->member_id = $_POST['member_id'];

        $transaction = $payments->createPayment();
        
        if($transaction) {
            echo json_encode([
                'code' => 201,
                'message' => 'Success create transaction',
            ]);
            header('status: 201');
            return;
        }

        echo json_encode([
            'code' => 412,
            'message' => 'Failed create transaction',
        ]);
        header('status: 412');
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method not allowed',
    ]);
    header('status: 405');
    return;
}

function detailPayment() {
    $payments = new Payments();

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $payments->transaction_id = $_GET['id'];
        $payment = $payments->detailPayment();
        if(empty($payment)) {
            echo json_encode([
                'data' => [],
                'code' => 404,
                'message' => 'Not found',
            ]);

            header('status: 404');

            return;
        }

        echo json_encode([
            'data' => $payments->_map_payments($payment),
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
    case 'get-transactions':
        getTransactions();
        break;

    case 'detail-transaction':
        detailTransaction();
        break;

    case 'create-transaction':
        createTransaction();
        break;

    case 'create-payments':
        createPayments();
        break;

    case 'detail-payment':
        detailPayment();
        break;

    default:
        echo json_encode([
            'data' => [],
            'code' => 404,
            'message' => 'Not found',
        ]);
}

