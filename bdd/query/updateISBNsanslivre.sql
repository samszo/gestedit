select 
-- count(distinct ir.id_livre) nb
 ir.id_livre idLivreRef, ir.num, ir.id_isbn idIsbnRef, im.id_livre idLivreVide, im.id_isbn idIsbnVide 
from iste_prod.iste_isbn ir, (
select i.num , i.id_livre, i.id_isbn
from iste.iste_isbn i
left join iste.iste_livre l on l.id_livre = i.id_livre
where l.id_livre is null) im
where im.num = ir.num
-- group by ir.num
order by ir.num, ir.id_livre