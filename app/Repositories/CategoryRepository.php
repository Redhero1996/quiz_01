<?php 

namespace App\Repositories;

use App\Category;

class CategoryRepository extends Repository {
    function model()
    {
        return new Category();
    }
}
