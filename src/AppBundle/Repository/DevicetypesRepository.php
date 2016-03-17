<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Devicetypes;
use Doctrine\ORM\EntityRepository;

/**
 * DevicetypesRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class DevicetypesRepository extends EntityRepository
{
    public function addDeviceType(Devicetypes $deviceTypes)
    {
        $double = $this->findOneByName($deviceTypes->getName());

        if ($double instanceof Devicetypes) {
            throw new \Exception('Device with such name already presents in DB');
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($deviceTypes);
        $entityManager->flush();
    }

    public function removeDeviceType(Devicetypes $deviceType)
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->remove($deviceType);
            $entityManager->flush();
        } catch (ForeignKeyConstraintViolationException $e ) {
            throw new \Exception('Can\'t delete, because probably you have foreign key restrictions');
        }
    }

    public function modifyDeviceType(Devicetypes $deviceType)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($deviceType);
        $entityManager->flush();
    }
}