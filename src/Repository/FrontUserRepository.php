<?php

namespace App\Repository;

use App\Entity\FrontUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method FrontUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method FrontUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method FrontUser[]    findAll()
 * @method FrontUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FrontUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FrontUser::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof FrontUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return FrontUser[] Returns an array of FrontUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findSomeOne($frontuseremail): ?FrontUser
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.email = :email')
            ->setParameter('email', $frontuseremail)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
