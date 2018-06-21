<?php

require_once('../lib/TokenDesk.php');

$projectId = 14996;

$tokenDesk = new \TokenDesk\TokenDesk();


if(!$_POST['submit']){
    // get project details required to display payment form
    $project = $tokenDesk->getProject($projectId);
} else if ($_POST['submit']) {

    // prepare post data
    $params = array(
        'projectId'        => $_POST["projectId"],
        'paymentMethod'    => $_POST["paymentMethod"],
        'finalPrice'       => $_POST["finalPrice"],
        'finalTokenAmount' => $_POST["finalTokenAmount"],
        'email'            => $_POST["email"],
        'name'             => $_POST["name"],
        'ethereum'         => $_POST["ethereum"],
        'phone'            => $_POST["phone"],
        'billing_country'  => $_POST["billing_country"],
        'billing_state'    => $_POST["billing_state"],
        'billing_city'     => $_POST["billing_city"],
        'billing_address'  => $_POST["billing_address"],
        'billing_zip'      => $_POST["billing_zip"],
    );

    // create the order
    $order = $tokenDesk->createOrder($params);
}

?>



