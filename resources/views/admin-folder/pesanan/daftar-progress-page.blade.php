<x-app-layout title="Informasi">
    <div class="card shadow p-3 mb-5 bg-white" style="border-radius: 0.7rem"">
        <div class="     row">
        <div class="col text-center">
            <h5 class="fw-bold">Daftar Progress</h5>
            <hr class="mt-2" size="5" style="width:15%;margin:auto;color:#303296">
        </div>
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
                    <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="alert-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class=" mt-2 p-4">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-image">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Tahap</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $key = 1;
                                @endphp
                                @foreach ($daftarProgress as $item)
                                    <tr>

                                        <th  scope="row">{{ $key++ }}</th>
                                        <td class="w-25">
                                            <img src="{{ asset('storage/progress/' . $item->progress) }}"
                                                class="img-fluid img-thumbnail" alt="Foto Progress">
                                        </td>
                                        <td >{{ $item->judul }}</td>
                                        <td >{{ $item->deskripsi }}</td>
                                        <td >{{ $item->tahap }}</td>
                                        <td ><a href="{{route('pesanan.hapus-progress',$item->id)}}" class="text-danger">Hapus progress</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    </script>
</x-app-layout>
