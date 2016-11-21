SELECT 	
			a.id_auteur recid, CONCAT(a.prenom,' ',a.nom) auteur
			, GROUP_CONCAT(DISTINCT la.role) roles
            , GROUP_CONCAT(DISTINCT IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) livres
--			, COUNT(l.id_livre) nbIdLivre, COUNT(DISTINCT l.id_livre) nbIdLivreDist
--			, COUNT(i.id_isbn) nbIdIsbn, COUNT(DISTINCT i.num) nbIdIsbnDist
			, GROUP_CONCAT(DISTINCT(i.num)) isbns
            , vDir.nb_vente vDirnb_vente, vDir.mt_l vDirmt_l
            , vAut.nb_vente vAutnb_vente, vAut.mt_l vAutmt_l
            , vCoor.nb_vente vCoornb_vente, vCoor.mt_l vCoormt_l
            , MIN(v.date_vente) date_first, MAX(v.date_vente) date_last			
			, GROUP_CONCAT(DISTINCT(b.nom)) boutiques
			, rTot.montant_livre mt_rTot
			, rDue.montant_livre mt_rDue
			, rPaie.montant_livre mt_rPaie
			FROM iste_auteur a 
				INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
				INNER JOIN iste_livre l ON l.id_livre = la.id_livre
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
                INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
                INNER JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				LEFT JOIN (SELECT
					 la.id_auteur
					, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
					FROM iste_vente v
					INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
					INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.role = "directeur"
					GROUP BY la.id_auteur) vDir ON vDir.id_auteur = la.id_auteur
				LEFT JOIN (SELECT
					 la.id_auteur
					, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
					FROM iste_vente v
					INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
					INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.role = "coordinateur"
					GROUP BY la.id_auteur) vCoor ON vDir.id_auteur = la.id_auteur
				LEFT JOIN (SELECT
					 la.id_auteur
					, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
					FROM iste_vente v
					INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
					INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.role = "auteur"
					GROUP BY la.id_auteur) vAut ON vAut.id_auteur = la.id_auteur
				LEFT JOIN (SELECT  SUM(r.montant_livre) montant_livre, ac.id_auteur 
					FROM iste_auteurxcontrat ac 
					INNER JOIN iste_royalty r ON r.id_auteurxcontrat = ac.id_auteurxcontrat
                    GROUP BY ac.id_auteur) rTot ON rTot.id_auteur = la.id_auteur
				LEFT JOIN (SELECT  SUM(r.montant_livre) montant_livre, ac.id_auteur 
					FROM iste_auteurxcontrat ac 
					INNER JOIN iste_royalty r ON r.id_auteurxcontrat = ac.id_auteurxcontrat AND date_paiement = '0000-00-00'	
                    GROUP BY ac.id_auteur) rDue ON rDue.id_auteur = la.id_auteur
				LEFT JOIN (SELECT  SUM(r.montant_livre) montant_livre, ac.id_auteur 
					FROM iste_auteurxcontrat ac 
					INNER JOIN iste_royalty r ON r.id_auteurxcontrat = ac.id_auteurxcontrat AND date_paiement != '0000-00-00'	
                    GROUP BY ac.id_auteur) rPaie ON rPaie.id_auteur = la.id_auteur			
			WHERE vDir.nb_vente IS NOT NULL OR vAut.nb_vente IS NOT NULL OR vCoor.nb_vente IS NOT NULL
            GROUP BY a.id_auteur
            