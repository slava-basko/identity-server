<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity;

use App\Entity\Interfaces\PermissionInterface;
use App\Exceptions\Logic\NoPermissionFoundException;
use App\Utils\Password;
use App\Value\DefaultRole;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Interfaces\RoleInterface;
use App\Utils\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Is\Sdk\Value\Answer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $password;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     * @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *     )
     * @var Role[]
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EntityEntry", mappedBy="user_id")
     * @var EntityEntry[]
     */
    private $entityEntries;

    /**
     * User constructor.
     * @param string $email
     * @param string $password
     * @param array $roles
     */
    public function __construct(string $email, string $password, array $roles)
    {
        $this->id = Uuid::generate();
        foreach ($roles as $index => $role) {
            if (!($role instanceof RoleInterface)) {
                throw new \InvalidArgumentException('Invalid roles');
            }
            if ($role instanceof DefaultRole) {
                unset($roles[$index]);
            }
        }

        $this->email = $email;
        $this->password = Password::hash($password);
        $this->roles = new ArrayCollection($roles);
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $password
     */
    public function changePassword(string $password)
    {
        $this->password = Password::hash($password);
        return;
    }

    /**
     * @param array $roles
     */
    public function changeRoles(array $roles)
    {
        foreach ($roles as $role) {
            if (!($role instanceof Role)) {
                throw new \InvalidArgumentException('Invalid roles');
            }
        }
        $this->roles = new ArrayCollection($roles);
        return;
    }

    /**
     * @param PermissionInterface $searchedPermission
     * @return Answer
     */
    public function hasPermission(PermissionInterface $searchedPermission): Answer
    {
        $rolesAliases = [];
        foreach ($this->roles as $role) {
            $rolesAliases[] = (string)$role;
        }
        $answer = new Answer(false, [], new \Is\Sdk\Auth\User($this->id, $this->email, $rolesAliases));

        foreach ($this->roles as $role) {
            try {
                $permission = $role->getPermission($searchedPermission);
                $answer = new Answer(true, $permission->getBusinessRules(), new \Is\Sdk\Auth\User($this->id, $this->email, $rolesAliases));
            } catch (NoPermissionFoundException $ex) {
                // Do nothing
            }
        }

        return $answer;
    }
}
