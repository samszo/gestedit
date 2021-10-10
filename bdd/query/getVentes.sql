SELECT 	
			l.id_livre recid, CONCAT(IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) titre
			, GROUP_CONCAT(DISTINCT(i.num)) isbns, GROUP_CONCAT(DISTINCT(i.id_isbn)) idsisbns
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
          , GROUP_CONCAT(DISTINCT(b.nom)) boutiques			
			, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			, ca.auteurs
			, SUM(r.montant_livre) mt_e_r
			FROM iste_livre l
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
				INNER JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				INNER JOIN (SELECT GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom))) auteurs, la.id_livre
				FROM iste_auteur a 
				INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
				GROUP BY la.id_livre
				) ca ON ca.id_livre = l.id_livre
				LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente
			GROUP BY l.id_livre
            