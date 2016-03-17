<?php

namespace AppBundle\Service;

/**
 * RepositoryService interprets DoctrineRepository as service
 *
 * @package AppBundle\Service
 */
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
