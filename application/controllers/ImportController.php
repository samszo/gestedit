<?php

class ImportController extends Zend_Controller_Action
{
	var $s;
	var $dbA;
	
    public function indexAction()
    {
    }
    
    public function historiqueAction()
    {
		$this->s = new Flux_Site();
		$this->s->bTrace = true;		
		$this->s->bTraceFlush = true;		
		$this->s->trace("DEBUT ".__METHOD__);		
		
		$this->dbA = new Model_DbTable_Iste_auteur();
		$this->dbCol = new Model_DbTable_Iste_collection();
		$this->dbCom = new Model_DbTable_Iste_comite();
		$this->dbSerie = new Model_DbTable_Iste_serie();
		$this->dbCoor = new Model_DbTable_Iste_coordination();
		$this->dbLivre = new Model_DbTable_Iste_livre();
		$this->dbLiAut = new Model_DbTable_Iste_livrexauteur();
		$this->dbLiCol = new Model_DbTable_Iste_livrexcollection();
		$this->dbLiSer = new Model_DbTable_Iste_livrexserie();
		$this->dbLiCom = new Model_DbTable_Iste_comitexlivre();
		$this->dbIsbn = new Model_DbTable_Iste_isbn();
		$this->dbPrix = new Model_DbTable_Iste_prix();
		$this->dbProp = new Model_DbTable_Iste_proposition();
		$this->dbProc = new Model_DbTable_Iste_processus();
		$this->dbPrev = new Model_DbTable_Iste_prevision();
		$this->dbCont = new Model_DbTable_Iste_contrat();
		$this->dbAutCont = new Model_DbTable_Iste_auteurxcontrat();
		
		$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015.csv");
		$i = 1;
		foreach ($arr as $r) {
			//
		$this->s->trace($i."//import des séries");			
			$idSerie = $this->dbSerie->ajouter(array("ref_racine"=>$r[0],"titre_en"=>$r[4],"titre_fr"=>$r[5]));
			//
			
		$this->s->trace($i."//import des collections");			
			$idCol = $this->dbCol->ajouter(array("titre_en"=>$r[4],"titre_fr"=>$r[5]));
						
			//
		$this->s->trace($i."//import des commités");			
			$idCom = $this->dbCom->ajouter(array("titre_en"=>$r[8]));
			//
			
		$this->s->trace($i."//import des livres");			
			$idLivre = $this->dbLivre->ajouter(array("reference"=>$r[1],"type_1"=>$r[18],"type_2"=>$r[9]
				,"titre_en"=>$r[11],"soustitre_en"=>$r[12],"titre_fr"=>$r[13],"soustitre_fr"=>$r[14]
				,"num_vol"=>$r[6]));
	
		$this->s->trace($i."//import des directeurs de collection");			
			$arrIdAut = $this->ajoutAuteur($r[7]);
			//ajout des coordinations
			foreach ($arrIdAut as $id) {
				$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"coordinateur"));
				$this->dbCoor->ajouter(array("id_collection"=>$idCol, "id_auteur"=>$id));
				if($r[3]){
					$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat de coordination","type"=>coordination));			
					$this->dbAutCont->ajouter(array("id_auteur"=>$id, "id_contrat"=>$idCont, "date_signature"=>$r[3]));
				}				
			}
				
