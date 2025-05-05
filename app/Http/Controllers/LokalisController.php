<?php

namespace App\Http\Controllers;

use App\Models\ImageMarker;
use App\Models\Lokalis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LokalisController extends Controller
{
    public function create()
    {
        return view('lokalis.create');
    }

    public function show($id)
    {
        $lokalis = Lokalis::with('markers')->findOrFail($id);

        return view('lokalis.show', compact('lokalis'));
    }

    public function edit($id)
    {
        $lokalis = Lokalis::with('markers')->findOrFail($id);
        return view('lokalis.edit', compact('lokalis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|integer',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'markers' => 'required|json',
            'snapshot' => 'required|string',
        ]);

        $imageData = $request->input('snapshot');
        preg_match("/data:image\/jpeg;base64,(.*)/", $imageData, $matches);
        $decodedImage = base64_decode($matches[1]);
        $imageFilename = 'lokalis/' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($imageFilename, $decodedImage);

        $lokalis = Lokalis::create([
            'pasien_id' => $request->pasien_id,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'created_by' => 1,
        ]);

        $markers = json_decode($request->markers, true);
        foreach ($markers as $marker) {
            ImageMarker::create([
                'lokalis_id' => $lokalis->id,
                'image_path' => $imageFilename,
                'number' => $marker['number'],
                'x' => $marker['x'],
                'y' => $marker['y'],
                'note' => $marker['note'] ?? null,
            ]);
        }

        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'markers' => 'required|json',
            'snapshot' => 'required|string',
        ]);

        $lokalis = Lokalis::with('markers')->findOrFail($id);

        // Optional: hapus file lama dari storage (jika semua marker sebelumnya pakai gambar yang sama)
        if ($lokalis->markers->isNotEmpty()) {
            $oldImage = $lokalis->markers->first()->image_path;
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        // Simpan gambar baru
        $snapshotPath = $this->saveSnapshotImage($request->input('snapshot'));

        // Update info lokalis
        $lokalis->update([
            'deskripsi' => $request->input('deskripsi'),
            'tanggal' => $request->input('tanggal'),
        ]);

        // Hapus marker lama & simpan yang baru
        $lokalis->markers()->delete();
        $markers = json_decode($request->input('markers'), true);

        foreach ($markers as $marker) {
            $lokalis->markers()->create([
                'x' => $marker['x'],
                'y' => $marker['y'],
                'note' => $marker['note'] ?? null,
                'number' => $marker['number'],
                'image_path' => $snapshotPath,
            ]);
        }

        return redirect()->route('lokalis.show', $lokalis->id)->with('success', 'Lokalis berhasil diperbarui');
    }

    private function saveSnapshotImage($base64)
    {
        if (!$base64) return null;

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $filename = 'lokalis/' . Str::uuid() . '.jpg';

        Storage::disk('public')->put($filename, $data);
        return $filename;
    }
}
