<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrenchCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'legal_name',
        'sector',
        'city',
        'state',
        'country',
        'website',
        'linkedin_url',
        'logo_url',
        'contact_name',
        'contact_email',
        'contact_phone',
        'source_url',
        'notes',
    ];

    public function brazilJobOffers()
    {
        return $this->hasMany(BrazilJobOffer::class);
    }
}
