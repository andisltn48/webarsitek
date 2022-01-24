<?php

namespace App\Http\Controllers;

use App\Models\DataPemesanan;
use App\Models\DataPemesananRenovasi;
use App\Models\Progress;
use App\Models\Revisi;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jumlah_pesanan = DataPemesanan::all()->count();
        $jumlah_pengguna = User::where('role_id', '2')->get()->count();
        $onprogress = DataPemesanan::where('status_pengerjaan', 'Dalam Pengerjaan')->get()->count();
        $selesai = DataPemesanan::where('status_pengerjaan', 'Selesai Dikerjakan')->get()->count(); 
        $daftarrevisi = Revisi::where('revisi_tahap', 'Tahap 1')->get();
        $daftarrevisi2 = Revisi::where('revisi_tahap', 'Tahap 2')->get();
        return view('admin-folder.pesanan.index', compact('daftarrevisi','daftarrevisi2','jumlah_pesanan', 'jumlah_pengguna', 'onprogress', 'selesai'));
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
        //
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
        $pesanan = DataPemesanan::where('id', $id)->first();
        if ($pesanan) {
            $pesanan->delete();
        }

        return redirect()->back()->with('success', 'Data pesanan berhasil dihapus');
    }

    public function reject_renovasi($id)
    {
        $pesanan = DataPemesananRenovasi::where('id', $id)->first();
        if ($pesanan) {
            $pesanan->delete();
        }

        return redirect()->back()->with('success', 'Data pesanan berhasil dihapus');
    }

    public function get_pesanan(Request $request)
    {
        function convert($harga)
        {
            return strrev(implode('.', str_split(strrev(strval($harga)), 3)));
        };

        $datapemesanan = DataPemesanan::select('data_pemesanan.*');

        if ($request->input('status') != null) {
            $datapemesanan = $datapemesanan->where('status_pengerjaan', $request->status);
        }

        if (session('role') == 'Arsitek') {
            $datapemesanan = $datapemesanan->where('status_pengerjaan', "Dalam Pengerjaan");
        }

        $daftarrevisi = Revisi::where('revisi_tahap', 'Tahap 1')->get();
        $daftarrevisi2 = Revisi::where('revisi_tahap', 'Tahap 2')->get();

        $datatables = Datatables::of($datapemesanan);

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('data_pemesanan.updated_at', $order);
        });
        return $datatables->addIndexColumn()->escapeColumns([])
        ->addColumn('action','admin-folder.pesanan.action')
        ->addColumn('daftar_revisi','admin-folder.pesanan.daftar-revisi')
        ->addColumn('bukti_pembayaran','admin-folder.pesanan.lihat-bukti')
        ->toJson();
    }

    public function store_progress(Request $request, $id)
    {
        foreach ($request->gambar_progress as $key => $value) {

            $file_progress = $value;
            $fileName_progress = time() . '_' . $file_progress->getClientOriginalName();
            $file_progress->move(public_path('storage/progress'), $fileName_progress);
        
            $pemesanan =  DataPemesanan::find($request->id_pesanan);
            $store = Progress::create([
                'id_pemesan' => $id,
                'id_pesanan' => $request->id_pesanan,
                'progress' => $fileName_progress,
                'tipe_progress' => $request->tipe_progress,
                'judul' => $request->judul,
                'tahap' => $pemesanan->tahap,
                'deskripsi' => $request->deskripsi
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil update progress');
    }

    public function confirm($id)
    {
        $datapemesanan = DataPemesanan::where('id', $id)->first();
        $datapemesanan->update([
            'tahap' => 'Tahap 1',
            'status_pengerjaan' => 'Dalam Pengerjaan'
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi');
    }

    public function to_tahap_dua($id)
    {
        $datapemesanan = DataPemesanan::where('id', $id)->first();
        $datapemesanan->update([
            'tahap' => 'Tahap 2',
        ]);

        return redirect()->back()->with('success', 'Berhasil ke tahap 2');        
    }

    public function to_tahap_tiga($id)
    {
        $datapemesanan = DataPemesanan::where('id', $id)->first();
        $datapemesanan->update([
            'tahap' => 'Tahap 3',
        ]);
        
        return redirect()->back()->with('success', 'Berhasil ke tahap 3'); 
    }

    public function confirm_renovasi($id)
    {
        $datapemesanan = DataPemesananRenovasi::where('id', $id)->first();
        $datapemesanan->update([
            'status_pengerjaan' => 'Dalam Pengerjaan'
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi');
    }

    public function done($id)
    {
        $datapemesanan = DataPemesanan::where('id', $id)->first();
        $datapemesanan->update([
            'tahap' =>  'Selesai',
            'status_pengerjaan' => 'Selesai Dikerjakan'
        ]);

        $progress = Progress::where('id_pesanan', $id)->get();
        foreach ($progress as $key => $value) {
            if(\File::exists(public_path('storage/progress/'.$value->progress))){
                \File::delete(public_path('storage/progress/'.$value->progress));
            }
            $value->delete();
        }

        $revisi= Revisi::where('id_pesanan', $id)->get();
        foreach ($revisi as $key => $value) {
            $value->delete();
        }

        return redirect()->back()->with('success', 'Pesanan selesai dikerjakan');
    }

    public function done_renovasi($id)
    {
        $datapemesanan = DataPemesananRenovasi::where('id', $id)->first();
        $datapemesanan->update([
            'status_pengerjaan' => 'Selesai Dikerjakan'
        ]);

        $progress = Progress::where('id_pesanan', $id)->where('tipe_progress', 'Progress Renovasi')->get();
        foreach ($progress as $key => $value) {
            if(\File::exists(public_path('storage/progress/'.$value->progress))){
                \File::delete(public_path('storage/progress/'.$value->progress));
            }
            $value->delete();
        }

        return redirect()->back()->with('success', 'Pesanan selesai dikerjakan');
    }

    public function index_renovasi()
    {
        return view('admin-folder.pesanan-renovasi.index');
    }

    public function get_pesanan_renovasi(Request $request)
    {

        $datapemesanan = DataPemesananRenovasi::select('data_pemesanan_renovasi.*');

        if ($request->input('status') != null) {
            $datapemesanan = $datapemesanan->where('tahap', $request->status);
        }

        if (session('role') == 'Renovator') {
            $datapemesanan = $datapemesanan->where('status_pengerjaan', "Dalam Pengerjaan");
        }
        
        $datatables = Datatables::of($datapemesanan);

        $datatables->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('data_pemesanan_renovasi.updated_at', $order);
        });
        return $datatables->addIndexColumn()->escapeColumns([])
        ->addColumn('action','admin-folder.pesanan-renovasi.action')
        ->addColumn('deskripsi','admin-folder.pesanan-renovasi.deskripsi-item-renovasi')
        ->addColumn('bukti_pembayaran','admin-folder.pesanan-renovasi.lihat-bukti')
        ->toJson();
    }
}
