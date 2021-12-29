<div class="">
    <form action="{{ route('user.destroy-cart', $model->id) }}" method="POST">
        @csrf
        <button style="border-radius: 2rem" type="submit" class="btn btn-block btn-danger"
            onclick="return confirm('Apakah anda yakin untuk menghapus item ini ?');"><i
                class="fas fa-trash-alt me-2"></i>Hapus</button>
    </form>
</div>