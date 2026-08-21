<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function index()
    {
        try {
            $films = DB::table('films')
                ->join('genres', 'films.id_genre', '=', 'genres.id')
                ->select(
                    'films.*',
                    'genres.nama_genre'
                )
                ->orderBy('films.created_at', 'desc')
                ->get();

            foreach ($films as $film) {
                $film->aktors = DB::table('aktor_films')
                    ->join('aktors', 'aktor_films.id_aktor', '=', 'aktors.id')
                    ->where('aktor_films.id_film', $film->id)
                    ->select('aktors.*')
                    ->get();
            }

            return response()->json([
                'success' => true,
                'message' => 'Daftar film publik berhasil diambil',
                'data'    => $films
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $film = DB::table('films')
                ->join('genres', 'films.id_genre', '=', 'genres.id')
                ->where('films.id', $id)
                ->select(
                    'films.*',
                    'genres.nama_genre'
                )
                ->first();

            if (!$film) {
                return response()->json([
                    'success' => false,
                    'message' => 'Film tidak ditemukan'
                ], 404);
            }

            $film->aktors = DB::table('aktor_films')
                ->join('aktors', 'aktor_films.id_aktor', '=', 'aktors.id')
                ->where('aktor_films.id_film', $film->id)
                ->select('aktors.*')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Detail film berhasil diambil',
                'data'    => $film
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $keyword = $request->query('keyword');

            $films = DB::table('films')
                ->join('genres', 'films.id_genre', '=', 'genres.id')
                ->where('films.judul', 'LIKE', "%{$keyword}%")
                ->orWhere('genres.nama_genre', 'LIKE', "%{$keyword}%")
                ->select(
                    'films.*',
                    'genres.nama_genre'
                )
                ->orderBy('films.created_at', 'desc')
                ->get();

            foreach ($films as $film) {
                $film->aktors = DB::table('aktor_films')
                    ->join('aktors', 'aktor_films.id_aktor', '=', 'aktors.id')
                    ->where('aktor_films.id_film', $film->id)
                    ->select('aktors.*')
                    ->get();
            }

            return response()->json([
                'success' => true,
                'message' => 'Hasil pencarian film',
                'data'    => $films
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
