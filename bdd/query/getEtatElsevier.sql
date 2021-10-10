SELECT 
	i.num 'ISBN'
	, GROUP_CONCAT(DISTINCT IFNULL(a.prenom,'') , ' ', IFNULL(a.nom,'') SEPARATOR ', ') 'AUTHOR(s)'
	, l.titre_en 'TITLE', l.soustitre_en 'SUBTITLE', l.type_2 'TYPE 2', l.type_1 'TYPE 1'
	, s.titre_en 'Set Title'
	, c.titre_en 'Catalog Section'
	, MAX(pa.nombre) 'ISTE Pages (projected)'
	, pm.prevision 'ISTE MS due date'
	, 0 'ISTE MS in production'
	, pp.prevision 'ISTE MS pud date'
	, pr.prix_dollar 'ISTE Proposed Price (USD)'
FROM iste_livre l
	INNER JOIN iste_isbn i ON i.id_livre = l.id_livre AND i.id_editeur = 4
	INNER JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
	INNER JOIN iste_serie s ON s.id_serie = ls.id_serie
    INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
    INNER JOIN iste_comite c ON c.id_comite = cl.id_comite
	INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
	INNER JOIN iste_livrexauteur la ON la.id_livre = ls.id_livre AND la.role = 'auteur'
    INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
    INNER JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
    LEFT JOIN iste_prevision pp ON pp.id_pxu = pl.id_plu AND pp.id_tache = 17
    LEFT JOIN iste_prevision pm ON pm.id_pxu = pl.id_plu AND pm.id_tache = 15
    LEFT JOIN iste_prix pr ON pr.id_isbn = i.id_isbn AND pr.type = 'prix catalogue'
    LEFT JOIN iste_page pa ON pa.id_livre = l.id_livre AND (pa.type = 'prévu GB' OR pa.type = 'pr&#233;vu')
    
GROUP BY i.id_isbn
ORDER BY i.num
