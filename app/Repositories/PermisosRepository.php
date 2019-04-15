<?php

namespace App\Repositories;

use App\Models\Permisos;
use InfyOm\Generator\Common\BaseRepository;

class PermisosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'descripcion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permisos::class;
    }
}
