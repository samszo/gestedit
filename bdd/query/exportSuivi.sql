SELECT 
			l.id_livre, l.titre_fr, l.soustitre_fr, l.titre_en, l.soustitre_en, l.type_1, l.type_2
			, GROUP_CONCAT(DISTINCT IFNULL(a.prenom,'') , ' ', IFNULL(a.nom,'') SEPARATOR ', ') 'auteur'
			, GROUP_CONCAT(DISTINCT IFNULL(co.prenom,'') , ' ', IFNULL(co.nom,'') SEPARATOR ', ') 'coordonateur'			
			, GROUP_CONCAT(DISTINCT IFNULL(ad.prenom,'') , ' ', IFNULL(ad.nom,'') SEPARATOR ', ') 'directeur'
			, GROUP_CONCAT(DISTINCT IFNULL(ar.prenom,'') , ' ', IFNULL(ar.nom,'') SEPARATOR ', ') 'resp. série'
			,iW.num 'ISBN Wiley', CONCAT(IFNULL(iW.date_parution,''), IFNULL(iE.date_parution,'')) 'Fin Parution GB'
			,iE.num 'ISBN Elsevier'
			,iI.num 'ISBN ISTE', iI.date_parution 'Fin Parution FR'
			
		    , GROUP_CONCAT(DISTINCT IFNULL(s.titre_en,'') , ' / ', IFNULL(s.titre_fr,'') SEPARATOR ', ') 'Série'
			-- , GROUP_CONCAT(DISTINCT IFNULL(aSerie.prenom,'') , ' ', IFNULL(aSerie.nom,'') SEPARATOR ', ') 'Resp. de la Série'
		
		    , GROUP_CONCAT(DISTINCT IFNULL(c.titre_en,'') , ' / ', IFNULL(c.titre_fr,'') SEPARATOR ', ') 'Comité'
			-- , GROUP_CONCAT(DISTINCT IFNULL(aCom.prenom,'') , ' ', IFNULL(aCom.nom,'') SEPARATOR ', ') 'Directeur du comite'
		
			, l.production
			
			, eFR.nom 'Editeur FR'
			, eGB.nom 'Editeur GB'
			
		    , MAX(pa.nombre) 'Pages Prévu'
		    , MAX(pfGB.nombre) 'Pages final GB'
		    , MAX(pfFR.nombre) 'Pages final FR'
		    
			, pm.prevision 'Prévision de réception du manuscrit'
		    , pm.commentaire 'réception du manuscrit commentaire'
			
		    , pt.prevision 'Prévision de réception de la traduction'
			
		    , pp.prevision 'Prévisions de parution GB'
		
		    , ppr.debut 'Gestion de proposal origine'
		    , ppr.fin 'Gestion de proposal fin'
		    , ppr.commentaire 'Gestion de proposal commentaire'
		
		    , ppc.debut 'Gestion de contrat origine'
		    , ppc.fin 'Gestion de contrat fin'
		    , ppc.commentaire 'Gestion de contrat commentaire'
		
			, pr.prix_dollar 'Prix catalogue dollar'
			-- , prp.prix_dollar 'Prix papier GB livre'
		
			FROM iste_livre l
				LEFT JOIN iste_isbn iW ON iW.id_livre = l.id_livre AND iW.id_editeur = 5
				LEFT JOIN iste_isbn iE ON iE.id_livre = l.id_livre AND iE.id_editeur = 4
				LEFT JOIN iste_isbn iI ON iI.id_livre = l.id_livre AND iI.id_editeur = 1
				
				LEFT JOIN iste_editeur eFR ON eFR.id_editeur = iI.id_editeur
				LEFT JOIN iste_editeur eGB ON eGB.id_editeur = iE.id_editeur	OR eGB.id_editeur = iW.id_editeur								
				
				LEFT JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
				LEFT JOIN iste_serie s ON s.id_serie = ls.id_serie
				-- INNER JOIN iste_coordination coo ON coo.id_serie = s.id_serie
				-- INNER JOIN iste_auteur aSerie ON aSerie.id_auteur = coo.id_auteur
		
				LEFT JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
				LEFT JOIN iste_comite c ON c.id_comite = cl.id_comite
				-- INNER JOIN iste_comitexauteur ca ON ca.id_comite = c.id_comite
				-- INNER JOIN iste_auteur aCom ON aCom.id_auteur = ca.id_auteur
		
				INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
		
				LEFT JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = 'auteur'
				LEFT JOIN iste_auteur a ON a.id_auteur = la.id_auteur
		
				LEFT JOIN iste_livrexauteur lad ON lad.id_livre = l.id_livre AND lad.role = 'directeur'
				LEFT JOIN iste_auteur ad ON ad.id_auteur = lad.id_auteur
		
				LEFT JOIN iste_livrexauteur las ON las.id_livre = l.id_livre AND las.role = 'resp. série'
				LEFT JOIN iste_auteur ar ON ar.id_auteur = las.id_auteur

				LEFT JOIN iste_livrexauteur lac ON lac.id_livre = l.id_livre AND lac.role = 'coordonnateur'
				LEFT JOIN iste_auteur co ON co.id_auteur = lac.id_auteur				
				
				LEFT JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
				LEFT JOIN iste_prevision pt ON pt.id_pxu = pl.id_plu AND pt.id_tache = 16
				LEFT JOIN iste_prevision pm ON pm.id_pxu = pl.id_plu AND pm.id_tache = 15
				LEFT JOIN iste_prevision pp ON pp.id_pxu = pl.id_plu AND pp.id_tache = 17        
				LEFT JOIN iste_prevision ppr ON ppr.id_pxu = pl.id_plu AND ppr.id_tache = 25
		
				LEFT JOIN iste_processusxlivre plc ON plc.id_livre = l.id_livre AND plc.id_processus = 3
				LEFT JOIN iste_prevision ppc ON ppc.id_pxu = plc.id_plu AND ppc.id_tache = 37
		
				LEFT JOIN iste_prix pr ON (pr.id_isbn = iW.id_isbn OR pr.id_isbn = iE.id_isbn OR pr.id_isbn = iI.id_isbn)  AND pr.type = 'prix catalogue'
				LEFT JOIN iste_prix prp ON (prp.id_isbn = iW.id_isbn OR prp.id_isbn = iE.id_isbn OR prp.id_isbn = iI.id_isbn)  AND prp.type = 'papier GB'
		
				LEFT JOIN iste_page pa ON pa.id_livre = l.id_livre AND (pa.type = 'prévu FR' OR pa.type = 'prévu GB' OR pa.type = 'pr&#233;vu')			    
					AND pa.maj = (SELECT MAX(maj) FROM iste_page WHERE id_livre = l.id_livre AND (type = 'prévu FR' OR type = 'prévu GB' OR type = 'pr&#233;vu'))		    
				LEFT JOIN iste_page pfGB ON pfGB.id_livre = l.id_livre AND (pfGB.type = 'final GB') 
					AND pfGB.maj = (SELECT MAX(maj) FROM iste_page WHERE id_livre = l.id_livre AND (type = 'final GB'))		    
				LEFT JOIN iste_page pfFR ON pfFR.id_livre = l.id_livre AND (pfFR.type = 'final FR')			    
					AND pfFR.maj = (SELECT MAX(maj) FROM iste_page WHERE id_livre = l.id_livre AND (type = 'final FR'))		    
			WHERE l.id_livre < 50
			GROUP BY l.id_livre