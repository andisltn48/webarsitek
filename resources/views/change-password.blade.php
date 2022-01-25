<x-app-layout title="Ganti Kata Sandi">
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
    <div class="d-flex row-profil justify-content-around">
        <div class="col card shadow p-3 bg-white m-2" style="border-radius: 0.7rem">
            <div class="">
                <div class="title">
                    <h5 class="fw-bold">Ganti Kata Sandi</h5>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <form action="{{ route('auth.change-password-update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="form-group">
                            <p>Kata sandi baru<sup class="text-danger">*</sup></p>

                            <div class="form-group mb-3">
                                <input style="word-break: break-all !important" type="password" id="password"
                                    name="password" class="form-control" required>
                            </div>
                            <div class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>

                            <p>Konfirmasi Kata sandi<sup class="mt-5 text-danger">*</sup></p>
                            <div class="form-group">
                                <input style="word-break: break-all !important" type="password" id="passwordconfirm"
                                    name="password_confirmation" class="form-control" required>
                            </div>
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
                    </div>
                    <div class="col text-center mt-4">
                        <button type="submit" style="border-radius: 2rem" class="btn btn-primary shadow">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function myFunction() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        </script>
</x-app-layout>
