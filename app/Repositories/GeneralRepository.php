<?php 

namespace App\Repositories;

class GeneralRepository implements GeneralRepositoryInterface
{
    public function getAlphabet() {
        return [
            'A', 'B', 'C', 'D', 'E',
            'F', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y',
            'z',
        ];
    }    
}
