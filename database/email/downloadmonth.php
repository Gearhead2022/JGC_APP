<?php
require_once "../controllers/backup.controller.php";
require_once "../models/backup.model.php";
$branch_list = new ControllerBackup();

// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('log_errors', 'On');
ini_set('error_log', 'log.txt');

// Set the maximum file size for the error log
ini_set('log_errors_max_size', '10M');

// Set the error log file permissions
chmod('log.txt', 0644);

if(isset($_GET['new_date'])){
$new_date = $_GET['new_date'];
$month = date('F', strtotime($new_date)); // e.g., "July"
$year = date('Y', strtotime($new_date)); // e.g., "2024"
$branch = $branch_list->ctrShowBranchAllBackup();

// Create a new zip archive
$zip = new ZipArchive();
$zipname = $month . '-' . $year . '.zip';

if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {
    foreach ($branch as $branches) {
        $branch_name = $branches['branch_name'];
        $folder = '../views/files/Backup/' . $branch_name . '/' . $year . '/' . $month . '/';
        
        if (is_dir($folder)) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS));
            foreach ($files as $file) {
                $filePath = $file->getRealPath();
                $relativePath = $branch_name . '/' . $month . '/' . substr($filePath, strlen(realpath($folder)) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        } else {
            echo "Directory does not exist: $folder<br>";
        }
    }
    $zip->close();

    // Check if the zip file was created successfully
    if (file_exists($zipname)) {
        // Set the appropriate headers for file download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipname) . '"');
        header('Content-Length: ' . filesize($zipname));

        // Clean output buffer before reading the file
        ob_clean();
        flush();

        // Read the zip file and output to the browser
        readfile($zipname);

        // Delete the zip file
        unlink($zipname);
    } else {
        echo 'Error: Zip file was not created.';
    }
} else {
    echo 'Error: Unable to create zip archive.';
}
}
?>
