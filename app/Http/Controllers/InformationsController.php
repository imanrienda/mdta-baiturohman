<?php

namespace App\Http\Controllers;

use App\Information;
use Illuminate\Http\Request;

class InformationsController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================
    public function index()
    {
        return view('pengumuman.index');
    }

    // =========================================================
    // CREATE
    // =========================================================
    public function create()
    {
        return view('pengumuman.create');
    }

    // =========================================================
    // STORE
    // =========================================================
    public function store(Request $request)
    {
        $request->validate(
            [
                'judul'  => 'required',
                'konten' => 'required',
            ],
            [
                'required' => ':attribute wajib diisi',
            ]
        );

        Information::create([
            'judul'   => $request->judul,
            'konten'  => $request->konten,
            'publish' => $request->has('publish') ? 1 : 0,
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/informations')
            ->with('status', 'Data pengumuman berhasil ditambah!');
    }

    // =========================================================
    // SHOW
    // =========================================================
    public function show(Information $information)
    {
        return view('pengumuman.show', compact('information'));
    }

    // =========================================================
    // EDIT
    // =========================================================
    public function edit(Information $information)
    {
        return view('pengumuman.edit', compact('information'));
    }

    // =========================================================
    // UPDATE
    // =========================================================
    public function update(Request $request, Information $information)
    {
        $request->validate(
            [
                'judul'  => 'required',
                'konten' => 'required',
            ],
            [
                'required' => ':attribute wajib diisi',
            ]
        );

        $information->update([
            'judul'   => $request->judul,
            'konten'  => $request->konten,
            'publish' => $request->has('publish') ? 1 : 0,
        ]);

        return redirect('/informations')
            ->with('status', 'Data pengumuman berhasil diubah!');
    }

    // =========================================================
    // DELETE
    // =========================================================
    public function destroy(Information $information)
    {
        $information->delete();

        return redirect('/informations')
            ->with('status', 'Data pengumuman berhasil dihapus!');
    }

    // =========================================================
    // DATATABLE
    // =========================================================
    public function getdatainformation()
    {
        $informations = Information::select('informations.*');

        return \DataTables::eloquent($informations)

            ->addIndexColumn()

            ->orderColumn('DT_RowIndex', function ($query, $order) {
                $query->orderBy('informations.id', $order);
            })

            ->addColumn('konten', function ($info) {
                return \Str::limit(strip_tags($info->konten), 50);
            })

            ->addColumn('publish', function ($info) {
                return $info->publish == 1
                    ? 'Publish'
                    : 'Tidak Publish';
            })

            ->addColumn('aksi', function ($info) {

                $button = '
                    <a href="/informations/' . $info->id . '" class="btn btn-info btn-sm">
                        Lihat
                    </a>

                    <a href="/informations/' . $info->id . '/edit" class="btn btn-warning btn-sm">
                        Edit
                    </a>
                ';

                // hanya pemilik pengumuman yang bisa hapus
                if ($info->user_id == auth()->user()->id) {

                    $button .= '
                        <form action="/informations/' . $info->id . '" method="POST" class="d-inline delete">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">

                            <button type="submit" class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    ';
                }

                return $button;
            })

            ->rawColumns(['aksi'])

            ->toJson();
    }
}