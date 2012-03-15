<?php
require_once('functions.php');
define('ROOT', dirname(__FILE__) . '/');
$query = isset($_GET['query']) ? htmlspecialchars($_GET['query'], ENT_QUOTES) : '';
?>
<meta charset="utf-8">
<form>
	<input type="text" name="query" value="<?=$query?>">
	<input type="submit">
</form>
<?php
if ($query) {
	$googleResults = getJSON(getResults($query, 50), $query);
	file_put_contents('/Users/lukashavrlant/WebSites/chandler/cache/__temp/'.$query.'.txt', $googleResults);
	// $googleResults = file_get_contents('/Users/lukashavrlant/WebSites/chandler/cache/__temp/fe82d11f002af646e3dc0938ccdf750e.txt');
	$fcaResults = sendPOST('http://localhost/chandler/api.php', array('data' => $googleResults));
	$json = json_decode($fcaResults);
	if ($json) {
		$sugg = $json->fca;

		$specialization = array();
		foreach ($sugg->spec as $spec) {
			$specialization[] = '+'.$spec->words[0];
		}

		echo implode(", ", $specialization);

		var_dump($sugg);
	}
	
}