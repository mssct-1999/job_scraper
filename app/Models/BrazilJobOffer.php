<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrazilJobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'french_company_id',
        'title',
        'offer_type',
        'status',
        'city',
        'state',
        'country',
        'source',
        'source_url',
        'contract_start_date',
        'published_at',
        'scraped_at',
        'description',
        'raw_payload',
    ];

    protected $casts = [
        'contract_start_date' => 'date',
        'published_at' => 'datetime',
        'scraped_at' => 'datetime',
        'raw_payload' => 'array',
    ];

    public function frenchCompany()
    {
        return $this->belongsTo(FrenchCompany::class);
    }
}
