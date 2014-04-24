<?php
$databaseName = 'elearning';
$fileName = 'C:\xampp\htdocs\elearning\app\webroot\files\db\\' . $databaseName . '-backup-' . date ( 'Y-m-d_H-i-s' ) . '.sql';

$cmd = 'cd "C:/xampp/mysql/bin" & mysqldump.exe --user=root --host=localhost elearning > ' . $fileName;
exec ( $cmd );