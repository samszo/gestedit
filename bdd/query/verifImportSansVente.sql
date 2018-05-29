SELECT 
d.*, f.periode_debut, f.periode_fin 
FROM iste_importdata d
INNER JOIN iste_importfic f ON f.id_importfic = d.id_importfic
LEFT JOIN iste_vente v on v.id_importdata = d.id_importdata
WHERE d.id_importfic = 4065 AND v.id_importdata IS NULL
ORDER BY id_importdata;