@extends('layouts.app')

@section('content')
<h2>Daftar Profesi</h2>
<a href="{{ url('profesi/create') }}">+ Tambah Profesi</a>
<table border="1">
    <thead>
        <tr>
            <th>ID</th><th>Kategori</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($profesi as $row)
        <tr>
            <td>{{ $row->profesi_id }}</td>
            <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $row->nama_profesi }}</td>
            <td>{{ $row->deskripsi }}</td>
            <td>
                <a href="{{ url('profesi/' . $row->profesi_id . '/edit') }}">Edit</a>
                <button class="delete-btn" data-id="{{ $row->profesi_id }}">Hapus</button>
            </td>            
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            var profesiId = this.getAttribute('data-id');
            if (confirm('Yakin ingin menghapus profesi ini?')) {
                $.ajax({
                    url: '/profesi/' + profesiId + '/delete_ajax',
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        alert(response.success);
                        location.reload(); // Reload halaman setelah penghapusan berhasil
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.status + ' ' + xhr.statusText);
                    }
                });
            }
        });
    });
</script>

@endsection
