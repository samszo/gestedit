SELECT 
		ac.id_auteurxcontrat
		, ac.id_isbn, ac.pc_papier, ac.pc_ebook
        ,la.role, c.type
		 ,i.num
         , v.id_vente, v.date_vente, v.montant_livre, v.id_boutique
		 , i.id_editeur, i.type
         , d.id_devise, d.taux_livre_dollar, d.taux_livre_euro, d.date_taux, d.date_taux_fin
         
		FROM iste_royalty r
			INNER JOIN iste_auteurxcontrat ac ON r.id_auteurxcontrat = ac.id_auteurxcontrat
		 INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
		 INNER JOIN iste_vente v ON v.id_vente = r.id_vente
		 INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		 INNER JOIN iste_livre l ON l.id_livre = i.id_livre
		 INNER JOIN iste_editeur e ON e.id_editeur = i.id_editeur
		 INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.id_auteur = ac.id_auteur -- AND la.role = c.type
		 INNER JOIN iste_devise d ON d.id_devise = r.id_devise
	-- 	WHERE ac.id_auteur = 484