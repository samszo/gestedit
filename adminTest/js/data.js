
var itemSelect;
var arrListes = [];
//arrListes['civilites'] = ['Mr', 'Mme', 'Mlle', 'Docteur', 'Doctor', 'Professeur', 'Professor'];
//arrListes['type1'] = ['Edited', 'Author'];
//arrListes['type2'] = ['Set', 'Focus', 'Classic'];
arrListes['contratBase'] = ['GB','FR'];
//arrListes['langues'] = ['anglais','français'];
//arrListes['roles'] = ['auteur','coordinateur','préfacier'];
//arrListes['traduction'] = ['français -> anglais', 'anglais -> français'];
arrListes['alerte'] = ['1 semaine avant', '10 jours avant','2 jours avant','le jour même'];
arrListes['mois'] = ['janvier', 'février','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','décembre'];
//arrListes['boutique'] = ['Amazon', 'NBN', 'Elsevier','Wiley'];
//var arrData = ['auteur','livre','traduction','production','vente'];
arrListes['role_uti'] = ["agent","admin","direction","lecteur","gestion","usager"]                      

function initAll(fct){
	//chargements AJAX
	$.get(urlP+"Index/liste",{obj:'param'},function(js){
		js.forEach(function(r){
			if(!arrListes[r.type])arrListes[r.type]=[];		
			arrListes[r.type].push(r);
		})
	},"json");                        				
	
	//w2popup.lock('Loading...', true);
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
									$.get(urlP+"Index/liste",{obj:'livre'},function(js){
										arrListes['livre']=js;
										$.get(urlP+"Index/liste",{obj:'isbn'},function(js){
											arrListes['isbn']=js;											
											$.get(urlP+"Index/liste",{obj:'licence'},function(js){
												arrListes['licence']=js;				
												$.get(urlP+"Index/liste",{obj:'tache'},function(js){
													arrListes['tache']=js;
													$.get(urlP+"Index/liste",{obj:'processus'},function(js){
														arrListes['processus']=js;														
														$.get(urlP+"Index/liste",{obj:'boutique'},function(js){
															arrListes['boutique']=js;														
															$.get(urlP+"Index/liste",{obj:'contrat'},function(js){
																arrListes['contrat']=js;														
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
								},"json");                        				
							},"json");                        				
						},"json");                        				
					},"json");                        				
				},"json");                        				
			},"json");                        				
		},"json");                        				
}
