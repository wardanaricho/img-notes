@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Detail Lokalis</h3>

        <div class="mb-3">
            <strong>Tanggal:</strong> {{ $lokalis->tanggal }}<br>
            <strong>Deskripsi:</strong> {{ $lokalis->deskripsi }}
        </div>

        <div class="mb-4">
            <h5>Gambar Lokalis:</h5>
            <img src="{{ asset('storage/' . $lokalis->markers->first()->image_path) }}" alt="Lokalis Snapshot"
                class="img-fluid border rounded">
        </div>

        <div>
            <h5>Catatan Marker:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Koordinat (x, y)</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lokalis->markers->sortBy('number') as $marker)
                        <tr>
                            <td>{{ $marker->number }}</td>
                            <td>{{ round($marker->x) }}, {{ round($marker->y) }}</td>
                            <td>{{ $marker->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
