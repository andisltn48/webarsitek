<div class="d-flex justify-content-center">
    <div class="m-1">
        <a data-link="{{route('auth.change-password-updates', $model->id)}}" 
            data-email="{{$model->email}}"
            data-toggle="modal" data-target="#modal-edit-passwords"
            style="border-radius: 2rem" type="submit" class="btn btn-block btn-warning btn-edit-passwords"><i class="fas fa-edit me-2"></i>Edit</a>
    </div>
    <div class="m-1">
        <form action="{{ route('user-admin.destroy', $model->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button style="border-radius: 2rem" type="submit" class="btn btn-block btn-danger"
                onclick="return confirm('Apakah anda yakin untuk menghapus pengguna ini ?');"><i
                    class="fas fa-trash-alt me-2"></i>Hapus</button>
        </form>
    </div>
</div>