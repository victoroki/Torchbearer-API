<?php

namespace App\Repositories;

use App\Models\InvolvementSubmission;
use App\Repositories\BaseRepository;

class InvolvementSubmissionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'name',
        'email',
        'organization',
        'phone',
        'message',
        'role_type',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return InvolvementSubmission::class;
    }
}
