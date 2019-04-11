<?php

ini_set('display_errors', 1);
require_once dirname(__FILE__)."/vendor/autoload.php";

$client = new \GuzzleHttp\Client(['verify' => false]);
$tileServer = 'https://tile.opengeofiction.net';
$path = str_replace('png', 'ddm', $_SERVER['REQUEST_URI']);
$tileUri = $tileServer . $path;
header('X-tile: '. $tileUri);
$res = $client->get($tileUri);
$data = array_chunk(unpack("f*", $res->getBody()->read(4*33*33)), 33);

require_once "convert.php";

$convert = new \OGF\Convert();
$convert->process($data)->writeImage();
