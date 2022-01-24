@if ($model->status_pengerjaan == 'Belum Dikonfirmasi' AND session('role') == 'Admin')
    <div class="d-flex">
        <div class="m-1">
            <a style="border-radius: 2rem" href="{{route('pesanan.confirm', $model->id)}}" class="btn btn-block btn-primary "><i
                    class="fas fa-check me-2"></i>Konfirmasi</a>
        </div>
        <div class="m-1">
            <form action="{{ route('pesanan.destroy', $model->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button style="border-radius: 2rem" type="submit" class="btn btn-block btn-danger"
                    onclick="return confirm('Apakah anda yakin untuk menolak pesanan ini ?');"><i
                        class="fas fa-times-circle  me-2"></i>Tolak</button>
            </form>
        </div>
    </div>
@endif

@if ($model->status_pengerjaan == 'Dalam Pengerjaan')
    <div class="d-flex">
        @if ($model->tahap == 'To Tahap 2')
            <div class="m-1">
                <a style="border-radius: 2rem"
                    onclick="return confirm('Apakah anda yakin untuk melanjutkan ke tahap 2 ?');" href="{{route('pesanan.to-tahap-dua', $model->id)}}"
                    class="btn btn-block btn-primary "><i class="fas fa-check me-2"></i>Konformasi ke Tahap 2</a>
            </div>
        @elseif($model->tahap == 'To Tahap 3')
            <div class="m-1">
                <a style="border-radius: 2rem"
                    onclick="return confirm('Apakah anda yakin untuk melanjutkan ke tahap 3 ?');" href="{{route('pesanan.to-tahap-tiga', $model->id)}}"
                    class="btn btn-block btn-primary "><i class="fas fa-check me-2"></i>Konfirmasi ke Tahap 3</a>
            </div>
        @endif
        <div class="m-1">
            <a data-link="{{ route('pesanan.store-progress', $model->id_pemesan) }}"
                data-nama="{{ $model->nama_pemesan }}" data-idpesanan="{{ $model->id }}" data-toggle="modal"
                data-target="#modal-progress" style="border-radius: 2rem" type="submit"
                class="btn btn-block btn-warning btn-update-progress"><i class="fas fa-pen-square me-2"></i>Update
                Progress</a>
        </div>
        @if ($model->tahap == 'to Selesai')
            
        <div class="m-1">
            <a style="border-radius: 2rem"
                onclick="return confirm('Apakah anda yakin untuk menyelesaikan pesanan ini ?');" href="{{route('pesanan.done', $model->id)}}"
                class="btn btn-block btn-primary "><i class="fas fa-check me-2"></i>Selesai</a>
        </div>
        @endif
    </div>
@endif

@if ($model->status_pengerjaan == 'Selesai Dikerjakan')
    <div class="m-1">
        <form action="{{ route('pesanan.destroy', $model->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button style="border-radius: 2rem" type="submit" class="btn btn-block btn-danger"
                onclick="return confirm('Apakah anda yakin untuk menghapus pesanan ini ?');"><i
                    class="fas fa-trash-alt me-2"></i>Hapus</button>
        </form>
    </div>
@endif
