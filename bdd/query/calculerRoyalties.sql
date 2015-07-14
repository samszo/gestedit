SELECT 
			GROUP_CONCAT(DISTINCT ac.id_auteur) idsA,
		    COUNT(DISTINCT ac.id_auteur) nbA,
		    ac.id_isbn, ac.pc_papier, ac.pc_ebook
		 , v.id_vente, v.date_vente, v.montant_euro, v.boutique
		 , i.id_editeur, i.type
		 , d.id_devise, d.taux_euro_dollar, d.taux_euro_livre
		FROM iste_auteurxcontrat ac
		 INNER JOIN iste_vente v ON v.id_isbn = ac.id_isbn
		 INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		 INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.id_auteur = ac.id_auteur AND la.role = 'auteur'
		 INNER JOIN iste_devise d on
				    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
		 LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente AND r.id_auteur = ac.id_auteur
		WHERE pc_papier is not null AND pc_ebook is not null AND pc_papier != 0 AND pc_ebook != 0
			AND v.montant_euro > 0
		    AND r.id_royalty is null
		GROUP BY v.id_vente