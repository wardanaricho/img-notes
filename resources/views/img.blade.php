@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Image Notes</h3>

        <form id="lokalisForm" method="POST" action="{{ route('lokalis.store') }}">
            @csrf

            <input type="hidden" name="pasien_id" value="1"> {{-- bisa kamu ganti dengan dynamic --}}
            <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">
            <input type="hidden" name="deskripsi" value="Deskripsi sementara"> {{-- kamu bisa ubah nanti --}}
            <input type="hidden" name="markers" id="markers-data">

            <div id="image-container" class="position-relative d-inline-block">
                <img id="body-image" src="{{ asset('human.png') }}" class="img-fluid" />
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan Lokalis</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('imgNotes.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imgNotes = new ImageNotes('#body-image', '#image-container');

            const form = document.getElementById('lokalisForm');
            form.addEventListener('submit', function(e) {
                const markers = imgNotes.getMarkers(); // pastikan method ini ada di imgNotes.js
                document.getElementById('markers-data').value = JSON.stringify(markers);
            });
        });
    </script>
@endsection
