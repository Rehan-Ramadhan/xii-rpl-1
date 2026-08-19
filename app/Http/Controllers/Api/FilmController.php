<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FilmController extends Controller
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
                'judul'         => 'required|unique:films,judul',
                'durasi'        => 'required',
                'rating'        => 'required',
                'deskripsi'     => 'required',
                'tanggal_rilis' => 'required',
                'poster'        => 'required',
                'id_genre'      => 'required|exists:genres,id',
                'sutradara'     => 'required',
                'id_aktor'      => 'required|array',
                'id_aktor.*'    => 'exists:aktors,id',
            ]);

            $now = Carbon::now();
            $filmData = [
                'judul'         => $request->judul,
                'slug'          => Str::slug($request->judul) . Str::random(10),
                'durasi'        => $request->durasi,
                'rating'        => $request->rating,
                'deskripsi'     => $request->deskripsi,
                'tanggal_rilis' => $request->tanggal_rilis,
                'poster'        => $request->poster,
                'id_genre'      => $request->id_genre,
                'sutradara'     => $request->sutradara,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];

            $filmId = DB::table('films')->insertGetId($filmData);

            $pivotData = [];
            foreach ($request->id_aktor as $aktorId) {
                $pivotData[] = [
                    'id_film'    => $filmId,
                    'id_aktor'   => $aktorId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('aktor_films')->insert($pivotData);

            $film = DB::table('films')->where('id', $filmId)->first();
            $film->aktors = DB::table('aktor_films')
                ->join('aktors', 'aktor_films.id_aktor', '=', 'aktors.id')
                ->where('aktor_films.id_film', $filmId)
                ->select('aktors.*')
                ->get();

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
            $film = DB::table('films')->where('id', $id)->first();
            if (!$film) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data film tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'judul'         => 'required|unique:films,judul,' . $id,
                'durasi'        => 'required',
                'rating'        => 'required',
                'deskripsi'     => 'required',
                'tanggal_rilis' => 'required',
                'poster'        => 'required',
                'id_genre'      => 'required|exists:genres,id',
                'sutradara'     => 'required',
                'id_aktor'      => 'required|array',
                'id_aktor.*'    => 'exists:aktors,id',
            ]);

            $now = Carbon::now();
            $updateData = [
                'judul'         => $request->judul,
                'slug'          => Str::slug($request->judul) . Str::random(10),
                'durasi'        => $request->durasi,
                'rating'        => $request->rating,
                'deskripsi'     => $request->deskripsi,
                'tanggal_rilis' => $request->tanggal_rilis,
                'poster'        => $request->poster,
                'id_genre'      => $request->id_genre,
                'sutradara'     => $request->sutradara,
                'updated_at'    => $now,
            ];

            DB::table('films')->where('id', $id)->update($updateData);

            DB::table('aktor_films')->where('id_film', $id)->delete();

            $pivotData = [];
            foreach ($request->id_aktor as $aktorId) {
                $pivotData[] = [
                    'id_film'    => $id,
                    'id_aktor'   => $aktorId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('aktor_films')->insert($pivotData);

            $updatedFilm = DB::table('films')->where('id', $id)->first();
            $updatedFilm->aktors = DB::table('aktor_films')
                ->join('aktors', 'aktor_films.id_aktor', '=', 'aktors.id')
                ->where('aktor_films.id_film', $id)
                ->select('aktors.*')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data film berhasil diupdate',
                'data'    => $updatedFilm
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
            $film = DB::table('films')->where('id', $id)->first();
            if (!$film) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data film tidak ditemukan'
                ], 404);
            }

            DB::table('aktor_films')->where('id_film', $id)->delete();
            DB::table('films')->where('id', $id)->delete();

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
