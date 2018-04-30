<?php
//header('Content-Type: text/html; charset=utf-8');
require_once( "../application/configs/config.php" );
try {
	$application->bootstrap();
	$s = new Flux_Site(false,false);
	$s->bTrace = true;
	$s->bTraceFlush = false;
	$s->trace("DEBUT TEST");		

	/*
	$bdA = new Model_DbTable_Iste_prevision();
    	$rsA = $bdA->getAlerteLivre();
    	for ($i = 0; $i < count($rsA); $i++) {
    		if($rsA[$i]['nbJour']<7)$rsA[$i]['style']='background-color: red';
    		if($rsA[$i]['nbJour']>7 && $rsA[$i]['nbJour']<14)$rsA[$i]['style']='background-color: orange';
    		if($rsA[$i]['nbJour']>14 && $rsA[$i]['nbJour']<21)$rsA[$i]['style']='background-color: green';    			
    		if($rsA[$i]['nbJour']>21)$rsA[$i]['style']='background-color: white';    			
    	}
    	*/		
	/*
    	$oBdd = new Model_DbTable_Iste_serie();
	$rs = $oBdd->copier(132);
	*/
	
	/*
	$dbL = new Model_DbTable_Iste_livre();
	$arr = $dbL->remove(2);
	*/
	
	/*
	$dbR = new Model_DbTable_Iste_royalty();    		
	$rs = $dbR->setForAuteur();	
	*/

	/*
	$path = "/data/livre_1/";
	$options = array('upload_dir' => ROOT_PATH.$path,'upload_url' => WEB_ROOT.$path);
	@$_SERVER["REQUEST_METHOD"]="GET";
	//$upload_handler = new UploadHandler($options);
	$upload_handler = new CustomUploadHandler($options);
	*/
	/*
	$w = new Flux_Wiley(false,true);
	$w->importer('../bdd/import/146169_1409.XLS');
	//$w->calculerVentes(3);
	*/

	/*
	$nbn = new Flux_Nbn(false,true);
	//$nbn->importer('../bdd/import/NBNEXPORT.CSV',"2015-03-30");
	$nbn->calculerVentes(4);
	*/
	
	//$dbFic = new Model_DbTable_Iste_importfic();
	//supprime un fichier et ses données
	//$dbFic->remove(43);
	//$rsFic = $dbFic->findById_importfic(48);
	/*calcul les colonnes 	
    	$cols = json_decode($rsFic["coldesc"]);
	*/
	
	/*
    	$dbData = new Model_DbTable_Iste_importdata();
    	$rs = $dbData->exportByIdFic(46);
	$arr = $s->csvToArray("../bdd/import/ISTEGlobal2015SAMbd.csv");
	*/
	
	/*
	$dbProcess = new Model_DbTable_Iste_processus();
	$dbProcess->setProcessusForLivre('Production livre', 1, 1); 
    	$dbProcess->getTraductionByLivre(1);
	*/
	
	/*
	$s = new Flux_Spip("spip_iste",true);
	$dbAut = new Model_DbTable_Iste_auteur();	
	//charge la liste des auteurs
	$arrAuteur = $dbAut->getAll("a.id_auteur");	
	$nbM = count($arrAuteur);
	for ($i = 0; $i < $nbM; $i++) {			
			//if($arrAuteur[$i]["id_auteur"]==200)
				$s->creaAuteurFromIste($arrAuteur[$i]);
	}		
	*/
	
	/*
	$result = array();
    	$dbR = new Model_DbTable_Iste_royalty();
	//$rs = $dbR->paiementLivre("1249");
	$rs = $dbR->paiementAuteur("484");
	$rapport = new Flux_Rapport();    		
	foreach ($rs as $r) {
    		$result[] = $rapport->creaPaiement($r);
	}
	*/
	/*
	$rapport = new Flux_Rapport();    		
	$rapport->creaEtatSeries(array(1,2));	
	*/
/*	
$iste_serie = array(
  array('id_serie' => '140','titre_fr' => 'copie ','titre_en' => 'copy Advances in Information Systems','ref_racine' => NULL),
  array('id_serie' => '141','titre_fr' => 'copie ','titre_en' => 'copy Architecture-Aware Optimization Strategies in Real-Time Image Processing','ref_racine' => NULL),
  array('id_serie' => '142','titre_fr' => 'copie ','titre_en' => 'copy Advanced SmartGrids','ref_racine' => NULL),
  array('id_serie' => '143','titre_fr' => 'copie  ','titre_en' => 'copy Branching Processes, Branching Random Walks and Branching Particle Fields','ref_racine' => NULL),
  array('id_serie' => '144','titre_fr' => 'copie  ','titre_en' => 'copy Discrete Element Model and Simulation of Continuous Materials Behavior','ref_racine' => NULL),
  array('id_serie' => '145','titre_fr' => 'copie ','titre_en' => 'copy Anthropogenic Processes in Fluvial Landscapes','ref_racine' => NULL),
  array('id_serie' => '146','titre_fr' => 'copie ','titre_en' => 'copy Durability, Robustness and Reliability of Photonic Devices','ref_racine' => NULL),
  array('id_serie' => '147','titre_fr' => 'copie ','titre_en' => 'copy Discrete Granular Mechanics','ref_racine' => NULL),
  array('id_serie' => '148','titre_fr' => 'copie ','titre_en' => 'copy Enterprise Interoperability','ref_racine' => NULL),
  array('id_serie' => '149','titre_fr' => 'copie ','titre_en' => 'copy Energy Storage – Batteries and Supercapacitors','ref_racine' => NULL),
  array('id_serie' => '150','titre_fr' => 'copie ','titre_en' => 'copy Functional Data Analysis','ref_racine' => NULL),
  array('id_serie' => '151','titre_fr' => 'copie ','titre_en' => 'copy High Level Parallel Programming','ref_racine' => NULL),
  array('id_serie' => '152','titre_fr' => 'copie ','titre_en' => 'copy Image Processing and Mathematical Modeling','ref_racine' => NULL),
  array('id_serie' => '153','titre_fr' => 'copie ','titre_en' => 'copy Mathematical Models and Methods in Reliability','ref_racine' => NULL),
  array('id_serie' => '154','titre_fr' => 'copie ','titre_en' => 'copy Local Approach to Fracture','ref_racine' => NULL),
  array('id_serie' => '155','titre_fr' => 'copie ','titre_en' => 'copy Innovative Bio and Food Technologies','ref_racine' => NULL),
  array('id_serie' => '156','titre_fr' => 'copie ','titre_en' => 'copy Micromechanics','ref_racine' => NULL),
  array('id_serie' => '157','titre_fr' => 'copie ','titre_en' => 'copy Modeling and Management of Contexts','ref_racine' => NULL),
  array('id_serie' => '158','titre_fr' => 'copie ','titre_en' => 'copy Multi-physics Coupling in Geomaterials','ref_racine' => NULL),
  array('id_serie' => '159','titre_fr' => 'copie ','titre_en' => 'copy Optical Instruments for Space Objects','ref_racine' => NULL),
  array('id_serie' => '160','titre_fr' => 'copie ','titre_en' => 'copy Optimization in Insurance and Finance','ref_racine' => NULL),
  array('id_serie' => '161','titre_fr' => 'copie ','titre_en' => 'copy Seas and Oceans','ref_racine' => NULL),
  array('id_serie' => '162','titre_fr' => 'copie ','titre_en' => 'copy Quantitative Finance','ref_racine' => NULL),
  array('id_serie' => '163','titre_fr' => 'copie  ','titre_en' => 'copy Oxidative Ageing of Polymers','ref_racine' => NULL),
  array('id_serie' => '164','titre_fr' => 'copie ','titre_en' => 'copy Sensor Networks','ref_racine' => NULL),
  array('id_serie' => '165','titre_fr' => 'copie ','titre_en' => 'copy Spatial Patterns in Mathematics','ref_racine' => NULL),
  array('id_serie' => '166','titre_fr' => 'copie ','titre_en' => 'copy Soil-structure Interaction','ref_racine' => NULL),
  array('id_serie' => '167','titre_fr' => 'copie ','titre_en' => 'copy Stochastic Models in Insurance','ref_racine' => NULL),
  array('id_serie' => '168','titre_fr' => 'copie ','titre_en' => 'copy Stochastic Models in Survival Analysis and Reliability','ref_racine' => NULL),
  array('id_serie' => '169','titre_fr' => 'copie ','titre_en' => 'copy Systems Dependability Assessment','ref_racine' => NULL),
  array('id_serie' => '170','titre_fr' => 'copie Analyse pour les EDP','titre_en' => 'copy Analysis for EDP','ref_racine' => NULL),
  array('id_serie' => '171','titre_fr' => 'copie 1','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '172','titre_fr' => 'copie Applications des métamatériaux aux vibrations','titre_en' => 'copy Metamaterials Applied to Waves','ref_racine' => NULL),
  array('id_serie' => '173','titre_fr' => 'copie Applications duales des nanotechnologies','titre_en' => 'copy Dual-use Nanotechnologies','ref_racine' => NULL),
  array('id_serie' => '174','titre_fr' => 'copie Architecture et sciences informatiques','titre_en' => 'copy Architecture and Computer Science','ref_racine' => NULL),
  array('id_serie' => '175','titre_fr' => 'copie Assimilation de données en mécanique','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '176','titre_fr' => 'copie Bibliothèques et collections numériques','titre_en' => 'copy Digital Libraries and Collections','ref_racine' => NULL),
  array('id_serie' => '177','titre_fr' => 'copie Biologie','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '178','titre_fr' => 'copie Biostatistique et sciences de la santé','titre_en' => 'copy Biostatistics and Health Science','ref_racine' => NULL),
  array('id_serie' => '179','titre_fr' => 'copie Biorhéologie','titre_en' => 'copy Biorheology','ref_racine' => NULL),
  array('id_serie' => '180','titre_fr' => 'copie Chémostat et bioprocédés','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '181','titre_fr' => 'copie Chimie verte et organo-catalyse','titre_en' => 'copy Green Chemistry and Organo Catalysts','ref_racine' => NULL),
  array('id_serie' => '182','titre_fr' => 'copie Conversion d’énergie solaire concentrée','titre_en' => 'copy Concentrated Solar Energy Conversion','ref_racine' => NULL),
  array('id_serie' => '183','titre_fr' => 'copie Décomposition modales en mécanique des fluides','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '184','titre_fr' => 'copie Drogues et addictions','titre_en' => 'copy Drugs and Addiction','ref_racine' => NULL),
  array('id_serie' => '185','titre_fr' => 'copie Drones communicants','titre_en' => 'copy Communicating Drones','ref_racine' => NULL),
  array('id_serie' => '186','titre_fr' => 'copie Durabilité des ouvrages de génie civil','titre_en' => 'copy Structures Durability in Civil Engineering','ref_racine' => NULL),
  array('id_serie' => '187','titre_fr' => 'copie Durabilité et le vieillissement des matériaux composites à matrice organique','titre_en' => 'copy Durability and Ageing of Organic Composite Materials','ref_racine' => NULL),
  array('id_serie' => '188','titre_fr' => 'copie Durabilité, robustesse et fiabilité des dispositifs photoniques','titre_en' => 'copy Durability, Robustness and Reliability of Photonic Devices','ref_racine' => NULL),
  array('id_serie' => '189','titre_fr' => 'copie Eco-toxicologie','titre_en' => 'copy Ecotoxicology','ref_racine' => NULL),
  array('id_serie' => '190','titre_fr' => 'copie Eau et énergie','titre_en' => 'copy Water and Energy','ref_racine' => NULL),
  array('id_serie' => '191','titre_fr' => 'copie Ecologie humaine','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '192','titre_fr' => 'copie Energie nucléaire','titre_en' => 'copy Nuclear Energy','ref_racine' => NULL),
  array('id_serie' => '193','titre_fr' => 'copie Enonciation et syntaxe en discours','titre_en' => 'copy Interaction of Syntax and Semantics in Discourse','ref_racine' => NULL),
  array('id_serie' => '194','titre_fr' => 'copie Entrepreunariat et innovation','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '195','titre_fr' => 'copie Facteurs humains dans le transport','titre_en' => 'copy Human Factors and Technology in Transport','ref_racine' => NULL),
  array('id_serie' => '196','titre_fr' => 'copie Environnement électromagnétique','titre_en' => 'copy Electromagnetic Environment','ref_racine' => NULL),
  array('id_serie' => '197','titre_fr' => 'copie Fiabilité des systèmes multiphysiques','titre_en' => 'copy Reliability of Multiphysical Systems','ref_racine' => NULL),
  array('id_serie' => '198','titre_fr' => 'copie Génie Industriel','titre_en' => 'copy Industrial Engineering','ref_racine' => NULL),
  array('id_serie' => '199','titre_fr' => 'copie fusion : Nanotechnologies pour la récupération d’énergie - ','titre_en' => 'copy fusion : Nanotechnologies for Energy Recovery','ref_racine' => NULL),
  array('id_serie' => '200','titre_fr' => 'copie Gestion de l\'énergie dans les systèmes embarqués','titre_en' => 'copy Energy Management in Embedded Systems','ref_racine' => NULL),
  array('id_serie' => '201','titre_fr' => 'copie Gestion des risques et des accidents par les technologies ondes','titre_en' => 'copy Risk and Accident Management using Wave Technologies','ref_racine' => NULL),
  array('id_serie' => '202','titre_fr' => 'copie Gestion des territoires et santé numérique','titre_en' => 'copy Territory Management and Digital Healthcare','ref_racine' => NULL),
  array('id_serie' => '203','titre_fr' => 'copie Industrialisation de la médecine','titre_en' => 'copy Industrialization of Medicine','ref_racine' => NULL),
  array('id_serie' => '204','titre_fr' => 'copie Informatique et société connectée','titre_en' => 'copy Computing and Connected Society','ref_racine' => NULL),
  array('id_serie' => '205','titre_fr' => 'copie Information, Communication et Territoires Intelligents','titre_en' => 'copy Information, Communication and Intelligent Territories','ref_racine' => NULL),
  array('id_serie' => '206','titre_fr' => 'copie Ingénierie documentaire','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '207','titre_fr' => 'copie Ingénierie mathématique et mécanique','titre_en' => 'copy Mathematical and Mechanical Engineering','ref_racine' => NULL),
  array('id_serie' => '208','titre_fr' => 'copie Innovation et Recherche Responsables','titre_en' => 'copy Responsible Research and Innovation','ref_racine' => NULL),
  array('id_serie' => '209','titre_fr' => 'copie Interaction fluide-structure','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '210','titre_fr' => 'copie Innovation et technologies','titre_en' => 'copy Innovation and Technology','ref_racine' => NULL),
  array('id_serie' => '211','titre_fr' => 'copie Interactions socio-écologiques','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '212','titre_fr' => 'copie Interaction Homme-Machine','titre_en' => 'copy Human-Machine Interaction','ref_racine' => NULL),
  array('id_serie' => '213','titre_fr' => 'copie Interdisciplinarités autour des faits sociaux','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '214','titre_fr' => 'copie L\'innovation, entre le risque et la réussite','titre_en' => 'copy ﻿Innovation between Risk and Reward','ref_racine' => NULL),
  array('id_serie' => '215','titre_fr' => 'copie La finance d’entreprise','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '216','titre_fr' => 'copie La science des données','titre_en' => 'copy Data Science','ref_racine' => NULL),
  array('id_serie' => '217','titre_fr' => 'copie La commande tolérante aux défauts','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '218','titre_fr' => 'copie La consommation responsable','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '219','titre_fr' => 'copie Lasers de nouvelle génération','titre_en' => 'copy Advanced Lasers','ref_racine' => NULL),
  array('id_serie' => '220','titre_fr' => 'copie Lasers de nouvelle génération','titre_en' => 'copy Advanced Lasers – B Uses','ref_racine' => NULL),
  array('id_serie' => '221','titre_fr' => 'copie L’analyse syntaxique','titre_en' => 'copy Parsing','ref_racine' => NULL),
  array('id_serie' => '222','titre_fr' => 'copie Linguistique du langage oral','titre_en' => 'copy Spoken Language Linguistics ','ref_racine' => NULL),
  array('id_serie' => '223','titre_fr' => 'copie Les métaheuristiques','titre_en' => 'copy Metaheuristics','ref_racine' => NULL),
  array('id_serie' => '224','titre_fr' => 'copie Les ciments du futur','titre_en' => 'copy Cements of the Future','ref_racine' => NULL),
  array('id_serie' => '225','titre_fr' => 'copie L’économie de fonctionnalité pour une consommation durable','titre_en' => 'copy Functional Economy for Sustainable Consumption','ref_racine' => NULL),
  array('id_serie' => '226','titre_fr' => 'copie L’Identification sans fil au-delà de la RFID','titre_en' => 'copy Remote Identification Beyond RFID','ref_racine' => NULL),
  array('id_serie' => '227','titre_fr' => 'copie Matériaux composites','titre_en' => 'copy Advanced Composites Materials','ref_racine' => NULL),
  array('id_serie' => '228','titre_fr' => 'copie Maitrise de la sécurité des systèmes à base de logiciel','titre_en' => 'copy Software-based Safety Systems','ref_racine' => NULL),
  array('id_serie' => '229','titre_fr' => 'copie Mécanique théorique','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '230','titre_fr' => 'copie Matériaux pour la bioingénierie','titre_en' => 'copy Materials for Bioengineering','ref_racine' => NULL),
  array('id_serie' => '231','titre_fr' => 'copie Mer et Océan','titre_en' => 'copy Seas and Oceans','ref_racine' => NULL),
  array('id_serie' => '232','titre_fr' => 'copie Méthodes statistiques pour les seismes','titre_en' => 'copy Statistical Methods for Seismes','ref_racine' => NULL),
  array('id_serie' => '233','titre_fr' => 'copie Mise en oeuvre du Model Based System Engineering','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '234','titre_fr' => 'copie Modèles stochastiques en informatique et réseaux de télécommunications','titre_en' => 'copy Stochastic Models in Computer Science and Telecommunication Networks','ref_racine' => NULL),
  array('id_serie' => '235','titre_fr' => 'copie Modèles avancés en sûreté de fonctionnement','titre_en' => 'copy Advanced Dependability Models','ref_racine' => NULL),
  array('id_serie' => '236','titre_fr' => 'copie Modélisation et contrôle des procédés alimentaires','titre_en' => 'copy Modeling and Control of Food Processes','ref_racine' => NULL),
  array('id_serie' => '237','titre_fr' => 'copie Modélisation économique et scénarios pour la transition énergétique','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '238','titre_fr' => 'copie Modélisation géométrique et applications','titre_en' => 'copy ﻿Geometric Modeling and Applications','ref_racine' => NULL),
  array('id_serie' => '239','titre_fr' => 'copie Nano-optique','titre_en' => 'copy Nano-optics','ref_racine' => NULL),
  array('id_serie' => '240','titre_fr' => 'copie Nanotechnologies pour la récupération d’énergie','titre_en' => 'copy Nanotechnologies for Energy Recovery','ref_racine' => NULL),
  array('id_serie' => '241','titre_fr' => 'copie Nous informe en juillet 15 s’il fait','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '242','titre_fr' => 'copie Nouvelles méthodes mathématiques, systèmes et applications','titre_en' => 'copy New Mathematical Methods, Systems and Applications','ref_racine' => NULL),
  array('id_serie' => '243','titre_fr' => 'copie Nouvelles approches en écologie','titre_en' => 'copy New Advances in Ecological Sciences','ref_racine' => NULL),
  array('id_serie' => '244','titre_fr' => 'copie Observatoires Hommes-Milieux','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '245','titre_fr' => 'copie Ondes couplées','titre_en' => 'copy Coupled Waves','ref_racine' => NULL),
  array('id_serie' => '246','titre_fr' => 'copie Optoélectronique','titre_en' => 'copy Optoelectronics','ref_racine' => NULL),
  array('id_serie' => '247','titre_fr' => 'copie Ondes pour l’imagerie du vivant','titre_en' => 'copy Waves for Life Imaging','ref_racine' => NULL),
  array('id_serie' => '248','titre_fr' => 'copie Paléobiologie des vertébrés et paléoenvironnements','titre_en' => 'copy Vertebrate Palaeobiology and Palaeoenvironments','ref_racine' => NULL),
  array('id_serie' => '249','titre_fr' => 'copie Photogrammétrie et patrimoine','titre_en' => 'copy Photogrammetry and Heritage','ref_racine' => NULL),
  array('id_serie' => '250','titre_fr' => 'copie Physique et chimie des matériaux','titre_en' => 'copy Physics and Chemistry of Materials','ref_racine' => NULL),
  array('id_serie' => '251','titre_fr' => 'copie Poromécanique','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '252','titre_fr' => 'copie Post-traitement de données pour la mécanique des fluides','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '253','titre_fr' => 'copie Production et usages de la qualité','titre_en' => 'copy Manufacturing and Quality','ref_racine' => NULL),
  array('id_serie' => '254','titre_fr' => 'copie Regards croisés sur la création de valeur','titre_en' => 'copy Diverse and Global Perspectives on Value Creation','ref_racine' => NULL),
  array('id_serie' => '255','titre_fr' => 'copie Quantification et propagation des incertitudes en mécanique','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '256','titre_fr' => 'copie Risques naturels','titre_en' => 'copy Natural Disasters','ref_racine' => NULL),
  array('id_serie' => '257','titre_fr' => 'copie Réseaux de nouvelles générations','titre_en' => 'copy Advanced Networks','ref_racine' => NULL),
  array('id_serie' => '258','titre_fr' => 'copie Résilience et génie urbain','titre_en' => 'copy Resilience and Urban Engineering','ref_racine' => NULL),
  array('id_serie' => '259','titre_fr' => 'copie Smart Innovation','titre_en' => 'copy Smart Innovation','ref_racine' => NULL),
  array('id_serie' => '260','titre_fr' => 'copie SmartGrids de nouvelle génération','titre_en' => 'copy Advanced SmartGrids','ref_racine' => NULL),
  array('id_serie' => '261','titre_fr' => 'copie Smarts systèmes en santé','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '262','titre_fr' => 'copie Statistiques pour la bioinformatique','titre_en' => 'copy Statistics for Bioinformatics','ref_racine' => NULL),
  array('id_serie' => '263','titre_fr' => 'copie Systèmes d\'actionnement en aéronautique','titre_en' => 'copy Aerospace Actuation Systems','ref_racine' => NULL),
  array('id_serie' => '264','titre_fr' => 'copie Systèmes d’aide à la décision','titre_en' => 'copy Decision Support Systems','ref_racine' => NULL),
  array('id_serie' => '265','titre_fr' => 'copie Systèmes d’information avancés','titre_en' => 'copy Advances in Information Systems','ref_racine' => NULL),
  array('id_serie' => '266','titre_fr' => 'copie Stockage de l’énergie – Batteries et supercondensateurs','titre_en' => 'copy Energy Storage – Batteries, Supercapacitors Set','ref_racine' => NULL),
  array('id_serie' => '267','titre_fr' => 'copie Technologies intellectives','titre_en' => 'copy Intellectual Technologies','ref_racine' => NULL),
  array('id_serie' => '268','titre_fr' => 'copie Thermodynamique – Energie, Environnement, Economie','titre_en' => 'copy Thermodynamics – Energy, Environment, Economy','ref_racine' => NULL),
  array('id_serie' => '269','titre_fr' => 'copie Technologies, innovations, médias et société','titre_en' => 'copy Technology, Innovation, Media and Society','ref_racine' => NULL),
  array('id_serie' => '270','titre_fr' => 'copie Thermodynamique chimique approfondie','titre_en' => 'copy Chemical Thermodynamics','ref_racine' => NULL),
  array('id_serie' => '271','titre_fr' => 'copie Télédétection pour l\'Observation des Surfaces Continentales','titre_en' => 'copy Remote Sensing Observations of Continental Surfaces','ref_racine' => NULL),
  array('id_serie' => '272','titre_fr' => 'copie Traces','titre_en' => 'copy Traces','ref_racine' => NULL),
  array('id_serie' => '273','titre_fr' => 'copie Traitement des déchets organiques','titre_en' => 'copy Organic Waste Treatment','ref_racine' => NULL),
  array('id_serie' => '274','titre_fr' => 'copie Traitement des images et des jeux','titre_en' => 'copy ','ref_racine' => NULL),
  array('id_serie' => '275','titre_fr' => 'copie Utopies en information, communication et documentation','titre_en' => 'copy Information and Communication Utopias','ref_racine' => NULL)
);
	
	$dbS = new Model_DbTable_Iste_serie();
	foreach ($iste_serie as $serie) {
		$r = $dbS->remove($serie["id_serie"]);
		$s->trace($serie["titre_fr"]." / ".$serie["titre_fr"],$r);		
	}
*/
	//
	$v = new Flux_Vente(false,true);	
	//$v->importerNew(4061);
	//$v->importer(null,4059,null,1);
	//$v->calculerVentes(2972);
	//$v->calculerVentesNew(4065);
	//$v->updateTauxDevise();
	//$dbR = new Model_DbTable_Iste_royalty();
	//$rs = $dbR->setForAuteur();
	$descColo = array("ISBN"=>"col1","auteurs"=>"col2","QTY PAPER"=>"col3","AMOUNT PAPER"=>"col4","AMOUNT EBOOK"=>"col5");
	$json = json_encode($descColo);
	$rs =  $v->getProblemes(4065);
	
	//
			
	$s->trace("FIN TEST");		
	
}catch (Zend_Exception $e) {
	 echo "<h1>Erreur d'exécution</h1>
  <h2>".$e->message."</h2>
  <h3>Exception information:</h3>
  <p><b>Message:</b>".$e->exception->getMessage()."</p>
  <h3>Stack trace:</h3>
  <pre>".$e->exception->getTraceAsString()."</pre>
  <h3>Request Parameters:</h3>
  <pre>".var_export($e->request->getParams(), true)."</pre>";
}
