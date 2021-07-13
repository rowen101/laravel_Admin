<?php


namespace App\Services;
use App\Models\Core\Permission;
use App\Models\Core\RolePermission;
use App\Models\Core\User;

class UserServices
{
    private $user;
    private $rolePermission;
    private $permission;

    public function __construct()
    {
       $this->user = new User();
       $this->rolePermission = new RolePermission();
       $this->permission = new Permission();
    }

    public function getMenuPermission($roleId, $appId){
        $menuIds = $this->rolePermission->where('role_id', $roleId)->map(function($permission){
            $this->permission->where('id',$permission->permission_id);
        });


    }

}
