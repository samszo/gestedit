SELECT 
	 l.id_livre
--	 ,count(p.id_proposition) nbProp
	 ,count(pl.id_plu) nbPlu, group_concat(pl.id_processus)
	FROM iste_livre l
--		INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
		INNER JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre
	GROUP BY l.id_livre
    HAVING nbPlu > 3
	ORDER BY nbPlu
        
        
        