SELECT 
		ac.id_auteurxcontrat
		, ac.id_isbn, ac.pc_papier, ac.pc_ebook
        , a.prenom, a.nom, la.role, c.type
		 ,i.num
         , v.id_vente, v.date_vente, v.montant_livre, v.id_boutique
		 , i.id_editeur, i.type
         , d.base_contrat, d.id_devise, d.taux_livre_dollar, d.taux_livre_euro, d.date_taux, d.date_taux_fin, d.taxe_taux, d.taxe_deduction
         , la.role
         , c.type
         , l.titre
		FROM iste_auteurxcontrat ac
		 INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur AND a.id_auteur = 1
		 INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
		 INNER JOIN iste_livre l ON l.id_livre = ac.id_livre
		 INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
		 INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
		 INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
		 INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.id_auteur = ac.id_auteur -- AND la.role = c.type
		 INNER JOIN iste_devise d ON d.base_contrat = IFNULL(p.base_contrat,'GB')
				    AND DATE_FORMAT(date_vente, '%Y') = DATE_FORMAT(date_taux, '%Y')
		 LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente AND r.id_auteurxcontrat = ac.id_auteurxcontrat
		WHERE pc_papier is not null AND pc_ebook is not null AND pc_papier != 0 AND pc_ebook != 0
			AND v.montant_livre > 0
--		    AND r.id_royalty is null