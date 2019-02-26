SELECT 
    ac.type_isbn,
    i.type,
    ac.id_contrat,
    ic.id_isbn idIC,
    ac.id_isbn,
    ac.id_auteurxcontrat
FROM
    iste_auteurxcontrat ac
        INNER JOIN
    iste_isbn i ON i.id_isbn = ac.id_isbn
        INNER JOIN
    iste_isbn ic ON ic.id_livre = ac.id_livre
        AND ic.type = ac.type_isbn
WHERE
    ac.type_isbn <> i.type