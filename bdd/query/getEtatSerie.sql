SELECT s.id_serie, s.titre_fr serie_titre_fr, s.titre_en serie_titre_en
, GROUP_CONCAT(DISTINCT IFNULL(ac.prenom,'') , ' ', IFNULL(ac.nom,'') SEPARATOR ', ') coordinateur
, l.titre_en, l.titre_fr
, GROUP_CONCAT(DISTINCT IFNULL(a.prenom,'') , ' ', IFNULL(a.nom,'') SEPARATOR ', ') auteurs
, pp.fin pFin, pp.prevision pPrev, pp.commentaire pCom
, pc.fin cFin, pc.prevision cPrev, pc.commentaire cCom
, pm.fin mFin, pm.prevision mPrev, pm.commentaire mCom
, p.commentaire
FROM iste_serie s
	INNER JOIN iste_coordination c ON c.id_serie = s.id_serie
	INNER JOIN iste_auteur ac ON ac.id_auteur = c.id_auteur
	INNER JOIN iste_livrexserie ls ON ls.id_serie = s.id_serie
	INNER JOIN iste_livre l ON l.id_livre = ls.id_livre
	INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
	INNER JOIN iste_livrexauteur la ON la.id_livre = ls.id_livre AND la.role = 'auteur'
    INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
    INNER JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
    INNER JOIN iste_prevision pp ON pp.id_pxu = pl.id_plu AND pp.id_tache = 25
    INNER JOIN iste_prevision pc ON pc.id_pxu = pl.id_plu AND pc.id_tache = 37
    INNER JOIN iste_prevision pm ON pm.id_pxu = pl.id_plu AND pm.id_tache = 15
WHERE s.id_serie IN (90,92)
GROUP BY l.id_livre
ORDER BY s.id_serie
