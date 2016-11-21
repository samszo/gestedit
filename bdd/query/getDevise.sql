SELECT
    DATE_FORMAT(date_vente, '%d-%m-%y') DebMoisAn
    ,d.date_taux
    /*
	DATE_FORMAT(NOW(), '%c'),
    DATE_ADD(NOW(), INTERVAL 1 MONTH) dN,
    DATEDIFF(MIN(v.date_vente), MAX(v.date_vente)) nb,
    MIN(v.date_vente) dMin,
    MAX(v.date_vente) dMax,
    EXTRACT(YEAR FROM MIN(v.date_vente)) yMin,
    EXTRACT(YEAR FROM MAX(v.date_vente)) yMax
    */
FROM
    iste_vente v
LEFT JOIN iste_devises d ON d.date_taux = DATE_FORMAT(date_vente, '01-%m-%y')
GROUP BY DebMoisAn
ORDER BY DebMoisAn
-- WHERE n < 100