<?php

namespace App\Repositories;

use App\Models\GalleryItem;
use App\Repositories\BaseRepository;

class GalleryItemRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'title',
        'category',
        'type',
        'file_url',
        'description',
        'featured',
        'rating',
        'views',
        'tags'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return GalleryItem::class;
    }
}
