<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    public function index()
    {
        try {
            $films = Film::latest()->get();
            return response()->json([
                'success' => true,
                'message' => 'Data film berhasil diambil',
                'data'    => $films
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul'       => 'required|unique:films,judul',
                'durasi'      => 'required',
                'rating'      => 'required',
                'deskripsi'   => 'required',
                'tahun_rilis' => 'required',
                'poster'      => 'required',
                'id_genre'    => 'required',
                'sutradara'   => 'required',
            ]);

            $film = new Film();
            $film->judul       = $request->judul;
            $film->slug        = Str::slug($request->judul) . Str::random(10);
            $film->durasi      = $request->durasi;
            $film->rating      = $request->rating;
            $film->deskripsi   = $request->deskripsi;
            $film->tahun_rilis = $request->tahun_rilis;
            $film->poster      = $request->poster;
            $film->id_genre    = $request->id_genre;
            $film->sutradara   = $request->sutradara;
            $film->save();

            return response()->json([
                'success' => true,
                'message' => 'Data film berhasil disimpan',
                'data'    => $film
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $film = Film::find($id);
            if (!$film) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data film tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'judul'       => 'required|unique:films,judul,' . $id,
                'durasi'      => 'required',
                'rating'      => 'required',
                'deskripsi'   => 'required',
                'tahun_rilis' => 'required',
                'poster'      => 'required',
                'id_genre'    => 'required',
                'sutradara'   => 'required',
            ]);

            $film->judul       = $request->judul;
            $film->slug        = Str::slug($request->judul) . Str::random(10);
            $film->durasi      = $request->durasi;
            $film->rating      = $request->rating;
            $film->deskripsi   = $request->deskripsi;
            $film->tahun_rilis = $request->tahun_rilis;
            $film->poster      = $request->poster;
            $film->id_genre    = $request->id_genre;
            $film->sutradara   = $request->sutradara;
            $film->save();

            return response()->json([
                'success' => true,
                'message' => 'Data film berhasil diupdate',
                'data'    => $film
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $film = Film::find($id);
            if (!$film) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data film tidak ditemukan'
                ], 404);
            }

            $film->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data film berhasil dihapus',
                'data'    => $film
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
