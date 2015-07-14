
var fuVerif = false;

function showChanged(id) {
    console.log(w2ui[id].getChanges()); 
    w2alert('Changed records are displayed in the console');
}
function updateBdd(url,data) {
	$.get(url,
		data,
		function(html){
			w2alert(html);
		});                        
}


function openPopup(name, html) {
	$().w2destroy(name);	
	w2popup.open({
		width   		: 900,
		height  		: 600,
		modal		: false,
		showClose	: true,
		showMax 		: true,
		body    		: html
	});
}