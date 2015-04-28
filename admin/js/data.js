
var arrListes = ['civilites','institution','collection','serie','comite']
arrListes['civilites'] = ['Mr', 'Mme', 'Mlle', 'Docteur', 'Doctor', 'Professeur', 'Professor'];

function initAll(){
	//chargements AJAX
	arrListes.forEach(function(l, i){
		if(l!="civilites"){
			if(l=="institution"){
				$.get(urlP+"index/liste",{obj:l},function(js){
					arrListes[l]=js;
					},"json");                        				
			}else{
				arrListes[l]=['fr','en'];
				$.get(urlP+"index/liste",{obj:l, text:'titre_fr'},function(js){
					arrListes[l]['fr']=js;
					},"json");                        		
				$.get(urlP+"index/liste",{obj:l, text:'titre_en'},function(js){
					arrListes[l]['en']=js;
					//initialisation des grilles quand tout est chargé
					if(i==arrListes.length-1){
						initAuteur();
					}
					},"json");                        		
			}			
		}
	});	
}
