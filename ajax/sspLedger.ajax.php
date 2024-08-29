<?php
require_once "../controllers/pastdue.controller.php";
require_once "../models/pastdue.model.php";
require_once "../views/modules/session.php";

$ssp = new sspTable();
$ssp->showSSPLedgerTable();

class sspTable {
    public function showSSPLedgerTable() {
        // Get DataTables parameters
        $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';

        // Define the column mapping to your database fields for sorting
        $columnMapping = [
            0 => 'ssp_ref',
            1 => 'ssp_folio',
            2 => 'ssp_tcode',
            3 => 'ssp_tdate',
            4 => 'ssp_desc',
            5 => 'ssp_amount',
            6 => 'ssp_old_ref',
            7 => 'ssp_atm_bal'
        ];

        // Handle sorting
        $sortColumn = isset($columnMapping[$orderColumnIndex]) ? $columnMapping[$orderColumnIndex] : 'ssp_tdate';
        $sortDirection = $orderDirection === 'desc' ? 'DESC' : 'ASC';

        // Get filtered data
        $filteredData = (new ControllerPastdue)->ctrGetFilteredSSPLedger($start, $length, $searchValue, $sortColumn, $sortDirection);
        if ($filteredData === false) {
            echo json_encode([
                "draw" => $draw,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ]);
            exit;
        }
        $totalData = (new ControllerPastdue)->ctrGetSSPLedgerCount();

        $jsonData = [
            "draw" => $draw,
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalData, // Adjust if using server-side search
            "data" => []
        ];

        foreach ($filteredData as $row) {
            $jsonData['data'][] = [
                isset($row["ssp_ref"]) ? $row["ssp_ref"] : '',           // Default to empty string if NULL
                isset($row["ssp_folio"]) ? $row["ssp_folio"] : '',         // Default to empty string if NULL
                isset($row["ssp_tcode"]) ? $row["ssp_tcode"] : 0,         // Default to 0 if NULL (assuming it's an integer)
                isset($row["ssp_tdate"]) ? $row["ssp_tdate"] : '',        // Default to empty string if NULL (assuming it's a date)
                isset($row["ssp_desc"]) ? $row["ssp_desc"] : '',           // Default to empty string if NULL
                isset($row["ssp_amount"]) ? $row["ssp_amount"] : 0.00,     // Default to 0.00 if NULL (assuming it's a decimal)
                isset($row["ssp_old_ref"]) ? $row["ssp_old_ref"] : '',    // Default to empty string if NULL
                isset($row["ssp_atm_bal"]) ? $row["ssp_atm_bal"] : 0.00   // Default to 0.00 if NULL (assuming it's a decimal)
            ];
        }

        // Debugging: Print JSON data directly to test
        header('Content-Type: application/json');
        echo json_encode($jsonData);
        exit;
    }
}
