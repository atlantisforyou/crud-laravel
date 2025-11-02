<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    // READ
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mahasiswa = Mahasiswa::when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(5);

        $mahasiswa->appends(['search' => $search]);

        return view('mahasiswa.index', compact('mahasiswa'));
    }

    // CREATE FORM
    public function create()
    {
        return view('mahasiswa.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'email' => 'required|email|unique:mahasiswas',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil ditambahkan!');
    }

    // EDIT FORM
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    // UPDATE
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,'.$mahasiswa->id,
            'email' => 'required|email|unique:mahasiswas,email,'.$mahasiswa->id,
        ]);

        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil diperbarui!');
    }

    // DELETE
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil dihapus!');
    }

    // CETAK PDF
    public function cetakPDF(Request $request)
    {
        $search = $request->input('search');

        $mahasiswas = Mahasiswa::when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->orderBy('nim', 'asc')->get();

        $judul = "Daftar Mahasiswa";

        $pdf = PDF::loadView('mahasiswa.pdf', compact('mahasiswas', 'judul'));
        return $pdf->download('Daftar_Mahasiswa.pdf');
    }

    // EXPORT EXCEL
    public function exportExcel(Request $request)
    {
        $search = $request->input('search');

        $mahasiswas = Mahasiswa::when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->orderBy('nim', 'asc')->get();

        $judul = "Daftar Mahasiswa";

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MahasiswaExport($mahasiswas, $judul), 'Daftar_Mahasiswa.xlsx');
    }


}