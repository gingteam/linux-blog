<?php

namespace App\Security;

use Nette\Security\Permission;

class PermissionFactory
{
    public static function create(): Permission
    {
        $acl = new Permission();

        $acl->addRole('guest');
        $acl->addRole('registered', ['guest']);
        $acl->addRole('admin', ['registered']);

        $acl->addResource('Post');

        $acl->allow('guest', 'Post', 'show');
        $acl->allow('admin', 'Post', ['create', 'edit', 'delete']);

        return $acl;
    }
}
