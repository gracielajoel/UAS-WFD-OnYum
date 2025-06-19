<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $listMenu = Menu::orderBy('id', 'desc')->get();
        return view('menu.index', compact('listMenu'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Personal,Sharing',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('menu_images', 'public');
        }

        Menu::create($validated);
        return redirect()->route('menu.index')->with('success', 'Menu item created successfully.');
    }

    public function edit($id)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $listMenu = Menu::orderBy('id', 'desc')->get();
        $editing = Menu::findOrFail($id);
        return view('menu.index', compact('listMenu', 'editing'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Personal,Sharing',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            if ($menu->image_url) {
                Storage::disk('public')->delete($menu->image_url);
            }
            $validated['image_url'] = $request->file('image_url')->store('menu_images', 'public');
        }

        $menu->update($validated);
        return redirect()->route('menu.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $menu = Menu::findOrFail($id);
        if ($menu->image_url) {
            Storage::disk('public')->delete($menu->image_url);
        }
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu item deleted successfully.');
    }

    // public function show()
    // {
    //     $menus = Menu::all();
    //     return view('menu.showmenu', compact('menus'));
    // }

    public function show(Request $request)
{
    $query = Menu::query();

    if ($request->filled('keyword')) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
    }

    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    $menus = $query->get();

    return view('menu.showmenu', compact('menus'));
}

}
