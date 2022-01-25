<x-app-layout title="Informasi">
    {{-- <div class="card shadow p-3 mb-5 bg-white" style="border-radius: 0.7rem"">
        <div class="   row">
        <div class="col text-center">
            <h5 class="fw-bold">Informasi</h5>
            <hr class="mt-2" size="5" style="width:15%;margin:auto;color:#303296">
        </div>

        <div class="deskripsi-profil mt-2 p-4">
            <div class="visi p-3">
                <div class="text">
                    <ul>
                        @foreach ($informasi as $item)
                        <li class="m-1" style="text-align: justify !important">{{$item->informasi}}</li>    
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach ($informasi as $item)
                    <div class="d-flex row-informasi">
                        <div class="m-2 text-center">
                            <img src="{{ asset('storage/gambar-informasi/' . $item->gambar) }}" class="img-informasi"
                                alt="Foto Progress">
                        </div>
                        <div class="m-2">
                            <div class="text-center">
                                <p class="fw-bold">{{ $item->title }}</p>
                            </div>
                            <div class="text-justify">
                                <p>{{ $item->informasi }} </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
    </script>
</x-app-layout>
