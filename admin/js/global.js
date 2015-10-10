
var fuVerif = false;

function finsession(js){
	if(js.finsession) window.location = urlP+'auth/login';	
}

function selectRowInGrid(recid, idGrid){
	var id;
	if( typeof recid === 'string' ) id = recid; else	id = recid[0];
	itemSelect = w2ui[idGrid].get(id);
	var idRow = w2ui[idGrid].get(id, true);
	w2ui[idGrid].selectNone();
	if(!idRow){
	    w2alert('Pas de ligne correspondante dans la grille');
	    return;
	}
	if( typeof recid === 'string' )
		w2ui[idGrid].select(recid);
	else
		w2ui[idGrid].select.apply(w2ui[idGrid], recid);
	w2ui[idGrid].scrollIntoView(idRow);
			
}

function setListe(r,nom) {
	//remplace la valeur enregistrée
	var i = 0;
	arrListes[nom].forEach(function(rl){
		if(rl.recid==r.recid)arrListes[nom][i]=r;
		i++;
	})
}


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

