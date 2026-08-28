<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PelataranController extends Controller
{
    public function table()
    {
        $pelatarans = DB::table('pelatarans')
            ->join('pasar', 'pelatarans.pasar_id', '=', 'pasar.id')
            ->select('pelatarans.*', 'pasar.nama_pasar')
            ->get();
        return view('backend_admin.pages.pelataran.table', compact('pelatarans'));
    }

    public function create()
    {
        $pasars = DB::table('pasar')->get();
        return view('backend_admin.pages.pelataran.tambah', compact('pasars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_pelataran' => 'required|string|max:255',
            'ukuran_pelataran' => 'required|string|max:255',
            'harga_sewa' => 'required|numeric',
            'satuan_retribusi' => 'required|in:hari,bulan,tahun',
            'kategori_pelataran' => 'required|in:tetap,tidaktetap,insidentil',
            'lokasi_pelataran' => 'required|string|max:255',
            'pasar_id' => 'required|exists:pasar,id'
        ]);

        DB::beginTransaction();
        try {
            // Cek jumlah total_pelataran di tabel pasar
            $pasar = DB::table('pasar')->where('id', $request->pasar_id)->first();
            if (!$pasar) {
                Log::error('Pasar not found', ['pasar_id' => $request->pasar_id]);
                return redirect()->back()->withErrors(['pasar_id' => 'Pasar tidak ditemukan.']);
            }
            if ($pasar->total_pelataran <= 0) {
                Log::warning('Total pelataran habis', ['pasar_id' => $request->pasar_id, 'total_pelataran' => $pasar->total_pelataran]);
                return redirect()->back()->withErrors(['pasar_id' => 'Total pelataran di pasar ini sudah habis.']);
            }

            // Cek apakah nomor_pelataran sudah ada untuk pasar_id ini
            $existingPelataran = DB::table('pelatarans')
                ->where('pasar_id', $request->pasar_id)
                ->where('nomor_pelataran', $request->nomor_pelataran)
                ->exists();
            if ($existingPelataran) {
                Log::warning('Duplicate nomor_pelataran', [
                    'pasar_id' => $request->pasar_id,
                    'nomor_pelataran' => $request->nomor_pelataran
                ]);
                return redirect()->back()->withErrors(['nomor_pelataran' => 'Nomor pelataran sudah digunakan untuk pasar ini.']);
            }

            // Insert data pelataran
            DB::table('pelatarans')->insert([
                'nomor_pelataran' => $request->nomor_pelataran,
                'ukuran_pelataran' => $request->ukuran_pelataran,
                'harga_sewa' => $request->harga_sewa,
                'satuan_retribusi' => $request->satuan_retribusi,
                'kategori_pelataran' => $request->kategori_pelataran,
                'lokasi_pelataran' => $request->lokasi_pelataran,
                'pasar_id' => $request->pasar_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Kurangi total_pelataran di tabel pasar
            DB::table('pasar')
                ->where('id', $request->pasar_id)
                ->decrement('total_pelataran');

            DB::commit();
            Log::info('Pelataran added successfully', [
                'pasar_id' => $request->pasar_id,
                'nomor_pelataran' => $request->nomor_pelataran
            ]);
            return redirect()->route('backend_admin.pages.pelataran.table')->with('success', 'Data pelataran berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding pelataran: ' . $e->getMessage(), $request->all());

            return redirect()->back()
                ->with('error', 'Gagal menambahkan pelataran: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}