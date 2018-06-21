
    <div class="purchase-alert">
        <div class="purchase-alert-container">
            <?php echo $order->note ?>
        </div>
    </div>

    <div id="transfer-directions" class="text-center">
        <div class="transfer-directions-container">
            Send
            <span><?php echo $order->final_price ?><?php echo ' ' ?><?php echo $order->currency ?></span>
            to this address and receive
            <span><?php echo $order->final_token_amount ?><?php echo ' ' ?><?php echo $order->token_name ?></span>

        </div>
    </div>

    <div id="transfer-address" class="container-fluid">
        <div class="transfer-address-container">
            <?php if ($order->payment_method == 'direct_pay') { ?>
                <div class="mx-auto direct-pay-details">
                    <div class="row">
                        <div class="col-xs-6">
                            <strong>Bank name:</strong>
                        </div>
                        <div class="col-xs-6">
                            <?php echo $order->payment_details->bank_name ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <strong>IBAN:</strong>
                        </div>
                        <div class="col-xs-6">
                            <?php echo $order->payment_details->iban ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <strong>Bank address:</strong>
                        </div>
                        <div class="col-xs-6">
                            <?php echo $order->payment_details->bank_address ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <strong>BIC/SWIFT:</strong>
                        </div>
                        <div class="col-xs-6">
                            <?php echo $order->payment_details->bic ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <strong>Recipient:</strong>
                        </div>
                        <div class="col-xs-6">
                            <?php echo $order->payment_details->recipient ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <strong>Payment details: </strong>
                        </div>
                        <div class="col-xs-6">
                            <?php echo $order->payment_details->invoice ?>
                        </div>
                    </div>

                </div>

            <?php } else {
                if ($order->payment_method == 'btc' || $order->payment_method == 'eth' || $order->payment_method == 'tds') { ?>
                    <div class="col-sm-9">
                        <input type="text" value="<?php echo $order->payment_details->receiving_address ?>" readonly>
                    </div>

                    <div class="col-sm-3 text-center">
                        <a class="copy-address noselect">Copy to clipboard</a>
                    </div>

                <?php } else {
                    if ($order->payment_method == 'coingate' || $order->payment_method == 'indacoin') { ?>

                        <div class="transfer-check col-lg-9 m-auto text-center">
                            <a href="<?php echo $order->payment_details->external_payment_url ?>" target="_blank"
                               class="do_pay">Pay</a>
                        </div>
                    <?php }
                }
            } ?>


            <div class="transfer-back col-xs-12 mt-2">
                <a target="_blank" class="text-center" href="<?php echo $order->button_link ?>">
                    <?php echo $order->button_text ?>
                </a>

            </div>

        </div>

    </div>


    <div id="transfer-controls" class="container-fluid">
        <div class="transfer-controls-container row">
            <div class="col-lg-12 text-center">
                <div class="row">
                    <div class="transfer-check col-12">
                        <a data-order-id="<?php echo $order->id ?>" data-ajax-url="ajax.php"
                           class="checkPayment noselect w-100" href="#">Check my payment</a>
                    </div>
                </div>
                <div id="paidButtonText" class="form-error-msg"></div>
            </div>
        </div>

    </div>

    <div style="display: none" class="alert alert-danger payment-waiting text-center"></div>

    <div style="display: none" class="alert alert-success payment-success text-center"></div>

