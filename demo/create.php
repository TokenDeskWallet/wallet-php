<div class="rates">
    <span class="primary-currency">1 <?php echo $project->data->token_name; ?></span>
    <span class="eq">=</span>
    <?php foreach ($project->rates as $key => $value) { ?>
        <span
            class="other-currency"><?php echo $value->currency ?><?php echo ' ' ?><?php echo $value->rate ?></span>
    <?php } ?>

</div>

<form method="POST"
      class="buy-tokens-form"
      data-ajax-url="ajax.php"
      data-project-id="<?php echo $projectId; ?>">

    <input type="hidden" name="projectId" value="<?php echo $projectId; ?>">

    <div class="tab1 tab-content" id="tab1">

        <h3 class="text-center mb16">Select prefered payment method</h3>

        <div class="form-group">
            <div class="payment-methods">
                <?php $counter = 0; ?>
                <?php foreach ($project->payment_methods as $key => $value) { ?>

                    <div class="payment-method">
                        <input class="form-check-input"
                               type="radio"
                               name="paymentMethod"
                               id= <?php echo $key ?>
                               data-pay-button="<?php echo $value->pay_button_title ?>"
                               data-currency="<?php echo $value->currency ?>"
                               data-note="<?php echo $value->note ?>"
                               data-min-order-amount="<?php echo $value->min_order_amount ?>"
                               data-max-order-amount="<?php echo $value->max_order_amount ?>"
                               data-min-payment-amount="<?php echo $value->min_payment_amount ?? 0 ?>"
                               data-max-payment-amount="<?php echo $value->max_payment_amount ?? 0 ?>"
                               data-disabled="<?php echo $value->disabled ?>"
                               value="<?php echo $key ?>"
                            <?php if ($counter == 0) {
                                echo ' checked = "checked" ';
                            } ?>>
                        <label for="<?php echo $key ?>"
                               class="btn btn-bluish"><?php echo $value->payment_method_title ?></label>
                    </div>

                    <?php $counter++; ?>
                <?php } ?>


            </div>
        </div>

        <div class="payment-method-active">
            <div id="exchange-wrapper">
                <div class="exchange-container">
                    <div class="row payment-details">
                        <div class="col-xs-6">
                            <label class="text-uppercase" for="final-price">Amount of <span
                                    class="currency-name"><?php echo array_values($project->payment_methods)[0]["currency"] ?></span>
                                to spend</label>
                            <div class="input-group input">
                                <input required="" type="number" step="any" min="0"
                                       name="finalPrice"
                                       class="form-control live-regular-price" id="final-price"
                                       aria-describedby="regular-price-addon">
                                                    <span class="input-group-addon currency-name"
                                                          id="regular-price-addon"><?php echo array_values($project->payment_methods)[0]["currency"] ?></span>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <label class="text-uppercase" for="final-token-amount">Ammount
                                of <?php echo $project->data->token_name; ?> to buy</label>
                            <div class="input-group">
                                <input class="form-control live-token-amount"
                                       id="final-token-amount"
                                       required="" type="number" step="any" min="0"
                                       name="finalTokenAmount"
                                       aria-describedby="token-amount-addon">
                                                    <span class="input-group-addon"
                                                          id="token-amount-addon"><?php echo $project->data->token_name; ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="dsc-wrapper">
                <div class="dsc-container">
                    <div class="row discount-details discount-row ninja">
                        <div class="col-xs-6">
                            <div class="cell">
                                <span class="text-orange"><span class="discount">0</span>%</span>
                                discount
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="cell">
                                <span class="discount-amount">0</span>
                                                    <span
                                                        class="pull-right currency-name dsc-units"><?php echo array_values($project->payment_methods)[0]["currency"] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row discount-details bonus-row ninja">
                        <div class="col-xs-6">
                            <div class="cell">
                                <span class="text-orange"><span class="bonus">0</span>%</span> bonus
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="cell">
                                <span class="bonus-amount">0</span>
                                                    <span
                                                        class="pull-right"><?php echo $project->data->token_name; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row discount-details hr-wrapper">
                        <div class="col-xs-12">
                            <hr>
                        </div>
                    </div>
                </div>
            </div>


            <div id="final-price-wrapper">
                <div class="final-price-container">
                    <div class="row discount-details">
                        <div class="col-xs-6">
                            <div class="cell">
                                <b>Final price</b>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="cell">
                                <b><span class="final-price">0</span></b>
                                <b class="pull-right"><span
                                        class="currency-name"><?php echo array_values($project->payment_methods)[0]["currency"] ?></span></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="purchase-pay-wrapper">
                <div class="purchase-pay-container">
                    <div class="row payment-btn-details">
                        <div class="col-xs-12">
                            <button class="btn btn-yellow btn-buy btn-buy-direct to-step-2">
                                                <span>Buy <span class="td-bg"><span
                                                            class="final-token-amount">0</span> <?php echo $project->data->token_name; ?></span> for <span
                                                        class="td-bg"><span class="final-price">0.00</span> <span
                                                            class="currency-name"><?php echo array_values($project->payment_methods)[0]["currency"] ?></span></span></span>
                                                <span class="get-it">
                                                  <span
                                                      class="pay-btn-value payment-button"><?php echo array_values($project->payment_methods)[0]["pay_button_title"] ?></span>
                                                  <i class="fa fa-angle-double-right"></i>
                                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab2 tab-content" id="tab2" style="display: none;">

        <h3 class="text-center mb16">Payment details</h3>


        <div class="row">
            <div class="form-item col-sm-6">
                <label for="email">Email:</label>
                <input class="form-control form-text"
                       value=""
                       name="email" id="email"
                       type="email">
            </div>

            <div class="form-item col-sm-6">
                <label for="ethereum">ETH wallet address:</label>
                <input class="form-control form-text"
                       value="" name="ethereum"
                       id="ethereum"
                       type="text">
            </div>

            <div class="form-item col-sm-6">
                <label for="name">Full Name:</label>
                <input class="form-control form-text"
                       value="" name="name"
                       id="name"
                       type="text">
            </div>


            <div class="form-item col-sm-6">
                <label for="phone">Phone:</label>
                <input class="form-control form-text"
                       value=""
                       name="phone" id="phone"
                       type="text">
            </div>

            <div class="form-item col-sm-6">
                <label for="billing_country">Country:</label>
                <input class="form-control form-text"
                       value=""
                       name="billing_country"
                       id="billing_country" type="text">
            </div>

            <div class="form-item col-sm-6">
                <label for="billing_state">State:</label>
                <input class="form-control form-text"
                       value=""
                       name="billing_state"
                       id="billing_state" type="text">
            </div>

            <div class="form-item col-sm-6">
                <label for="billing_city">City:</label>
                <input class="form-control form-text"
                       value=""
                       name="billing_city"
                       id="billing_city" type="text">
            </div>

            <div class="form-item col-sm-6">
                <label for="billing_address">Address:</label>
                <input class="form-control form-text"
                       value=""
                       name="billing_address"
                       id="billing_address" type="text">
            </div>

            <div class="form-item col-sm-6">
                <label for="billing_zip">Zip Code:</label>
                <input class="form-control form-text"
                       value=""
                       name="billing_zip"
                       id="billing_zip" type="text">
            </div>

        </div>

        <div id="purchase-pay-wrapper">
            <div class="purchase-pay-container">
                <div class="row payment-btn-details">
                    <div class="col-xs-12">
                        <button class="btn btn-yellow btn-buy btn-buy-direct submit-form">
                                                <span>Buy <span class="td-bg"><span
                                                            class="final-token-amount">0</span> <?php echo $project->data->token_name; ?></span> for <span
                                                        class="td-bg"><span class="final-price">0.00</span> <span
                                                            class="currency-name"><?php echo array_values($project->payment_methods)[0]["currency"] ?></span></span></span>
                                                <span class="get-it">
                                                  <span
                                                      class="pay-btn-value payment-button"><?php echo array_values($project->payment_methods)[0]["pay_button_title"] ?></span>
                                                  <i class="fa fa-angle-double-right"></i>
                                                </span>
                        </button>
                        <input class="order-create-submit" type="submit" name="submit"
                               value="submit">

                    </div>
                </div>
            </div>
        </div>

    </div>

</form>