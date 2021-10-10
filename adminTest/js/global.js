
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
	/*
	if(!idRow){
	    w2alert('Pas de ligne correspondante dans la grille');
	    return;
	}
	*/
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

function exportByPost(ids, obj){
	var form = document.getElementById("exportPostForm");
	if(form){
		form.ids.value = ids;
		form.obj.value = obj;
	}else{
	    var form = document.createElement("form");
	    form.setAttribute("id", "exportPostForm");
	    form.setAttribute("method", "post");
	    form.setAttribute("action", "export");
	
	    form.setAttribute("target", "view");
	
	    var hiddenField = document.createElement("input"); 
	    hiddenField.setAttribute("type", "hidden");
	    hiddenField.setAttribute("name", "ids");
	    hiddenField.setAttribute("value", ids);
	    form.appendChild(hiddenField);
	    hiddenField = document.createElement("input"); 
	    hiddenField.setAttribute("type", "hidden");
	    hiddenField.setAttribute("name", "obj");
	    hiddenField.setAttribute("value", obj);
	    form.appendChild(hiddenField);
	    document.body.appendChild(form);
	}
    window.open('', 'view');
    form.submit();				            
	
}
