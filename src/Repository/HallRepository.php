<?php

namespace App\Repository;

use App\Entity\Ergonomy;
use App\Entity\Hall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hall|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hall|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hall[]    findAll()
 * @method Hall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hall::class);
    }

 
    public function findByCriteria($data)
    {      
        $ergonomies = [];
        foreach($data['Ergonomy'] as $ergonomy) {
            $ergonomies[] = $ergonomy->getName();
        }

        $materials=[];
        foreach($data['Material'] as $material) {
            $materials[] = $material->getName();
        }

        $softwares=[];
        foreach($data['Software'] as $software) {
            $softwares[] = $software->getName();
        }


        return $this->createQueryBuilder('h')
            ->leftJoin('h.ergonomy','e')
            ->leftJoin('h.material','m')
            ->leftJoin('h.software','s')

            ->andWhere('h.capacity >= :capacity')
            ->setParameter('capacity', $data['Capacity'])
            ->andWhere('e.name IN (:ergonomies)')
            ->setParameter('ergonomies', $ergonomies)
            ->andWhere('m.name IN (:materials)')
            ->setParameter('materials', $materials)
            ->andWhere('s.name IN (:softwares)')
            ->setParameter('softwares', $softwares)
            ->getQuery()
            ->getResult()
        ;
    }
    


    /*
    public function findOneBySomeField($value): ?Hall
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
       // /**
    //  * @return Hall[] Returns an array of Hall objects
    //  * used to get the nearest capacity hall
    //  */
    
    // public function findData($data,$foundcapacity)
    // {       
    //     $capacity=$data['Capacity']+($foundcapacity); 
    //     $negcapacity=$data['Capacity']+($foundcapacity*-1);
    
    //     return $this->createQueryBuilder('h')
    //         ->andWhere('h.capacity = :capacity')
    //         ->setParameter('capacity', $data['Capacity'])
           
    //         ->andWhere('h.capacity = :capacity')
    //         ->setParameter('capacity',$negcapacity)
    //         ->andWhere('h.capacity = :capacity')
    //         ->setParameter('capacity',$capacity)
           
    //         // ->andWhere('h.material= :material')
    //         // ->setParameter('material', $data->getMaterial())
    //          ->getQuery()
    //         ->getResult()
    //     ;
    // }
}
