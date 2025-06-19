<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReservationController extends Controller
{
    // public function index()
    // {
    //     if (!Auth::check() || Auth::user()->role_id !== 1) {
    //     return redirect()->route('home')->with('error', 'Unauthorized access.');
    // }
    //     $reservations = Reservation::with(['table', 'user'])->get();
    //     $availableTables = Table::where('is_empty', true)->get();
    //     return view('reservations.confirmation', compact('reservations', 'availableTables'));
    // }

    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
        $search = $request->input('search');

        $reservations = Reservation::with(['table', 'user'])
        ->when($search, function($query) use($search){
            $query->whereHas('user', function($q) use($search){
                $q->where('name','like', '%'.$search.'%');
            });
        })
        ->orderBy('date','desc')
        ->get();


        $availableTables = Table::where('is_empty', true)->get();
        return view('reservations.confirmation', compact('reservations', 'availableTables'));
    }


    public function confirm(Request $request, Reservation $reservation)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id'
        ]);

        $table = Table::find($request->table_id);

        if (!$table->is_empty || $table->capacity < $reservation->num_person) {
            return back()->with('error', 'Meja tidak tersedia atau kapasitas tidak cukup.');
        }

        $reservation->update([
            'status' => 'Confirmed',
            'table_id' => $table->id,
        ]);

        $table->update(['is_empty' => false]);

        return back()->with('success', 'Reservasi berhasil dikonfirmasi.');
    }

    public function reject(Reservation $reservation)
    {
        $reservation->update([
            'status' => 'Rejected',
            'table_id' => null,
        ]);

        return back()->with('success', 'Reservasi ditolak.');
    }

    public function finish(Reservation $reservation)
    {
        if ($reservation->table) {
            $reservation->table->update(['is_empty' => true]);
        }

        $reservation->update(['status' => 'Finished']);
        return back()->with('success', 'Reservasi selesai.');
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->table) {
            $reservation->table->update(['is_empty' => true]);
        }

        $reservation->update([
            'status' => 'Cancelled',
            'table_id' => null,
        ]);
        return back()->with('success', 'Reservasi dibatalkan.');
    }

}
