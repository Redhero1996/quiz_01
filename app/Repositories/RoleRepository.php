<?php 

namespace App\Repositories;

use App\Role;

class RoleRepository extends Repository {
    function model()
    {
        return new Role();
    }
}
