<?php

error_reporting(E_ALL);
$solrServer = 'http://192.168.205.10:8983/solr/npf/select?indent=on&wt=json';
$q = $_POST['q'];
$category = $_POST['category'];
if ($category != 'all') {
    $q = '+category:' . $category. ' ' . $q;
}
$url = $solrServer . '&q=' . urlencode($q);
$response = file_get_contents($url);
echo $response;
exit;