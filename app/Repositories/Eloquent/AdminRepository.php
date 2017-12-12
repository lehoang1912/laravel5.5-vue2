<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;

class AdminRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }
}
