INSERT INTO iste_prevision (id_tache, id_pxu, obj)
SELECT t.id_tache, pl.id_plu, 'livre'
FROM iste_tache t
INNER JOIN iste_processusxlivre pl ON pl.id_processus = t.id_processus
LEFT JOIN iste_prevision p ON p.id_tache = t.id_tache AND p.id_pxu = pl.id_plu AND p.obj = 'livre' 
WHERE t.id_tache = 29 AND p.id_prevision IS NULL