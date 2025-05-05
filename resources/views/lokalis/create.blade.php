@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Image Notes</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="lokalisForm" method="POST" action="{{ route('lokalis.store') }}">
            @csrf

            <input type="hidden" name="pasien_id" value="1">
            <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">
            <input type="hidden" name="deskripsi" value="Deskripsi sementara">
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
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('imgNotes.js') }}"></script>
    <script>
        $(document).ready(function() {
            const imgNotes = new ImageNotes('#body-image', '#image-container');
            imgNotes.attachToForm('#lokalisForm');
        });
    </script>
@endsection
