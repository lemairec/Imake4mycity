<?php

namespace AppBundle\Repository;

/**
 * PodometerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PodometerRepository extends \Doctrine\ORM\EntityRepository
{
    public function sumAll(){
        $sql = 'SELECT SUM(value) FROM podometer';

        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll();
        return $res[0]["SUM(value)"];
    }
}
