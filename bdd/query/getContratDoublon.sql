SELECT 
			count(*) nb, 
            concat(l.id_livre, '-', a.id_auteur, '-', i.id_isbn, '-', c.type) clef
            , group_concat(ac.id_auteurxcontrat) idAuteurContrat, group_concat(ifnull(date_signature,'-')) dateSignature, group_concat(ifnull(pc_papier,'-')) pcPapier, group_concat(ifnull(pc_ebook,'-')) pcEbook
			, a.id_auteur, a.prenom, a.nom
			, c.id_contrat, c.nom cnom, c.type ctype, c.url curl
			, l.id_livre, l.titre_en, l.titre_fr, l.type_1, l.type_2
			, i.id_isbn, i.date_parution, i.num isbn 
			, isbn_auteur
		    , com.id_comite, com.titre_en com_en, com.titre_fr com_en
			, s.id_serie, s.titre_en serie_en, s.titre_fr serie_en
		FROM iste_auteurxcontrat ac
			INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
			INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur 
			INNER JOIN iste_isbn i ON i.id_isbn = ac.id_isbn
		    LEFT JOIN iste_livre l ON l.id_livre = ac.id_livre
			LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
			LEFT JOIN iste_comite com ON com.id_comite = ac.id_comite 
			LEFT JOIN iste_serie s ON s.id_serie = ac.id_serie
WHERE ac.commentaire IS NULL
GROUP BY clef
HAVING nb > 0 AND clef IS NOT NULL
ORDER by l.id_livre, a.id_auteur, i.id_isbn, c.type
        