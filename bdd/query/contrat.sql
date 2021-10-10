SELECT 
	id_auteurxcontrat recid, date_signature, pc_papier, pc_ebook, ac.commentaire
	, a.id_auteur, a.prenom, a.nom
	, c.id_contrat, c.nom cnom, c.type ctype, c.url curl
	, l.id_livre, l.titre_en, l.titre_fr, l.type_1, l.type_2
	, i.id_isbn, i.date_parution, i.num isbn 
	, isbn_auteur
    , col.id_collection, col.titre_en col_en, col.titre_fr col_en
	, s.id_serie, s.titre_en serie_en, s.titre_fr serie_en
FROM iste_auteurxcontrat ac
	INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
	INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur 
    INNER JOIN iste_livre l ON l.id_livre = ac.id_livre
	INNER JOIN iste_isbn i ON i.id_isbn = ac.id_isbn 
	LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
	LEFT JOIN iste_collection col ON col.id_collection = ac.id_collection 
	LEFT JOIN iste_serie s ON s.id_serie = ac.id_serie
 GROUP BY id_auteurxcontrat

