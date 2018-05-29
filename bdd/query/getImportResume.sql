SELECT 
    COUNT(DISTINCT d.id_isbn) nbIsbn,
    COUNT(DISTINCT la.id_auteur) nbAuteur,
    COUNT(DISTINCT d.id_livre) nbLivre,
    COUNT(DISTINCT v.id_vente) nbVente,
    SUM(d.col3) qtyPaper,
    SUM(d.col4) sumPaper,
    SUM(d.col5) sumEbook
FROM
    iste_importdata d
        INNER JOIN
    iste_importfic f ON f.id_importfic = d.id_importfic
        INNER JOIN
    iste_vente v ON v.id_importdata = d.id_importdata
        INNER JOIN
    iste_livrexauteur la ON la.id_livre = d.id_livre
WHERE
    d.id_importfic = 4065
            