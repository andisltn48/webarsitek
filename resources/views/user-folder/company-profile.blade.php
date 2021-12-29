<x-app-layout title="Profil">
    <div class="card shadow p-3 mb-5 bg-white" style="border-radius: 0.7rem"">
        <div class="  row">
        <div class="col text-center">
            <h5 class="fw-bold">Profil</h5>
            <hr class="mt-2" size="5" style="width:15%;margin:auto;color:#303296">
        </div>

        <div class="deskripsi-profil mt-5 p-4">
            <div class="visi p-3">
                <div class="title">
                    <h6 class="fw-bolder">Visi</h6>
                </div>
                <div class="text">
                    <ul>
                        @foreach ($visi as $item)
                        <li class="m-1" style="text-align: justify !important">{{$item->visi}}</li>    
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="misi p-3">
                <div class="title">
                    <h6 class="fw-bolder">Misi</h6>
                </div>
                <div class="text">
                    <ul>
                        @foreach ($misi as $item)
                        <li class="m-1" style="text-align: justify !important">{{$item->misi}}</li>    
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
    </script>
</x-app-layout>
