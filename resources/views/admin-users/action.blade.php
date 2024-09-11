<td>
    <div class="flex-row d-flex justify-content-around">
        <a href="#" data-id="{{ $data->id }}" class="btn btn-info btn-circle btn-sm">
            <i class="fas fa-info-circle"></i>
        </a>
        <a href="#" data-id="{{ $data->id }}" class="btn btn-warning btn-circle btn-sm tombol-edit">
            <i class="fas fa-edit"></i> </a>
        <a href="#" data-id="{{ $data->id }}" class="btn btn-danger btn-circle tombol-del btn-sm" {{-- onclick="returnconfirm('kamuyakin??')" --}}>
            <i class="fas fa-trash"></i>
        </a>
    </div>
</td>
