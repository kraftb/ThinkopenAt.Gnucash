
var getNewBlock = function(lastBlock, keepCategory, keepComment) {
	var lastIndex = parseInt(lastBlock.find('.receipt-entry-index').val());
//	console.log("last-index: " + lastIndex);
	
	var newBlock = lastBlock.clone( true );
	newBlock.find('.receipt-entry-index').val(lastIndex + 1);
//	newBlock.find('.receipt-entry-date').val('');
//	newBlock.find('.receipt-entry-shop').val('');
	newBlock.find('.receipt-entry-price').val('0.00');
	return newBlock;
}

var updateFieldName = function(fieldName) {
	return fieldName.replace(/newReceipts\[entries\]\[([0-9]+|\*)\]/, 'newReceipts[entries]['+idx+']');
}

$(window).keypress(function(e) {
	if (e.altKey && e.key == 'n') {
		var blockId = addLineFunc(e.key);
		$('#'+blockId).find('.receipt-entry-date').each(function(index, obj) {
			$(obj).focus();
		});
	} else {
//		console.log(e);
	}
});

