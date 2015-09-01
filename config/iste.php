<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
define('_MYSQL_SET_SQL_MODE',true);
spip_connect_db('localhost','','root','','iste','mysql', '');
mysql_query("SET NAMES 'utf8'");
?>