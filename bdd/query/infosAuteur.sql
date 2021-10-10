SELECT a.id_auteur
, c.id_comite, c.titre_en caen, c.titre_fr cafr
FROM iste_auteur a
LEFT JOIN iste_comitexauteur ca ON ca.id_auteur = a.id_auteur
LEFT JOIN iste_comite c ON c.id_comite = ca.id_comite
LEFT JOIN iste_coordination co ON co.id_auteur = a.id_auteur 
LEFT JOIN iste_serie s ON s.idiid
GROUP BY a.id_auteur



