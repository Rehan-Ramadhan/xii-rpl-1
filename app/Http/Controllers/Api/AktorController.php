<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aktor;
use Illuminate\Support\Str;

class AktorController extends Controller
{
    public function index()
    {
        try {
            $aktor = Aktor::latest()->get();
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

            $Aktor = new Aktor();
            $Aktor->nama_aktor = $request->nama_aktor;
            $Aktor->slug       = Str::slug($request->nama_aktor) . Str::random(10);
            $Aktor->gender     = $request->gender;
            $Aktor->umur       = $request->umur;
            $Aktor->foto       = $request->foto;
            $Aktor->save();

            return response()->json([
                'success' => true,
                'message' => 'Data Aktor berhasil disimpan',
                'data'    => $Aktor
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
            $Aktor = Aktor::find($id);
            if (!$Aktor) {
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

            $Aktor->nama_aktor = $request->nama_aktor;
            $Aktor->slug       = Str::slug($request->nama_aktor) . Str::random(10);
            $Aktor->gender     = $request->gender;
            $Aktor->umur       = $request->umur;
            $Aktor->foto       = $request->foto;
            $Aktor->save();

            return response()->json([
                'success' => true,
                'message' => 'Data Aktor berhasil diupdate',
                'data'    => $Aktor
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
            $Aktor = Aktor::find($id);
            if (!$Aktor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Aktor tidak ditemukan'
                ], 404);
            }

            $Aktor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Aktor berhasil dihapus',
                'data'    => $Aktor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
