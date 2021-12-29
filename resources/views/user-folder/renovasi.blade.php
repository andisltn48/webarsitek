<x-app-layout title="Renovasi">
    <div class="card shadow p-3 mb-5 bg-white" style="border-radius: 0.7rem"">
         @if (session('error'))
        <div class="alert alert-danger alert-dismissible show fade" role="alert">
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
            <div class="alert alert-success alert-dismissible show fade" role="alert">
                <div class="text-end">
                    <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div> 
                <div class="alert-body">
                    {{ session('success') }}
                    
                </div>

                @if (session('pembayaran_renovasi') != null)
                    <hr>
                    <div class="d-flex mt-2">
                        <p class="col fw-bold">Download bukti pembayaran</p>
                        <a class="btn btn-primary col" href="{{ route('pembayaran.download-pdf-renovasi') }}">Download
                            PDF</a>
                    </div>
                @endif
            </div>
        @endif
        <div class=" col text-center">
            <h5 class="fw-bold">Renovasi</h5>
            <hr class="mt-2" size="5" style="width:15%;margin:auto;color:#303296">
        </div>
        <div class="button mb-4 mt-2 ">
            <a data-toggle="modal" data-target="#modal-daftar-item" href="" class="m-1 btn btn-primary"
                style="border-radius: 2rem" onclick="funcTable()">Lihat Keranjang</a>

            <a data-toggle="modal" data-target="#modal-daftar-pesanan" href="" class="m-1 btn btn-primary"
                style="border-radius: 2rem" onclick="funcTable()">Lihat pesanan</a>

            <a href="{{ route('user.get-progress-renovasi') }}" class="m-1 btn btn-primary"
                style="border-radius: 2rem">Lihat progress</a>
        </div>

        <div class="p-4">
            <div id="" class="flex-container wrap mt-3 ">
                @if (count($daftarrenovasi) == 0)
                    <div class="ml-auto">
                        <h1 class="fw-bolder">Belum ada Item :(</h1>
                    </div>
                @else
                    @foreach ($daftarrenovasi as $item)
                        <div class="mt-3">
                            <div class="card item-design" style="width: 18rem;">
                                <img class="card-img-top img-design"
                                    src="{{ asset('storage/gambar-renovasi/' . $item->gambar_item) }}"
                                    alt="Card image cap">
                                <div class="card-body text-center mt-2">
                                    <h5 class="card-title">{{ $item->nama_item }}</h5>
                                    <p class="card-text">Rp. {{ $item->harga_item }}</p>
                                    <a href="{{ route('user.detail-item-renovasi', $item->id) }}"
                                        class="btn btn-success" style="border-radius: 2rem;">Pesan Item</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

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
                                    <th>Deskripsi</th>
                                    <th>Harga Total</th>
                                    <th>Status Pengerjaan</th>
                                    <th>Tanggal Pemesanan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-daftar-item" class="modal fade bd-example-modal-lg" role="dialog">
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
                        <table id="tableItemUser" class="table table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>Luas Bangunan</th>
                                    <th>Harga</th>
                                    <th>Tanggal Pesan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <hr>
                    <div class="text-end p-3">
                        <p class="fw-bold">Total harga : Rp. {{ $hargatotal }}</p>
                    </div>
                    <div class="p-3">
                        <div class="text-center">
                            <h5 class="fw-bold">Pembayaran</h5>
                        </div>
                        <form action="{{ route('user.store-pemesanan-renovasi') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
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
                                <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    required>{{ old('alamat') }}</textarea>
                            </div>
                            <div class="mt-3">
                                <p>Whatsapp<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="form-group">
                                <input id="kontak" name="kontak" required value="{{ old('kontak') }}" type="number"
                                    class="form-control">
                            </div>
                            <div class="text-end mt-2">
                                <button class="btn btn-primary" type="submit"
                                    style="border-radius: 2rem;">Bayar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                let table = $('#tablePesananUser').DataTable({
                    bAutoWidth: false,
                    order: [
                        [5, "desc"]
                    ],
                    scrollX: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('user.get-pesanan-renovasi') }}",
                    },
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_Row_Index',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'no_pemesanan',
                    }, {
                        data: 'deskripsi',
                    }, {
                        data: 'total_harga',
                        searchable: false
                    }, {
                        data: 'status_pengerjaan',
                        searchable: false
                    }, {
                        data: 'created_at',
                        searchable: false
                    }],
                });

                let table2 = $('#tableItemUser').DataTable({
                    bAutoWidth: false,
                    order: [
                        [4, "desc"]
                    ],
                    scrollX: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('user.get-kart-item') }}",
                    },
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_Row_Index',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'nama_item',
                    }, {
                        data: 'luas_bangunan',
                        searchable: false
                    }, {
                        data: 'harga_item',
                        searchable: false
                    }, {
                        data: 'created_at',
                        searchable: false
                    }, {
                        data: 'action',
                        searchable: false
                    }],
                });

                function funcTable(params) {
                    table.columns.adjust().draw();
                    table2.columns.adjust().draw();
                }
            </script>
</x-app-layout>
