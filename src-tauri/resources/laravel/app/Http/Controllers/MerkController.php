<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    public function index(Request $request)
    {
        $merks = Merk::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('merks.index', compact('merks'));
    }

    public function create()
    {
        return view('merks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:255'],
        ]);

        Merk::create($validated);

        return redirect()->route('merk.index')->with('success', 'Merk berhasil ditambahkan.');
    }

    public function edit(Merk $merk)
    {
        return view('merks.edit', compact('merk'));
    }

    public function update(Request $request, Merk $merk)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:255'],
        ]);

        $merk->update($validated);

        return redirect()->route('merk.index')->with('success', 'Merk berhasil diperbarui.');
    }

    public function destroy(Merk $merk)
    {
        try {
            $merk->delete();

            return redirect()->route('merk.index')->with('success', 'Merk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('merk.index')->with('error', 'Merk tidak dapat dihapus karena masih digunakan.');
        }
    }
}
