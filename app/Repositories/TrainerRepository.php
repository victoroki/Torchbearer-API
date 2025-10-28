<?php

namespace App\Repositories;

use App\Models\Trainer;
use App\Repositories\BaseRepository;

class TrainerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'name',
        'role',
        'bio',
        'image_url',
        'linkedin_url',
        'courses',
        'experience',
        'is_active'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Trainer::class;
    }
}
