SELECT DISTINCT
    i.num,
    a.id_auteur,
    a.nom,
    a.prenom,
    l.id_livre,
    l.titre_en,
    l.titre_fr
FROM
    iste_importdata d
        INNER JOIN
    iste_importfic f ON f.id_importfic = d.id_importfic
        INNER JOIN
    iste_vente v ON v.id_importdata = d.id_importdata
        INNER JOIN
    iste_isbn i ON i.id_isbn = v.id_isbn
        INNER JOIN
    iste_livrexauteur la ON la.id_livre = i.id_livre
        INNER JOIN
    iste_auteur a ON a.id_auteur = la.id_auteur
        INNER JOIN
    iste_livre l ON l.id_livre = i.id_livre
        LEFT JOIN
    iste_auteurxcontrat ac ON ac.id_auteur = la.id_auteur
        AND ac.id_livre = la.id_livre
WHERE
    d.id_importfic = 4065
        AND ac.id_auteurxcontrat IS NULL
ORDER BY v.id_importdata;