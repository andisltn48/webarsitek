<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\DaftarDesain;
use App\Models\DaftarGambarDesain;
use App\Models\DaftarGambarRenovasi;
use App\Models\Progress;
use App\Models\Misi;
use App\Models\Revisi;
use App\Models\Media;
use App\Models\Informasi;
use App\Models\Visi;
use App\Models\Renov;
use App\Models\KartRenov;
use Yajra\Datatables\Datatables;
use App\Models\DataPemesanan;
use App\Models\DataPemesananRenovasi;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function generateNoPemesanan()
    {
        do {
            $nopemesanan = random_int(100000, 999999);
        } while (DataPemesanan::where("no_pemesanan", $nopemesanan)->first());

        return $nopemesanan;
    }

    public function index(Request $request)
    { 
        $pembayaran = [
            'BNI' => 'BNI - 1111000000',
            'BRI' => 'BRI - 1111111111',
            'Mandiri' => 'Mandiri - 111222211'
        ]; 

        $datapemesanan = DataPemesanan::where('id_pemesan', Auth::user()->id)->where('status_pengerjaan', 'Dalam Pengerjaan')->first();
        if ($datapemesanan) {
            $daftarrevisi = Revisi::where('id_pesanan', $datapemesanan->id)->where('revisi_tahap', 'Tahap 1')->get();
            $daftarrevisi2 = Revisi::where('id_pesanan', $datapemesanan->id)->where('revisi_tahap', 'Tahap 2')->get();
        } else {
            $daftarrevisi = NULL;
            $daftarrevisi2 = NULL;
        }
        
        $progress_desain_tahap1 = Progress::where('id_pemesan', Auth::user()->id)->where('tipe_progress', 'Progress Desain')->where('tahap', 'Tahap 1')->get();
        $progress_desain_tahap2 = Progress::where('id_pemesan', Auth::user()->id)->where('tipe_progress', 'Progress Desain')->where('tahap', 'Tahap 2')->get();
        $progress_desain_tahap3 = Progress::where('id_pemesan', Auth::user()->id)->where('tipe_progress', 'Progress Desain')->where('tahap', 'Tahap 3')->get();
        $progress_pengerjaan = Progress::where('id_pemesan', Auth::user()->id)->where('tipe_progress', 'Progress Pengerjaan')->get();
        // dd($progress_pengerjaan);
        return view('user-folder.index', compact('progress_desain_tahap1', 
        'progress_desain_tahap2',
        'progress_desain_tahap3',
        'progress_pengerjaan',
        'daftarrevisi',
        'daftarrevisi2',
        'pembayaran',
        'datapemesanan',));
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
        function RemoveSpecialChar($str)
        {
            $res = str_replace(array('.'), '', $str);

            
            return preg_replace('~\D~', '', $res);
        }

        $datapemesanan = DataPemesanan::where('id_pemesan', Auth::user()->id)->where('status_pengerjaan', 'Dalam Pengerjaan')->orWhere('status_pengerjaan', 'Belum Dikonfirmasi')->first();
        if ($datapemesanan) {
            
            return redirect()->back()->with('error', 'Tidak bisa melakukan pemesanan karena anda masih memiliki pesanan yang belum selesai');
        } else {
            $file_bukti_pembayaran = $request->buktipembayaran;
            $fileName_bukti_pembayaran = time() . '_' . $file_bukti_pembayaran->getClientOriginalName();
            $file_bukti_pembayaran->move(public_path('storage/bukti-pembayaran'), $fileName_bukti_pembayaran);

            $validate = $request->validate([
                'kontak' => 'numeric'
            ]);
            $desain = DaftarDesain::where('id', $request->id_desain)->first();
            // dd(RemoveSpecialChar($desain->harga));
            $datapemesanan = DataPemesanan::create([
                'nama_pemesan' => Auth::user()->name,
                'id_pemesan' => Auth::user()->id,
                'alamat_pemesan' => $request->alamat,
                'kontak_pemesan' => $request->kontak,
                'nama_pesanan' => $desain->nama_desain,
                'id_pesanan' => $desain->id,
                'tipe_lantai' => $desain->tipe_lantai,
                'luas_bangunan' => $request->luas_bangunan,
                'harga_bayar' => RemoveSpecialChar($request->harga_bayar),
                'tahap' => 'Belum Dikonfirmasi',
                'total_harga_bayar' => RemoveSpecialChar($request->harga_bayar),
                'harga_pesanan' => RemoveSpecialChar($request->harga_desain),
                'pembayaran_via' => $request->pembayaran,
                'bukti_pembayaran' => $fileName_bukti_pembayaran,
                'status_pengerjaan' => 'Belum Dikonfirmasi',
                'no_pemesanan'  => $this->generateNoPemesanan(),
            ]); 

            session(['pembayaran_desain' => $datapemesanan]);
            return redirect()->back()->with('success', 'Berhasil melakukan pemesanan');
        }
        
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
        function RemoveSpecialChar($str)
        {
            $res = str_replace(array('.'), '', $str);

            
            return preg_replace('~\D~', '', $res);
        }

        // dd($request->to_tahap);
        if ($request->to_tahap == 'Tahap 2') {
            $tahap = 'To Tahap 2';
        } elseif ($request->to_tahap == 'Tahap 3'){
            $tahap = 'To Tahap 3';
        }
        $file_bukti_pembayaran = $request->buktipembayaran;
        $fileName_bukti_pembayaran = time() . '_' . $file_bukti_pembayaran->getClientOriginalName();
        $file_bukti_pembayaran->move(public_path('storage/bukti-pembayaran'), $fileName_bukti_pembayaran);

        $datapemesanan = DataPemesanan::where('id', $id)->first();
        $data = RemoveSpecialChar($datapemesanan->total_harga_bayar) + RemoveSpecialChar($request->harga_bayar);
        $datapemesanan->update([
            'tahap' => $tahap,
            'harga_bayar' => RemoveSpecialChar($request->harga_bayar),
            'total_harga_bayar' => $data,
            'bukti_pembayaran' => $fileName_bukti_pembayaran,
        ]);

        session(['pembayaran_desain' => $datapemesanan]);
        return redirect()->back()->with('success', 'Berhasil melakukan pembayaran');
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

    public function company_profile()
    {
        $visi = Visi::all();
        $misi = Misi::all();
        return view('user-folder.company-profile', compact('visi', 'misi'));
    }

    public function design_index()
    {
        $daftargambar1 = DaftarDesain::where('tipe_lantai', '1 Lantai')
        ->leftJoin('daftar_gambar_desain', function ($join) {
            $join->on('daftar_gambar_desain.id_desain', '=', 'daftar_desain.id')
                ->where('daftar_gambar_desain.id', '=', \DB::raw('(SELECT id FROM daftar_gambar_desain WHERE daftar_gambar_desain.id_desain = daftar_desain.id LIMIT 1)'));
        })->select('daftar_desain.*', 'daftar_gambar_desain.gambar')->get();

        $daftargambar2 = DaftarDesain::where('tipe_lantai', '2 Lantai')
            ->leftJoin('daftar_gambar_desain', function ($join) {
                $join->on('daftar_gambar_desain.id_desain', '=', 'daftar_desain.id')
                    ->where('daftar_gambar_desain.id', '=', \DB::raw('(SELECT id FROM daftar_gambar_desain WHERE daftar_gambar_desain.id_desain = daftar_desain.id LIMIT 1)'));
            })->select('daftar_desain.*', 'daftar_gambar_desain.gambar')->get();
            
        $daftargambar3 = DaftarDesain::where('tipe_lantai', '3 Lantai')
            ->leftJoin('daftar_gambar_desain', function ($join) {
                $join->on('daftar_gambar_desain.id_desain', '=', 'daftar_desain.id')
                    ->where('daftar_gambar_desain.id', '=', \DB::raw('(SELECT id FROM daftar_gambar_desain WHERE daftar_gambar_desain.id_desain = daftar_desain.id LIMIT 1)'));
            })->select('daftar_desain.*', 'daftar_gambar_desain.gambar')->get();

        return view('user-folder.design-index', compact('daftargambar1', 'daftargambar2', 'daftargambar3'));
    }

    public function renovasi()
    {
        function RemoveSpecialChar($str)
        {
            $res = str_replace(array('.'), '', $str);

            
            return preg_replace('~\D~', '', $res);
        }

        $pembayaran = [
            'BNI' => 'BNI - 1111000000',
            'BRI' => 'BRI - 1111111111',
            'Mandiri' => 'Mandiri - 111222211'
        ];

        $datakeranjang = KartRenov::where('id_pemesan', Auth::user()->id)->get();

        $totalharga = 0;

        foreach ($datakeranjang as $key => $value) {
            $totalharga+= RemoveSpecialChar($value->harga_item);
        }

        $hargatotal = strrev(implode('.', str_split(strrev(strval($totalharga)), 3)));

        $daftarrenovasi = Renov::leftJoin('daftar_gambar_renovasi', function ($join) {
            $join->on('daftar_gambar_renovasi.id_renovasi', '=', 'renov.id')
                ->where('daftar_gambar_renovasi.id', '=', \DB::raw('(SELECT id FROM daftar_gambar_renovasi WHERE daftar_gambar_renovasi.id_renovasi = renov.id LIMIT 1)'));
        })->select('renov.*', 'daftar_gambar_renovasi.gambar')->get();

        return view('user-folder.renovasi', compact('daftarrenovasi', 'pembayaran', 'hargatotal'));
    }

    public function detail_design(Request $request, $id)
    {
        $pembayaran = [
            'BNI' => 'BNI - 1111000000',
            'BRI' => 'BRI - 1111111111',
            'Mandiri' => 'Mandiri - 111222211'
        ];
        // dd($id);
        $detaildesain = DaftarDesain::where('id', $id)->first();
        $daftargambar = DaftarGambarDesain::where('id_desain', $id)->get();
        return view('user-folder.detail-design', compact('detaildesain', 'pembayaran', 'daftargambar'));
    }

    public function detail_item_renovasi(Request $request, $id)
    {
        $pembayaran = [
            'BNI' => 'BNI - 1111000000',
            'BRI' => 'BRI - 1111111111',
            'Mandiri' => 'Mandiri - 111222211'
        ];
        // dd($id);
        $detailitem = Renov::where('id', $id)->first();
        $daftargambar = DaftarGambarRenovasi::where('id_renovasi', $id)->get();
        return view('user-folder.detail-item-renovasi', compact('detailitem', 'pembayaran', 'daftargambar'));
    }

    public function media()
    {
        $allmedia = Media::all();
        return view('user-folder.media', compact('allmedia'));
    }

    public function informasi()
    {
        $informasi = Informasi::all();
        return view('user-folder.informasi', compact('informasi'));
    }

    public function get_pesanan(Request $request)
    {
        

        $datapemesanan = DataPemesanan::where('id_pemesan', Auth::user()->id);
        
        $datatables = Datatables::of($datapemesanan);

        $datatables->orderColumn('created_at', function ($query, $order) {
            $query->orderBy('data_pemesanan.created_at', $order);
        });
        return $datatables->addIndexColumn()->escapeColumns([])
        ->toJson();
    }

    public function get_pesanan_renovasi(Request $request)
    {
        function convert($harga)
        {
            return strrev(implode('.', str_split(strrev(strval($harga)), 3)));
        };

        $datapemesanan = DataPemesananRenovasi::where('id_pemesan', Auth::user()->id);
        
        $datatables = Datatables::of($datapemesanan);

        $datatables->orderColumn('created_at', function ($query, $order) {
            $query->orderBy('data_pemesanan_renovasi.created_at', $order);
        });
        return $datatables->addIndexColumn()->escapeColumns([])
        ->addColumn('deskripsi','user-folder.deskripsi-item-renovasi')
        ->toJson();
    }

    public function store_item_to_kart(Request $request)
    {
        function RemoveSpecialChar($str)
        {
            $res = str_replace(array('.'), '', $str);

            
            return preg_replace('~\D~', '', $res);
        }
        // dd(RemoveSpecialChar($desain->harga));
        $datarenov = Renov::where('id', $request->id_renovasi)->first();
        $datapemesanan = KartRenov::create([
            'nama_item' => $datarenov->nama_item,
            'harga_item' => RemoveSpecialChar($request->harga_desain),
            'luas_bangunan' => $request->luas_bangunan,
            'id_item' => $datarenov->id,
            'id_pemesan' => Auth::user()->id
        ]);

        return redirect(route('user.renovasi'))->with('success', 'Berhasil memesan item');
    }

    public function get_kart_item()
    {
        function convert($harga)
        {
            return strrev(implode('.', str_split(strrev(strval($harga)), 3)));
        };

        $datapemesanan = KartRenov::where('id_pemesan', Auth::user()->id);
        
        $datatables = Datatables::of($datapemesanan);

        $datatables->orderColumn('created_at', function ($query, $order) {
            $query->orderBy('data_kart_renov.created_at', $order);
        });
        return $datatables->addIndexColumn()->escapeColumns([])
        ->addColumn('action','user-folder.action-item-cart')
        ->toJson();
    }

    public function destroy_cart_item($id)
    {
        $datapemesanan = KartRenov::find($id);
        $datapemesanan->delete();

        return redirect(route('user.renovasi'))->with('success', 'Berhasil menghapus item');
    }

    public function store_pemesanan_renovasi(Request $request)
    {
        $nopemesanan = $this->generateNoPemesanan();

        function RemoveSpecialChar($str)
        {
            $res = str_replace(array('.'), '', $str);

            
            return preg_replace('~\D~', '', $res);
        }

        $datapemesanan = KartRenov::where('id_pemesan', Auth::user()->id)->get();
        
        $file_bukti_pembayaran = $request->buktipembayaran;
        $fileName_bukti_pembayaran = time() . '_' . $file_bukti_pembayaran->getClientOriginalName();
        $file_bukti_pembayaran->move(public_path('storage/bukti-pembayaran'), $fileName_bukti_pembayaran);

        // dd(RemoveSpecialChar($desain->harga));
        $array = [];
        $totalharga = 0;
        foreach ($datapemesanan as $key => $value) {
            
            array_push($array, [
                'id_item' => $value->id,
                'nama_item' => $value->nama_item,
                'luas_bangunan' => $value->luas_bangunan,
                'harga_item' => $value->harga_item,
            ]);

            $totalharga+=RemoveSpecialChar($value->harga_item);
            $value->delete();
        }
        // dd($array);

        $data = DataPemesananRenovasi::create([
    
            'nama_pemesan' => Auth::user()->name,
            'id_pemesan' => Auth::user()->id,
            'alamat_pemesan' => $request->alamat,
            'kontak_pemesan' => $request->kontak,
            'deskripsi_item' => $array,
            'total_harga' => $totalharga,
            'pembayaran_via' => $request->pembayaran,
            'bukti_pembayaran' => $fileName_bukti_pembayaran,
            'status_pengerjaan' => 'Belum Dikonfirmasi',
            'no_pemesanan' => $nopemesanan,
        ]);

        
        // setcookie('my_cookie', 'download complete', time() + 86400, "/");
        session(['pembayaran_renovasi' => $data]);

        // dd(session('pembayaran_renovasi')->getOriginal());
        
        return redirect(route('user.renovasi'))->with('success', 'Berhasil melakukan pembayaran');
    }

    public function get_progress_renovasi(Type $var = null)
    {
        $progress_renovasi = Progress::where('id_pemesan', Auth::user()->id)->where('tipe_progress', 'Progress Renovasi')->get();
        // dd($progress_pengerjaan);
        return view('user-folder.progress-renov', compact('progress_renovasi'));
    }

    public function download_pembayaran_renovasi(Request $request)
    {
        $data = session('pembayaran_renovasi');
        $pdf = PDF::loadView('user-folder.pdf-pembayaran', compact('data'));
        return $pdf->download('pembayaran-renovasi.pdf');
    }

    public function download_pembayaran_desain(Request $request)
    {
        
        $data = session('pembayaran_desain');
        $pdf = PDF::loadView('user-folder.pdf-pembayaran-desain', compact('data'));
        session(['pembayaran_desain' => NULL]);
        return $pdf->download('pembayaran-desain.pdf');
    }

    public function upload_revisi(Request $request)
    {
        $datapemesanan = DataPemesanan::where('id_pemesan', Auth::user()->id)->where('status_pengerjaan', 'Dalam Pengerjaan')->first();

        $revisi = Revisi::where('id_pesanan',  $datapemesanan->id)->get();
        if (count($revisi) >= 3) {
            return redirect()->back()->with('error', 'Anda hanya bisa melakukan revisi sebanyak 3x!');
        }
        $revisi = Revisi::create([
            "id_pemesan" => Auth::user()->id,
            "id_pesanan" => $datapemesanan->id,
            "revisi" => $request->revisi,
            "revisi_tahap" => $datapemesanan->tahap,
            "status_revisi" => 'Belum Selesai',
        ]);

        return redirect()->back()->with('success', 'Berhasil mengirim revisi');
    }

    public function hapus_revisi($revisi_id)
    {
        $revisi = Revisi::find($revisi_id);
        $revisi->delete();

        return redirect()->back();
    }

    public function done_revisi($revisi_id)
    {
        $revisi = Revisi::find($revisi_id);
        $revisi->update([
            'status_revisi' => 'Selesai'
        ]);

        return redirect()->back();
    }

    public function done_confirm()
    {
        $datapemesanan = DataPemesanan::where('id_pemesan',Auth::user()->id)->where('status_pengerjaan', 'Dalam Pengerjaan')->first();
        $datapemesanan->update([
            'tahap' => 'to Selesai'
        ]);

        return redirect()->back();
    }
}
