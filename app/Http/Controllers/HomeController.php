<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\TrainingProgram;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
public function index()
{
    // New Users
    $newUsers = User::where('created_at', '>=', now()->subDay())
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
                'title' => 'New user registered',
                'description' => $user->name ?? 'New user',
                'created_at' => $user->created_at->timestamp,  // Convert to timestamp
                'created_at_formatted' => $user->created_at,
                'icon' => '👤'
            ];
        });

    // New Certificates
    $newCertificates = Certificate::where('created_at', '>=', now()->subDay())
        ->get()
        ->map(function ($certificate) {
            return [
                'id' => $certificate->id,
                'title' => 'Certificate issued',
                'description' => $certificate->certificate_name ?? 'New certificate',
                'created_at' => $certificate->created_at->timestamp,  // Convert to timestamp
                'created_at_formatted' => $certificate->created_at,
                'icon' => '🎓'
            ];
        });

    // New Events
    $newEvents = Event::where('created_at', '>=', now()->subDay())
        ->get()
        ->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => 'Event created',
                'description' => $event->name ?? 'New event',
                'created_at' => $event->created_at->timestamp,  // Convert to timestamp
                'created_at_formatted' => $event->created_at,
                'icon' => '📅'
            ];
        });

    // New Training Programs
    $newTrainingPrograms = TrainingProgram::where('created_at', '>=', now()->subDay())
        ->get()
        ->map(function ($program) {
            return [
                'id' => $program->id,
                'title' => 'Training program added',
                'description' => $program->name ?? 'New training program',
                'created_at' => $program->created_at->timestamp,  // Convert to timestamp
                'created_at_formatted' => $program->created_at,
                'icon' => '📚'
            ];
        });

    // Combine and sort activities, limit to 5
    $recentActivities = collect([])
        ->merge($newUsers)
        ->merge($newCertificates)
        ->merge($newEvents)
        ->merge($newTrainingPrograms)
        ->sortByDesc('created_at')
        ->take(5)
        ->values()
        ->toArray();

    // Pass data to the view
    return view('home', compact('recentActivities'));
}
}
