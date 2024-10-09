<?php

namespace App\Repository;

use App\Entity\Reservation;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findAll()
    {
        return $this->findBy(array(), array('startdate' => 'ASC'));
    }
    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
   
    public function findAlert()
    {
        $nextDate=new DateTime('+5 day');
        $nowDate=new DateTime();

        return $this->createQueryBuilder('r')
            ->andWhere('r.startdate >= :nowDate')
            ->setParameter('nowDate', $nowDate)
            ->andWhere('r.startdate <= :nextDate')
            ->setParameter('nextDate', $nextDate)
            ->andWhere('r.status = :status')
            ->setParameter('status', "P")
            ->getQuery()
            ->getResult()
        ; 
    }
    

   /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function checkDates($startDate,$endDate,$hall)
    {
        
        return $this->createQueryBuilder('r')
    

            ->andWhere('r.startdate = :startDate')
            ->setParameter('startDate', $startDate)
            ->andWhere('r.enddate >= :endDate')
            ->setParameter('endDate', $endDate)
            ->andWhere('r.hall = :hall')
            ->setParameter('hall', $hall) 
            ->getQuery()
            ->getResult()
            ;

   
    }
    
}
