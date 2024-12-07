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
    <p>Date: {{ $date }}</p>
    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Nama</th>
                <th style="text-align: center">Role</th>
                <th style="text-align: center">Username</th>
                <th style="text-align: center">Email</th>
                <th style="text-align: center">No Hp</th>
                <th style="text-align: center">Limit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td
                        style="@if ($user->role == 'admin') background-color: #007bff; color: white;
                    @elseif ($user->role == 'kasir') background-color: #31ce36; color: white;
                    @else
                    background-color: #ffc107; color: white; @endif font-weight: bold; text-align: center">
                        {{ $user->role }}

                    </td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->no_hp }}</td>
                    <td>{{ $user->debt_limit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

<td>{{ $index + 1 }}</td>
