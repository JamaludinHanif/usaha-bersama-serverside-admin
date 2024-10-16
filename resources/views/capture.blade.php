<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture Image</title>
    <script>
        // function refreshImage() {
        //     setInterval(function() {
        //         fetch('/capture-image')
        //             .then(response => response.text())
        //             .then(html => {
        //                 document.body.innerHTML = html;
        //             });
        //     }, 1000); // Refresh every 5 seconds
        // }

        // window.onload = refreshImage;
    </script>
</head>
<body>
    <h1>Hikvision Camera Snapshot</h1>
    <h1>{{ $msg }}</h1>
    {{-- @if(isset($image_path))
        <img src="http://localhost:5000/{{ $image_path }}" alt="Hikvision Snapshot" width="800">
    @else
        <p>Loading...</p>
    @endif --}}
    <p><a href="/capture-image">Refresh Image</a></p>
</body>
</html>
