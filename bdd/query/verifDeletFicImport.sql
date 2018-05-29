SELECT 
    COUNT(*)
FROM
    iste_royalty r
        INNER JOIN
    iste_vente v ON v.id_vente = r.id_vente
        INNER JOIN
    iste_importdata d ON d.id_importdata = v.id_importdata
WHERE
    d.id_importfic = 4065
        AND r.date_envoi IS NOT NULL