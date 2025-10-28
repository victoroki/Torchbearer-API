<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\BaseRepository;

class EventRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'title',
        'category',
        'date',
        'time',
        'location',
        'participants',
        'max_participants',
        'price',
        'description',
        'status',
        'featured',
        'registration_url'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Event::class;
    }
}
