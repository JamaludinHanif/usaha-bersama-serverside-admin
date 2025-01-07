<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data User</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .button-primary {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
        }

        .button-info {
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    {{-- <h1>Laporan Data User</h1> --}}
    <div class="">
        <img src="{{ public_path('kop-surat-2.png') }}" style="width: 100%" alt="">
    </div>
    <h1>{{ $title }}</h1>
    @if ($type == 'all')
        <p>Pada tanggal : Semua Tanggal</p>
    @else
        <p>Pada tanggal : {{ $logs->first->user->created_at->format('d-F-Y') }}</p>
    @endif
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Username</th>
                <th>Aktivitas</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $index => $log)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->user->name ?? 'Pengguna Telah Dihapus' }}</td>
                    @if (isset($log->user->role))
                        <td
                            style="@if ($log->user->role == 'admin') background-color: #007bff; color: white;
                        @elseif ($log->user->role == 'seller') background-color: #31ce36; color: white;
                        @else
                        background-color: #ffc107; color: white; @endif font-weight: bold; text-align: center">
                            {{ $log->user->role ?? 'Pengguna Telah Dihapus' }}
                        </td>
                    @else
                        <td
                            style="
                        background-color: #ffc107; color: white; font-weight: bold; text-align: center">
                            {{ $log->user->role ?? 'Pengguna Telah Dihapus' }}
                        </td>
                    @endif
                    <td>{{ $log->user->username ?? 'Pengguna Telah Dihapus' }}</td>
                    <td
                        style="@if ($log->action == 'login') background-color: #007bff; color: white;
                @else
                background-color: #ffc107; color: white; @endif font-weight: bold; text-align: center">
                        {{ $log->action }}

                    </td>
                    <td>{{ $log->created_at->format('d-m-Y') . ', Pukul: ' . $log->created_at->format('H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
