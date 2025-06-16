<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    public function index()
    {
        // Pastikan user sudah login
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

        $listTables = Table::all();
        return view('tables.index', compact('listTables'));
    }


    public function create()
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        return view('tables.form', ['table' => null]);
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'is_empty' => 'required|boolean',
        ]);

        Table::create($validated);

        return redirect()->route('tables.index')->with('success', 'Table created successfully!');
    }

    public function edit($id)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $table = Table::findOrFail($id);
        return view('tables.form', compact('table'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'is_empty' => 'required|boolean',
        ]);

        $table = Table::findOrFail($id);
        $table->update($validated);

        return redirect()->route('tables.index')->with('success', 'Table updated successfully!');
    }

    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Table deleted successfully!');
    }
}
