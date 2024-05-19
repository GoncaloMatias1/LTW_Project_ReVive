<?php
class Transaction {
    public int $transaction_id;
    public int $item_id;
    public int $buyer_id;
    public int $seller_id;
    public string $transaction_date;

    public function __construct(array $data) {
        $this->transaction_id = $data['transaction_id'];
        $this->item_id = $data['item_id'];
        $this->buyer_id = $data['buyer_id'];
        $this->seller_id = $data['seller_id'];
        $this->transaction_date = $data['transaction_date'];
    }

    public static function getTransactionsBySeller(PDO $db, int $seller_id): array {
        $stmt = $db->prepare('SELECT * FROM transactions WHERE seller_id = ?');
        $stmt->execute([$seller_id]);
        $transactions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = new Transaction($row);
        }
        return $transactions;
    }

    public static function getTransactionDetails(PDO $db, int $transaction_id): ?Transaction {
        $stmt = $db->prepare('SELECT * FROM transactions WHERE transaction_id = ?');
        $stmt->execute([$transaction_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Transaction($data) : null;
    }

    public static function getTransactionDetailsByItem(PDO $db, int $item_id): ?Transaction {
        $stmt = $db->prepare('SELECT * FROM transactions WHERE item_id = ?');
        $stmt->execute([$item_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Transaction($data) : null;
    }
}
?>
