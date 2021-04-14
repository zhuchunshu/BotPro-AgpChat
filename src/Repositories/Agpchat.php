<?php

namespace App\Plugins\agpchat\src\Repositories;

use App\Plugins\agpchat\src\Models\Agpchat as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Agpchat extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
