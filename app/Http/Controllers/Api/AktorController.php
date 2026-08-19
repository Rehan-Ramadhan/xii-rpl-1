<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AktorController extends Controller
{
    public function index()
    {
        try {
            $aktor = DB::table('aktors')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data Aktor berhasil diambil',
                'data'    => $aktor
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
                'nama_aktor' => 'required|unique:aktors,nama_aktor',
                'gender'     => 'required',
                'umur'       => 'required',
                'foto'       => 'required',
            ]);

            $now = Carbon::now();
            $data = [
                'nama_aktor' => $request->nama_aktor,
                'slug'       => Str::slug($request->nama_aktor) . Str::random(10),
                'gender'     => $request->gender,
                'umur'       => $request->umur,
                'foto'       => $request->foto,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $id = DB::table('aktors')->insertGetId($data);

            $aktor = DB::table('aktors')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Data Aktor berhasil disimpan',
                'data'    => $aktor
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
            $aktor = DB::table('aktors')->where('id', $id)->first();
            if (!$aktor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Aktor tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'nama_aktor' => 'required|unique:aktors,nama_aktor,' . $id,
                'gender'     => 'required',
                'umur'       => 'required',
                'foto'       => 'required',
            ]);

            $updateData = [
                'nama_aktor' => $request->nama_aktor,
                'slug'       => Str::slug($request->nama_aktor) . Str::random(10),
                'gender'     => $request->gender,
                'umur'       => $request->umur,
                'foto'       => $request->foto,
                'updated_at' => Carbon::now(),
            ];

            DB::table('aktors')->where('id', $id)->update($updateData);

            $updatedAktor = DB::table('aktors')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Data Aktor berhasil diupdate',
                'data'    => $updatedAktor
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
            $aktor = DB::table('aktors')->where('id', $id)->first();
            if (!$aktor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Aktor tidak ditemukan'
                ], 404);
            }

            DB::table('aktors')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Aktor berhasil dihapus',
                'data'    => $aktor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
