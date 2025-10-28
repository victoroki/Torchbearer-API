<?php

namespace App\Repositories;

use App\Models\TrainingProgram;
use App\Repositories\BaseRepository;

class TrainingProgramRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'title',
        'description',
        'program_type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'price',
        'early_bird_price',
        'features',
        'registration_link',
        'speaker',
        'status',
        'recording_url',
        'slides_url',
        'trainer_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return TrainingProgram::class;
    }
}
