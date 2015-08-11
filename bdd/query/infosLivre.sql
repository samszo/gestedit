SELECT 
l.* 
, GROUP_CONCAT(DISTINCT a.prenom, ' ',a.nom, ':', la.role) auteurs
, GROUP_CONCAT(i.id_isbn, ',', i.num, ',', i.type, ',', i.date_parution SEPARATOR ':') isbns
, GROUP_CONCAT(e.nom) editeur
, GROUP_CONCAT(p.prix_dollar, ',', p.prix_euro, ',', p.prix_livre SEPARATOR ':') prix
 , GROUP_CONCAT(DISTINCT ls.id_serie) idsSerie
 , GROUP_CONCAT(DISTINCT cl.id_comite) idsComite
FROM iste_livre l
INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
INNER JOIN iste_editeur e ON e.id_editeur = i.id_editeur
INNER JOIN iste_prix p ON p.id_isbn = i.id_isbn AND p.type = "prix catalogue"
INNER JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
WHERE l.id_livre = 59
