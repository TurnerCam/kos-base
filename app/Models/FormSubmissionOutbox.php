<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('form_submission_outbox')]
#[WithoutTimestamps]
#[Fillable('form_submission_id', 'processed_at', 'last_error', 'last_error_at')]
class FormSubmissionOutbox extends Model
{



    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'processed_at' => 'datetime',
            'last_error_at' => 'datetime',
        ];
    }

    /**
     * 1:1 relationship back to the form submission
     */
    public function formSubmission(): BelongsTo
    {
        return $this->belongsTo(FormSubmission::class, 'form_submission_id');
    }
}
