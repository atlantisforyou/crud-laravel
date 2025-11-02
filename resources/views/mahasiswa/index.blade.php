<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 text-primary">📋 Daftar Mahasiswa</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('mahasiswa.exportExcel', ['search' => request('search')]) }}" class="btn btn-success">
                    📗 Export Excel
                </a>
                <a href="{{ route('mahasiswa.cetakPDF', ['search' => request('search')]) }}" class="btn btn-danger">
                    📕 Export PDF
                </a>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                    + Tambah Mahasiswa
                </a>
            </div>
        </div>

        <form action="{{ route('mahasiswa.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama, NIM, atau Email..."
                    value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">🔍 Cari</button>
            </div>
        </form>

        <!-- Tabel Mahasiswa -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswa as $m)
                            <tr>
                                <td>{{ $m->nama }}</td>
                                <td>{{ $m->nim }}</td>
                                <td>{{ $m->email }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('mahasiswa.edit',$m->id) }}" class="btn btn-warning btn-sm">✏ Edit</a>
                                        <form action="{{ route('mahasiswa.destroy',$m->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">🗑 Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data mahasiswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $mahasiswa->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>