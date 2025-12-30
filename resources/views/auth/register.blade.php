@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Register sebagai</label>
                            <div class="col-md-6">
                                <select name="role" class="form-control" id="role" required>
                                    <option value="">-- pilih role --</option>
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="dosen">Dosen</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3" id="nip_field" style="display:none;">
                            <label class="col-md-4 col-form-label text-md-end">NIP</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nip">
                            </div>
                        </div>

                        <div class="row mb-3" id="nim_field" style="display:none;">
                            <label class="col-md-4 col-form-label text-md-end">NIM</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nim">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Contact</label>
                            <div class="col-md-6">
                                <input id="contact" type="text" class="form-control" name="contact">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <script>
                        document.getElementById('role').addEventListener('change', function () {
                            let role = this.value;

                            // ambil elemen field
                            let nipField = document.getElementById('nip_field');
                            let nimField = document.getElementById('nim_field');

                            // reset
                            nipField.style.display = 'none';
                            nimField.style.display = 'none';

                            if (role === 'dosen') {
                                nipField.style.display = 'flex';   // tampilkan NIP
                            } else if (role === 'mahasiswa') {
                                nimField.style.display = 'flex';   // tampilkan NIM
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


