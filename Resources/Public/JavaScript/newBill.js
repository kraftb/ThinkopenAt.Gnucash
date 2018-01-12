
// Bind buttons and drop down boxes onchange

function Form_Field_getFloat(obj, selector) {
	var f = obj.querySelector(selector);
	var val = f.value;
    val = parseFloat(val);
    if (isNaN(val)) {
        val = 1;
        f.value = 1;
    }
	return val;
}


function calculateNet(e) {
	var cont = e.target.parentNode.parentNode;
	var amount = Form_Field_getFloat(cont, '.bill-entry-amount');
	var price = Form_Field_getFloat(cont, '.bill-entry-price');
    var net = price * amount;
    var netString = formatAmount(net, 2);
    cont.querySelector('.bill-entry-net').value = netString;
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

window.addEventListener('load', function( ) {
	connectEventsByClassName('.calculateNet', ['click'], calculateNet);
	connectEventsByClassName('.bill-entry-priceUnit', ['click'], alterPriceUnit);
	connectEventsByClassName('.bill-entry-amountUnit', ['click'], alterAmountUnit);
});

