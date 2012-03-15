<?php
function getResults($query, $limit = 5, $restrictions = '') {
    $searchquery = "select * from google.search(0,".$limit.") where q='" . urlencode($query) . " " . urlencode($restrictions) ."'";
    $link = 'http://query.yahooapis.com/v1/public/yql?format=xml&env=http%3A%2F%2Fdatatables.org%2Falltables.env&q=' . $searchquery;
    $link = str_replace(' ', '%20', $link);

    return downloadResults($link);
}

function downloadResults($url) {
    $session = curl_init($url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($session);
}

function getJSON($text) {
    $xml = simplexml_load_string($text);
    $documents = array();

    foreach ($xml->results->results as $page) {
        $content = (string)strip_tags($page->content);
        $documents[] = array(
            'title' => (string)$page->titleNoFormatting,
            'url' => (string)$page->url,
            'type' => 'txt',
            'content' => $content,
            'description' => $content
            );
    }

    $data = array();
    $data['data'] = $documents;
    $data['options'] = array(
        'lang' => 'en'
        );

    return json_encode($data);
}