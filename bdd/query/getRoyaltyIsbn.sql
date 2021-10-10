SELECT 
	COUNT(DISTINCT r.id_royalty) nbRoy
    ,SUM(v.montant_livre) rMtVente, SUM(v.nombre) unit
    ,SUM(r.montant_livre) rMtRoy
	,MIN(r.taxe_taux) taux, MIN(r.taxe_deduction) deduction, MIN(r.pourcentage) pc
	,i.id_isbn, i.date_parution, i.type
FROM iste_royalty r 
	INNER JOIN iste_vente v ON v.id_vente = r.id_vente
	INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
WHERE r.id_royalty IN (1326, 1327)
GROUP BY i.id_isbn