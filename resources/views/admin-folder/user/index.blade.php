<x-app-layout title="User">
    <div class="d-flex row-media justify-content-around">

        <div class="col card shadow p-3 bg-white m-2" style="border-radius: 0.7rem">
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
            <div class="">
                <div class="title">
                    <h5 class="fw-bold">User</h5>
                </div>
            </div>
            <hr>
            <div class="tab">
                <button class="m-2 tablinks active" onclick="tabUser(event, 'User')"
                    style="width: 7rem !important">User</button>
                <button class="m-2 tablinks" onclick="tabUser(event, 'Arsitek')"
                    style="width: 7rem !important">Arsitek</button>
                {{-- <button class="m-2 tablinks" onclick="tabUser(event, 'Renovator')"
                    style="width: 7rem !important">Renovator</button> --}}
            </div>
            <div id="User" class=" mt-4 tabcontent active">
                <table id="tableUser" class="table table-bordered" style="width: 100%; overflow-x: scroll;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div id="Arsitek" class=" mt-4 tabcontent">
                <div class="button-tambah mb-3">
                    <a data-toggle="modal" data-target="#modal-tambah-arsitek" style="border-radius: 2rem" type="submit"
                        class="btn btn-block btn-primary btn-edit-media">Tambah Arsitek</a>
                </div>
                <table id="tableArsitek" class="table table-bordered" style="width: 100%; overflow-x: scroll;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="Renovator" class=" mt-4 tabcontent">
                <div class="button-tambah mb-3">
                    <a data-toggle="modal" data-target="#modal-tambah-renovator" style="border-radius: 2rem" type="submit"
                        class="btn btn-block btn-primary btn-edit-media">Tambah Renovator</a>
                </div>
                <table id="tableRenovator" class="table table-bordered" style="width: 100%; overflow-x: scroll;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-tambah-arsitek" class="modal fade bd-example-modal-lg" role="dialog">
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
                    <form action="{{ route('auth.register-arsitek') }}" method="POST">
                        @csrf
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        <div class="form-outline mb-4">
                            <label class="form-label fs-6" for="form3Example3">Nama<sup
                                    class="text-danger">*</sup></label>
                            <input style="border-radius: 2rem !important" type="" id="name"
                                class="form-control form-control-lg" placeholder="Masukkan Nama" name="name" required />
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label fs-6" for="form3Example3">Email<sup
                                    class="text-danger">*</sup></label>
                            <input style="border-radius: 2rem !important" type="email" id="email"
                                class="form-control form-control-lg" placeholder="Masukkan Email" name="email"
                                required />
                            <div class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label fs-6" for="form3Example4">Password<sup
                                    class="text-danger">*</sup></label>
                            <input style="border-radius: 2rem !important" type="password" id="password"
                                class="form-control form-control-lg" placeholder="Masukkan password" name="password"
                                required />
                            <div class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <!-- Checkbox -->
                            <input style="margin-top: 0.9rem" type="checkbox" onclick="myFunction()"> Show Password
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-outline-primary"
                                style="padding-left: 2.5rem; padding-right: 2.5rem; border-radius:2rem !important">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-tambah-renovator" class="modal fade bd-example-modal-lg" role="dialog">
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
                    <form action="{{ route('auth.register-renovator') }}" method="POST">
                        @csrf
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        <div class="form-outline mb-4">
                            <label class="form-label fs-6" for="form3Example3">Nama<sup
                                    class="text-danger">*</sup></label>
                            <input style="border-radius: 2rem !important" type="" id="name"
                                class="form-control form-control-lg" placeholder="Masukkan Nama" name="name" required />
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label fs-6" for="form3Example3">Email<sup
                                    class="text-danger">*</sup></label>
                            <input style="border-radius: 2rem !important" type="email" id="email"
                                class="form-control form-control-lg" placeholder="Masukkan Email" name="email"
                                required />
                            <div class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label fs-6" for="form3Example4">Password<sup
                                    class="text-danger">*</sup></label>
                            <input style="border-radius: 2rem !important" type="password" id="password-renovator"
                                class="form-control form-control-lg" placeholder="Masukkan password" name="password"
                                required />
                            <div class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <!-- Checkbox -->
                            <input style="margin-top: 0.9rem" type="checkbox" onclick="myFunction()"> Show Password
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-outline-primary"
                                style="padding-left: 2.5rem; padding-right: 2.5rem; border-radius:2rem !important">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-edit-passwords" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- konten modal-->
            <div class="modal-content">
                <!-- heading modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Password</h4>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <!-- body modal -->

                <div class="model-body p-4">
                    <form id="form-edit-password" method="POST">
                        @csrf
                        <div class="form-outline mb-3">
                            <label class="form-label fs-6" for="form3Example4">Email<sup
                                    class="text-danger">*</sup></label>
                            <input style="border-radius: 2rem !important" readonly id="email-user"
                                class="form-control form-control-lg" />
                            <div class="form-outline mb-3">
                                <label class="form-label fs-6" for="form3Example4">Password Baru<sup
                                        class="text-danger">*</sup></label>
                                <input style="border-radius: 2rem !important" type="password" id="password-baru"
                                    class="form-control form-control-lg" placeholder="Masukkan password"
                                    name="password" required />
                                <div class="text-danger">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-outline mb-3">
                                <label class="form-label fs-6" for="form3Example4">Password Baru<sup
                                        class="text-danger">*</sup></label>
                                <input style="border-radius: 2rem !important" type="password" id="password-baru2"
                                    class="form-control form-control-lg" placeholder="Masukkan password"
                                    name="password_confirmation" required />
                                <div class="text-danger">
                                    @error('password_confirmation')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="">
                                <!-- Checkbox -->
                                <input style="margin-top: 0.9rem" type="checkbox" onclick="myFunction()"> Show Password
                            </div>
                            <div class="col text-center mt-4">
                                <button type="submit" style="border-radius: 2rem"
                                    class="btn btn-primary shadow">Simpan</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.btn-edit-passwords', function(event) {

            var link = $(this).data('link');
            var email = $(this).data('email');

            // console.log(nama, harga, deskripsi)
            $('#email-user').val(email);
            $('#form-edit-password').attr('action', link);
        });

        $(document).ready(function() {
            $('.dataTables_filter input[type="search"]').css({
                'max-width': '150px',
                'display': 'inline-block'
            });
        });

        let table = $('#tableUser').DataTable({
            order: [
                [3, "desc"]
            ],
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('user-admin.get-user') }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_Row_Index',
                orderable: false,
                searchable: false
            }, {
                data: 'name',
                searchable: false
            }, {
                data: 'email',
                searchable: false
            }, {
                data: 'created_at',
                className: 'dt-body-nowrap',
                searchable: false
            }, {
                className: 'dt-body-nowrap',
                width: '15vw',
                data: 'action',
                searchable: false
            }],
        });

        let tableArsitek = $('#tableArsitek').DataTable({
            order: [
                [3, "desc"]
            ],
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('user-admin.get-arsitek') }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_Row_Index',
                orderable: false,
                searchable: false
            }, {
                data: 'name',
                searchable: false
            }, {
                data: 'email',
                searchable: false
            }, {
                data: 'created_at',
                className: 'dt-body-nowrap',
                searchable: false
            }, {
                className: 'dt-body-nowrap',
                width: '15vw',
                data: 'action',
                searchable: false
            }],
        });

        let tableRenovator = $('#tableRenovator').DataTable({
            order: [
                [3, "desc"]
            ],
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('user-admin.get-renovator') }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_Row_Index',
                orderable: false,
                searchable: false
            }, {
                data: 'name',
                searchable: false
            }, {
                data: 'email',
                searchable: false
            }, {
                data: 'created_at',
                className: 'dt-body-nowrap',
                searchable: false
            }, {
                className: 'dt-body-nowrap',
                width: '15vw',
                data: 'action',
                searchable: false
            }],
        });


        function tabUser(evt, tabName) {
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

            table.ajax.reload(null, false)
            tableArsitek.ajax.reload(null, false)
            tableRenovator.ajax.reload(null, false)
        }

        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

            var y = document.getElementById("password-baru");
            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }

            var z = document.getElementById("password-renovator");
            if (z.type === "password") {
                z.type = "text";
            } else {
                z.type = "password";
            }
        }
    </script>
</x-app-layout>
