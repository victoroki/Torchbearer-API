<?php

namespace App\Repositories;

use App\Models\FormSubmission;
use App\Repositories\BaseRepository;

class FormSubmissionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'email',
        'phone',
        'subject',
        'message',
        'form_type',
        'status',
        'source_url',
        'user_agent',
        'ip_address'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return FormSubmission::class;
    }
}
