@extends('layouts.app')

@section('content')
    <style>
        .table td,
        .table th {
            padding: .35rem;
            vertical-align: middle !important;
            text-align: center;
        }
    </style>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <h4 class="m-0 font-weight-bold text-primary">Profile</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control field-user" maxlength="10" id="username" name="username"
                                value="{{ isset($users['username']) ? $users['username'] : 0 }}" disabled>
                            <input type="hidden" class="form-control field-user" id="user_id" name="user_id" value="{{ isset($users['id']) ? $users['id'] : 0 }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control field-user" maxlength="50" id="name" name="name"
                                value="{{ isset($users['name']) ? $users['name'] : '' }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="phone">Telepon <span class="text-danger">*</span></label>
                            <input type="number" class="form-control field-user" onKeyPress="if(this.value.length==14) return false;" id="phone" name="phone"
                                value="{{ isset($users['phone']) ? $users['phone'] : '' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control field-user" maxlength="50" id="email" name="email"
                                value="{{ isset($users['email']) ? $users['email'] : '' }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control field-user" minlength="8" maxlength="20" id="password" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role_id">Role <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-control field-user" id="role_id" required>
                                <option value="">- Pilih Role -</option>
                                @foreach ($roles as $row)
                                    <option value="{{ $row['id'] }}" @if($users['role_id'] == $row['id']) {{ 'selected' }} @endif>{{ $row['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                    <div class="text-right">
                        <a href="/dashboard" class="btn btn-secondary mr-3">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    @push('script')
        <script>
            //
        </script>
    @endpush
@endsection
