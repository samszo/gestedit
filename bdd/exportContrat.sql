SELECT 
    a.id_auteur,
    a.prenom,
    a.nom,
    la.role,
    c.nom,
    '' creer1_2_3,
    ac.date_signature,
    '' c_date,
    ac.pc_ebook,
    '' c_ebook,
    ac.pc_papier,
    '' c_papier,
    p.base_contrat,
    '' basecontrat,
    l.id_livre,
    l.titre_en,
    l.titre_fr,
    s.id_serie,
    CONCAT(s.titre_en, ' / ', s.titre_fr) serie,
    com.id_comite,
    CONCAT(com.titre_en, ' / ', com.titre_fr) comite,
    GROUP_CONCAT(DISTINCT i.id_isbn) idsIsbn,
    GROUP_CONCAT(DISTINCT i.num) nulmsIsbn
FROM
    iste_auteur a
        INNER JOIN
    iste_livrexauteur la ON la.id_auteur = a.id_auteur
        INNER JOIN
    iste_livre l ON l.id_livre = la.id_livre
        INNER JOIN
    iste_isbn i ON i.id_livre = l.id_livre
        INNER JOIN
    iste_proposition p ON p.id_livre = l.id_livre
        LEFT JOIN
    iste_auteurxcontrat ac ON ac.id_auteur = a.id_auteur
        LEFT JOIN
    iste_contrat c ON c.id_contrat = ac.id_contrat
        LEFT JOIN
    iste_livrexserie ls ON ls.id_livre = l.id_livre
        LEFT JOIN
    iste_serie s ON s.id_serie = ls.id_serie
        LEFT JOIN
    iste_comitexlivre cl ON cl.id_livre = l.id_livre
        LEFT JOIN
    iste_comite com ON com.id_comite = cl.id_comite
 GROUP BY la.id_livrexauteur
 order by la.id_auteur, la.id_livre, la.role