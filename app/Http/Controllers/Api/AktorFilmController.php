<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AktorFilm;
use Illuminate\Support\Str;

class AktorFilmController extends Controller
{
    public function index()
    {
        try {
            $aktorFilms = AktorFilm::latest()->get();
            return response()->json([
                'success' => true,
                'message' => 'Data actor film berhasil diambil',
                'data'    => $aktorFilms
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
                'id_film'  => 'required',
                'id_aktor' => 'required',
            ]);

            $aktorFilm = new AktorFilm();
            $aktorFilm->id_film  = $request->id_film;
            $aktorFilm->id_aktor = $request->id_aktor;
            $aktorFilm->save();

            return response()->json([
                'success' => true,
                'message' => 'Data actor film berhasil disimpan',
                'data'    => $aktorFilm
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
            $aktorFilm = AktorFilm::find($id);
            if (!$aktorFilm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data actor film tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'id_film'  => 'required',
                'id_aktor' => 'required',
            ]);

            $aktorFilm->id_film  = $request->id_film;
            $aktorFilm->id_aktor = $request->id_aktor;
            $aktorFilm->save();

            return response()->json([
                'success' => true,
                'message' => 'Data actor film berhasil diupdate',
                'data'    => $aktorFilm
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
            $aktorFilm = AktorFilm::find($id);
            if (!$aktorFilm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data actor film tidak ditemukan'
                ], 404);
            }

            $aktorFilm->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data actor film berhasil dihapus',
                'data'    => $aktorFilm
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
