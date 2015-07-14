
SELECT count(*) nb, nom, 
GROUP_CONCAT(prenom)
FROM `iste_auteur` 
group by nom
order by nb desc
--
/*
SELECT count(*) nb, titre_en
FROM `iste_comite` 
group by titre_en
order by nb desc
*/
/*
SELECT count(*) nb, titre_en, titre_fr
FROM `iste_serie` 
group by titre_en, titre_fr
order by nb desc
*/
/*
SELECT count(*) nb, titre_en, titre_fr
	, group_concat(concat(a.nom,' ',a.prenom))
FROM iste_collection c
INNER JOIN iste_coordination coor ON coor.id_collection = c.id_collection  
INNER JOIN iste_auteur a ON a.id_auteur = coor.id_auteur  
group by titre_en, titre_fr
order by nb desc
*/
