<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of job offers.
     */
    public function index()
    {
        $jobs = Job::all();
        return view('jobs.index', compact('jobs'));
    }

    /**
     * Update the candidature status to "Sent" (value = O).
     */
    public function updateCandidature(Job $job)
    {
        $job->update(['sent_candidature' => 'O']);
        return redirect()->route('jobs.index')->with('success', 'Candidature marked as sent!');
    }
}
