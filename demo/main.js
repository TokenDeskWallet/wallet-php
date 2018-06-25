
function validateInputAddresses(address){

    return (/^(0x){1}[0-9a-fA-F]{40}$/i.test(address));
}

jQuery.noConflict();

jQuery(document).ready(function ($) {


    paymentMethodChanged($("input[name='paymentMethod']:checked"));
    $('.payment-method').click(function () {
        paymentMethodChanged($(this).children('input'));
    });

    $('button').click(function (e) {
        e.preventDefault();
    });


    $('.to-step-2').click(function () {

        if($('.buy-tokens-form')[0].checkValidity()) {

            $('.tab2').show();
            $('.tab1').hide();
            $("#email").prop('required', true);
            $("#name").prop('required', true);
            if ($("#ethereum").length > 0) {
                $("#ethereum").prop('required', true);
            }

            if ($("#nem_address").length > 0) {
                $("#nem_address").prop('required', true);
            }



            if ($("input[name='paymentMethod']:checked").val() == 'direct_pay') {
                $("#phone").prop('required', true).parent().show();
                $("#country").prop('required', true).parent().show();
                $("#billing_state").prop('required', true).parent().show();
                $("#billing_city").prop('required', true).parent().show();
                $("#billing_address").prop('required', true).parent().show();
                $("#billing_country").prop('required', true).parent().show();
                $("#billing_zip").prop('required', true).parent().show();
            } else {
                $("#phone").prop('required', false).parent().hide();
                $("#country").prop('required', false).parent().hide();
                $("#billing_state").prop('required', false).parent().hide();
                $("#billing_city").prop('required', false).parent().hide();
                $("#billing_address").prop('required', false).parent().hide();
                $("#billing_country").prop('required', false).parent().hide();
                $("#billing_zip").prop('required', false).parent().hide();
            }
        }else{
            $(".order-create-submit").click();
        }

    })



    $(".submit-form").click(function (e) {

        if($('.buy-tokens-form')[0].checkValidity()){
            if ($("#ethereum").length==0 || validateInputAddresses($("#ethereum").val())) {
                $(".order-create-submit").click();
            }else{
                $("#ethereum").addClass('parsley-error');
                $("#ethereum").focus();
            }
        }else{
            $(".order-create-submit").click();
        }

    });


    $("#final-token-amount").on("input", function () {
        $("input[name='finalPrice']").val("");

        if ($("#final-token-amount").val()) {
            delay_method("final-token-amount", function () {
                getPrices();
            }, 250);
        } else {
            resetInputs();
        }
    });


    $("#final-price").on("input", function () {
        $("input[name='finalTokenAmount']").val("");

        if ($("#final-price").val()) {
            delay_method("final-price", function () {
                getPrices();
            }, 250);
        } else {
            resetInputs();
        }
    });



    function resetInputs() {
        $("input[name='finalTokenAmount']").val("");
        $("input[name='finalPrice']").val("");


        $("#final-price").prop('max', '');
        $("#final-price").prop('min', '');

        $(".discount-row").hide();
        $(".bonus-row").hide();
        $(".sc-eth-wallet-input").hide();
        $(".note").html("");

        $(".discount-amount").text("0.00");
        $(".discount").text("0");
        $(".bonus-amount").text("0");
        $(".bonus").text("0");
        $(".final-price").text("0.00");
        $(".token-amount").text("0");
        $(".final-token-amount").text("0");

        $(".final-price-tds").text("0.00");
        $(".final-price-tds-eth").text("0.00");
        $(".final-token-amount-tds").text("0");
    }




    function calculatorSuccessFunc(data, status) {

        if (data.field_changed == 'finalPrice') {
            $("input[name='finalTokenAmount']").val(data.finalTokenAmount);
        } else if (data.field_changed == 'finalTokenAmount') {
            $("input[name='finalPrice']").val(data.finalPrice);
        }

        $(".discount").text((data.discount));
        $(".discount-amount").text((data.discountAmount));
        $(".bonus").text((data.bonus));
        $(".bonus-amount").text((data.bonusAmount));
        $(".final-price").text((data.finalPrice));
        $(".regular-price").text((data.regularPrice));
        $(".token-amount").text((data.tokenAmount));
        $(".final-token-amount").text((data.finalTokenAmount));


        if (data.discount == 0) {
            $(".discount-row").css('display', 'none');
        } else {
            $(".discount-row").css('display', 'flex');
        }

        if (data.bonus == 0) {
            $(".bonus-row").css('display', 'none');
        } else {
            $(".bonus-row").css('display', 'flex');
        }

    };


    function paymentMethodChanged(payment_method) {
        resetInputs();


        $(".currency-name").html($(payment_method).data("currency"));
        $(".payment-button").html($(payment_method).data("pay-button"));
        $(".note").html($(payment_method).data("note"));

        if($(payment_method).data("min-order-amount")>0){
            $("#final-token-amount").prop('min', $(payment_method).data("min-order-amount"));
        }else{
            $("#final-token-amount").prop('min', "0");
        }

        if($(payment_method).data("max-order-amount")!=""){
            $("#final-token-amount").prop('max', $(payment_method).data("max-order-amount"));
        }else{
            $("#final-token-amount").prop('max', false);
        }

        if($(payment_method).data("min-payment-amount")!=""){
            $("#final-price").prop('min', $(payment_method).data("min-payment-amount"));
        }else{
            $("#final-price").prop('min', '0');
        }

        if($(payment_method).data("max-payment-amount")!=""){
            $("#final-price").prop('max', $(payment_method).data("max-payment-amount"));
        }else{
            $("#final-price").prop('max', false);
        }

    }

    // copy address to clipboard
    $('.copy-address').click(function(e){
        e.preventDefault();
        var el = $('#transfer-address input');
        el.select();
        document.execCommand('copy');
        $(this).text('Copied!');
    });

    function delay_method(label, callback, time) {
        if (typeof window.delayed_methods == "undefined") {
            window.delayed_methods = {};
        }
        delayed_methods[label] = Date.now();
        var t = delayed_methods[label];
        setTimeout(function () {
            if (delayed_methods[label] != t) {
                return;
            } else {
                callback();
            }
        }, time || 800);
    };




    if($(".checkPayment").length>0){
        var interval = setInterval(checkPayment, 30000);
    }

    function getPrices() {
        $.ajax({
            type: 'get',
            dataType: "json",
            url: $('.buy-tokens-form').data('ajax-url'),
            data: {
                action: 'purchaseCalculator',
                projectId: $('.buy-tokens-form').data('project-id'),
                paymentMethod:$("input[name='paymentMethod']:checked").val(),
                finalPrice:$("input[name='finalPrice']").val(),
                finalTokenAmount:$("input[name='finalTokenAmount']").val(),

            },
            success: calculatorSuccessFunc
        });
    }

    function checkPayment(){
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: $('.checkPayment').data('ajax-url'),
            data: {
                action: 'checkPayment',
                orderId: $(".checkPayment").data('order-id')
            },
            success: paymentSuccessFunc,
            error: errorFunc
        });
    }

    $(".checkPayment").click(function(e){
        e.preventDefault();
        checkPayment();
    })

    function paymentSuccessFunc(data) {
        if (data["status"] == '0') {
            $('.payment-waiting').empty().html(data["message"]);
            $('.payment-waiting').show();
            $('.payment-success').hide();
        } else if (data["status"] == '1') {
            $('.payment-success').empty().html(data["message"]);
            $('.payment-waiting').hide();
            $('.payment-success').show();
        }
    }

    function errorFunc() {
        console.log("failure");
    };

});