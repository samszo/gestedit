<?php
class SpipController extends Zend_Controller_Action
{
	var $dbNom = "spip_iste";
	
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		$this->view->data = "OK"; 					
			
	}

	/**
	 * controle pour l'importation d'un fichier csv
	 */
	public function importAction() {
		$this->view->data = "OK"; 					
			
	}

	/**
	 * controle pour la création automatique des rubrique et article d'auteur
	 */
	public function creaauteurAction() {
		//initialisation des objets
		if($this->_getParam('idBase')) $this->dbNom = $this->_getParam('idBase');
		
		$s = new Flux_Site($this->dbNom);
		$dbAut = new Model_DbTable_Iste_auteur();
		$dbLivre = new Model_DbTable_Iste_livre();
		$dbSpip = new Model_DbTable_Iste_spip();
		
		$dbArt = new Model_DbTable_Spip_articles($s->db);
		$dbAutS = new Model_DbTable_Spip_auteurs($s->db);
		$dbR = new Model_DbTable_Spip_rubriques($s->db);
		$dbM = new Model_DbTable_Spip_mots($s->db);
		$dbAutR = new Model_DbTable_Spip_auteursrubriques($s->db);
		$dbML = new Model_DbTable_Spip_motsliens($s->db);
		
		$arrRub = array("Liste"=>15,"Comite"=>16,"Catalog"=>18);
		$arrMC = array("Serie"=>1,"Comite"=>2, "Role"=>3);
		
		//charge la liste des auteurs
		if($this->_getParam('idAuteur')) $arrAuteur = $dbAut->findById_auteur($this->_getParam('idAuteur'));
		else $arrAuteur = $dbAut->getAll();
		
		$nbM = count($arrAuteur);
		for ($i = 0; $i < $nbM; $i++) {
				
			//construction du numéro d'ordre
			$num = $i."00";

			//vérifie si la rubrique de l'auteur existe
			$titreRubAuteur = $num.". ".$arrAuteur[$i]["prenom"]." ".$arrAuteur[$i]["nom"];
			$arrRubAut = $dbArt->findByTitre($titreRubAuteur);
			$idRubAuteur = count($arrRubAut) ? $arrRubAut[0]["id_rubrique"] : 0;
			if($idRubAuteur==0){
				//création de l'auteur
				$idAutS = $dbAutS->ajouter(array("nom"=>$arrAuteur[$i]["prenom"]." ".$arrAuteur[$i]["nom"], "email"=>$arrAuteur[$i]["mail1"],"statut"=>"1comite","source"=>"flux"));
				$dbSpip->ajouter(array("id_spip"=>$idAutS,"id_iste"=>$arrAuteur[$i]["id_auteur"],"obj_spip"=>"auteurs","obj_iste"=>"auteur"));
				//création de l'article de l'auteur
				$idArtAuteur = $dbArt->ajouter(array("id_rubrique"=>$arrRub["Liste"], "texte"=>utf8_encode("A compléter..."), "titre"=>$titreRubAuteur, "statut"=>'publie'));				
				$dbSpip->ajouter(array("id_spip"=>$idArtAuteur,"id_iste"=>$arrAuteur[$i]["id_auteur"],"obj_spip"=>"articles","obj_iste"=>"auteur"));
				//création des mots clefs
				$infoAut = $dbAut->findInfos($arrAuteur[$i]["id_auteur"]);
				$oComite = "";
				$oSerie = "";
				$oLivre = "";
				foreach ($infoAut as $info) {
					if($oComite!=$info["id_comite"]){
						$idMC = $dbM->ajouter(array("titre"=>"<multi>[fr]".$info["cafr"]."[en]".$info["caen"]."</multi>","id_groupe"=>$arrMC["Comite"]));
						$dbSpip->ajouter(array("id_spip"=>$idMC,"id_iste"=>$info["id_comite"],"obj_spip"=>"mots","obj_iste"=>"comite"));
						$dbML->ajouter(array("objet"=>"auteur","id_objet"=>$idAutS,"id_mot"=>$idMC));
						$oComite=$info["id_comite"];
					}
					if($oSerie!=$info["id_serie"]){
						$idMC = $dbM->ajouter(array("titre"=>"<multi>[fr]".$info["sfr"]."[en]".$info["sen"]."</multi>","id_groupe"=>$arrMC["Serie"]));
						$dbSpip->ajouter(array("id_spip"=>$idMC,"id_iste"=>$info["id_serie"],"obj_spip"=>"mots","obj_iste"=>"serie"));
						$dbML->ajouter(array("objet"=>"auteur","id_objet"=>$idAutS,"id_mot"=>$idMC));
						$oSerie=$info["id_serie"];
					}
					if($oLivre!=$info["id_livre"]){
						$infoLivre = $dbLivre->findInfos($info["id_livre"]);
						//vérifi
						if($infoLivre["titre_fr"]){
							$idArtLivreFr = $dbArt->ajouter(array("id_rubrique"=>$arrRub["Catalog"]
								, "texte"=>$infoLivre["titre_fr"], "titre"=>$titreRubAuteur, "statut"=>'publie'));				
							
						}
						$dbSpip->ajouter(array("id_spip"=>$idArtLivre,"id_iste"=>$info["id_livre"],"obj_spip"=>"articles","obj_iste"=>"livre"));
						$oLivre=$info["id_livre"];
					}
				}
				
			}
		}
		
		$this->view->data = $membres;
					
	}
	
	/**
	 * controle pour pour l'envoie des mails de connection
	 */
	public function envoiemailauteurAction() {
			
		//initialisation des objets
		if($this->_getParam('idBase')) $this->dbNom = $this->_getParam('idBase');
		$s = new Flux_Site($this->dbNom);
		$dbA = new Model_DbTable_Spip_articles($s->db);
		$dbAut = new Model_DbTable_Spip_auteurs($s->db);
		$dbR = new Model_DbTable_Spip_rubriques($s->db);
		$gm = new Flux_Gmail("samszon","Juillet2014");
		
		//charge la liste des auteurs à prévenir
		//$auteurs = $s->csvToArray("../data/paragraphe/auteursCITU.csv",0,","); 					
		$auteurs = $s->csvToArray("../data/CreaTIC/auteursLivrePostNumTest.csv",0,","); 					
		
		$nbAut = count($auteurs);
		$this->view->data = array();
		for ($i = 0; $i < $nbAut; $i++) {
			//récupère l'identifiant de l'auteur
			$arrAuteur = $dbAut->findByLogin(utf8_encode($auteurs[$i][2]));
			$idAuteur = count($arrAuteur["id_auteur"]) ? $arrAuteur["id_auteur"] : 0; 
			if($idAuteur){
				//recherche la rubrique dédié à l'auteur
				$arrRubAut = $dbR->findByTitre($arrAuteur["nom"],true);
				$idRubAuteur = count($arrRubAut) ? $arrRubAut[0]["id_rubrique"] : 0;
				$auteurs[$i]["idRubAuteur"] = $idRubAuteur;
				//$this->view->data["auteurs"][]=$auteurs[$i];
				if($idRubAuteur){
					//récupère les articles de la rubrique
					$arrArt = $dbA->findById_rubrique($idRubAuteur);
					/*construction de la vue
					 * http://stackoverflow.com/questions/11076428/sending-newsletter-from-a-zend-framework-project
					 */
					$mailView = new Zend_View();
					$mailView->setScriptPath(APPLICATION_PATH.'/views/scripts/mail/');
				    	$mailView->assign('site',$auteurs[$i][4]);
				    	$mailView->assign('prenom',$auteurs[$i][0]);
				    	$mailView->assign('nom',$auteurs[$i][1]);
				    	$mailView->assign('login',$auteurs[$i][2]);
				    	$mailView->assign('mdp',$auteurs[$i][3]);
				    	$mailView->assign('arrAut',$arrAuteur);
				    	$mailView->assign('arrRub',$arrRubAut[0]);
				    	$mailView->assign('arrArt',$arrArt);
				    	$mailView->assign('urlVoir',$auteurs[$i][5]);
				    	$mailView->assign('urlEcrire',$auteurs[$i][6]);
				    	$mailView->assign('urlAuteur',$auteurs[$i][7]);
				    	
				    	$mailView->assign('mailContact',"samuel.szoniecky@univ-paris8.fr");
				    	$mailView->assign('nomContact',"Samuel Szoniecky");    	

					/*envoie du mail
					merci à http://stackoverflow.com/questions/18361233/gmail-sending-limits
					http://stackoverflow.com/questions/11076428/sending-newsletter-from-a-zend-framework-project
					*/
					try {
				    		$date = date("m/d/Y H:i:s");
						$gm->sendMail($arrAuteur['email'], "samszon@gmail.com", $auteurs[$i][4]." : nouveau site", $mailView->render('spipconnexion.phtml'));
						$this->view->data["OK"][] = "mail envoyé à ".$arrAuteur['email']." le :".$date;
						//$this->view->data["HTML"][] = $mailView->render('spipconnexion.phtml');
						//$this->view->data["arrRubAut"] = $arrRubAut;
						//$this->view->data["arrAuteur"] = $arrAuteur;
						//$this->view->data["arrArt"] = $arrArt;
						
						//ne pas envoyer les mail trop vite
						//https://support.google.com/a/answer/166852?hl=en
						sleep(2);
				       	continue;
					} catch (Zend_Mail_Transport_Exception $e) {
					    $this->view->data['Zend_Mail_Transport_Exception'][]="- Mails were not accepted for sending: ".$e->getMessage();
					} catch (Zend_Mail_Protocol_Exception $e) {
					    $this->view->data['Zend_Mail_Protocol_Exception'][]="- SMTP Sentmail Error: ".$e->getMessage();
					} catch (Exception $e) {
					    $this->view->data['Unknown Exception'][]="- SMTP Sentmail Error: ".$e->getMessage();
					}		
			    	
				}
				
			}
		}	
			
		
	}
	

	/**
	 * controleur pour les récupérer les données d'un formulaire
	 */
	public function formgetdonneesAction() {
		if($this->_getParam('idBase')) $this->dbNom = $this->_getParam('idBase');
		$s = new Flux_Site($this->dbNom);
		$dbF = new Model_DbTable_Spip_forms($s->db);
		//$rs = $dbF->getDonneesDetails($this->_getParam('idForm'));
		$rs = $dbF->getDonneesDetailsPropre($this->_getParam('idForm'),$this->_getParam('auteur',true));
		
		$this->view->rs = $rs;
		
	}
	
}