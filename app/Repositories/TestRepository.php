<?php

namespace App\Repositories;

use App\Model\Test;

class TestRepository
{
    use BaseRepository;

    protected $model;

    /**
     * Constructor.
     *
     * @param Category $category
     */
    public function __construct(Test $model = null)
    {
        $this->model = $model ? $model : new Test();
    }
}