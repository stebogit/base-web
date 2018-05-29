<?php

namespace Src\Controllers;

use Psr\Container\ContainerInterface;


class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if (isset($this->container->{$property})) {
            return $this->container->{$property};
        }
    }
}