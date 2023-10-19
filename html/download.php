<?php
    $file = "/var/www/html/Sprint2_Final.xlsm";
    if(isset($_POST['download'])) {
    if (file_exists($file)) {
        header('Content-Type: application/vnd.ms-excel.sheet.macroEnabled.12');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    } else {
        echo "Could not find file";
    }
    }
?>