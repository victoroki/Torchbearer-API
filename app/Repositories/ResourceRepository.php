<?php

namespace App\Repositories;

use App\Models\Resource;
use App\Repositories\BaseRepository;

class ResourceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'title',
        'category',
        'type',
        'size',
        'downloads',
        'rating',
        'description',
        'author',
        'date',
        'featured',
        'tags',
        'preview',
        'file_url'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Resource::class;
    }
}
