<?php

namespace App\Repositories;

use App\Models\Certificate;
use App\Repositories\BaseRepository;

class CertificateRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'certificate_id',
        'recipient_name',
        'recipient_email',
        'course_name',
        'course_description',
        'issue_date',
        'status',
        'email_sent_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Certificate::class;
    }
}
