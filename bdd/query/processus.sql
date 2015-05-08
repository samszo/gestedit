SELECT 
	p.nom
	, pl.date_creation, pl.id_plu, pl.commentaire
	, u.login, u.id_uti
    , t.nom tache, t.ordre
    , pre.id_prevision recid, pre.debut, pre.prevision, pre.fin, pre.commentaire, pre.alerte
FROM iste_processus p
	INNER JOIN iste_processusxlivre pl ON pl.id_processus = p.id_processus
	INNER JOIN iste_prevision pre ON pre.id_pxu = pl.id_plu AND pre.obj = 'livre'     
	INNER JOIN iste_tache t ON t.id_tache = pre.id_tache 
	INNER JOIN iste_uti u ON u.id_uti = pl.id_uti
WHERE pl.id_livre = 1
ORDER BY t.ordre
-- GROUP BY p.id_processus
