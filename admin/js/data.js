
var itemSelect;
var arrListes = [];
arrListes['civilites'] = ['Mr', 'Mme', 'Mlle', 'Docteur', 'Doctor', 'Professeur', 'Professor'];
arrListes['type1'] = ['Edited', 'Author'];
arrListes['type2'] = ['Set', 'Focus', 'Classic'];
arrListes['contrat'] = ['GB','FR'];
arrListes['langues'] = ['anglais','français'];
arrListes['roles'] = ['auteur','coordinateur','préfacier'];
arrListes['traduction'] = ['français -> anglais', 'anglais -> français','anglais <-> français'];
arrListes['alerte'] = ['1 semaine avant', '10 jours avant','2 jours avant','le jour même'];
                      
function initAll(fct){
	//chargements AJAX
	$.get(urlP+"Index/liste",{obj:'institution'},function(js){
		arrListes['institution']=js;
		$.get(urlP+"Index/liste",{obj:'collection'},function(js){
			arrListes['collection']=js;
			$.get(urlP+"Index/liste",{obj:'serie'},function(js){
				arrListes['serie']=js;
				$.get(urlP+"Index/liste",{obj:'comite'},function(js){
					arrListes['comite']=js;
					$.get(urlP+"Index/liste",{obj:'editeur'},function(js){
						arrListes['editeur']=js;
						$.get(urlP+"Index/liste",{obj:'auteur'},function(js){
							arrListes['auteur']=js;
							$.get(urlP+"Index/liste",{obj:'uti'},function(js){
								arrListes['uti']=js;
								$.get(urlP+"Index/liste",{obj:'traducteur'},function(js){
									arrListes['traducteur']=js;
									//initialisation des configurations de layout
									if(fct)fct();
									},"json");                        				
								},"json");                        				
							},"json");                        				
						},"json");                        				
					},"json");                        				
				},"json");                        				
			},"json");                        				
		},"json");                        				
}
