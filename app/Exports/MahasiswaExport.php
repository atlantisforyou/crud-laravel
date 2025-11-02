<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MahasiswaExport implements FromView
{
    protected $mahasiswas;
    protected $judul;

    public function __construct($mahasiswas, $judul)
    {
        $this->mahasiswas = $mahasiswas;
        $this->judul = $judul;
    }

    public function view(): View
    {
        return view('mahasiswa.excel', [
            'mahasiswas' => $this->mahasiswas,
            'judul' => $this->judul
        ]);
    }
}