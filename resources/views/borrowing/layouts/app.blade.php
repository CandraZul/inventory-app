<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Peminjaman Lab')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div style="display:flex; min-height:100vh">

    {{-- SIDEBAR --}}
    <aside style="width:220px; background:#1e293b; color:white; padding:20px;">
        <h3>Lab PTIK</h3>
        <hr>

        <a href="{{ route('borrowing.dashboard') }}" style="color:white; display:block; margin-bottom:10px;">
            Dashboard
        </a>

        <a href="{{ route('borrowing.riwayat') }}" style="color:white;">
            Riwayat Peminjaman
        </a>
    </aside>

    {{-- CONTENT --}}
    <main style="flex:1; padding:30px;">
        @yield('content')
    </main>

</div>

</body>
</html>
