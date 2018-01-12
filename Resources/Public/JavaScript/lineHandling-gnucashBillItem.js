
var getNewBlock = function(template, keepCategory, keepComment) {
	
	var lastIndex = parseInt(template.querySelector('.bill-entry-index').value);
//	console.log("last-index: " + lastIndex);
	
	var newBlock = template.cloneNode( true );
	newBlock.querySelector('.bill-entry-index').value = lastIndex + 1;
	newBlock.querySelector('.bill-entry-description').value = '';
	newBlock.querySelector('.bill-entry-amount').value = '';
	newBlock.querySelector('.bill-entry-price').value = '';
	newBlock.querySelector('.bill-entry-net').value = '0.00';
	return newBlock;
}

var updateFieldName = function(fieldName) {
	return fieldName.replace(/newBill\[entries\]\[([0-9]+|\*)\]/, 'newBill[entries]['+idx+']');
}

window.addEventListener('keypress', function(e) {
	if (e.altKey && e.key == 'n') {
		var blockId = addLineFunc(e.key);

		if (blockId != "") {
			var block = document.getElementById(blockId);
			var el = block.querySelector('.bill-entry-description');
			el.focus();
		}
	} else {
//		console.log(e);
	}
});


