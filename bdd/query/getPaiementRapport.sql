SELECT 
			r.id_rapport recid, r.url, r.maj
		    , ids.royIds, ids.idAuteur, ids.idLivre
			, nom, prenom, id_auteur
			, titre_fr, titre_en, id_livre    
		    , SUM(montant_livre) montant_livre
		    , MIN(date_paiement) date_paiement, MIN(date_edition) date_edition, MIN(date_encaissement) date_encaissement
			, base_contrat, DATE_FORMAT(date_taux,'%Y') periode
		FROM iste_rapport r
			INNER JOIN (SELECT id_rapport  
				, SUBSTRING_INDEX(obj_id,'_',-1) royIds
				, SUBSTRING_INDEX(obj_id,'_',1) idAuteur
				, SUBSTRING_INDEX(SUBSTRING_INDEX(obj_id,'_',-2),'_',1) idLivre
				FROM iste_rapport) ids ON ids.id_rapport = r.id_rapport
			INNER JOIN iste_auteur a ON a.id_auteur = ids.idAuteur
		    INNER JOIN iste_livre l ON l.id_livre = ids.idLivre
		    INNER JOIN iste_royalty roy ON roy.id_royalty IN (ids.royIds)
		    INNER JOIN iste_devise d  ON d.id_devise = roy.id_devise
		WHERE a.id_auteur = 206
		GROUP BY r.id_rapport          
