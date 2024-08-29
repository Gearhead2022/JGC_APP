<?php
// specify the folder path and name
if(isset($_GET['branch_name']) && isset($_GET['new_date'])){
    
$branch_name = $_GET['branch_name'];
$new_date = $_GET['new_date'];


$date_now = date('F j, Y', strtotime($new_date));
                $month = date('F', strtotime($new_date));
                $year = date('Y', strtotime($new_date));

                $cn_branch_name = strlen($branch_name)+1 + strlen($year)+1 + strlen($month)+1;
                
$folder = '../views/files/Backup/'.$branch_name.'/'.$year.'/'.$month.'/'.$date_now.'';

// create a new zip archive
$zip = new ZipArchive();
$zipname = ''.$branch_name.' '.$date_now.'.zip';

// open the archive and add files to it
if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
    foreach ($files as $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath,81 + $cn_branch_name);
            $zip->addFile($filePath, $relativePath);
        }
        
    }
    $zip->close();

    // set the appropriate headers for file download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.basename($zipname).'"');
    header('Content-Length: ' . filesize($zipname));

    // read the zip file and output to the browser
    readfile($zipname);

    // delete the zip file
    unlink($zipname);
} else {
    echo 'Error creating zip archive';
}
}else{
    echo "ERROR";
}
