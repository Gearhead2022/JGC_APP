<?php
    require_once "session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../views/img/JGC.png" type="image/x-icon">
    <title>Inventory-spreadsheet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: gainsboro;
        }
        .spreadsheet {
            overflow-x: hidden;
            overflow-y: hidden;
            white-space: nowrap;
            max-width: 1870px;
        }
        .container-fixed-width {
            width: 1870px; /* Fixed container width */
            margin: 0 auto; /* Center align the container */
        }
        .spreadsheet h6, p, textarea, select#est_life_year, select#est_life_year, select#status, select#type,
        .spreadsheet input[type="text"],
        .spreadsheet input[type="date"],
        .spreadsheet input[type="number"] {
            border: 1px solid black;
            margin: 0;
            padding: 2px;
            box-sizing: border-box;
            text-align: center;
            width: 100%;
            font-size: 12px;
        }
        .header-cell {
            background-color:khaki;
        }

        .seperator-cell{
            height: 5px;
        }

        input::placeholder, textarea::placeholder{
            font-style: italic;
            color: lightsteelblue;
        }

        textarea{
            overflow-y: hidden;
        }

        .input-cell,
        .spreadsheet select, .spreadsheet textarea,
        .spreadsheet input[type="text"],
        .spreadsheet input[type="date"],
        .spreadsheet input[type="number"] {
            background-color: aliceblue;
            line-height: 1.2em;
            margin-bottom:  -2px;
            text-align: center;
        }
        .seperator-cell,
        .header-cell,
        .input-cell {
            flex-shrink: 0;
            box-sizing: border-box;
        }
        .seperator-cell{
            width: 1840px;
        }
        .header-cell:nth-child(1),
        .input-cell:nth-child(1) {
            width: 130px;
        }
        .header-cell:nth-child(2),
        .input-cell:nth-child(2) {
            width: 100px;
        }
        .header-cell:nth-child(3),
        .input-cell:nth-child(3) {
            width: 230px;
        }
        .header-cell:nth-child(4),
        .input-cell:nth-child(4) {
            width: 130px;
        }
        .header-cell:nth-child(5),
        .input-cell:nth-child(5){
            width: 110px;
        }

        .header-cell:nth-child(6),
        .input-cell:nth-child(6) {
            width: 120px;
        }
        .header-cell:nth-child(7),
        .input-cell:nth-child(7) {
            width: 170px;
        }
        .header-cell:nth-child(8),
        .input-cell:nth-child(8) {
            width: 160px;
        }
        .header-cell:nth-child(9),
        .input-cell:nth-child(9) {
            width: 235px;
        }
        .header-cell:nth-child(10),
        .input-cell:nth-child(10) {
            width: 150px;
        }
        .header-cell:nth-child(11),
        .input-cell:nth-child(11) {
            width: 115px;
        }
        .header-cell:nth-child(12),
        .input-cell:nth-child(12) {
            width: 100px;
        }
        .header-cell:nth-child(13),
        .input-cell:nth-child(13) {
            width: 90px;
        }
        
        @media print {
            body{
                margin-left: 20px;
            }
            
            select.spreadsheet-cell, input#acq_cost, input#acc_depr,
            input#ffe_depr, input#book_value, input#ref_no, textarea#item_description, input#branch_name[type="text"] {
                display: none;
            }

            .btn-custom-print{
                display: none;
            }

            input.print-value {
                display: inline !important;
                border: 1px solid black !important;
                margin: 0 !important;
                padding: 2px !important;
                box-sizing: border-box !important;
                text-align: center !important;
                width: 100% !important;
                font-size: 12px !important;
            }
        }
        input.print-value {
            display: none;
        }


        .modal-content, .modal-footer{
            background-color: #C9E0DC;
        }
        .modal-title{
            color: black;
        }

        .modal-body{
            background-color: #F0FAF9;
        }

        .form-control:focus{
            background-color: #efebf5 !important;
            border: solid black 1px;
            color: black;
        }

