@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">
        @php
            $colors = ['primary', 'success', 'secondary', 'info', 'warning', 'danger', 'dark'];
        @endphp
        @foreach ($datas as $data)
            {{-- @dd($data->first()->quote) --}}

            @php
                $color = $colors[array_rand($colors)];
                $quotes = $data->find($data->id)->quote;
            @endphp
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="/categories/{{ $data->name }}" class="link-offset-2 link-underline link-underline-opacity-0">
                    <div style="cursor: pointer" class="card border-left-{{ $color }} shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-sm font-weight-bold text-{{ $color }} text-uppercase mb-1">
                                        {{ $data->name }}
                                    </div>
                                    <div class="h5 mb-0 text-xs font-weight-bold text-gray-800">Jumlah Quotes :
                                        {{ $quotes->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
