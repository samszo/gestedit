SELECT pre.id_prevision recid
, pre.commentaire, pre.obj
, DATEDIFF(pre.alerte, pre.prevision) nbJour
, pro.nom processus, t.nom tache
, l.id_livre, CONCAT(l.titre_fr, ' / ', l.titre_en) titre
, 'background-color: #C2F5B4' as 'style' 
-- , if(DATEDIFF(pre.prevision, pre.alerte)>10) 'OUI'
FROM iste_prevision pre
INNER JOIN iste_tache t ON t.id_tache = pre.id_tache
INNER JOIN iste_processus pro ON pro.id_processus = t.id_processus
INNER JOIN iste_processusxlivre pl ON pl.id_plu = pre.id_pxu
INNER JOIN iste_livre l ON l.id_livre = pl.id_livre
WHERE pre.alerte is not null AND pre.fin is null AND pre.obj = "livre"
ORDER BY nbJour