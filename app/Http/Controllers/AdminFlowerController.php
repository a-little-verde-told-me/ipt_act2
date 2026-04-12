<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminFlowerController extends Controller
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

        $flowers = Flower::orderBy('created_at', 'desc')->get();

        return view('admin.flowers.index', ['flowers' => $flowers]);
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.flowers.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'string', 'max:1000'],
        ]);

        Flower::create($data);

        return redirect()->route('admin.flowers.index')->with('success', 'Flower added successfully.');
    }

    public function edit(Flower $flower)
    {
        $this->authorizeAdmin();

        return view('admin.flowers.edit', ['flower' => $flower]);
    }

    public function update(Request $request, Flower $flower)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'string', 'max:1000'],
        ]);

        $flower->update($data);

        return redirect()->route('admin.flowers.index')->with('success', 'Flower updated successfully.');
    }

    public function destroy(Flower $flower)
    {
        $this->authorizeAdmin();

        $flower->delete();

        return redirect()->route('admin.flowers.index')->with('success', 'Flower deleted successfully.');
    }
}
