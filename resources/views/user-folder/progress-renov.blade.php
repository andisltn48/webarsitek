<x-app-layout title="Progress Renovasi">

    {{-- <img src="{{ asset('images/carouseimage.jpg') }}" alt=""> --}}

    <div id="Renovasi" class="mt-4 tabcontent active">
        @if (count($progress_renovasi) == 0)
            <div class="text-center mt-5">
                <h1 class="fw-bolder">Belum ada Progres :(</h1>
            </div>
        @else
            <div class="owl-carousel owl-theme" id="home-carousel">
                @foreach ($progress_renovasi as $item)
                    <a class="modal-image" href="" data-target="#modal-image-pop" data-toggle="modal"
                        data-link="{{ asset('storage/progress/' . $item->progress) }}"
                        data-judul="{{$item->judul}}"
                        data-deskripsi="{{$item->deskripsi}}">
                        <img class="card-img-top img-progress"
                            src="{{ asset('storage/progress/' . $item->progress) }}" alt="">
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div id="modal-image-pop" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
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

    <script>
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
                data: 'created_at',
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
    </script>
</x-app-layout>
