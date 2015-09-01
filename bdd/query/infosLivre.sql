SELECT 
l.* 
, GROUP_CONCAT(DISTINCT a.prenom, ' ',a.nom, ':', la.role) auteurs
, GROUP_CONCAT(i.id_isbn, ',', i.num, ',', i.type, ',', i.date_parution, ',', i.nb_page SEPARATOR ':') isbns
, GROUP_CONCAT(e.nom) editeur
, GROUP_CONCAT(p.prix_dollar, ',', p.prix_euro, ',', p.prix_livre SEPARATOR ':') prix
, GROUP_CONCAT(DISTINCT s.id_serie, ',', s.titre_fr, ',', s.titre_en SEPARATOR ':') series
, GROUP_CONCAT(DISTINCT c.id_comite, ',', c.titre_fr, ',', c.titre_en SEPARATOR ':') comites
, GROUP_CONCAT(DISTINCT fic.id_importfic, ',', fic.type, ',', fic.url SEPARATOR ':') fics
FROM iste_livre l
INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
LEFT JOIN iste_isbn i ON i.id_livre = l.id_livre
LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur
LEFT JOIN iste_prix p ON p.id_isbn = i.id_isbn AND p.type = 'prix catalogue'
LEFT JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
LEFT JOIN iste_serie s ON s.id_serie = ls.id_serie
LEFT JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
LEFT JOIN iste_comite c ON c.id_comite = cl.id_comite
LEFT JOIN iste_importfic fic ON fic.obj = 'livre' AND fic.id_obj = l.id_livre 
-- WHERE l.id_livre = 3
