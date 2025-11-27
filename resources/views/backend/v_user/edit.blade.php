@extends('backend.v_layout.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('backend.user.update', $edit->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>

                        <div class="row">

                            {{-- FOTO --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>

                                    @if ($edit->foto)
                                        <img src="{{ asset('storage/img-user/' . $edit->foto) }}" class="foto-preview" width="100%">
                                    @else
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}" class="foto-preview" width="100%">
                                    @endif

                                    <p></p>

                                    <input type="file" name="foto"
                                        class="form-control @error('foto') is-invalid @enderror"
                                        onchange="previewFoto()">

                                    @error('foto')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- COL KANAN --}}
                            <div class="col-md-8">

                                {{-- ROLE --}}
                                <div class="form-group">
                                    <label>Role</label>
                                        <select name="role" class="form-control @error('role') is-invalid @enderror">
                                            <option value=""> - Pilih Role -</option>

                                            {{-- SUPER ADMIN --}}
                                            <option value="1" {{ old('role', $edit->role) == '1' ? 'selected' : '' }}>Super Admin</option>

                                            {{-- ADMIN --}}
                                            <option value="0" {{ old('role', $edit->role) == '0' ? 'selected' : '' }}>Admin</option>

                                            <!--{{-- MEMBER --}}
                                            <option value="2" {{ old('role', $edit->role) == '2' ? 'selected' : '' }}>Member</option>-->
                                        </select>
                                    @error('role')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- STATUS --}}
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value=""> - Pilih Status -</option>
                                        <option value="1" {{ old('status', $edit->status) == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('status', $edit->status) == '0' ? 'selected' : '' }}>NonAktif</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- NAMA --}}
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama"
                                        value="{{ old('nama', $edit->nama) }}"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Masukkan Nama">
                                    @error('nama')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- EMAIL --}}
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email"
                                        value="{{ old('email', $edit->email) }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Masukkan Email">
                                    @error('email')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- HP --}}
                                <div class="form-group">
                                    <label>HP</label>
                                    <input type="text" name="hp"
                                        onkeypress="return hanyaAngka(event)"
                                        value="{{ old('hp', $edit->hp) }}"
                                        class="form-control @error('hp') is-invalid @enderror"
                                        placeholder="Masukkan Nomor HP">
                                    @error('hp')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- PASSWORD --}}
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label>Password Baru</label>
                                        <input type="password" name="password"
                                            class="form-control"
                                            placeholder="Kosongkan jika tidak diubah">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label>Ulangi Password</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control"
                                            placeholder="Ulangi password">
                                    </div>
                                </div>

                            </div> {{-- end col-md-8 --}}

                        </div> {{-- end row --}}
                    </div> {{-- end card-body --}}

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Perbaharui</button>

                            <a href="{{ route('backend.user.index') }}">
                                <button type="button" class="btn btn-secondary">Kembali</button>
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
