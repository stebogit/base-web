<?php

// Routes
$app->get('/[{name}]', \Src\Controllers\Pages::class . ':home')->setName('home');
