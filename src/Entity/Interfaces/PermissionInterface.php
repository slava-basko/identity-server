<?php
/**
 * Created by Slava Basko <basko.slava@gmail.com>
 */

namespace App\Entity\Interfaces;

interface PermissionInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return array
     */
    public function getBusinessRules(): array;
}