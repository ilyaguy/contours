<?php

require_once "convert.php";

$convert = new \OGF\Convert();

$convert->process($convert->loadFile('7336.ddm'))->writeFile('7336.png');
