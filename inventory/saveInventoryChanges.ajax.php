<?php
require_once "../views/modules/session.php";
require_once "../models/connection.php";

class Inventory {

    public function saveInventoryChanges() {
        $item_id = $_GET['item_id'];
        $field_id = $_GET['field_id'];
        $field_value = $_GET['field_value'];
        $branch_name = $_GET['branch_name'];

        if (!empty($item_id) && !empty($field_id) && !empty($branch_name)) {
            // Allow empty values
            $this->mdlUpdate($item_id, $field_id, $field_value, $branch_name);
        } else {
            echo "Missing required fields.";
        }
    }

    private function mdlUpdate($item_id, $field_id, $field_value, $branch_name) {
        $allowed_fields = ['date_purchased', 'item_qty', 'item_description', 'ref_no', 'sticker_no', 'item_code', 
        'est_life_mon', 'est_life_year', 'acq_cost', 'acc_depr', 'ffe_depr', 'book_value', 'branch_name', 'type', 'status'];
        
        if (!in_array($field_id, $allowed_fields)) {
            echo "Invalid field.";
            return;
        }

        // Prepare query
        $query = "UPDATE `inventory` SET $field_id = :field_value, branch_name = :branch_name WHERE id = :item_id";
        $stmt = (new Connection)->connect()->prepare($query);

        $stmt->bindParam(":item_id", $item_id, PDO::PARAM_INT);
        $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);

        // Handle empty values
        if ($field_value === '' || $field_value === null) {
            $stmt->bindValue(":field_value", null, PDO::PARAM_NULL);
        } elseif (is_numeric($field_value) && intval($field_value) == $field_value) {
            $stmt->bindValue(":field_value", $field_value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(":field_value", $field_value, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            echo "ok";
        } else {
            echo "error";
        }

        // Close the cursor
        $stmt->closeCursor();
    }

    public function saveAddInventoryList() {
        $item_qty = $_GET['item_qty'];
    
        // Extract numeric part of the item_code
        $item_code = $_GET['item_code'];
        preg_match('/(\d+)$/', $item_code, $matches);
        $item_code_num = isset($matches[1]) ? intval($matches[1]) : 0;
    
        $branch_name = $_GET['branch_name'];
        $date_purchased = $_GET['date_purchased'];
        $item_description = $_GET['item_description'];
        $ref_no = $_GET['ref_no'];
        $sticker_from = $_GET['sticker_from'];
        $sticker_to = $_GET['sticker_to'];
        $est_life_mon = $_GET['est_life_mon'];
        $est_life_year = $_GET['est_life_year'];
        $acq_cost = $_GET['acq_cost'];
        $acc_depr = $_GET['acc_depr'];
        $ffe_depr = $_GET['ffe_depr'];
        $book_value = $_GET['book_value'];
        $type = $_GET['type'];
        $status = $_GET['status'];
    
        try {
            $pdo = (new Connection)->connect();
            $pdo->beginTransaction();
    
            for ($i = 0; $i < $item_qty; $i++) {
                // Increment item code number
                $new_item_code_num = str_pad($item_code_num + $i, strlen($matches[1]), '0', STR_PAD_LEFT);
                $new_item_code = preg_replace('/\d+$/', $new_item_code_num, $item_code);
    
                // Calculate sticker number for each item
                if ($sticker_from && $sticker_to && ($sticker_to - $sticker_from + 1) >= $item_qty) {
                    $sticker_length = strlen($sticker_from); // Get the length to pad correctly
                    $sticker_no = str_pad($sticker_from + $i, $sticker_length, '0', STR_PAD_LEFT);
                } else {
                    $sticker_no = $_GET['sticker_no'];  // Default to single sticker number if range is invalid
                }
                $stmt = $pdo->prepare("INSERT INTO `inventory` (item_code, branch_name, date_purchased, item_description, ref_no, sticker_no, 
                est_life_mon, est_life_year, acq_cost, acc_depr, ffe_depr, book_value, type, status) 
                VALUES (:item_code, :branch_name, :date_purchased, :item_description, :ref_no, :sticker_no, :est_life_mon, :est_life_year,
                :acq_cost, :acc_depr, :ffe_depr, :book_value, :type, :status)");
    
                $stmt->bindParam(":item_code", $new_item_code, PDO::PARAM_STR);
                $stmt->bindParam(":branch_name", $branch_name, PDO::PARAM_STR);
                $stmt->bindParam(":date_purchased", $date_purchased, PDO::PARAM_STR);
                $stmt->bindParam(":item_description", $item_description, PDO::PARAM_STR);
                $stmt->bindParam(":ref_no", $ref_no, PDO::PARAM_STR);
                $stmt->bindParam(":sticker_no", $sticker_no, PDO::PARAM_STR);
                $stmt->bindParam(":est_life_mon", $est_life_mon, PDO::PARAM_INT);
                $stmt->bindParam(":est_life_year", $est_life_year, PDO::PARAM_INT);
                $stmt->bindParam(":acq_cost", $acq_cost, PDO::PARAM_STR);
                $stmt->bindParam(":acc_depr", $acc_depr, PDO::PARAM_STR);
                $stmt->bindParam(":ffe_depr", $ffe_depr, PDO::PARAM_STR);
                $stmt->bindParam(":book_value", $book_value, PDO::PARAM_STR);
                $stmt->bindParam(":type", $type, PDO::PARAM_STR);
                $stmt->bindParam(":status", $status, PDO::PARAM_STR);
                $stmt->execute();
            }
    
            $pdo->commit();
            echo "ok";
    
        } catch (PDOException $exception) {
            $pdo->rollBack();
            echo "error";
        }
    
        $stmt = null;
    }
    

}

$inventory = new Inventory();
if (isset($_GET['action']) && $_GET['action'] === 'update') {
    $inventory->saveInventoryChanges();
} else if (isset($_GET['action']) && $_GET['action'] === 'insert') {
    $inventory->saveAddInventoryList();
}

