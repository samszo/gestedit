SELECT 
	p.nom
	, pc.date_creation
    , c.id_chapitre recid, CONCAT(c.num,' - ',c.titre_fr) content
	, u.login
    , pre1.id_prevision idPrev1, pre1.fin tache1
    , pre2.id_prevision idPrev2, pre2.fin tache2
    , pre3.id_prevision idPrev3, pre3.fin tache3
    , pre4.id_prevision idPrev4, pre4.fin tache4
    , pre5.id_prevision idPrev5, pre5.fin tache5
FROM iste_processus p
	INNER JOIN iste_processusxchapitre pc ON pc.id_processus = p.id_processus
	INNER JOIN iste_chapitre c ON c.id_chapitre = pc.id_chapitre 
	INNER JOIN iste_uti u ON u.id_uti = pc.id_uti
	INNER JOIN iste_prevision pre1 ON pre1.id_pxu = pc.id_pcu AND pre1.obj = 'chapitre' AND pre1.id_tache = 10     
	INNER JOIN iste_prevision pre2 ON pre2.id_pxu = pc.id_pcu AND pre2.obj = 'chapitre' AND pre2.id_tache = 11     
	INNER JOIN iste_prevision pre3 ON pre3.id_pxu = pc.id_pcu AND pre3.obj = 'chapitre' AND pre3.id_tache = 12     
	INNER JOIN iste_prevision pre4 ON pre4.id_pxu = pc.id_pcu AND pre4.obj = 'chapitre' AND pre4.id_tache = 13     
	INNER JOIN iste_prevision pre5 ON pre5.id_pxu = pc.id_pcu AND pre5.obj = 'chapitre' AND pre5.id_tache = 14         
WHERE c.id_livre = 2
GROUP BY c.id_chapitre
