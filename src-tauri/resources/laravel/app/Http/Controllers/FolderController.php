<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index(Request $request)
    {
        $folders = Folder::query()
            ->withCount([
                'suratJalans',
                'details',
            ])
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('folders.index', compact('folders'));
    }

    public function create()
    {
        $nama = Folder::getNama();

        return view('folders.create', compact('nama'));
    }

    public function show(Folder $folder)
    {
        $suratJalans = $folder->suratJalans()
            ->with([
                'merk:id,nama',
                'penerima:id,nama',
            ])
            ->orderByDesc('tanggal')
            ->get();

        $folder->load('details.suratJalan');

        return view('folders.show', compact('folder', 'suratJalans'));
    }

    public function storeDetails(Request $request, Folder $folder)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['nullable', 'exists:folder_details,id'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
            'items.*.nama_barang' => ['required', 'string'],
            'items.*.surat_jalan_id' => ['nullable', 'exists:surat_jalans,id'],

            'deleted_ids' => ['nullable', 'array'],
            'deleted_ids.*' => ['exists:folder_details,id'],
        ]);

        if (! empty($validated['deleted_ids'])) {
            $folder->details()
                ->whereIn('id', $validated['deleted_ids'])
                ->delete();
        }

        foreach ($validated['items'] as $item) {
            $folder->details()->updateOrCreate(
                [
                    'id' => $item['id'] ?? null,
                ],
                [
                    'jumlah' => $item['jumlah'],
                    'nama_barang' => $item['nama_barang'],
                    'surat_jalan_id' => $item['surat_jalan_id'],
                ]
            );
        }

        return redirect()
            ->route('folder.index', $folder)
            ->with('success', 'Detail barang berhasil disimpan.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:255'],
        ]);
        Folder::create($validated);

        return redirect()->route('folder.index')->with('success', 'Folder berhasil ditambahkan.');
    }

    public function edit(Folder $folder)
    {
        return view('folders.edit', compact('folder'));
    }

    public function update(Request $request, Folder $folder)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:255'],
        ]);

        $folder->update($validated);

        return redirect()->route('folder.index')->with('success', 'Folder berhasil diperbarui.');
    }

    public function destroy(Folder $folder)
    {
        try {
            $folder->delete();

            return redirect()->route('folder.index')->with('success', 'Folder berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('folder.index')->with('error', 'Folder tidak dapat dihapus karena masih digunakan.');
        }
    }

    public function print(Folder $folder)
    {
        $folder->load([
            'suratJalans.merk',
            'suratJalans.penerima',
            'suratJalans.items',
            'details',
        ]);

        return view('folders.print', compact('folder'));
    }
}
