<?php

namespace App\Services;


abstract class AbstractService
{
    /**
     * Define relation allow to use
     *
     * @var array
     */
    protected $allowedRelation = [];

    /**
     * Define relation allow to use with count
     *
     * @var array
     */
    protected $allowedWithCountRelation = [];
}
