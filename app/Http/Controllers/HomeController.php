<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Data pasar lokal
            $pasars = DB::table('pasar')
                ->select([
                    'nama_pasar',
                    'total_kios',
                    'total_los',
                    'total_pelataran',
                    DB::raw('(total_kios + total_los + total_pelataran) AS total_unit')
                ])
                ->orderBy('nama_pasar', 'asc')
                ->get();

            return view('frontend.pages.home', compact('pasars'));
            
        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
            $pasars = collect();
            return view('frontend.pages.home', compact('pasars'));
        }
    }

    // 🔥 FIXED: API endpoint dengan fallback data
    public function getHargaPanganData()
    {
        try {
            \Log::info('Fetching data from external API...');
            
            // Coba ambil data dari API external (timeout pendek)
            $response = Http::timeout(5) // Timeout lebih pendek
                ->withOptions([
                    'verify' => false,
                ])
                ->get('https://dev-hargapangan.zoema.web.id/home/api');

            \Log::info('API Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                \Log::info('API Data fetched successfully');
                return response()->json($data);
            } else {
                \Log::warning('API Response failed: ' . $response->status());
                // Fallback ke mock data
                return $this->getMockData();
            }
            
        } catch (\Exception $e) {
            \Log::warning('API Timeout/Error: ' . $e->getMessage());
            // Fallback ke mock data
            return $this->getMockData();
        }
    }

    // 🔥 NEW: Mock data untuk fallback
    private function getMockData()
    {
        $mockData = [
            'status' => 'success',
            'timestamp' => now()->toISOString(),
            'data' => [
                [
                    'id_komoditas' => 1,
                    'nama_komoditas' => 'Beras Premium',
                    'harga' => '12500',
                    'satuan' => 'kg'
                ],
                [
                    'id_komoditas' => 2,
                    'nama_komoditas' => 'Minyak Goreng',
                    'harga' => '15000',
                    'satuan' => 'liter'
                ],
                [
                    'id_komoditas' => 3,
                    'nama_komoditas' => 'Gula Pasir',
                    'harga' => '12000',
                    'satuan' => 'kg'
                ],
                [
                    'id_komoditas' => 4,
                    'nama_komoditas' => 'Telur Ayam',
                    'harga' => '28000',
                    'satuan' => 'kg'
                ],
                [
                    'id_komoditas' => 5,
                    'nama_komoditas' => 'Daging Ayam',
                    'harga' => '35000',
                    'satuan' => 'kg'
                ],
                [
                    'id_komoditas' => 6,
                    'nama_komoditas' => 'Cabai Merah',
                    'harga' => '45000',
                    'satuan' => 'kg'
                ]
            ]
        ];

        \Log::info('Using mock data for harga pangan');
        return response()->json($mockData);
    }
}