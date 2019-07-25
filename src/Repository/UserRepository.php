<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Repository;

use App\Entity\User;
use App\Exceptions\Logic\UserExistException;
use App\Exceptions\Logic\UserNotExistException;
use App\Exceptions\SystemException;
use App\Repository\Traits\EntityPersistStateTrait;
use App\Value\DefaultRole;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    use EntityPersistStateTrait;

    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public function createNew(string $email, string $password): User
    {
        $user = $this->findOneBy(['email' => $email]);
        if ($user instanceof User) {
            throw new UserExistException();
        }
        return $user = new User($email, $password, [new DefaultRole()]);
    }

    /**
     * @param User $user
     * @return bool
     * @throws SystemException
     */
    public function delete(User $user): bool
    {
        try {
            $this->getEntityManager()->remove($user);
            $this->getEntityManager()->flush();
        } catch (\Exception $ex) {
            throw new SystemException('Can not delete user.');
        }
        return true;
    }

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User
    {
        $user = $this->findOneBy(['email' => $email]);
        if (!($user instanceof User)) {
            throw new UserNotExistException();
        }
        /**
         * @var User $user
         */
        return $user;
    }

    /**
     * @param string $email
     * @return array
     */
    public function getUser(string $email)
    {
        $userInfo = $this->createQueryBuilder('u')
            ->select('u.id, ur.name as role', 'p.operation as permission', 'd.name as domainName')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->leftJoin('u.roles', 'ur')
            ->leftJoin('ur.permissions', 'p')
            ->leftJoin('p.domainEntity', 'd')
            ->getQuery()
            ->getArrayResult();

        if (!$userInfo) {
            throw new UserNotExistException();
        }
        $res = [
            'id' =>$userInfo[0]['id'],
            'email' => $email,
            'roles' => []
        ];
        foreach ($userInfo as $item){
            $res['roles'][$item['role']][$item['domainName']][]=$item['permission'];
        }
        return $res;
    }
}