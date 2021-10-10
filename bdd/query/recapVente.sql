SELECT l.id_livre, l.titre_en, l.titre_fr
	,n.num 'num N', p.num 'num P', ln.num 'num LN', t.num 'num T'
    ,n.m N, n.n 'nb N' 
	,p.m P, p.n 'nb P'
	,ln.m 'LN', ln.n 'nb LN'
	,t.m 'T', t.n 'nb T'
	, GROUP_CONCAT(DISTINCT CONCAT(a.prenom,' ', a.nom,' (',au.role,')')) auteurs
    
FROM iste_livre l 
 	INNER JOIN iste_livrexauteur au ON au.id_livre = l.id_livre
 	INNER JOIN iste_auteur a ON a.id_auteur = au.id_auteur

LEFT JOIN (
	SELECT count(*) nb
		, i.id_isbn, i.num
		, SUM(v.montant_livre) m, SUM(v.nombre) n
		, i.id_livre
	FROM iste_isbn i
		INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn AND v.type = 'N'
	GROUP BY i.id_isbn) n ON n.id_livre = l.id_livre
LEFT JOIN (
	SELECT count(*) nb
		, i.id_isbn, i.num
		, SUM(v.montant_livre) m, SUM(v.nombre) n
		, i.id_livre
	FROM iste_isbn i
		INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn AND v.type = 'P'
	GROUP BY i.id_isbn) p ON p.id_livre = l.id_livre
LEFT JOIN (
	SELECT count(*) nb
		, i.id_isbn, i.num
		, SUM(v.montant_livre) m, SUM(v.nombre) n
		, i.id_livre
	FROM iste_isbn i
		INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn AND v.type = 'Licence num'
	GROUP BY i.id_isbn) ln ON ln.id_livre = l.id_livre
LEFT JOIN (
	SELECT count(*) nb
		, i.id_isbn, i.num
		, SUM(v.montant_livre) m, SUM(v.nombre) n
		, i.id_livre
	FROM iste_isbn i
		INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn AND v.type = 'Traduction Chinois'
	GROUP BY i.id_isbn) t ON t.id_livre = l.id_livre
WHERE n.m IS NOT NULL OR p.m IS NOT NULL OR ln.m IS NOT NULL OR t.m IS NOT NULL  
GROUP BY l.id_livre
ORDER BY l.id_livre
    