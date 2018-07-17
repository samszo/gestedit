SELECT 
                count(ac.id_auteurxcontrat) nb
, la.role, c.type
                FROM iste_auteurxcontrat ac
                INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur
                LEFT JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
                INNER JOIN iste_livre l ON l.id_livre = ac.id_livre
                INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
                INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
                INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
                LEFT JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.id_auteur = ac.id_auteur AND la.role = c.type
                INNER JOIN iste_devise d ON d.base_contrat = IFNULL(p.base_contrat,'GB')
                            AND DATE_FORMAT(date_vente, '%Y') = DATE_FORMAT(date_taux, '%Y')
               
group by la.role, c.type