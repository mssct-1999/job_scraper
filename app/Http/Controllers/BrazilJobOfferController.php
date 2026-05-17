<?php

namespace App\Http\Controllers;

use App\Models\BrazilJobOffer;
use App\Models\FrenchCompany;
use Illuminate\Http\Request;

class BrazilJobOfferController extends Controller
{
    public function index()
    {
        $offers = BrazilJobOffer::with('frenchCompany')
            ->latest()
            ->get();

        return view('brazil_offers.index', compact('offers'));
    }

    public function create()
    {
        $companies = FrenchCompany::orderBy('name')->get();

        return view('brazil_offers.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'french_company_id' => ['nullable', 'exists:french_companies,id'],
            'title' => ['required', 'string', 'max:255'],
            'offer_type' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'source_url' => ['nullable', 'url', 'max:255'],
            'contract_start_date' => ['nullable', 'date'],
            'published_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        $data['country'] = $data['country'] ?? 'Brazil';
        $data['source'] = $data['source'] ?? 'manual';

        $offer = BrazilJobOffer::create($data);

        return redirect()
            ->route('brazil-offers.show', $offer)
            ->with('success', 'Brazil job offer registered.');
    }

    public function show(BrazilJobOffer $brazilOffer)
    {
        $brazilOffer->load('frenchCompany');

        return view('brazil_offers.show', ['offer' => $brazilOffer]);
    }
}
