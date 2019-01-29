<?php
require_once '../vendor/autoload.php';

use KielD01\InstaTag\Search;

$posts = Search::byHashTag('challenge');
dd($posts);