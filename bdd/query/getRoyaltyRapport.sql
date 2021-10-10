SELECT r.*
, a.prenom, a.nom, a.id_auteur
, l.titre_en, l.titre_fr, l.id_livre
FROM iste_rapport r
INNER JOIN iste_auteur a ON a.id_auteur =  SUBSTRING_INDEX(r.obj_id,"_",1)
INNER JOIN iste_livre l ON l.id_livre =  SUBSTRING_INDEX(r.obj_id,"_",-1)