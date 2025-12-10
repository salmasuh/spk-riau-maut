@extends('layouts.app')

@section('title','Edit Pengguna')
@section('page-title','Edit Pengguna')

@section('content')
<div class="card bg-white p-6">
  <h2 class="text-lg font-semibold mb-4">Edit Pengguna</h2>

  @if ($errors->any())
    <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
      <ul class="list-disc pl-5">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('users.update', $user) }}">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-700">Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-3 border rounded" required>
      </div>

      <div>
        <label class="block text-sm text-gray-700">Username</label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full p-3 border rounded" required>
      </div>

      <div>
        <label class="block text-sm text-gray-700">Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="w-full p-3 border rounded">
      </div>

      <div>
        <label class="block text-sm text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full p-3 border rounded">
      </div>

      <div>
        <label class="block text-sm text-gray-700">Role</label>
        <select name="role" class="w-full p-3 border rounded" required>
          @foreach($roles as $key => $label)
            <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm text-gray-700">Status</label>
        <select name="status" class="w-full p-3 border rounded" required>
          <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>aktif</option>
          <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>nonaktif</option>
        </select>
      </div>
    </div>

    <div class="mt-4">
      <a href="{{ route('users.index') }}" class="inline-block mr-2 px-4 py-2 border rounded">Batal</a>
      <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded">Perbarui</button>
    </div>
  </form>
</div>
@endsection