		$this->s->trace($i."//import des auteurs");			
			$arrIdAut = $this->ajoutAuteur($r[10]);
			foreach ($arrIdAut as $id) {
				$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"auteur"));
			}			

			
		$this->s->trace($i."//import des isbn");	
			$idIsbn = false;		
			switch ($r[25]) {
				case 1:
					$idEditeur = 5;//'Wiley'
					break;
				case 2:
					$idEditeur = 4;//'Elsevier'
					break;
				case 3:
					$idEditeur = 2;//'ISTE International'
					break;
			}
			//gestion de la date 
			$date_parution = null;
			if($r[19]=="GB") $date_parution = $r[37];
			if($r[19]=="FR") $date_parution = $r[40];
			//creation des data isbn;
			$dataIsbn = array("id_livre"=>$idLivre,"id_editeur"=>$idEditeur);
			if($r[33])$dataIsbn["nb_page"]=$r[33];
			if($date_parution)$dataIsbn["date_parution"]=$date_parution;		
			
			//gestion de l'éditeur
			if($r[26]){//'Wiley'
				$dataIsbn["id_editeur"]=5;
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
			}
			if($r[27]){//'Elsevier'
				$dataIsbn["id_editeur"]=4;
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
			}
			if($r[28]){//'ISTE Editions'
				$dataIsbn["id_editeur"]=1;
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
			}
			//(1, 'ISTE Editions'),
			//(3, 'ISTE Press'),
			
			//vérifie si l'isbn est créé
			if(!$idIsbn)
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);	
			
			//gestion du prix
			if($r[34]){
				$this->dbPrix->ajouter(array("id_isbn"=>$idIsbn,"prix_dollar"=>$r[34]));
			}
				
		$this->s->trace($i."//import des propositions");	
			$dataProp = array('id_livre'=>$idLivre,"base_contrat"=>$r[17]
				,"publication_en"=>$r[20],"publication_fr"=>$r[21],"nb_page"=>$r[23]);
			
			if($r[15]=="reçu")$dataProp['date_debut']=new Zend_Db_Expr('NOW()');
			elseif ($r[15])$dataProp['date_debut']=$r[15];
			
			if(substr($r[16], 0, 3)=="ENV")$dataProp['date_contrat']=substr($r[16], 4);
			elseif ($r[16])$dataProp['date_contrat']=$r[16];
			
			if($r[22])$dataProp['traduction']="anglais";

			if($r[24])$dataProp['date_manuscrit']=$r[24];

			if($r[19]=="GB")$dataProp['langue']="anglais";
			if($r[19]=="FR")$dataProp['langue']="français";
			
			$this->dbProp->ajouter($dataProp);
					
		$this->s->trace($i."//import des prévisions");	
			if($r[22]) $this->dbProc->setProcessusForLivre('Traduction livre', $idLivre, 1);    		    			

			$rsProc = $this->dbProc->setProcessusForLivre('Production livre', $idLivre, 1);    		    			
			
			if($r[29])$this->dbPrev->edit($id, array("fin"=>$r[29]));
			if($r[30])$this->dbPrev->edit($id, array("fin"=>$r[30]));
			if($r[31])$this->dbPrev->edit($id, array("prevision"=>$r[31]));
			if($r[32])$this->dbPrev->edit($id, array("prevision"=>$r[32]));			
						
		$this->s->trace($i."//import des données liées");	
			$this->dbLiCol->ajouter(array("id_collection"=>$idCol, "id_livre"=>$idLivre));
			$this->dbLiSer->ajouter(array("id_serie"=>$idSerie, "id_livre"=>$idLivre));
			$this->dbLiCom->ajouter(array("id_comite"=>$idCom, "id_livre"=>$idLivre));
			
			$i++;
		}

		$this->s->trace("FIN ".__METHOD__);		
    }

    function ajoutAuteur($r){
		$arrAuteur = explode(",", $r);
		$arrId = array();
		foreach ($arrAuteur as $a) {
			$np = explode(" ", trim($a));
			if(count($np)>2)
				$arrId[] = $this->dbA->ajouter(array("nom"=>$np[0].' '.$np[1], "prenom"=>$np[2]));
			else{
				if($np[0] && $np[1])$arrId[] = $this->dbA->ajouter(array("nom"=>$np[0], "prenom"=>$np[1]));
				if(!$np[0] && $np[1])$arrId[] = $this->dbA->ajouter(array("nom"=>$np[1]));
			}
			$this->s->trace($i." - Nom : ".$np[0].", "."Prénom ".$np[1]);
		}
		return $arrId;
    }

    function ajoutCollection($r){
		$arrAuteur = explode(",", $r);
		foreach ($arrAuteur as $a) {
			$np = explode(" ", trim($a));
			if(count($np)>2)
				$this->dbA->ajouter(array("nom"=>$np[0].' '.$np[1], "prenom"=>$np[2]));
			else{
				if($np[0] && $np[1])$this->dbA->ajouter(array("nom"=>$np[0], "prenom"=>$np[1]));
				if(!$np[0] && $np[1])$this->dbA->ajouter(array("nom"=>$np[1]));
			}
			$this->s->trace($i." - Nom : ".$np[0].", "."Prénom ".$np[1]);
		}
    }
    
}



