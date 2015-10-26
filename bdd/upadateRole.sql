update`iste_livrexauteur` set role='Resp. série' WHERE role = 'coordinateur';
UPDATE iste_livrexauteur la
INNER JOIN iste_livre l ON la.id_livre = l.id_livre AND la.role = 'auteur' AND l.type_1 = 'Coord.'
SET la.role = 'coordonnateur';