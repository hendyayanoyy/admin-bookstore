<?php 

namespace Api;

include '../config.php';
include 'banks.php';

use Helpers\Helper;
use Api\Transactions;
use Api\Banks;

$transaction = new Transactions();

class Payments {

    public int $id;
    public string $code_payment;
    public float $total;
    public int|null $bank_id;
    public int|null $number_virtual;
    public int|null $transaction_id;
    public string $status;
    public int|null $member_id;

    CONST FAILED = 'failed',
          PENDING = 'pending',
          COMPLETED = 'completed';

    public function __construct() {}

    public function existsPayment(): array {
        $conn = $GLOBALS['conn'];
        $query = "SELECT * FROM payments WHERE transaction_id = '$this->transaction_id'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($result);
        if ($result) {
            return $result;
        } 

        return [];
    }

    public function detailPayment(): array {
        $conn = $GLOBALS['conn'];
        $query = "SELECT * FROM payments WHERE transaction_id = '$this->transaction_id'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($result);
        if ($result) {
            return $result;
        }

        return [];
    }

    public function createPayment(): bool {
        $conn = $GLOBALS['conn'];

        $transaction = $GLOBALS['transaction'];
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

        if ($result) {
            return true;
        }

        return false;
    }

    public function _map_payments($payment): array {
        if(!empty($payment)) {
            $payment['id'] = (int) $payment['id'];
            $payment['total'] = (double) $payment['total'];
            $payment['bank_id'] = (int) $payment['bank_id'];
            $payment['member_id'] = (int) $payment['member_id'];
            $payment['number_virtual'] = (int) $payment['number_virtual'];
            $payment['transaction_id'] = (int) $payment['transaction_id'];

            $bank = new Banks();
            $detail_bank = $bank->detailBank($payment['bank_id']);
            $payment['bank'] = $bank->_map_banks($detail_bank);

            $payment['member'] = Helper::getMemberById($payment['member_id']);
        }

        return $payment;
    }

}