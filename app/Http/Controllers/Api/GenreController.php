<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GenreController extends Controller
{
    public function index()
    {
        try {
            $genres = DB::table('genres')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data genre berhasil diambil',
                'data'    => $genres
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
                'nama_genre' => 'required|unique:genres,nama_genre',
            ]);

            $now = Carbon::now();
            $data = [
                'nama_genre' => $request->nama_genre,
                'slug'       => Str::slug($request->nama_genre) . Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $id = DB::table('genres')->insertGetId($data);

            $genre = DB::table('genres')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Data genre berhasil disimpan',
                'data'    => $genre
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
            $genre = DB::table('genres')->where('id', $id)->first();
            if (!$genre) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data genre tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'nama_genre' => 'required|unique:genres,nama_genre,' . $id,
            ]);

            $updateData = [
                'nama_genre' => $request->nama_genre,
                'slug'       => Str::slug($request->nama_genre) . Str::random(10),
                'updated_at' => Carbon::now(),
            ];

            DB::table('genres')->where('id', $id)->update($updateData);

            $updatedGenre = DB::table('genres')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Data genre berhasil diupdate',
                'data'    => $updatedGenre
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
            $genre = DB::table('genres')->where('id', $id)->first();
            if (!$genre) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data genre tidak ditemukan'
                ], 404);
            }

            DB::table('genres')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data genre berhasil dihapus',
                'data'    => $genre
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
