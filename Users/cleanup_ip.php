<?php
$logFile = __DIR__ . '/ip_log.json';

$currentTime = time();

if (file_exists($logFile)) {
    $ipLog = json_decode(file_get_contents($logFile), true);
} else {
    $ipLog = [];
}

foreach ($ipLog as $ip => $lastRequestTime) {
    if (($currentTime - $lastRequestTime) >= 3600) {
        unset($ipLog[$ip]);
    }
}

file_put_contents($logFile, json_encode($ipLog));

echo "All Expired IP Removed";
?>