<?php
$databaseName = 'elearning';
$filename = 'C:\xampp\htdocs\elearning\app\webroot\backup\\' . $databaseName . '-backup-' . date ( 'Y-m-d_H-i-s' );
$file =  $filename. '.sql';

$cmd = 'cd "C:/xampp/mysql/bin" & mysqldump.exe --user=root --host=localhost elearning > ' . $file;
exec ( $cmd );
//backup files

$dirBackup = new Folder();
$dirBackup->create($fileName);
$dirCurrent = new Folder(WWW_ROOT.'files');
$dirCurrent->copy($fileName);