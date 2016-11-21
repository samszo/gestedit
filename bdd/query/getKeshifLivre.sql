SELECT 	
			l.id_livre recid, titre_fr, titre_en, soustitre_fr, soustitre_en, type_1, type_2, num_vol
            , GROUP_CONCAT(DISTINCT(CONCAT(t.nom,':',IFNULL(pre.prevision,0),':',IFNULL(pre.fin,0)))) dates
			, GROUP_CONCAT(DISTINCT(i.num)) isbns, GROUP_CONCAT(DISTINCT(i.nb_page)) nbPage
            , GROUP_CONCAT(DISTINCT(e.nom)) editeurs
			, GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom))) auteurs
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
            , MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			, GROUP_CONCAT(DISTINCT(b.nom)) boutiques			
			, SUM(r.montant_livre) mt_e_r            
			, p.prix_livre, prix_euro, prix_dollar
			, GROUP_CONCAT(DISTINCT f.type,':',f.url) fics
			FROM iste_livre l
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
				INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
                INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
                INNER JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
                INNER JOIN iste_prevision pre ON pre.id_pxu = pl.id_plu AND pre.obj = 'livre' AND pre.id_tache IN (17,18)
                INNER JOIN iste_tache t ON t.id_tache = pre.id_tache
				LEFT JOIN iste_vente v ON v.id_isbn = i.id_isbn
				LEFT JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente
				LEFT JOIN iste_prix p ON p.id_isbn = i.id_isbn
				LEFT JOIN iste_importfic f ON f.id_obj = l.id_livre AND f.obj = 'livre' AND (f.type = 'Couverture en.' OR f.type = 'Couverture fr.') 
			GROUP BY l.id_livre