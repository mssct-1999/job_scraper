<?php

namespace App\Http\Controllers;

use App\Models\FrenchCompany;
use Illuminate\Http\Request;

class FrenchCompanyController extends Controller
{
    public function index()
    {
        $companies = FrenchCompany::withCount('brazilJobOffers')
            ->orderBy('name')
            ->get();

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'sector' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'logo_url' => ['nullable', 'url', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'source_url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['country'] = $data['country'] ?? 'Brazil';

        $company = FrenchCompany::create($data);

        return redirect()
            ->route('companies.show', $company)
            ->with('success', 'Company registered.');
    }

    public function show(FrenchCompany $company)
    {
        $company->load(['brazilJobOffers' => function ($query) {
            $query->latest();
        }]);

        return view('companies.show', compact('company'));
    }
}