/* 
        input::placeholder{
        
            color: green;
        } */
        .form-control{
            background-color: white;
            border: solid black 1px;
        }
        .form-control[readonly]{
            background-color: #efebf5;
            border: solid black 1px;
            color: black;
        }
                
    </style>
    <?php require_once "../../models/connection.php"; 
    
    if (isset($_SESSION['branch_name'])) {
        $branch_str = substr($_SESSION['branch_name'], 0, 3);

        if ($branch_str === 'EMB') {
            $title_str = 'EMB FINANCE CORP';
        } else if($branch_str === 'FCH') {
            $title_str = 'FCH FINANCE CORP';
        } else if($branch_str === 'RLC') {
            $title_str = 'RLC FINANCE CORP';
        } else if($branch_str === 'ELC') {
            $title_str = 'ELC FINANCE CORP';
        }

    } else {
        echo "<script> location.href='../../index.php'; </script>";
        exit;
    }

    $item_id = (new Connection)->connect()->query("SELECT * from inventory ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
    if(empty($item_id)){
        $id = 0;
    }else{
        $id = $item_id['id'];
    }
    $last_id = $id + 1;
    $id_holder = "IC" . str_repeat("0",5-strlen($last_id)).$last_id;   
    
    ?>
</head>
<body>
    <div class="clearfix"></div>
  
    <div class="content-wrapper">
        <div class="container-fluid container-fixed-width">
            <div class="row mb-3 mt-2">
                <div class="col-12 fs-5 fw-bold"><?php echo $title_str?></div>
                <div class="col-12 fs-6">SUMMARY OF FURNITURE, FIXTURES & EQUIPMENT</div>
                <div class="col-11 fs-6">AS OF <?php echo strtoupper(date('F d, Y', time())); ?></div>
                <div class="col-11 d-flex justify-content-end">  <!-- Print Button -->
                <button class="btn btn-dark text-light btn-round waves-effect btn-custom-print me-2" data-bs-toggle="modal" data-bs-target="#addItemModal"><span><i class="fa fa-plus-circle"></i> &nbsp;Add Item</span></button>
                    <button class="btn btn-primary btn-round waves-effect btn-custom-print me-2 enableEdit"><span><i class="fa fa-pencil"></i> &nbsp;Enable Edit</span></button>
                    <button class="btn btn-success btn-round waves-effect btn-custom-print" onclick="window.print()"><span><i class="fa fa-print"></i> &nbsp;Print</span></button>
                </div>
            </div>
            <div class="spreadsheet">
                <div class="row g-0">
                    <div class="header-cell">
                        <h6>DATE ACQUIRED</h6>
                    </div>
                    <div class="header-cell">
                        <h6>QTY UNIT</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ITEM DESCRIPTION/SERIAL NO.</h6>
                    </div>
                    <div class="header-cell">
                        <h6>REF. NO.</h6>
                    </div>
                    <div class="header-cell">
                        <h6>STICKER NO.</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ITEM CODE</h6>
                    </div>
                    <div class="header-cell">
                        <h6>EST. LIFE</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ACQUISITION COST</h6>
                    </div>
                    <div class="header-cell">
                        <h6>ACCUMULATED DEPRECATION</h6>
                    </div>
                    <div class="header-cell">
                        <h6>FFE DEPRECATION</h6>
                    </div>
                    <div class="header-cell">
                        <h6>BOOK VALUE</h6>
                    </div>
                    <div class="header-cell">
                        <h6>TYPE</h6>
                    </div>
                    <div class="header-cell">
                        <h6>STATUS</h6>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="header-cell">
                        <p>(Date Booked)</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>(Years)</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>(as of this month)</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                    <div class="header-cell">
                        <p>&nbsp;</p>
                    </div>
                </div>

                <?php
                    $branch_name = $_SESSION['branch_name'];
                    $get_item_code = (new Connection)->connect()->query("SELECT item_code FROM inventory WHERE branch_name = '$branch_name' GROUP BY item_code")->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($get_item_code as $code){

                        $item_cod = $code['item_code'];
                        $get_inventory_list = (new Connection)->connect()->query("SELECT * FROM inventory WHERE item_code = '$item_cod'")->fetchAll(PDO::FETCH_ASSOC);

                        $totals = [];
                        $sticker_list = [];
                        $i = 0;
                        $j = 0;
                        $code_list = [];

                        foreach ($get_inventory_list as $inv) {
                            $item_desc = $inv['item_description'];
                            $sticker_no = $inv['sticker_no'];
                            $item_code = $inv['item_code'];
                            
                            if (!isset($totals[$item_desc])) {
                                $totals[$item_desc] = 0;
                            }
                            $totals[$item_desc]++;

                            if (!in_array($sticker_no, $sticker_list)) {
                                $sticker_list[$i] = $sticker_no;
                                $i++;
                            } 
                        }

                        ?>
                        <div class="row g-0">
                            <div class="seperator-cell">
                                <p>&nbsp;</p>
                            </div>
                        </div>

                        <?php
                        $last_item_desc = '';
                        
                        foreach ($get_inventory_list as $inv) {
                            $date_purchased = $inv['date_purchased'];
                            $ref_no = $inv['ref_no'];
                            $item_desc = $inv['item_description'];
                            $sticker_no = $inv['sticker_no'];
                            $item_code = $inv['item_code'];
                            $item_id = $inv['id'];
                            $type = $inv['type'];
                            $status = $inv['status'];

                            if (isset($inv['est_life_mon'])) {
                                if ($inv['est_life_mon'] > 1) {
                                    $est_life_mon = $inv['est_life_mon'];
                                    $est_life_mon_disp = $inv['est_life_mon'].' '. 'months';
                                }else{
                                    $est_life_mon = $inv['est_life_mon'];
                                    $est_life_mon_disp = $inv['est_life_mon'].' '. 'month';
                                }
                            } else {
                                $est_life_mon = '';
                                $est_life_mon_disp = '<-month->';
                            }

                            if (isset($inv['est_life_year'])) {
                                if ($inv['est_life_year'] > 1) {
                                    $est_life_year = $inv['est_life_year'];
                                    $est_life_year_disp = $inv['est_life_year'].' '. 'years';
                                }else{
                                    $est_life_year = $inv['est_life_year'];
                                    $est_life_year_disp = $inv['est_life_year'].' '. 'year';
                                }
                            } else {
                                $est_life_year = '';
                                $est_life_year_disp = '<-year->';
                            }

                            if (isset($inv['est_life_mon']) && isset($inv['est_life_year'])) {
                                $print_display = $est_life_year_disp . ' & ' . $est_life_mon_disp;
                            } else {
                                if (isset($inv['est_life_mon'])) {
                                    $print_display = $est_life_mon_disp;
                                } elseif (isset($inv['est_life_year'])) {
                                    $print_display = $est_life_year_disp;
                                } else {
                                    $print_display = '';
                                }
                            }

                            $acq_cost = ($inv['acq_cost'] != '') ? number_format($inv['acq_cost'], 2, '.', ',') : '';
                            $acc_depr = ($inv['acc_depr'] != '') ? number_format($inv['acc_depr'], 2, '.', ',') : '';
                            $ffe_depr = ($inv['ffe_depr'] != '') ? number_format($inv['ffe_depr'], 2, '.', ',') : '';
                            $book_value = ($inv['book_value'] != '') ? number_format($inv['book_value'], 2, '.', ',') : '';
                     
                            if ($last_item_desc != $item_desc) {
                                $item_qty = $totals[$item_desc];
                               
                                $last_sticker_list = $item_qty > 1 ? '- ' .end($sticker_list) : '';
                                ?>
                                <input type="text" name="branch_name" id="branch_name"  hidden value="<?php echo $_SESSION['branch_name']; ?> ">
                                <div class="row g-0">
                              
                                    <div class="input-cell">
                                        <input type="date" name="date_purchased" disabled id="date_purchased" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" value="<?php echo $date_purchased;?>" placeholder="">
                                    </div>
                                    <div class="input-cell">
                                        <input type="number" readonly name="item_qty" id="item_qty" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" value="<?php echo $item_qty;?>" placeholder="0">
                                    </div>
                                    <div class="input-cell">
                                        <textarea name="item_description" disabled id="item_description" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" class="nowrap" placeholder="Description / Serial no."><?php echo $item_desc;?></textarea>
                                        <textarea type="text" class="print-value" value=""><?php echo $item_desc;?></textarea>
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" readonly name="ref_no" id="ref_no" class="spreadsheet-cell" value="<?php echo $ref_no ?>" data-item-id="<?php echo $item_id;?>" placeholder="Reference no.">
                                        <input type="text" class="print-value" value="<?php echo $ref_no; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" readonly name="sticker_no" id="sticker_no" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" value="<?php echo $sticker_no .' '. $last_sticker_list?>" placeholder="Sticker no.">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" readonly name="item_code" id="item_code" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" value="<?php echo $item_code;?>" placeholder="Item Code">
                                        <input type="text" class="print-value" value="<?php echo $item_code; ?> ">
                                    </div>
                                    <div class="input-cell d-flex">
                                        <select id="est_life_year" disabled name="est_life_year" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" style="width: 50%;">
                                            <option value="<?php echo $est_life_year; ?>" selected disabled><?php echo $est_life_year_disp; ?></option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="6">6 Years</option>
                                            <option value="7">7 Years</option>
                                            <option value="8">8 Years</option>
                                            <option value="9">9 Years</option>
                                            <option value="10">10 Years</option>
                                        </select>
                                        <select id="est_life_mon" disabled name="est_life_mon" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" style="width: 50%; font-size: 12px;">
                                            <option value="<?php echo $est_life_mon; ?>" selected disabled><?php echo $est_life_mon_disp; ?></option>
                                            <option value="1">1 Month</option>
                                            <option value="2">2 Months</option>
                                            <option value="3">3 Months</option>
                                            <option value="4">4 Months</option>
                                            <option value="5">5 Months</option>
                                            <option value="6">6 Months</option>
                                            <option value="7">7 Months</option>
                                            <option value="8">8 Months</option>
                                            <option value="9">9 Months</option>
                                            <option value="10">10 Months</option>
                                            <option value="11">11 Months</option>
                            
                                        </select>
                                           <!-- Text to display selected year value during print -->
                                        <input type="text" class="print-value" value="<?php echo $print_display; ?> ">
                                    
                                    </div>
                                    <div class="input-cell">
                                        <input type="number" disabled name="acq_cost" id="acq_cost" class="spreadsheet-cell" value="<?php echo $acq_cost ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $acq_cost; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="number" disabled name="acc_depr" id="acc_depr" class="spreadsheet-cell" value="<?php echo $acc_depr ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" disabled class="print-value" value="<?php echo $acc_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" disabled name="ffe_depr" id="ffe_depr" class="spreadsheet-cell" value="<?php echo $ffe_depr ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $ffe_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" disabled name="book_value" id="book_value" class="spreadsheet-cell" value="<?php echo $book_value ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $book_value; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <select id="type" name="type" disabled class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>">
                                            <option value="<?php echo $type; ?>" selected disabled><?php echo $type; ?></option>
                                            <option value="Accessories">Accessories</option>
                                            <option value="Non-Accesories">Non-Accesories</option>
                                        </select>
                                        <input type="text" class="print-value" value="<?php echo $type; ?> ">
                                    </div>
                                    <div class="input-cell">
                                            <select id="status" name="status" disabled class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>">
                                            <option value="<?php echo $status; ?>" selected disabled><?php echo $status; ?></option>
                                            <option value="Working">Working</option>
                                            <option value="Damaged">Damaged</option>
                                            <option value="Defective">Defective</option>
                                        </select>
                                        <input type="text" class="print-value" value="<?php echo $status; ?> ">
                                    </div>
                                </div>        

                                <?php
                                // Update the last item description to the current one
                                $last_item_desc = $item_desc;
                            }
                        }
                    }
                    ?>

            </div>

        </div>
    </div>

          <!-- ADD ITEM MODAL -->
    <!-- CREATE NEW ACCOUNT OR TRANSACTION MODAL2 -->
    <div class="modal fade" id="addItemModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD ITEM LIST</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="pdrNewForm" enctype="multipart/form-data">
                <div class="modal-body mb-0">
                    <div class="card">
                        <div class="card-header">
                        <div class="row">
                                <div class="col-2 mt-2">
                                    <label for="new_item_code" class="form-label">ITEM CODE :</label>
                                </div>
                                <div class="col-2">
                                    <input type="text" id="n_item_code" readonly name="n_item_code" value="<?php echo $id_holder; ?>" class="form-control" placeholder="">
                                </div>
                                <div class="col-1"></div>
                                <div class="col-2 mt-2">
                                    <label for="new_branch_name" class="form-label">BRANCH NAME :</label>
                                </div>
                                <div class="col-4">
                                    <input type="text" id="n_branch_name" name="n_branch_name" readonly value="<?php echo $_SESSION['branch_name']; ?>" class="form-control" placeholder="">
                                </div>  
                            </div>
                        </div>
                
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_item_description" class="form-label">DESCRIPTION :</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="n_item_description" name="n_item_description" class="form-control" required placeholder="Enter Description / Serial no.">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_date_purchased" class="form-label">DATE ACQUIRED :</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" id="n_date_purchased" name="n_date_purchased" class="form-control" required placeholder="Enter Date">
                                </div>
                                <div class="col-3">
                                    <i>(Date Booked)</i>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-2 mt-1">
                                    <label for="n_ref_no" class="form-label">REFERENCE NO. :</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" id="n_ref_no" required name="n_ref_no" class="form-control" placeholder="Enter Reference no.">
                                </div> 
                                <div class="col-2 mt-1">
                                    <label for="n_sticker_no" class="form-label">STICKER NO. :</label>
                                </div>
                                <div class="col-sm-3  d-flex">
                                    <input type="number" id="n_sticker_no" required name="n_sticker_no" class="form-control" placeholder="Enter Sticker no.">
                                    <input type="number" id="n_sticker_from" hidden required name="n_sticker_from" style="width: 46%; font-size: 12px;" class="form-control" placeholder="Enter Sticker no.">
                                    <c id="dash" class="mt-2" hidden>&nbsp;-&nbsp;</c>
                                    <input type="number" id="n_sticker_to" hidden required name="n_sticker_to" style="width: 46%; font-size: 12px;" class="form-control" placeholder="Enter Sticker no.">
                                </div> 
                                <div class="col-1 mt-1">
                                    <label for="n_item_qty" class="form-label">QUANTITY</label>
                                </div>
                                <div class="col-sm-1">
                                    <input type="number" id="n_item_qty" required name="n_item_qty" class="form-control" placeholder="0">
                                </div> 
                            </div>
                            <div class="row mb-3">
                                <div class="col-1 mt-2">EST. LIFE</div>
                                <div class="col-1">
                                    <label for="n_est_life_year" class="form-label">YEAR (s) :</label>
                                </div>
                                <div class="col-3">
                                    <select id="n_est_life_year" name="n_est_life_year" class="form-control">
                                        <option value="" selected disabled>&lt; Select year (s) &gt;</option>
                                        <option value="1">1 Year</option>
                                        <option value="2">2 Years</option>
                                        <option value="3">3 Years</option>
                                        <option value="4">4 Years</option>
                                        <option value="5">5 Years</option>
                                        <option value="6">6 Years</option>
                                        <option value="7">7 Years</option>
                                        <option value="8">8 Years</option>
                                        <option value="9">9 Years</option>
                                        <option value="10">10 Years</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                <label for="n_est_life_mon" class="form-label">MONTH (s) :</label>
                                </div>
                                <div class="col-3">
                                     <select id="n_est_life_mon" name="n_est_life_mon" class="form-control">
                                        <option value="" selected disabled>&lt; Select month (s) &gt;</option>
                                        <option value="1">1 Month</option>
                                        <option value="2">2 Months</option>
                                        <option value="3">3 Months</option>
                                        <option value="4">4 Months</option>
                                        <option value="5">5 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="7">7 Months</option>
                                        <option value="8">8 Months</option>
                                        <option value="9">9 Months</option>
                                        <option value="10">10 Months</option>
                                        <option value="11">11 Months</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="n_acq_cost" class="col-form-label">ACQUISITION COST :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" id="n_acq_cost" step="any" name="n_acq_cost" class="form-control" placeholder="0.00">
                                </div>

                                <div class="col-2">
                                    <label for="n_acc_depr" class="col-form-label">ACCUMULATED DEPRECATION :</label>
                                </div>
                                <div class="col-3">
                                    <input type="number" id="n_acc_depr" step="any" name="n_acc_depr" class="form-control" placeholder="0.00">
                                </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="n_ffe_depr" class="col-form-label">FFE DEPRECATION :</label>
                            </div>
                            <div class="col-3">
                                <input type="number" id="n_ffe_depr" step="any" name="n_ffe_depr" class="form-control" placeholder="0.00">
                            </div>

                            <div class="col-2">
                                <label for="n_book_value" class="col-form-label">BOOK VALUE :</label>
                            </div>
                            <div class="col-3">
                                <input type="number" id="n_book_value" step="any" required name="n_book_value" class="form-control" placeholder="0.00">
                            </div>
                            <div class="col-2">
                                <i>(as of this month)</i>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="n_type" class="col-form-label">TYPE :</label>
                            </div>
                            <div class="col-3">
                                <select id="n_type" name="n_type" required class="form-control">
                                    <option value="" selected disabled>&lt; Select Type &gt;</option>
                                    <option value="Accessories">Accessories</option>
                                    <option value="Non-Accesories">Non-Accesories</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="n_status" class="col-form-label">Status :</label>
                            </div>
                            <div class="col-3">
                                    <select id="n_status" name="n_status" required class="form-control">
                                    <option value="" selected disabled>&lt; Select Status &gt;</option>
                                    <option value="Working">Working</option>
                                    <option value="Damaged">Damaged</option>
                                    <option value="Defective">Defective</option>
                                </select>
                            </div>
                        
                        </div>
            
                    </div>        
                    </div><!--card-->
                    </div>
                        <div class="modal-footer">
                        <button type="button" name="" id="" class="btn btn-primary saveItem">Submit</button>
                        <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal" id="">Close</button>
                        </div>
            
                </div>
            </form>
                
           </div>
        </div>
     <!-- END ADD ITEM MODAL -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(".spreadsheet-cell").on('change', function() {
            var item_id = $(this).attr("data-item-id");
            var field_id = $(this).attr("id");
            var field_value = $(this).val();
            var branch_name = document.getElementById('branch_name').value;

            $.ajax({
                url: '../../ajax/saveInventoryChanges.ajax.php',
                data: {
                    action: 'update',
                    item_id: item_id,
                    field_id: field_id,
                    field_value: field_value,
                    branch_name: branch_name
                },
                method: 'GET',
                success: function(data) {
                    if (data === 'ok') {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Inventory updated successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(function(result) {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update inventory.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred during the AJAX request.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $(".saveItem").on('click', function() {
            var item_code = document.getElementById('n_item_code').value;
            var branch_name = document.getElementById('n_branch_name').value;
            var date_purchased =document.getElementById('n_date_purchased').value;
            var item_qty =document.getElementById('n_item_qty').value;
            var item_description = document.getElementById('n_item_description').value;
            var ref_no = document.getElementById('n_ref_no').value;
            var sticker_no = document.getElementById('n_sticker_no').value;
            var sticker_from = document.getElementById('n_sticker_from').value;
            var sticker_to = document.getElementById('n_sticker_to').value;
            var est_life_mon = document.getElementById('n_est_life_mon').value;
            var est_life_year = document.getElementById('n_est_life_year').value;
            var acq_cost = document.getElementById('n_acq_cost').value;
            var acc_depr = document.getElementById('n_acc_depr').value;
            var ffe_depr = document.getElementById('n_ffe_depr').value;
            var book_value = document.getElementById('n_book_value').value;
            var type = document.getElementById('n_type').value;
            var status = document.getElementById('n_status').value;

            $.ajax({
                url: '../../ajax/saveInventoryChanges.ajax.php',
                data: {
                    action: 'insert',
                    item_code: item_code,
                    branch_name: branch_name,
                    date_purchased: date_purchased,
                    item_qty: item_qty,
                    item_description: item_description,
                    ref_no: ref_no,
                    sticker_no: sticker_no,
                    sticker_from: sticker_from,
                    sticker_to: sticker_to,
                    est_life_mon: est_life_mon,
                    est_life_year: est_life_year,
                    acq_cost: acq_cost,
                    acc_depr: acc_depr,
                    ffe_depr: ffe_depr,
                    book_value: book_value,
                    type: type,
                    status: status
                },
                method: 'GET',
                success: function(data) {
                    if (data === 'ok') {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Inventory saved successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(function(result) {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update inventory.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred during the AJAX request.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $("#n_item_qty").on('change', function() {
            var item_qty = document.getElementById('n_item_qty').value;
            var sticker_no = document.getElementById('n_sticker_no');
            var sticker_from = document.getElementById('n_sticker_from');
            var sticker_to = document.getElementById('n_sticker_to');
            var dash = document.getElementById('dash');

            if (item_qty > 1) {
                sticker_from.removeAttribute('hidden');
                sticker_to.removeAttribute('hidden');
                sticker_no.setAttribute('hidden', true);
                dash.removeAttribute('hidden', true);
            } else {
                sticker_from.setAttribute('hidden', true);
                sticker_to.setAttribute('hidden', true);
                sticker_no.removeAttribute('hidden');
                dash.setAttribute('hidden');
            }
        });

        // Function to adjust textarea height based on input
        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = textarea.scrollHeight + 'px'; // Adjust height based on content
        }

        // Function to adjust input fields height based on textarea
        function adjustInputHeights(textarea) {
            const row = textarea.closest('.row');
            const inputs = row.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], select, text');
            inputs.forEach(input => {
                input.style.height = textarea.style.height; // Match the height
            });
        }

        // Attach event listeners to all textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                autoResizeTextarea(this);
                adjustInputHeights(this);
            });

            // Trigger the resize on page load
            autoResizeTextarea(textarea);
            adjustInputHeights(textarea);
        });

        $(".enableEdit").on('click', function() {
            $(this).addClass('btn-secondary');
            $(this).html('<span><i class="fa fa-pencil"></i> &nbsp;Enabled</span>');
            $(".spreadsheet-cell").removeAttr('disabled'); 
        });


    </script>

</body>
</html>
