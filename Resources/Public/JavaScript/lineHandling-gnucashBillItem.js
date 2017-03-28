
var getNewBlock = function(lastBlock, keepCategory, keepComment) {
	var lastIndex = parseInt(lastBlock.find('.bill-entry-index').val());
//	console.log("last-index: " + lastIndex);
	
	var newBlock = lastBlock.clone( true );
	newBlock.find('.bill-entry-index').val(lastIndex + 1);
	newBlock.find('.bill-entry-description').val('');
	newBlock.find('.bill-entry-amount').val('');
	newBlock.find('.bill-entry-price').val('');
	newBlock.find('.bill-entry-net').val('0.00');
	return newBlock;
}

var updateFieldName = function(fieldName) {
	return fieldName.replace(/newBill\[entries\]\[([0-9]+|\*)\]/, 'newBill[entries]['+idx+']');
}

$(window).keypress(function(e) {
	if (e.altKey && e.key == 'n') {
		var blockId = addLineFunc(e.key);
		$('#'+blockId).find('.bill-entry-description').each(function(index, obj) {
			$(obj).focus();
		});
	} else {
//		console.log(e);
	}
});


