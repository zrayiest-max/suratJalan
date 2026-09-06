<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\FolderDetail;
use App\Models\Merk;
use App\Models\Penerima;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class suratJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = SuratJalan::query();

        if ($search = request('search')) {
            $query->whereHas('merk', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        $suratJalans = $query
            ->with([
                'merk:id,nama',
                'penerima:id,nama',
                'folder:id,nama',
            ])
            ->withSum('items as jumlah_barang', 'jumlah')
            ->orderByRaw('folder_id IS NOT NULL')
            ->orderByDesc('tanggal')
            ->get();

        $folders = Folder::withCount('suratJalans')->get();

        return view('surat-jalan.index', compact('suratJalans', 'folders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merks = Merk::all('id', 'nama');
        $penerimas = Penerima::all('id', 'nama');
        $nomorSurat = SuratJalan::generateNomorSuratJalan();

        return view('surat-jalan.create', compact(['merks', 'penerimas', 'nomorSurat']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'merk_id' => ['required', 'exists:merks,id'],
            'penerima_id' => ['required', 'exists:penerimas,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.nama_barang' => ['required', 'string'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($validated) {
            $suratJalan = SuratJalan::create([
                'no_surat' => SuratJalan::generateNomorSuratJalan(),
                'tanggal' => $validated['tanggal'],
                'merk_id' => $validated['merk_id'],
                'penerima_id' => $validated['penerima_id'],
            ]);

            $suratJalan->items()->createMany($validated['items']);
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Surat jalan berhasil disimpan.');
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
    public function edit(SuratJalan $suratJalan)
    {
        $suratJalan->load('items');

        $merks = Merk::orderBy('nama')->get();
        $penerimas = Penerima::orderBy('nama')->get();

        return view('surat-jalan.edit', compact(
            'suratJalan',
            'merks',
            'penerimas'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratJalan $suratJalan)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'merk_id' => ['required', 'exists:merks,id'],
            'penerima_id' => ['required', 'exists:penerimas,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.nama_barang' => ['required', 'string'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($validated, $suratJalan) {
            $suratJalan->update([
                'tanggal' => $validated['tanggal'],
                'merk_id' => $validated['merk_id'],
                'penerima_id' => $validated['penerima_id'],
            ]);

            $suratJalan->items()->delete();

            $suratJalan->items()->createMany($validated['items']);
        });

        return redirect()
            ->route('surat-jalan.index')
            ->with('success', 'Surat jalan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratJalan $suratJalan)
    {
        $suratJalan->delete();

        return redirect()
            ->route('surat-jalan.index')
            ->with('success', 'Surat jalan berhasil dihapus.');
    }

    public function masukkanFolder(Request $request)
    {
        $validated = $request->validate([
            'folder_id' => ['required', 'exists:folders,id'],
            'surat_jalan_ids' => ['required', 'array'],
            'surat_jalan_ids.*' => ['exists:surat_jalans,id'],
        ]);

        SuratJalan::whereIn('id', $validated['surat_jalan_ids'])
            ->update([
                'folder_id' => $validated['folder_id'],
            ]);

        return redirect()
            ->route('surat-jalan.index')
            ->with('success', 'Surat jalan berhasil dimasukkan ke folder.');
    }

    public function tracking(Request $request)
    {
        $details = FolderDetail::query()
            ->with([
                'folder:id,nama',
                'suratJalan.merk:id,nama',
                'suratJalan.penerima:id,nama',
            ])
            ->when($request->search, function ($query, $search) {
                $query->where('nama_barang', 'like', "%{$search}%");
            })
            ->paginate(20)
            ->withQueryString();

        return view('surat-jalan.tracking', compact('details'));
    }
}
