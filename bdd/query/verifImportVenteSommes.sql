SELECT 
SUM(d.col3) nbVenteImp, SUM(d.col4) mtPapier, SUM(d.col5) mtEbook 
-- , v.type, SUM(v.nombre) nbVente, SUM(v.montant_livre) mtLivre 
FROM iste_importdata d
-- INNER JOIN iste_vente v on v.id_importdata = d.id_importdata
WHERE d.id_importfic = 4065 
-- group by  v.type