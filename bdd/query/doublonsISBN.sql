SELECT 
			count(*) nb , num
			, GROUP_CONCAT(id_isbn ORDER BY id_isbn) ids, GROUP_CONCAT(ifnull(nb_page,0) ORDER BY id_isbn) nbPages
			, GROUP_CONCAT(id_editeur ORDER BY id_isbn) edit,  GROUP_CONCAT(i.id_livre ORDER BY id_isbn) idsLivre
			,  GROUP_CONCAT(ifnull(date_parution,0) ORDER BY id_isbn) dates
			,  GROUP_CONCAT(ifnull(titre_fr,0) ORDER BY id_isbn SEPARATOR '$') titresFR,  GROUP_CONCAT(ifnull(titre_en,0) ORDER BY id_isbn SEPARATOR '$') titresEN
			FROM iste_isbn i
			INNER JOIN iste_livre l ON l.id_livre = i.id_livre
			WHERE num is not null 
			GROUP BY num
			HAVING nb > 1
			ORDER BY nb DESC 	