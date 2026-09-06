<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;

class PenarimaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $penerimas = Penerima::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('penerima.index', compact('penerimas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penerima.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:255'],
            'alamat' => ['required', 'string', 'min:2', 'max:512'],
        ]);
        Penerima::create($validated);

        return redirect()->route('penerima.index')->with('success', 'Penerima berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penerima $penerima)
    {
        return view('penerima.edit', compact('penerima'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penerima $penerima)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:255'],
            'alamat' => ['required', 'string', 'min:2', 'max:512'],
        ]);

        $penerima->update($validated);

        return redirect()->route('penerima.index')->with('success', 'Penerima berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penerima $penerima)
    {
        try {
            $penerima->delete();

            return redirect()->route('penerima.index')->with('success', 'Penerima berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('penerima.index')->with('error', 'Penerima tidak dapat dihapus karena masih digunakan.');
        }
    }
}
