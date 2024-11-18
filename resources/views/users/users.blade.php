@php
use App\Enums\PermissionLevel;
@endphp

@extends('layout.master1.master')
@section('title', 'Pengguna')
@section('menuUsers', 'active')

@section('content')


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Pengguna</h1>
    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addUserModal">
        <i class="fas fa-plus"></i>
        Tambah Pengguna
    </button> 
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Hak Akses</th>
                        <th>Tanggal Registrasi</th>
                        <th>Update Terakhir</th>
                        <th>Status Premium</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="inventoryTableBody">
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ str_replace("_", " ",$user->permission_level->name) }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>1</td>
                        <td class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#userFormModal" data-user="{{json_encode($user)}}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if (auth()->user()->permission_level->value > $user->permission_level->value)
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUserModal" data-user="{{json_encode($user)}}">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif
                            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#generateLicenseKeyModal" data-user="{{json_encode($user)}}">
                                <i class="fas fa-cogs"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('users.add')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>  
                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group row">
                        <label for="permission" class="col-sm-6 col-form-label">Hak Akses</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="permission" name="permission_level">
                                @foreach(PermissionLevel::cases() as $permission)
                                  @if (auth()->user()->permission_level->value >= $permission->value)
                                    <option value="{{ $permission->value }}" {{ auth()->user()->permission_level === $permission->value ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                  @endif 
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update User Modal -->
<div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-labelledby="userFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="userUpdateForm" class="user" method="POST" action="">
                @csrf
                @method("PUT")
                <div class="modal-header">
                    <h5 class="modal-title" id="userFormModalLabel">Ubah Data Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Nama</label>
                        <input type="text" class="form-control" id="username" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>
                    @if (auth()->user()->permission_level == PermissionLevel::SUPER_ADMIN)
                    <div class="form-group row">
                        <label for="permission" class="col-sm-6 col-form-label">Hak Akses</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="permission" name="permission_level">
                                @foreach(PermissionLevel::cases() as $permission)
                                    <option value="{{ $permission->value }}" {{ auth()->user()->permission_level === $permission->value ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- generate license key Modal --}}
<div class="modal fade" id="generateLicenseKeyModal" tabindex="-1" role="dialog" aria-labelledby="generateLicenseKeyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateLicenseKeyModalLabel">Generated License Key</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="licenseKey"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="userDeleteForm" class="user" method="POST" action="">
                @csrf
                @method("DELETE")
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Hapus Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#generateLicenseKeyModal').on('show.bs.modal', function (event) {
            var licenseKey = generateLicenseKey(16);
            document.getElementById('licenseKey').textContent = licenseKey;
        });

        function generateLicenseKey(length) {
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var result = '';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#userFormModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            const user = button.data('user')
            var modal = $(this);
            modal.find('#userUpdateForm').attr('action', '/users/' + user.id);
            modal.find('#username').val(user.name);
            modal.find('#userEmail').val(user.email);
            modal.find("#permission").val(user.permission_level)
        });
      
        $('#addUserModal').on('hide.bs.modal', function(_) {
            $('#name').val('')
            $('#email').val('')
            $('#password').val('')
        });

        $('#deleteUserModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); 
            const user = button.data('user')
            const modal = $(this)
            modal.find('#userDeleteForm').attr('action', '/users/' + user.id)
        })
    }); 
</script>


@endsection


