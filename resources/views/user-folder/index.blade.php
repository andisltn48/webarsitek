<x-app-layout title="Home">

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="text-end">
                <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="alert-body">
                {{ session('error') }}
            </div>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="text-end">
                <button type="button" class="btn close btn-closed" data-dismiss="alert" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="alert-body">
                {{ session('success') }}
            </div>
            @if (session('pembayaran_desain') != null)
                <hr>
                <div class="d-flex mt-2">
                    <p class="col fw-bold">Download bukti pembayaran</p>
                    <a class="btn btn-primary col" href="{{ route('pembayaran.download-pdf-desain') }}">Download
                        PDF</a>
                </div>
            @endif
        </div>
    @endif

    <div class="button mb-4">
        <a data-toggle="modal" data-target="#modal-daftar-pesanan" href="" class="btn btn-primary"
            style="border-radius: 2rem">Lihat pesanan</a>
    </div>
    <div class="text-center fs-4 fw-bold">Progress Desain</div>

    <hr class="mt-2" size="5" style="width:15%;margin:auto;color:#303296">

    {{-- <div class="tab_user">
        <button class="tablinks active" onclick="openDesign(event, 'Desain')">Progress Desain</button>
        {{-- <button class="tablinks" onclick="openDesign(event, 'Pengerjaan')">Progress Pengerjaan</button> --}}
    {{-- </div> --}}
    {{-- <img src="{{ asset('images/carouseimage.jpg') }}" alt=""> --}}




    @if ($datapemesanan)
        <div id="Desain" class="mt-4 tabcontent active">
            <div class="tab_user mb-3">
                @if ($datapemesanan->tahap == 'Tahap 1' || $datapemesanan->tahap == 'To Tahap 2')
                    <button class="tabtahap active" onclick="openTahap(event, 'divtahap1')">Tahap 1</button>
                    <button class="tabtahap" onclick="openTahap(event, 'divtahap2')"
                        title="Tidak dapat memilih tahap">Tahap 2</button>
                    <button class="tabtahap" onclick="openTahap(event, 'divtahap3')"
                        title="Tidak dapat memilih tahap">Tahap 3</button>
                @elseif($datapemesanan->tahap == 'Tahap 2' || $datapemesanan->tahap == 'To Tahap 3')
                    <button class="tabtahap " title="Tidak dapat memilih tahap"
                        onclick="openTahap(event, 'divtahap1')">Tahap 1</button>
                    <button class="tabtahap active" onclick="openTahap(event, 'divtahap2')">Tahap 2</button>
                    <button class="tabtahap" onclick="openTahap(event, 'divtahap3')"
                        title="Tidak dapat memilih tahap">Tahap 3</button>
                @elseif($datapemesanan->tahap == 'Tahap 3')
                    <button class="tabtahap " title="Tidak dapat memilih tahap"
                        onclick="openTahap(event, 'divtahap1')">Tahap 1</button>
                    <button class="tabtahap" onclick="openTahap(event, 'divtahap2')">Tahap 2</button>
                    <button class="tabtahap active" onclick="openTahap(event, 'divtahap3')"
                        title="Tidak dapat memilih tahap">Tahap 3</button>
                @endif
            </div>
            @if ($datapemesanan->tahap == 'Tahap 1' || $datapemesanan->tahap == 'To Tahap 2')
                <div id="divtahap1" class="tahap active">
                @else
                    <div id="divtahap1" class="tahap">
            @endif
            @if (count($progress_desain_tahap1) == 0)
                <div class="text-center mt-5">
                    <h1 class="fw-bolder">Belum ada Progres :(</h1>
                </div>
            @else
                <div class="owl-carousel owl-theme" id="home-carousel">
                    @foreach ($progress_desain_tahap1 as $item)
                        <a class="modal-image" href="" data-target="#modal-image-pop" data-toggle="modal"
                            data-link="{{ asset('storage/progress/' . $item->progress) }}"
                            data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}">
                            <img class="card-img-top img-progress"
                                src="{{ asset('storage/progress/' . $item->progress) }}" alt="">
                        </a>
                    @endforeach
                </div>

                <div class="text-center p-3">
                    @if ($datapemesanan->tahap == 'Tahap 1')
                        <button class="btn btn-primary m-2" data-target="#modal-revisi"
                            data-toggle="modal">Revisi</button>
                        <button class="btn btn-primary m-2 modal-setuju"
                            data-harga="{{ $datapemesanan->harga_pesanan }}" data-target="#modal-pesan-tahap2"
                            data-toggle="modal">Setujui</button>
                        <button class="btn btn-primary m-2" data-target="#modal-daftar-revisi"
                            data-toggle="modal">Daftar
                            Revisi</button>
                    @else
                        <button class="btn btn-primary m-2" data-target="#modal-daftar-revisi"
                            data-toggle="modal">Daftar
                            Revisi</button>
                    @endif
                </div>
            @endif

        </div>
        @if ($datapemesanan->tahap == 'Tahap 2' || $datapemesanan->tahap == 'To Tahap 3')
            <div id="divtahap2" class="tahap active">
            @else
                <div id="divtahap2" class="tahap">
        @endif
        @if (count($progress_desain_tahap2) == 0)
            <div class="text-center mt-5">
                <h1 class="fw-bolder">Belum ada Progres :(</h1>
            </div>
        @else
            <div class="owl-carousel owl-theme" id="home3-carousel">
                @foreach ($progress_desain_tahap2 as $item)
                    <a class="modal-image" href="" data-target="#modal-image-pop" data-toggle="modal"
                        data-link="{{ asset('storage/progress/' . $item->progress) }}"
                        data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}">
                        <img class="card-img-top img-progress"
                            src="{{ asset('storage/progress/' . $item->progress) }}" alt="">
                    </a>
                @endforeach
            </div>

            <div class="text-center p-3">
                @if ($datapemesanan->tahap == 'Tahap 2')
                    <button class="btn btn-primary m-2" data-target="#modal-revisi" data-toggle="modal">Revisi</button>
                    <button class="btn btn-primary m-2 modal-setuju_tahap2"
                        data-harga="{{ $datapemesanan->harga_pesanan }}" data-target="#modal-pesan-tahap3"
                        data-toggle="modal">Setujui</button>
                    <button class="btn btn-primary m-2" data-target="#modal-daftar-revisi2" data-toggle="modal">Daftar
                        Revisi</button>
                @else
                    <button class="btn btn-primary m-2" data-target="#modal-daftar-revisi2" data-toggle="modal">Daftar
                        Revisi</button>
                @endif
            </div>
        @endif

        </div>
        @if ($datapemesanan->tahap == 'Tahap 3' || $datapemesanan->tahap == 'to Selesai')
            <div id="divtahap3" class="tahap active">
            @else
                <div id="divtahap3" class="tahap">
        @endif
        @if (count($progress_desain_tahap3) == 0)
            <div class="text-center mt-5">
                <h1 class="fw-bolder">Belum ada Progres :(</h1>
            </div>
        @else
            <div class="owl-carousel owl-theme" id="home4-carousel">
                @foreach ($progress_desain_tahap3 as $item)
                    <a class="modal-image" href="" data-target="#modal-image-pop" data-toggle="modal"
                        data-link="{{ asset('storage/progress/' . $item->progress) }}"
                        data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}">
                        <img class="card-img-top img-progress"
                            src="{{ asset('storage/progress/' . $item->progress) }}" alt="">
                    </a>
                @endforeach
            </div>

            <div class="text-center p-3">
                @if ($datapemesanan->rab != null)
                    <a href="{{ route('user.download-rab', $datapemesanan->rab) }} " class="btn btn-primary">Download
                        RAB</a>
                @endif
                @if ($datapemesanan->tahap == 'Tahap 3')
                    {{-- href="{{ route('user.done-confirm') }}" --}}
                    <a data-target="#modal-terima-desain" data-toggle="modal" class="btn btn-primary">Terima</a>
                @endif
            </div>
        @endif

        </div>
        </div>
        <div id="Pengerjaan" class="mt-4 tabcontent">
            @if (count($progress_pengerjaan) == 0)
                <div class="text-center mt-5">
                    <h1 class="fw-bolder">Belum ada Progres :(</h1>
                </div>
            @else
                <div class="owl-carousel owl-theme" id="home2-carousel">
                    @foreach ($progress_pengerjaan as $item)
                        <a class="modal-image" href="" data-target="#modal-image-pop" data-toggle="modal"
                            data-link="{{ asset('storage/progress/' . $item->progress) }}"
                            data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}">
                            <img class="card-img-top img-progress"
                                src="{{ asset('storage/progress/' . $item->progress) }}" alt="">
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div id="modal-image-pop" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog">
                <!-- konten modal-->
                <div class="modal-content">
                    <!-- heading modal -->
                    <div class="modal-header">
                        <h3 id="judul"></h3>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <!-- body modal -->

                    <div class="model-body p-4">
                        <img style="width: 100%; overflow: hidden !important" id="img-modal" alt="">
                        <h5 class="fw-bold mt-3">Deskripsi</h5>
                        <p id="deskripsi"></p>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-terima-desain" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog">
                <!-- konten modal-->
                <div class="modal-content">
                    <!-- heading modal -->
                    <div class="modal-header">
                        <h3 id=""></h3>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <!-- body modal -->

                    <div class="model-body p-4">
                        <form action="{{ route('user.done-confirm') }}" method="POST">
                            @csrf
                            <div class="mt-3">
                                <p>Nama Penerima<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <input id="example-penerima" name="penerima" required type="text" class="form-control"
                                    value="{{ $datapemesanan->nama_pemesan }}">
                            </div>
                            <div class="mt-3">
                                <p>Alamat<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <textarea name="alamat" class="form-control" id="example-alamat" rows="3"
                                    required>{{ $datapemesanan->alamat_pemesan }}</textarea>
                            </div>
                            <div class="mt-3">
                                <p>Whatsapp<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <input id="example-kontak" value="{{ $datapemesanan->kontak_pemesan }}" name="kontak"
                                    required type="number" class="form-control">
                            </div>
                            <div class="text-center">
    
                                <button type="submit" class="btn btn-primary mt-3">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-revisi" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog">
                <!-- konten modal-->
                <div class="modal-content">
                    <!-- heading modal -->
                    <div class="modal-header">
                        <h3 id="judul">Revisi</h3>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <!-- body modal -->

                    <div class="model-body p-4">
                        <form action="{{ route('user.upload-revisi') }}" method="POST">
                            @csrf
                            <textarea style="width: 100%; overflow: hidden !important" required name="revisi" id=""
                                cols="30" rows="10"></textarea>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-daftar-revisi" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog  modal-lg">
                <!-- konten modal-->
                <div class="modal-content">
                    <!-- heading modal -->
                    <div class="modal-header">
                        <h3 id="judul">Daftar Revisi</h3>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <!-- body modal -->

                    <div class="model-body p-4">
                        <ul>
                            @foreach ($daftarrevisi as $item)
                                <li>{{ $item->revisi }} | {{ $item->revisi_tahap }} |
                                    {{ $item->status_revisi }}
                                    @if ($item->status_revisi != 'Selesai')
                                        | <a href="{{ route('user.delete-revisi', $item->id) }}"
                                            class="text-danger">Hapus</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-daftar-revisi2" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog  modal-lg">
                <!-- konten modal-->
                <div class="modal-content">
                    <!-- heading modal -->
                    <div class="modal-header">
                        <h3 id="judul">Daftar Revisi</h3>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <!-- body modal -->

                    <div class="model-body p-4">
                        <ul>
                            @foreach ($daftarrevisi2 as $item)
                                <li>{{ $item->revisi }} | {{ $item->revisi_tahap }} |
                                    {{ $item->status_revisi }}
                                    @if ($item->status_revisi != 'Selesai')
                                        | <a href="{{ route('user.delete-revisi', $item->id) }}"
                                            class="text-danger">Hapus</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-pesan-tahap2" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- konten modal-->
                <div class="modal-content">
                    <!-- heading modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Lanjut ke tahap 2</h4>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <!-- body modal -->

                    <div class="model-body p-4">
                        <form action="{{ route('user.update', $datapemesanan->id) }}" method="POST" id="form-confirm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="text" name="id_desain" id="id-desain" hidden>
                            <div class="title">
                                <p>Luas Bangunan (m2)</p>
                            </div>
                            <div class="form-group">
                                <input id="luas-bangunan" value="{{ $datapemesanan->luas_bangunan }}" readonly
                                    name="luas_bangunan" type="number" class="form-control">
                            </div>
                            <div class="title">
                                <p>Nama Desain</p>
                            </div>
                            <div class="form-group">
                                <input id="nama-desain" value="{{ $datapemesanan->nama_pesanan }}" name="nama_desain"
                                    type="text" class="form-control" readonly>
                            </div>
                            <div class="title">
                                <p>Tipe Lantai</p>
                            </div>
                            <div class="form-group">
                                <input id="tipe-lantai" value="{{ $datapemesanan->tipe_lantai }}" name="tipe_lantai"
                                    type="text" class="form-control" readonly>
                            </div>
                            <div class="mt-3">
                                <p>Total Harga</p>
                            </div>
                            <div class="form-group">
                                <input id="harga-desain" value="{{ $datapemesanan->harga_pesanan }}"
                                    name="harga_desain" type="text" class="form-control" readonly>
                            </div>
                            <div class="mt-3">
                                <p>Total Harga Bayar</p>
                            </div>
                            <div class="form-group">
                                <input id="total-harga-desain" value="{{ $datapemesanan->total_harga_bayar }}"
                                    name="total_harga_bayar" type="text" class="form-control" readonly>
                            </div>
                            <div class="mt-3">
                                <p>Harga yang harus di bayar (40% Harga Total)</p>
                            </div>
                            <div class="form-group">
                                <input id="harga-bayar" name="harga_bayar" type="text" class="form-control" readonly>
                            </div>
                            <div class="mt-3">
                                <p>Pembayaran Via<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <select name="pembayaran" class="form-select" required>
                                    <option value="">Pilih</option>
                                    @foreach ($pembayaran as $key => $data)
                                        @if (Request::old('pembayaran') == $key)
                                            <option value="{{ $key }}" selected>{{ $data }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $data }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="exampleFormControlInput1">Bukti Pembayaran<sup
                                        class="text-danger">*</sup></label>
                                <div class="custom-file">
                                    <input accept="image/*" required class="form-control-file" name="buktipembayaran"
                                        type="file">
                                </div>
                            </div>
                            <div class="mt-3">
                                <p>Alamat<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1"
                                    rows="3" readonly>{{ $datapemesanan->alamat_pemesan }}</textarea>
                            </div>
                            <div class="mt-3">
                                <p>Whatsapp<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <input id="kontak" name="kontak" readonly
                                    value="{{ $datapemesanan->kontak_pemesan }}" type="number"
                                    class="form-control">
                            </div>

                            <input type="text" value="Tahap 2" name="to_tahap" hidden>
                            <div class="note mt-3">
                                {{-- <p class="text-disable">*Untuk jasa pengerjaan dan berikut bahan
                                bangunan silahkan konsultasi melalui <a href=""
                                    class="text-success"><u>Whatsapp</u></a> untuk menyesuaikan
                                jenis bahan yg dibutuhkan bedasarkan keinginan anda</p> --}}
                            </div>
                            <div class="mt-4 text-end">
                                <button style="border-radius: 2rem" class="btn me-1 btn-block btn-success"
                                    type="submit"><i class="f"></i>Pesan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-pesan-tahap3" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- konten modal-->
                <div class="modal-content">
                    <!-- heading modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Lanjut ke tahap 3</h4>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <!-- body modal -->

                    <div class="model-body p-4">
                        <form action="{{ route('user.update', $datapemesanan->id) }}" method="POST" id="form-confirm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="text" name="id_desain" id="id-desain" hidden>
                            <div class="title">
                                <p>Luas Bangunan (m2)</p>
                            </div>
                            <div class="form-group">
                                <input id="luas-bangunan" value="{{ $datapemesanan->luas_bangunan }}" readonly
                                    name="luas_bangunan" type="number" class="form-control">
                            </div>
                            <div class="title">
                                <p>Nama Desain</p>
                            </div>
                            <div class="form-group">
                                <input id="nama-desain" value="{{ $datapemesanan->nama_pesanan }}" name="nama_desain"
                                    type="text" class="form-control" readonly>
                            </div>
                            <div class="title">
                                <p>Tipe Lantai</p>
                            </div>
                            <div class="form-group">
                                <input id="tipe-lantai" value="{{ $datapemesanan->tipe_lantai }}" name="tipe_lantai"
                                    type="text" class="form-control" readonly>
                            </div>
                            <div class="mt-3">
                                <p>Total Harga</p>
                            </div>
                            <div class="form-group">
                                <input id="harga-desain" value="{{ $datapemesanan->harga_pesanan }}"
                                    name="harga_desain" type="text" class="form-control" readonly>
                            </div>
                            <div class="mt-3">
                                <p>Total Harga Bayar</p>
                            </div>
                            <div class="form-group">
                                <input id="total-harga-desain" value="{{ $datapemesanan->total_harga_bayar }}"
                                    name="total_harga_bayar" type="text" class="form-control" readonly>
                            </div>
                            <div class="mt-3">
                                <p>Harga yang harus di bayar (30% Harga Total)</p>
                            </div>
                            <div class="form-group">
                                <input id="harga-bayar-tahap3" name="harga_bayar" type="text" class="form-control"
                                    readonly>
                            </div>
                            <div class="mt-3">
                                <p>Pembayaran Via<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <select name="pembayaran" class="form-select" required>
                                    <option value="">Pilih</option>
                                    @foreach ($pembayaran as $key => $data)
                                        @if (Request::old('pembayaran') == $key)
                                            <option value="{{ $key }}" selected>{{ $data }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $data }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="exampleFormControlInput1">Bukti Pembayaran<sup
                                        class="text-danger">*</sup></label>
                                <div class="custom-file">
                                    <input accept="image/*" required class="form-control-file" name="buktipembayaran"
                                        type="file">
                                </div>
                            </div>
                            <div class="mt-3">
                                <p>Alamat<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1"
                                    rows="3" readonly>{{ $datapemesanan->alamat_pemesan }}</textarea>
                            </div>
                            <div class="mt-3">
                                <p>Whatsapp<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <input id="kontak" name="kontak" readonly
                                    value="{{ $datapemesanan->kontak_pemesan }}" type="number"
                                    class="form-control">
                            </div>

                            <input type="text" value="Tahap 3" name="to_tahap" hidden>
                            <div class="note mt-3">
                                {{-- <p class="text-disable">*Untuk jasa pengerjaan dan berikut bahan
                                bangunan silahkan konsultasi melalui <a href=""
                                    class="text-success"><u>Whatsapp</u></a> untuk menyesuaikan
                                jenis bahan yg dibutuhkan bedasarkan keinginan anda</p> --}}
                            </div>
                            <div class="mt-4 text-end">
                                <button style="border-radius: 2rem" class="btn me-1 btn-block btn-success"
                                    type="submit"><i class="f"></i>Pesan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="modal-daftar-pesanan" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <table id="tablePesananUser" class="table table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Pemesanan</th>
                                <th>Nama Desain</th>
                                <th>Tipe Lantai</th>
                                <th>Harga Total</th>
                                <th>Harga Bayar</th>
                                <th>Total Harga Bayar</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Tahap</th>
                                <th>Status Pesanan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.modal-setuju', function(event) {
            // return confirm($(this).data('tanggalSP2D'));
            var harga = $(this).data('harga');

            let currHarga = harga
            let hargaNow = currHarga.toString().split('.').join("");

            let hargaBayar = hargaNow * 40 / 100;
            hargaBayar = Math.ceil(hargaBayar)
            console.log(hargaBayar);
            $('#harga-bayar').attr('value', formatRupiah(hargaBayar));
            // console.log($('#img-modal'))
        });

        $(document).on('click', '.modal-setuju_tahap2', function(event) {
            // return confirm($(this).data('tanggalSP2D'));
            var harga = $(this).data('harga');

            let currHarga = harga
            let hargaNow = currHarga.toString().split('.').join("");

            let hargaBayar = hargaNow * 30 / 100;
            hargaBayar = Math.ceil(hargaBayar)
            console.log(hargaBayar);
            $('#harga-bayar-tahap3').attr('value', formatRupiah(hargaBayar));
            // console.log($('#img-modal'))
        });

        function formatRupiah(angka) {
            var number_string = angka.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return rupiah;
        }

        $(document).ready(function() {
            $('.tahap').hide();
            $('#divtahap1').show();
            $('#filter-status').change(function() {
                $('.tahap').hide();
                $('#div' + $(this).val()).show();
            });
        });
        $(document).on('click', '.modal-image', function(event) {
            // return confirm($(this).data('tanggalSP2D'));
            var link = $(this).data('link');
            var judul = $(this).data('judul');
            var deskripsi = $(this).data('deskripsi');

            $('#img-modal').attr('src', link);
            $('#judul').html(judul);
            $('#deskripsi').html(deskripsi);
            console.log(judul);
        });

        let table = $('#tablePesananUser').DataTable({
            order: [
                [5, "desc"]
            ],
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('user.get-pesanan') }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_Row_Index',
                orderable: false,
                searchable: false
            }, {
                data: 'no_pemesanan',
            }, {
                data: 'nama_pesanan',
            }, {
                data: 'tipe_lantai',
                searchable: false
            }, {
                data: 'harga_pesanan',
                searchable: false
            }, {
                data: 'harga_bayar',
                searchable: false
            }, {
                data: 'total_harga_bayar',
                searchable: false
            }, {
                data: 'created_at',
                searchable: false
            }, {
                data: 'tahap',
                searchable: false
            }, {
                data: 'status_pengerjaan',
                searchable: false
            }],
        });

        $(document).ready(function() {
            $('.dataTables_filter input[type="search"]').css({
                'max-width': '150px',
                'display': 'inline-block'
            });
        });

        function openDesign(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.className += " active";
        }

        function openTahap(evt, tabName) {
            var i, tahap, tablinks;
            tahap = document.getElementsByClassName("tahap");
            for (i = 0; i < tahap.length; i++) {
                tahap[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tabtahap");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.className += " active";
        }

        $(document).on('click', '.btn-closed', function(event) {
            $.ajax({
                url: "{{ route('user.batal-download') }}",
                type: "GET",
                data: {
                    items: arr_items,
                    curr_id: id_aset
                },
            });
        });

        function batal_download() {
            alert('ok')
            $.ajax({
                url: "{{ route('user.batal-download') }}",
                type: "GET",
                data: {
                    items: arr_items,
                    curr_id: id_aset
                },
            });
        }
    </script>
</x-app-layout>
