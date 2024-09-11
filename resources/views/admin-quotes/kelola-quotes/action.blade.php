<td>
    <div class="flex-row d-flex justify-content-around">
        <a href="#" data-id="{{ $data->id }}" class="btn btn-info btn-circle btn-sm">
            <i class="fas fa-info-circle"></i>
        </a>
        <a href="#" data-id="{{ $data->id }}" class="btn btn-warning btn-circle btn-sm tombol-edit">
            <i class="fas fa-edit"></i> </a>
        <a href="#" data-id="{{ $data->id }}" class="btn btn-danger btn-circle tombol-del btn-sm" {{-- onclick="returnconfirm('kamuyakin??')" --}}>
            <i class="fas fa-trash"></i>
            {{-- {{ $data->id }} --}}
        </a>

        {{-- <form action="" method="POST">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger btn-circle btn-sm"
                onclick="return confirm('kamu yakin ??')"><i
                    class="fas fa-trash"></i></button>
        </form> --}}
    </div>
</td>
