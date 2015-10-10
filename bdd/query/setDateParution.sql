update iste_isbn tab1 join (
SELECT i.id_isbn, i.date_parution
, p.fin, p.id_prevision
FROM iste_isbn i
INNER JOIN iste_processusxlivre pl ON pl.id_livre = i.id_livre
INNER JOIN iste_prevision p ON p.id_pxu = pl.id_plu AND p.id_prevision = 536
WHERE i.date_parution is null AND p.fin is not null
) tab2 on tab1.id_isbn = tab2.id_isbn set tab1.date_parution = tab2.fin