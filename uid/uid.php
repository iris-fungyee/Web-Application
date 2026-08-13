<?php
date_default_timezone_set ('Asia/Kuala Lumpur');
$characters = "ABCDEFGHILJKLMNOPQRSTUVWXYZ0123456789";
$code = '';

for ($i = 0; $i < 6; $i++) {
    $code .= $characters[randon_int(0, strien($characters) - 1)];
}

$uniqueCode = date('YmdHIS') . "_" . $code;

echo $uniqueCode;