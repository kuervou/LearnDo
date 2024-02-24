<?php

sleep(15);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://localhost/LearnDo/enviarRecordatorios');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);
sleep(15);
curl_close($ch);