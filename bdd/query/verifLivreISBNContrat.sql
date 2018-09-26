SELECT 
    l.id_livre,
    l.titre_en,
    l.titre_fr,
    COUNT(DISTINCT i.id_isbn) nbIsbn_EB_FR,
    COUNT(DISTINCT ii.id_isbn) nbIsbn_P_EN,
    COUNT(DISTINCT iii.id_isbn) nbIsbn_P_FR,
    COUNT(DISTINCT ac.id_isbn)-COUNT(DISTINCT acVide.id_isbn) nbIsbn_contrat,
    COUNT(DISTINCT la.id_auteur) nbAuteur_livre,
    GROUP_CONCAT(DISTINCT la.id_auteur) Auteurs_livre,
    COUNT(DISTINCT ac.id_auteur) nbAuteur_contrat,
    GROUP_CONCAT(DISTINCT ac.id_auteur) Auteurs_contrat,
    GROUP_CONCAT(DISTINCT ac.id_contrat) type_contrat
FROM
    iste_livre l
        INNER JOIN
    iste_livrexauteur la ON la.id_livre = l.id_livre
        LEFT JOIN
    iste_isbn i ON i.id_livre = l.id_livre
        AND i.type = 'E-Book FR'
        LEFT JOIN
    iste_isbn ii ON ii.id_livre = l.id_livre
        AND ii.type = 'Hardback EN'
        LEFT JOIN
    iste_isbn iii ON iii.id_livre = l.id_livre
        AND iii.type = 'Papier FR'
        LEFT JOIN
    iste_auteurxcontrat ac ON ac.id_livre = l.id_livre
        LEFT JOIN
    iste_auteurxcontrat acVide ON acVide.id_livre = l.id_livre AND (acVide.id_isbn IS NULL or acVide.id_isbn =0)
GROUP BY l.id_livre
-- HAVING nbAuteur_contrat = 0
ORDER BY l.titre_en , l.titre_fr