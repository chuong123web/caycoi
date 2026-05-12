<?php
header('Content-Type: text/plain');
$ch = curl_init('https://caycoi-production.up.railway.app');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpcode\n";
echo "Response Length: " . strlen($response) . "\n";
echo "Response Body:\n";
// Output the first 2000 chars of the body
echo substr(strip_tags($response), 0, 2000);
