<?php
function upload($file)
{
    $destination = __DIR__ . "/../../assets/uploads/" . str_pad(rand(2, 3000), 8, 23456) . ".csv";
    move_uploaded_file($file, $destination);

    $filesize = filesize($destination);

    $fileHandle = fopen($destination, "r");
    $content = explode("\n", trim(fread($fileHandle, $filesize)));
    fclose($fileHandle);
    unlink($destination);
    return $content;
}
