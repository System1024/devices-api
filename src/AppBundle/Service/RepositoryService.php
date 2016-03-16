<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 16.03.2016
 * Time: 8:04
 */

namespace AppBundle\Service;

class RepositoryService
{
    protected $repository;

    function __construct($repository)
    {
        if (empty($repository)) {
            throw new RepositoryServiceException('Empty name of repository');
        }

        $this->repository = $repository;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    function __call($name, $arguments)
    {
        return $this->repository->$name(...$arguments);
    }
}
