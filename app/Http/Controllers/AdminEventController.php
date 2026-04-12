<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function authorizeAdmin(): void
    {
        if (! Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();

        $events = Event::orderBy('created_at', 'desc')->get();

        return view('admin.events.index', ['events' => $events]);
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'url', 'max:1000'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event added successfully.');
    }

    public function edit(Event $event)
    {
        $this->authorizeAdmin();

        return view('admin.events.edit', ['event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'url', 'max:1000'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeAdmin();

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
