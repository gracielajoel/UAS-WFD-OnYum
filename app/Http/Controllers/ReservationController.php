<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\OrderedMenu;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $availableMenus = Menu::where('is_available', true)->get();
        return view('reservations.index', compact('availableMenus'));
    }

    public function showOrderDetail()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orderedMenus = OrderedMenu::with(['menu', 'reservation'])
            ->whereHas('reservation', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return view('reservations.history', compact('orderedMenus'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'guests' => 'required|integer|min:1',
            'date' => 'required|date',
            'start_time' => 'required',
            'duration' => 'required|integer|min:1',
            'reservation_type' => 'required|string',
        ]);

        // Simpan ke tabel reservations
        $reservation = Reservation::create([
            'num_person' => $validated['guests'],
            'date' => $validated['date'],
            'time' => $validated['start_time'],
            'duration' => $validated['duration'],
            'reservation_type' => $validated['reservation_type'],
            'status' => 'Pending',
            'dp_proof' => null,
            'user_id' => Auth::user()->id, // ← user login
        ]);


        // Ambil menu yang tersedia
        $menus = Menu::where('is_available', true)->get();

        // Simpan menu yang dipesan
        foreach ($menus as $menu) {
            $quantityKey = Str::slug($menu->name) . '_quantity';
            $quantity = $request->input($quantityKey);
            
            if ($quantity && intval($quantity) > 0) {
                OrderedMenu::create([
                    'quantity' => intval($quantity),
                    'notes' => $request->input("notes")[$menu->id] ?? null, 
                    'reservation_id' => $reservation->id,
                    'menu_id' => $menu->id,
                ]);
            }
        }

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat!');
    }

    public function uploadProof(Request $request, $id)
    {
        // Ambil reservasi yang statusnya Confirmed dan milik user login
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Confirmed')
            ->firstOrFail();

        // Validasi input
        $validated = $request->validate([
            'dp_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan file ke folder storage/app/public/dp_proofs
        $path = $request->file('dp_proof')->store('dp_proofs', 'public');

        // Ambil hanya nama file (tanpa folder)
        $filename = basename($path);

        // Simpan ke database
        $reservation->dp_proof = $filename;
        $reservation->save();

        return redirect()->back()->with('success', 'DP proof uploaded successfully.');
    }

}

