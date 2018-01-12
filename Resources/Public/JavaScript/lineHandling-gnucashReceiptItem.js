
var getNewBlock = function(template, keepCategory, keepComment) {
	var lastIndex = parseInt(template.querySelector('.receipt-entry-index').value);
//	console.log("last-index: " + lastIndex);
	
	var newBlock = template.cloneNode( true );
	newBlock.querySelector('.receipt-entry-index').value = lastIndex + 1;
//	newBlock.querySelector('.receipt-entry-date').value = '';
//	newBlock.querySelector('.receipt-entry-shop').value = '';
	newBlock.querySelector('.receipt-entry-price').value = '0.00';
	return newBlock;
}

var updateFieldName = function(fieldName) {
	return fieldName.replace(/newReceipts\[([0-9]+|\*)\]/, 'newReceipts['+idx+']');
}

window.addEventListener('keypress', function(e) {
	if (e.altKey && e.key == 'n') {
		var blockId = addLineFunc(e.key);

		if (blockId != "") {
			var block = document.getElementById(blockId);
			var el = block.querySelector('.receipt-entry-date');
			el.focus();
		}
	} else {
//		console.log(e);
	}
});

