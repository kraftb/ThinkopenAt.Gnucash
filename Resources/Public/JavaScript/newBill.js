
// Bind buttons and drop down boxes onchange

function calculateNet(o) {
    console.log("test 123");
    var cont = $(this).parent().parent();
    var amount = cont.find('.bill-entry-amount').val();
    var price = cont.find('.bill-entry-price').val();
    amount = parseFloat(amount);
    if (isNaN(amount)) {
        amount = 1;
        cont.find('.bill-entry-amount').val(1);
    }
    price = parseFloat(price);
    if (isNaN(price)) {
        alert("Price is not a valid number!");
        return false;
    }
    var net = price * amount;
    var netString = formatAmount(net, 2);
    cont.find('.bill-entry-net').val(netString);
}

function formatAmount(value, decimals) {
    var result = value + '';
    if (decimals) {
        var dotIndex = result.indexOf('.');
        if (dotIndex < 0) {
            result += '.';
        } else {
            decimals -= result.length - (dotIndex + 1);
        }
        while (decimals > 0) {
            result += '0';
            decimals--;
        }
    }
    return result;
}

function alterPriceUnit() {
}

function alterAmountUnit() {
}

$(document).ready(function() {
	$('.calculateNet').bind('click', calculateNet);
	$('.bill-entry-priceUnit').bind('click', alterPriceUnit);
	$('.bill-entry-amountUnit').bind('click', alterAmountUnit);
});

