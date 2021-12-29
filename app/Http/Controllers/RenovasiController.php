<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Renov;
use App\Models\DaftarGambarRenovasi;
use Yajra\Datatables\Datatables;

class RenovasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-folder.renovasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        function RemoveSpecialChar($str) {
            $res = str_replace( array( '.' ), '', $str);

            return $res;
        }

        $harga = RemoveSpecialChar($request->harga);

        $file_gambar_utama = $request->gambar_utama;
        $fileName_gambarUtama = time().'_'.$file_gambar_utama->getClientOriginalName();
        $file_gambar_utama->move(public_path('storage/gambar-renovasi'), $fileName_gambarUtama);
        
        $daftarrenovasi = Renov::create([
            'nama_item' => $request->nama_item,
            'deskripsi_item' => $request->deskripsi,
            'gambar_item' => $fileName_gambarUtama,
            'harga_item' => $harga
        ]);

        $gambar = $request->gambar_item;
        foreach ($gambar as $key => $value) {
            $file_gambar_item = $value;
            $fileName_gambarItem = time().'_'.$file_gambar_item->getClientOriginalName();
            $file_gambar_item->move(public_path('storage/gambar-renovasi'), $fileName_gambarItem);
            // echo $value;

            $datagambar = DaftarGambarRenovasi::create([
                'id_renovasi' => $daftarrenovasi->id,
                'gambar' => $fileName_gambarItem
            ]);
        }

        return redirect()->back()->with('success', 'Item renovasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_renovasi(Request $request)
    {
        $datapemesanan = Renov::select('renov.*');
        
        $datatables = Datatables::of($datapemesanan);
        if ($request->get('search')['value']) {
            $datatables->filter(function ($query) {
                    $keyword = request()->get('search')['value'];
                    $query->where('nama_item', 'like', "%" . $keyword . "%");
        });}
        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('renov.updated_at', $order);
        });
        return $datatables->addIndexColumn()->escapeColumns([])
        ->addColumn('action','admin-folder.renovasi.action')
        ->addColumn('lihat','admin-folder.renovasi.lihat')
        ->addColumn('deskripsi','admin-folder.renovasi.deskripsi')
        ->toJson();
    }

    public function get_gambar_renovasi($id)
    {
        $daftargambar = DaftarGambarRenovasi::where('id_renovasi', $id)->get();
        return view('admin-folder.renovasi.daftar-gambar', compact('daftargambar'));
    }
}
