<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Onesheet;
use Illuminate\Support\Facades\Auth;

class OnesheetController extends Controller
{
    public function index(Request $request)
    {
        $adminId = Auth::id();

        $query = Onesheet::where('admin_id', $adminId);

        if ($request->has('search')) {
            $query->where('judul_film', 'like', '%' . $request->search . '%');
        }

        $onesheets = $query->orderBy('tanggal', 'desc')->get();

        return view('onesheet.laporan', compact('onesheets'));
    }


    public function create()
    {
        return view('onesheet.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_film' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
            'penerima' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
        ]);

        Onesheet::create([
            'admin_id' => Auth::id(), // atau session('admin_id') jika tidak pakai Auth
            'tanggal' => $request->tanggal,
            'penerima' => $request->penerima,
            'pengirim' => $request->pengirim,
            'judul_film' => $request->judul_film,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);


        return redirect()->route('onesheet.form')->with('success', 'Data onesheet berhasil disimpan.');
    }

    public function laporan()
    {
        $adminId = Auth::id(); // atau session('admin_id') jika kamu pakai session manual

        $onesheets = \App\Models\Onesheet::where('admin_id', $adminId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('onesheet.laporan', compact('onesheets'));
    }

    public function search(Request $request)
    {
        $adminId = Auth::id();

        $query = Onesheet::where('admin_id', $adminId);

        if ($request->has('search') && $request->search !== null) {
            $query->where('judul_film', 'like', '%' . $request->search . '%');
        }

        $onesheets = $query->orderBy('tanggal', 'desc')->get();

        return view('onesheet.partial_table', compact('onesheets'));
    }
}
