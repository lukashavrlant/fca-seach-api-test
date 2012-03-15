<?php
require_once('functions.php');
define('ROOT', dirname(__FILE__) . '/');
?>
<meta charset="utf-8">
<?php
echo getJSON(getResults('paris hilton'));