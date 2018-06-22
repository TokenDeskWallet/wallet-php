<?php

require_once('init.php');


/*
 * Using this ajax proxy in order not to send Access token from frontend.
 *
 *
 */

if($_GET["action"] == 'purchaseCalculator'){

    echo json_encode($tokenDesk->purchaseCalculator($_GET));
}else if($_GET["action"] == 'checkPayment'){

    echo json_encode($tokenDesk->getOrderStatus($_GET));
}
