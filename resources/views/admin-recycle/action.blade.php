<td>
    <div class="flex-row d-flex justify-content-around">
        <a href="#" data-id="{{ $data->id }}" class="btn btn-primary tombol-restore btn-icon-split btn-sm">
            <span class="icon text-white-50">
                <i class="fas fa-recycle"></i> </span>
            <span class="text" style="color: white">Recycle</span>
        </a>
        <a href="#" data-id="{{ $data->id }}" class="btn btn-danger btn-circle tombol-del btn-sm"
            {{-- onclick="returnconfirm('kamuyakin??')" --}}>
            <i class="fas fa-trash"></i>
        </a>
    </div>
</td>
