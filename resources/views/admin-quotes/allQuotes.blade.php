@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    {{-- @dd($datas) --}}
    <h1 class="h3 mb-4 text-gray-800">All Quotes {{-- $datas->isEmpty()?'datakosong':'' --}}</h1>

    {{-- convert string: --}}
    {{-- <h1>{{ \Illuminate\Support\Str::words($datas2['blog'], 10, '...') }}</h1> --}}

    <div class="row">

        @foreach ($datas as $data)
            <div class="col-lg-6">
                <!-- Collapsable Card Example -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#collapseCardExample{{ $data->id }}" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">{!! $data->title !!}</h6>
                        {{-- <h6 class="m-0 font-weight-bold text-primary">{!! $data->category->name !!}</h6> --}}
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse" id="collapseCardExample{{ $data->id }}">
                        <div class="card-body">
                            {!! $data->quote !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
