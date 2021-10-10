update iste_royalty r
inner join iste_vente v on
    r.id_vente = v.id_vente
inner join iste_devise d on
    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
set
    r.id_devise = d.id_devise
    , r.montant_euro = d.taux_dollar_euro * r.montant_dollar 
    , r.montant_livre = d.taux_dollar_livre * r.montant_dollar 
where r.montant_euro is null AND r.montant_livre is null;

/*update iste_vente v
inner join iste_devise d on
    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
set
    v.id_devise = d.id_devise
    , v.montant_euro = d.taux_dollar_euro * v.montant_dollar 
    , v.montant_livre = d.taux_dollar_livre * v.montant_dollar 
where v.montant_euro is null AND v.montant_livre is null;
*/
/*
SELECT
     v.id_vente, v.date_vente
    , v.montant_euro, v.montant_livre, v.montant_dollar
    , d.id_devise, d.taux_dollar_livre, d.taux_dollar_euro    
FROM
    iste_vente v
INNER JOIN iste_devise d ON DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
WHERE v.montant_euro is null AND v.montant_livre is null
*/