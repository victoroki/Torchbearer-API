<?php

namespace App\Repositories;

use App\Models\UsefulLink;
use App\Repositories\BaseRepository;

class UsefulLinkRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'title',
        'url',
        'description',
        'category',
        'featured',
        'rating',
        'visits'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return UsefulLink::class;
    }
}
