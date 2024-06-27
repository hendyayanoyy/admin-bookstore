<?php 

namespace Api;

include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Helpers\Helper;
use Api\Transactions;
use Api\Banks;
use mysqli;

class Payments {

    public int $id;
    public string $code_payment;
    public float $total;
    public int|null $bank_id;
    public int|null $number_virtual;
    public int|null $transaction_id;
    public string $status;
    public int|null $member_id;
    private object $conn;

    CONST FAILED = 'failed',
          PENDING = 'pending',
          COMPLETED = 'completed';

    public function __construct() {
        $this->conn = getConnection();
    }

    public function existsPayment(): array {
        $conn = $this->conn;
        $query = "SELECT * FROM payments WHERE transaction_id = '$this->transaction_id'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($result);
        if ($result) {
            return $result;
        } 

        return [];
    }

    public function detailPayment(): array {
        $conn = $this->conn;
        $query = "SELECT * FROM payments WHERE transaction_id = '$this->transaction_id'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($result);
        if ($result) {
            return $result;
        }

        return [];
    }

    public function createPayment(): bool {
        $conn = $this->conn;

        mysqli_begin_transaction($conn);
        $transaction = new Transactions();
        $transaction = $transaction->detailTransaction($this->transaction_id);
        if (!$transaction) {
            return false;
        }

        $exists = $this->existsPayment();
        if ($exists && $exists['status'] !== SELF::FAILED) {
            return false;
        }

        $member = Helper::getMemberById($this->member_id);
        if (!$member) {
            return false;
        }
        
        $total = $this->total;
        $bank_id = $this->bank_id;
        $transaction_id = $this->transaction_id;
        $number_virtual = rand(100000000000, 999999999999);
        $code_payment = "PY".rand(100000, 999999);

        $query = "INSERT INTO payments (code_payment, total, bank_id, number_virtual, transaction_id, status, member_id) VALUES ('$code_payment', '$total', '$bank_id', '$number_virtual', '$transaction_id', '".SELF::PENDING."', '$this->member_id')";

        $result = mysqli_query($conn, $query);

        $query = "UPDATE transactions SET status = 'waiting payment' WHERE id = '$transaction_id'";
        mysqli_query($conn, $query);

        if ($result) {
            mysqli_commit($conn);
            return true;
        }

        mysqli_rollback($conn);
        return false;
    }

    public function _map_payments($payment): array {
        if(!empty($payment)) {
            $payment['id'] = (int) $payment['id'];
            $payment['total'] = (double) $payment['total'];
            $payment['bank_id'] = (int) $payment['bank_id'];
            $payment['member_id'] = (int) $payment['member_id'];
            $payment['transaction_id'] = (int) $payment['transaction_id'];

            $bank = new Banks();
            $detail_bank = $bank->detailBank($payment['bank_id']);
            $payment['bank'] = $bank->_map_banks($detail_bank);

            $payment['member'] = Helper::getMemberById($payment['member_id']);
        }

        return $payment;
    }

}