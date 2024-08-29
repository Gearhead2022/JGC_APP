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
            max-width: 1720px;
        }
        .container-fixed-width {
            width: 1790px; /* Fixed container width */
            margin: 0 auto; /* Center align the container */
        }
        .spreadsheet h6, p, textarea, select#est_life_year, select#est_life_year,
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
            width: 1720px;
        }
        .header-cell:nth-child(1),
        .input-cell:nth-child(1) {
            width: 150px;
        }
        .header-cell:nth-child(2),
        .input-cell:nth-child(2) {
            width: 100px;
        }
        .header-cell:nth-child(3),
        .input-cell:nth-child(3) {
            width: 250px;
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
            width: 245px;
        }
        .header-cell:nth-child(10),
        .input-cell:nth-child(10) {
            width: 150px;
        }
        .header-cell:nth-child(11),
        .input-cell:nth-child(11) {
            width: 135px;
        }
        
        @media print {
            body{
                margin-left: 20px;
            }
            
            select.spreadsheet-cell, input#acq_cost, input#acc_depr,
            input#ffe_depr, input#book_value, input#ref_no {
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
        
    </style>
    <?php require_once "../../models/connection.php"; ?>
</head>
<body>
    <div class="clearfix"></div>
  
    <div class="content-wrapper">
        <div class="container-fluid container-fixed-width">
            <div class="row mb-3 mt-2">
                <div class="col-12 fs-5 fw-bold">FCH FINANCE CORP</div>
                <div class="col-12 fs-6">SUMMARY OF FURNITURE, FIXTURES & EQUIPMENT</div>
                <div class="col-11 fs-6">AS OF <?php echo strtoupper(date('F d, Y', time())); ?></div>
                <div class="col-1">  <!-- Print Button -->
                <button class="btn btn-success btn-round waves-effect btn-custom-print" onclick="window.print()"><span><i class="fa fa-print"></i> &nbsp;Print</span></button></div>
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
                </div>

                <?php
                    $get_item_code = (new Connection)->connect()->query("SELECT item_code FROM inventory GROUP BY item_code")->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($get_item_code as $code){

                        $item_cod = $code['item_code'];
                        $get_inventory_list = (new Connection)->connect()->query("SELECT * FROM inventory WHERE item_code = '$item_cod'")->fetchAll(PDO::FETCH_ASSOC);

                        $totals = [];
                        $sticker_list = [];
                        $i = 0;

                        foreach ($get_inventory_list as $inv) {
                            $item_desc = $inv['item_description'];
                            $sticker_no = $inv['sticker_no'];
                            
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
                                $est_life_mon_disp = '<-Month->';
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
                                if ($item_qty > 1) {
                                    $last_sticker_list = '- ' .end($sticker_list);
                                } else {
                                    $last_sticker_list = '';
                                }
                                            
                                ?>

                                <div class="row g-0">
                                    <div class="input-cell">
                                        <input type="date" name="date_purchased" id="date_purchased" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" value="<?php echo $date_purchased;?>" placeholder="">
                                    </div>
                                    <div class="input-cell">
                                        <input type="number" readonly name="item_qty" id="item_qty" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" value="<?php echo $item_qty;?>" placeholder="0">
                                    </div>
                                    <div class="input-cell">
                                        <textarea name="item_description" id="item_description" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" class="nowrap" placeholder="Description / Serial no."><?php echo $item_desc;?></textarea>
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" name="ref_no" id="ref_no" class="spreadsheet-cell" value="<?php echo $ref_no ?>" data-item-id="<?php echo $item_id;?>" placeholder="Reference no.">
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
                                        <select id="est_life_mon" name="est_life_mon" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" style="width: 50%; font-size: 12px;">
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
                                        
                                        <select id="est_life_year" name="est_life_year" class="spreadsheet-cell" data-item-id="<?php echo $item_id;?>" style="width: 50%;">
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

                                           <!-- Text to display selected year value during print -->
                                        <input type="text" class="print-value" value="<?php echo $print_display; ?> ">
                                    
                                    </div>
                                    <div class="input-cell">
                                        <input type="number" name="acq_cost" id="acq_cost" class="spreadsheet-cell" value="<?php echo $acq_cost ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $acq_cost; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="number" name="acc_depr" id="acc_depr" class="spreadsheet-cell" value="<?php echo $acc_depr ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $acc_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" name="ffe_depr" id="ffe_depr" class="spreadsheet-cell" value="<?php echo $ffe_depr ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $ffe_depr; ?> ">
                                    </div>
                                    <div class="input-cell">
                                        <input type="text" name="book_value" id="book_value" class="spreadsheet-cell" value="<?php echo $book_value ?>" data-item-id="<?php echo $item_id;?>" step="any" placeholder="0.00">
                                        <input type="text" class="print-value" value="<?php echo $book_value; ?> ">
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
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(".spreadsheet-cell").on('change', function() {
            var item_id = $(this).attr("data-item-id");
            var field_id = $(this).attr("id");
            var field_value = $(this).val();

            $.ajax({
                url: '../../ajax/saveInventoryChanges.ajax.php',
                data: {
                    item_id: item_id,
                    field_id: field_id,
                    field_value: field_value
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
    </script>

</body>
</html>
