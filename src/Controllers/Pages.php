<?php

namespace Src\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class Pages extends Controller
{

    public function home(Request $request, Response $response, array $args)
    {
        date_default_timezone_set('America/Los_Angeles');

        $data = [
            'today' => $request->getParam('today') ?? date('l'),
            'name' => $args['name'] ?? ''
        ];

        return $this->view->render($response, 'home.twig', $data);
    }

}