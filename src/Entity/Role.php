<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity;

use App\Entity\Interfaces\PermissionInterface;
use App\Entity\Interfaces\RoleInterface;
use App\Exceptions\Logic\NoPermissionFoundException;
use Doctrine\ORM\Mapping as ORM;
use App\Utils\Uuid;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 * @ORM\Table(name="role")
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @var string
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Permission")
     * @ORM\JoinTable(name="roles_permissions",
     *      joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permission_id", referencedColumnName="id")}
     *      )
     * @var Permission[]
     */
    private $permissions;

    /**
     * Role constructor.
     * @param string $name
     * @param array $permissions
     */
    public function __construct(string $name, array $permissions)
    {
        $this->id = Uuid::generate();
        foreach ($permissions as $perm) {
            if (!($perm instanceof Permission)) {
                throw new \InvalidArgumentException('Invalid permissions');
            }
        }
        
        $this->name = $name;
        $this->permissions = new ArrayCollection($permissions);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @param PermissionInterface $searchedPermission
     * @return PermissionInterface
     * @throws \Exception
     */
    public function getPermission(PermissionInterface $searchedPermission): PermissionInterface
    {
        foreach ($this->permissions as $permission) {
            if ($permission->isEqualTo($searchedPermission)) {
                return $permission;
            }
        }

        throw new NoPermissionFoundException();
    }

    /**
     * @param array $permissions
     */
    public function resetPermissions(array $permissions)
    {
        foreach ($permissions as $perm) {
            if (!($perm instanceof Permission)) {
                throw new \InvalidArgumentException('Invalid permissions');
            }
        }
        $this->permissions = new ArrayCollection($permissions);
        return;
    }
}
