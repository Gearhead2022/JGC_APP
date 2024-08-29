<?php

require_once "../../../models/connection.php";
require_once "../../../views/modules/session.php";

class printClientList{

    public $ref_id; 
public function getClientsPrinting(){

    $connection = new connection;
    $connection->connect();
    $date = date('F j, Y');
    $branch_name =  $_SESSION['branch_name'];
    $type = $_SESSION['type'];

    if($branch_name == "admin" || $type == "fullypaid_admin" ){
        $sql = "SELECT * FROM fully_paid WHERE status = 'F' ORDER BY name";

    }else{
        $sql = "SELECT * FROM fully_paid WHERE status = 'F' AND branch_name = '$branch_name' ORDER BY name";
     
    }
    $stmt = $connection->connect()->query($sql);
    
   
    

     
  require_once('tcpdf_include.php');


  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->startPageGroup();
  $pdf->setPrintHeader(false);  /*remove line on top of the page*/

  // set document information


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(22,22);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




$pdf->SetFont('Times');
$pdf->AddPage();

    // set JPEG quality
$pdf->setJPEGQuality(75);
// Example of Image from data stream ('PHP rules')
$imgdata = base64_decode('');

       // The '@' character is used to indicate that follows an image data stream and not an image file name
$pdf->Image('@'.$imgdata);



//rlwh//
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
// $pdf->Image('../../../views/files/'.$img_name.'', 165, 15, 30, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



$header = <<<EOF

    <p>$date</p>
    <table style="width: 100%;">
    <tr>
        <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
        <td style="width: 45%; text-align: center;"><h1>FULLY PAID REPORT</h1></td> <!-- Centered cell -->
        <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
</tr>
    <tr>
    <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
    <td style="width: 45%; text-align: center;"><p>$branch_name</p></td> <!-- Centered cell -->
    <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
    
</tr>
<tr>
    <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
    <td style="width: 45%; text-align: center;"><p></p></td> <!-- Centered cell -->
    <td style="width: 33%;"></td> <!-- Empty cell for spacing -->
</tr>

</table>

     <table style="margin-top: 5px;">    
         <tr style="border-style: solid;">
              
                <td style="width:29px;text-align:center;font-size:11px;color:white;background-color:black;">&nbsp;ID</td>

                <td style="width:115px;text-align:center;font-size:11px;color:white;background-color:black;">&nbsp;&nbsp;&nbsp;Full Name</td>
                                                                    
                <td style="width:80px;text-align:center;font-size:11px;color:white;background-color:black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Out Date</td>
        
                <td style="width:80px;text-align:center;font-size:11px;color:white;background-color:black;">&nbsp;&nbsp;&nbsp;Bank</td>
         
                <td style="width:80px;text-align:center;font-size:11px;color:white;background-color:black;">&nbsp;&nbsp;&nbsp;ATM Status</td>
                                                                    
                <td style="width:100px;text-align:center;font-size:11px;color:white;background-color:black;">&nbsp;&nbsp;Date Claimed</td>
        
                <td style="width:138px;text-align:center;font-size:11px;color:white;background-color:black;">Remarks</td>
                </tr>                 
                </table>
EOF; 

while($check = $stmt->fetch()){
    $fpid = $check['fpid'];
    $name = $check['name'];
    $out_date1 = $check['out_date'];
    $bank = $check['bank'];
    $status = $check['status'];
    $remarks = $check['remarks'];
    $atm_status = $check['atm_status'];
    $date_claimed = $check['date_claimed'];
    $out_date = date('Y-m-d', strtotime($out_date1));

    if(!empty($date_claimed)){
        $dateFormatted = date('F j, Y H:i', strtotime($date_claimed));
    }else{
        $dateFormatted="";
    }
    


$header .= <<<EOF
<table style="border: none;margin-top: 5px;">  
    <tr  style="border: 1px solid #black;">
    <td style="width:30px;text-align:left;font-size:8px; border: 1px solid #black;">$fpid</td>

    <td style="width:125px;text-align:left;font-size:8px; border: 1px solid #black;">$name</td>
                                                        
    <td style="width:80px;text-align:left;font-size:8px;margin-right: 5px; border: 1px solid #black;">$out_date</td>

    <td style="width:75px;text-align:left;font-size:8px;margin-right: 15px; border: 1px solid #black;">$bank</td>

    <td style="width:85px;text-align:left;font-size:8px; border: 1px solid #black;">$atm_status</td>
                                                        
    <td style="width:80px;text-align:left;font-size:8px;margin-right: 5px; border: 1px solid #black;">$dateFormatted</td>

    <td style="width:145px;text-align:left;font-size:8px;margin-right: 15px; border: 1px solid #black;">$remarks</td>


       
    </tr>
    
</table>
EOF;
}

    $pdf->writeHTML($header, false, false, false, false, '');
    
    $pdf->Output('Fully Paid Reports', 'I');
    
   }
  }  

  $clientsFormRequest = new printClientList();
  $clientsFormRequest -> getClientsPrinting();

?>