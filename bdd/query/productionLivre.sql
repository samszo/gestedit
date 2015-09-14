SELECT 
			GROUP_CONCAT(i.id_isbn) idsIsbn, GROUP_CONCAT(i.date_parution) date_parution, GROUP_CONCAT(i.num) isbn, GROUP_CONCAT(i.nb_page) nb_page 
			, GROUP_CONCAT(DISTINCT CONCAT(a.prenom, ' ', a.nom)) auteurs
			, l.titre_fr, l.soustitre_fr, l.titre_en, l.soustitre_en, l.type_2, l.id_livre, l.id_livre recid
			, l.contexte_fr, l.contexte_en, l.bio_fr, l.bio_en, l.tdm_fr, l.tdm_en 
		    , p.traduction, p.langue
		    , GROUP_CONCAT(DISTINCT e.nom) editeur
		FROM iste_livre l
			INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = 'auteur'
			INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur 
			INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
			INNER JOIN iste_proposition p ON p.id_livre = l.id_livre     
			LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
		GROUP BY i.id_livre