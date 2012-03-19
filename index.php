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
	$normQuery = normQuery($query);
	$googleResults = getJSON(getResults($query, 50), $query);

	if(isset($_GET['save'])) {
		file_put_contents(ROOT . 'saved/' . $normQuery . '.json', data);
	}

	// file_put_contents('/Users/lukashavrlant/WebSites/chandler/cache/__temp/'.$query.'.txt', $googleResults);
	// $googleResults = file_get_contents('/Users/lukashavrlant/WebSites/chandler/cache/__temp/45a7b39d640d33e057941ea41bebefe8.txt');
	// $fcaResults = sendPOST('http://localhost/chandler/api.php', array('data' => $googleResults));
	$fcaResults = sendPOST('http://phoebe.inf.upol.cz/~havrlanl/fca/api.php', array('data' => $googleResults));
	$json = json_decode($fcaResults);
	if ($json) {
		$sugg = $json->fca;

		$specialization = array();
		foreach ($sugg->spec as $spec) {
			$specialization[] = '+'.$spec->words[0];
		}

		$siblings = array();
		foreach ($sugg->sib as $sib) {
			$siblings[] = '∼'.implode(',', $sib->words);
		}

		echo implode(", ", $specialization);
		echo "<br><br>";
		echo implode(" | ", $siblings);
	}
	
}