<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Http\Resources\MahasiswaResource;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class MahasiswaController extends Controller
{
    /**
     * GET /api/mahasiswa
     * Menampilkan daftar mahasiswa dengan search, filter, sort, pagination.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi Query
        $query = Mahasiswa::query();

        // 2. Searching (q) - Grouping logic where agar tidak bentrok dengan filter lain
        $query->when($request->input('q'), function (Builder $q, $search) {
            $q->where(function (Builder $subQ) use ($search) {
                $subQ->where('nama', 'like', "%{$search}%")
                     ->orWhere('nim', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%");
            });
        });

        // 3. Filtering (Exact Match)
        $query->when($request->input('prodi'), function (Builder $q, $prodi) {
            $q->where('prodi', $prodi);
        });

        $query->when($request->input('status'), function (Builder $q, $status) {
            $q->where('status', $status);
        });

        $query->when($request->input('angkatan'), function (Builder $q, $angkatan) {
            $q->where('angkatan', $angkatan);
        });

        // 4. Sorting
        $sortField = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDir', 'desc');

        // Whitelist kolom agar aman dari SQL Injection
        $allowedSorts = ['nama', 'nim', 'angkatan', 'created_at', 'status'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 5. Pagination
        $perPage = $request->input('per_page', 10);
        $mahasiswas = $query->paginate($perPage);

        // Return Collection Resource
        return MahasiswaResource::collection($mahasiswas);
    }

    /**
     * POST /api/mahasiswa
     * Menyimpan data baru.
     */
    public function store(StoreMahasiswaRequest $request)
    {
        // Data sudah tervalidasi otomatis oleh FormRequest
        $mahasiswa = Mahasiswa::create($request->validated());

        return new MahasiswaResource($mahasiswa);
    }

    /**
     * GET /api/mahasiswa/{id}
     * Menampilkan detail mahasiswa.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return new MahasiswaResource($mahasiswa);
    }

    /**
     * PUT /api/mahasiswa/{id}
     * Update data mahasiswa.
     */
    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($request->validated());

        return new MahasiswaResource($mahasiswa);
    }

    /**
     * DELETE /api/mahasiswa/{id}
     * Menghapus data (Soft Delete).
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return response()->json([
            'message' => 'Data mahasiswa berhasil dihapus (soft delete).'
        ], 200);
    }
}