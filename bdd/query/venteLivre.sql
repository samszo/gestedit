SELECT 	
l.id_livre recid, CONCAT(IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) titre
, ca.auteurs
, GROUP_CONCAT(DISTINCT(i.num)) isbns
, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d, GROUP_CONCAT(DISTINCT(v.boutique)) boutiques

FROM iste_livre l
INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
INNER JOIN (SELECT GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom))) auteurs, la.id_livre
FROM iste_auteur a 
INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
GROUP BY la.id_livre
) ca ON ca.id_livre = l.id_livre
GROUP BY i.id_isbn
