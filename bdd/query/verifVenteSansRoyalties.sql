SELECT 
v.*, f.periode_debut, f.periode_fin 
FROM iste_importdata d
INNER JOIN iste_importfic f ON f.id_importfic = d.id_importfic
INNER JOIN iste_vente v on v.id_importdata = d.id_importdata
LEFT JOIN iste_royalty r on r.id_vente = v.id_vente
WHERE d.id_importfic = 4065 AND r.id_vente IS NULL
ORDER BY id_importdata;