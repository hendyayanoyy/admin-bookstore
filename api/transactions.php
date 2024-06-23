<?php 

namespace Api;

include '../helper/helper.php';
include '../config.php';
include 'detail_transactions.php';
include 'payments.php';

use Api\DetailTransactions;
use Api\Payments;
use Helpers\Helper;

$detail_transaction = new DetailTransactions();
$payments = new Payments();

class Transactions {

    public int $id;
    public string $code_transaction;
    public float $total;
    public string $status;
    public int|null $member_id;
    public array $detail;
    
    CONST PROCESSED = 'processed',
          FAILED = 'failed',
          CANCELLED = 'cancelled',
          REFUND = 'refund',
          WAITINGPAYMENT = 'waiting payment',
          COMPLETED = 'completed';

    public function __construct() {
    }

    public function getTransactions(): array {

        $query = "SELECT * FROM transactions";

        $user = null;
        if ($this->member_id) {
            $user = Helper::getMemberById($this->member_id);
        }
        
        if ($user) {
            $query .= " WHERE member_id = " . $user['id'];
        }
        
        $result = mysqli_query($GLOBALS['conn'], $query);

        $transactions = $result->fetch_all(MYSQLI_ASSOC);
        
        return $transactions;
    }

    public function detailTransaction(int $id): array {
        $query = "SELECT * FROM transactions WHERE id = " . $id;
        $result = mysqli_query($GLOBALS['conn'], $query);
        $transaction = $result->fetch_assoc();
        
        return $transaction ?? [];
    }

    public function createTransaction() {
        $mysqli = $GLOBALS['conn'];
        $mysqli->begin_transaction();

        $user = Helper::getMemberById($this->member_id);
        if (!$user) {
            return false;
        }

        $this->member_id = $user['id'];
        $this->code_transaction = 'TR'.rand(1000, 9999);
        $this->total = $this->total;
        $this->status = self::PROCESSED;

        $query = "INSERT INTO transactions (member_id, code_transaction, total, status) VALUES (" . $this->member_id . ", '" . $this->code_transaction . "', " . $this->total . ", '" . $this->status . "')";

        $result = $mysqli->query($query);

        $this->id = $mysqli->insert_id;

        $detail_transaction = $GLOBALS['detail_transaction'];
        $detail = $this->detail;
        array_map(function($d) use($detail_transaction) {
            $detail_transaction->transaction_id = $this->id;
            $detail_transaction->book_id = $d['book_id'];
            $detail_transaction->quantity = $d['quantity'];
            $detail_transaction->price = $d['price'];
            return $detail_transaction->createDetailTransaction();
        }, $detail);

        if ($result) {
            $mysqli->commit();
            return true;
        } else {
            $mysqli->rollback();
            return false;
        }
    }

    public function _map_transaction($transaction) {
        $transaction['id'] = (int)$transaction['id'];
        $transaction['total'] = (double)$transaction['total'];
    
        $detail_transaction = $GLOBALS['detail_transaction'];
        $detail_transaction->transaction_id = $transaction['id'];
        $detail = $detail_transaction->getDetailTransactions();
        $detail = array_map(function($d) use($detail_transaction) {
            return $detail_transaction->_map_detail_transaction($d);
        }, $detail);
    
        $transaction['detail'] = $detail;

        $payments = $GLOBALS['payments'];
        $payments->transaction_id = $transaction['id'];
        $payment = $payments->detailPayment();
        $transaction['payment'] = $payments->_map_payments($payment);
    
        return $transaction;
    }
}