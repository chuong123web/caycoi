<?php
header('Content-Type: application/json');
echo json_encode([
    'gd' => extension_loaded('gd'),
    'zip' => extension_loaded('zip'),
    'exif' => extension_loaded('exif'),
    'fileinfo' => extension_loaded('fileinfo'),
    'max_upload' => ini_get('upload_max_filesize'),
    'memory_limit' => ini_get('memory_limit')
]);
