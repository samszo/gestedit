SELECT 
		GROUP_CONCAT(DISTINCT a.prenom, ' ',a.nom, ':', la.role) auteurs
		,l.titre_en 
		,l.titre_fr 
		,pGB.nombre 'Nbre Pages prévision GB'
		,pFR.nombre 'Nbre Pages prévision FR'
        , ELT(FIND_IN_SET(p.langue,'Français,Anglais'), 'FR', 'GB') 'Langue du manuscrit'
        ,p.publication_en 'Publication prévue GB'
        ,p.publication_fr 'Publication prévue FR'
        , FIELD(p.traduction,'français -> anglais') 'traduction'
		, pre1.prevision 'Date de remise prévue du manuscrit'
		, pre1.fin 'Date de réception du manuscrit'
		, pre2.fin 'Date de réception de la traduction'
		, pre3.fin 'Date de publication GB'
		, pre4.fin 'Date de publication FR'
		, FIND_IN_SET(e.nom,'Wiley,Elsevier') editeur
		FROM iste_livre l
		INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
		INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
		INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
		INNER JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
        INNER JOIN iste_prevision pre1 ON pre1.id_pxu = pl.id_plu AND pre1.id_tache = 15
        INNER JOIN iste_prevision pre2 ON pre2.id_pxu = pl.id_plu AND pre2.id_tache = 16
        INNER JOIN iste_prevision pre3 ON pre3.id_pxu = pl.id_plu AND pre3.id_tache = 17
        INNER JOIN iste_prevision pre4 ON pre4.id_pxu = pl.id_plu AND pre4.id_tache = 18
		INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
		LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur
        LEFT JOIN iste_page pGB ON pGB.id_livre = l.id_livre AND
			pGB.maj = (SELECT MAX(pGBm.maj) FROM iste_page pGBm WHERE pGBm.id_livre = pGB.id_livre AND pGBm.type = 'prévu GB')
        LEFT JOIN iste_page pFR ON pFR.id_livre = l.id_livre AND
			pFR.maj = (SELECT MAX(pFRm.maj) FROM iste_page pFRm WHERE pFRm.id_livre = pFR.id_livre AND pFRm.type = 'prévu FR')

GROUP BY l.id_livre
