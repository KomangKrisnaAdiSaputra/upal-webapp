@extends('layouts.main')
@section('title', 'Edit Profile')

@section('data')
    <div class="container mt-5 p-4 bg-white shadow rounded">
        <form action="{{ route('profile.save.post') }}" method="POST" id="edit-profile-form">
            @csrf
            <div class="row mb-4">
                <!-- Username -->
                <div class="col-md-6">
                    <label for="username" class="form-label h5">Username</label>
                    <input type="text" id="username" name="username" value="{{ auth()?->user()?->username ?? '' }}"
                        class="form-control" required>
                </div>

                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label for="nama" class="form-label h5">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control"
                        value="{{ auth()?->user()?->nama }}" required>
                </div>
            </div>

            <div class="row mb-4">
                @if ((auth()?->user()?->role ?? 0) == 1)
                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label h5">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="john@example.com"
                            required>
                    </div>
                @endif

                <!-- Nomor Kontak -->
                <div class="col-md-6">
                    <label for="kontak" class="form-label h5">Nomor Kontak</label>
                    <input type="tel" id="kontak" name="kontak" class="form-control"
                        value="{{ auth()?->user()?->kontak ?? '' }}">
                </div>
            </div>

            <div class="row mb-4">
                <!-- Ubah Password -->
                <div class="col-md-6">
                    <label for="password" class="form-label h5">Ubah Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Masukkan password baru">

                </div>

                <!-- Konfirmasi Password -->
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label h5">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                        placeholder="Ulangi password baru">
                    <small id="passwordHelp" class="text-danger"></small>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-5 py-2">Save</button>
            </div>

        </form>
    </div>

@endsection


@section('js')
    <script>
        document.getElementById("edit-profile-form").addEventListener("submit", function(event) {
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirm_password").value;
            let passwordHelp = document.getElementById("passwordHelp");

            passwordHelp.textContent = "";

            if (password !== "" && password !== confirmPassword) {
                event.preventDefault();
                passwordHelp.textContent = "Konfirmasi password tidak cocok.";
            }
        });
    </script>
@endsection
