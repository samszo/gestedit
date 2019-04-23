SELECT 
    p.id_prospect, nom_prenom, pn.id_nomenclature, n.label
FROM
    iste_prospect p
        INNER JOIN
    iste_prospectxnomenclature pn ON pn.id_prospect = p.id_prospect
        INNER JOIN
    iste_nomenclature n ON n.id_nomenclature = pn.id_nomenclature
WHERE p.id_prospect = 7

    
