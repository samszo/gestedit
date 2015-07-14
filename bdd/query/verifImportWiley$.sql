select count(id_importdata) nb, col1
from iste_importdata
group by col1
order by nb desc