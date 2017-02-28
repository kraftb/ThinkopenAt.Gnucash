
// Bind buttons and drop down boxes onchange
$(document).ready(function() {
	$('.calculateNet').bind('click', calculateNet);
	$('.bill-entry-priceUnit').bind('click', alterPriceUnit);
	$('.bill-entry-amountUnit').bind('click', alterAmountUnit);
});

