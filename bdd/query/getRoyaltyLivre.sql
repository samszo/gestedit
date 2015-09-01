SELECT 
			GROUP_CONCAT(DISTINCT r.id_royalty) idsRoyalty
		    , SUM(v.nombre) vNb, SUM(v.montant_livre) vMtLivre, MIN(v.date_vente) minDateVente, MAX(v.date_vente) maxDateVente
		    , a.id_auteur, a.nom autNom, a.prenom, a.adresse_1, a.adresse_2, a.civilite, a.code_postal, a.ville, a.pays
		    , ac.pc_papier, ac.pc_ebook
		    , c.nom contNom
            , MIN(i.date_parution) parution
		    , l.id_livre, l.titre_en, l.titre_fr
		FROM iste_royalty r 
			INNER JOIN iste_vente v ON v.id_vente = r.id_vente
		    INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		    INNER JOIN iste_livre l ON l.id_livre = i.id_livre AND i.id_livre IN (798)
		    INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat
		    INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
		    INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = c.type
		    INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur
		WHERE r.date_paiement IS NULL
		GROUP BY ac.id_auteur, l.id_livre