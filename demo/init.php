<?php

require_once('../lib/TokenDesk.php');

$projectId = 'YOUR_PROJECT_ID';
$auth_token = 'YOUR_AUTH_TOKEN';

$tokenDesk = new \TokenDesk\TokenDesk();

$tokenDesk->config(array(
    'auth_token' => $auth_token
));