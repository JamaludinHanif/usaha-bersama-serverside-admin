<div class="">
    <div class="">
        <ul>
            <li>Download template file excel <a style="color: blue"
                    href="{{ route('download.template.product') }}">Disini</a></li>
            <li>Silahkan isi dengan format yang sesuai template diatas</li>
            <li>Setelah di isi, silahkan uploadkan file excel di bawah </li>
            <li>File yang didukung : xls, xlsx</li>
        </ul>
    </div>
    <div class="" style="height: 30px"></div>
    <form id="importForm" enctype="multipart/form-data" action="">
        <div class="ml-2 mr-2" style="padding: 10px">
            <div style="font-weight: bold;margin-bottom: 1px">File :</div>
            <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls, .csv">
        </div>
        <div class="" style="height: 40px"></div>
        <div class="d-flex justify-content-center">
            <button type="submit" id="importButton" class="btn btn-primary ladda-button import-btn">Import</button>
        </div>
    </form>
</div>
