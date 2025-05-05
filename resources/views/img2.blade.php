<!-- resources/views/image_notes.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Image Notes</h3>
        <div id="image-container" class="position-relative d-inline-block">
            <img id="body-image" src="{{ asset('human.png') }}" class="img-fluid" />
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="noteForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Note for Point <span id="note-number"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="note-x">
                        <input type="hidden" id="note-y">
                        <textarea id="note-text" class="form-control" placeholder="Enter your note here" required autofocus></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" id="delete-note">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let counter = 1;
        let points = [];

        $('#body-image').on('click', function(e) {
            const offset = $(this).offset();
            const x = e.pageX - offset.left;
            const y = e.pageY - offset.top;

            $('#note-x').val(x);
            $('#note-y').val(y);
            $('#note-number').text(counter);
            $('#note-text').val('');
            $('#noteModal').data('editing', false).modal('show');
        });

        $('#noteForm').on('submit', function(e) {
            e.preventDefault();

            const note = $('#note-text').val();
            const x = parseFloat($('#note-x').val());
            const y = parseFloat($('#note-y').val());
            const number = parseInt($('#note-number').text());

            const isEditing = $('#noteModal').data('editing');

            if (isEditing) {
                const index = points.findIndex(p => p.number === number);
                if (index !== -1) {
                    points[index].note = note;

                    // Update tooltip
                    $('.marker').each(function() {
                        const n = parseInt($(this).text());
                        if (n === number) {
                            const tooltipInstance = bootstrap.Tooltip.getInstance(this);
                            if (tooltipInstance) tooltipInstance.dispose();
                            $(this).attr('title', note);
                            new bootstrap.Tooltip(this);
                        }
                    });
                }
            } else {
                createMarker(x, y, counter, note);
                points.push({
                    x,
                    y,
                    number: counter,
                    note
                });
                counter++;
            }

            $('#noteModal').removeData('editing').removeData('editNumber').modal('hide');
        });

        $('#delete-note').on('click', function() {
            const number = $('#noteModal').data('editNumber');
            if (!number) return;

            points = points.filter(p => p.number !== number);

            $('.marker').each(function() {
                if (parseInt($(this).text()) === number) {
                    const tooltipInstance = bootstrap.Tooltip.getInstance(this);
                    if (tooltipInstance) tooltipInstance.dispose();
                    $(this).remove();
                }
            });

            $('#noteModal').removeData('editing').removeData('editNumber').modal('hide');
        });

        function createMarker(x, y, number, note) {
            const marker = $('<div>')
                .addClass('marker')
                .text(number)
                .attr('title', note)
                .attr('data-bs-toggle', 'tooltip')
                .css({
                    left: x + 'px',
                    top: y + 'px',
                    transform: 'translate(-50%, -50%)'
                })
                .on('click', function(e) {
                    e.stopPropagation();
                    const point = points.find(p => p.number === number);
                    if (point) {
                        $('#note-x').val(point.x);
                        $('#note-y').val(point.y);
                        $('#note-number').text(point.number);
                        $('#note-text').val(point.note);
                        $('#noteModal').data('editing', true).data('editNumber', point.number);
                        $('#noteModal').modal('show');
                    }
                });

            $('#image-container').append(marker);
            new bootstrap.Tooltip(marker[0]);
        }
    </script>

    <style>
        #image-container {
            position: relative;
            display: inline-block;
        }

        .marker {
            position: absolute;
            width: 24px;
            height: 24px;
            background-color: black;
            border: 1px solid white;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
@endsection
