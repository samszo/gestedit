SELECT 
	i.id_isbn recid, i.date_parution, i.num isbn, i.nb_page 
	, l.titre_en, l.soustitre_en, l.type_2
	, GROUP_CONCAT(DISTINCT CONCAT(a.prenom, ' ', a.nom)) auteurs
    , p.traduction
    , GROUP_CONCAT(DISTINCT e.nom) editeur
FROM iste_livre l
	INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
	INNER JOIN iste_proposition p ON p.id_livre = l.id_livre     
	INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = 'auteur'
	INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur 
	INNER JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
GROUP BY i.id_livre;

