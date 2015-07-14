SELECT 
-- count(id_importdata) nb, 
d.*, f.periode_debut, f.periode_fin 
FROM iste.iste_importdata d
INNER JOIN iste.iste_importfic f ON f.id_importfic = d.id_importfic
WHERE d.id_importfic = 3 AND d.numsheet = 1 AND d.col1 != 'isbn introuvable'
-- AND col1 = "RETURNS"
-- GROUP BY d.col1 
-- GROUP BY d.col6 
-- ORDER BY nb DESC;
ORDER BY id_importdata;
;