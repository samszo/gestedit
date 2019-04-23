SELECT 
    COUNT(DISTINCT p.id_prospect) nbPros,
    COUNT(DISTINCT n.id_nomenclature) nbNomen,
    e.id_etab,
    e.affiliation1,
    e.affiliation2,
    e.affiliation3
FROM
    iste_prospect p
        INNER JOIN
    iste_prospectxnomenclature pn ON pn.id_prospect = p.id_prospect
        INNER JOIN
    iste_nomenclature n ON n.id_nomenclature = pn.id_nomenclature
        INNER JOIN
    iste_prospectxetab pe ON pe.id_prospect = p.id_prospect
        INNER JOIN
    iste_etab e ON e.id_etab = pe.id_etab
GROUP BY e.id_etab
