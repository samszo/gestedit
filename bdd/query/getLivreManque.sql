SELECT 
--	COUNT(DISTINCT l.id_livre) 
	 COUNT(DISTINCT p.id_livre) 
	, COUNT(DISTINCT pl1.id_livre) 
	, COUNT(DISTINCT pl3.id_livre) 
	, COUNT(DISTINCT pl4.id_livre) 
    
--    , COUNT(DISTINCT pcs.id_livre) 
-- l.id_livre
-- , p.id_livre pid
-- , pl1.id_livre pl1id
-- , pl3.id_livre pl3id
-- , pl4.id_livre pl4id
	FROM iste_livre l
/*
    INNER JOIN iste_livre lp ON lp.id_livre = l.id_livre
    INNER JOIN iste_livre l1 ON l1.id_livre = l.id_livre
    INNER JOIN iste_livre l3 ON l3.id_livre = l.id_livre
    INNER JOIN iste_livre l4 ON l4.id_livre = l.id_livre
*/
	LEFT JOIN iste_proposition p ON p.id_livre = l.id_livre
    LEFT JOIN iste_processusxlivre pl1 ON pl1.id_livre = l.id_livre AND pl1.id_processus = 1
    LEFT JOIN iste_processusxlivre pl3 ON pl3.id_livre = l.id_livre AND pl3.id_processus = 3
    LEFT JOIN iste_processusxlivre pl4 ON pl4.id_livre = l.id_livre AND pl4.id_processus = 4
-- GROUP BY l.id_livre
WHERE
	p.id_livre IS NULL  
    OR pl1.id_livre IS NULL
    OR pl3.id_livre IS NULL
    OR pl4.id_livre IS NULL
