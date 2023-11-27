<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Link to your favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.ico') }}">

    @if(!Auth::check())
        <title>Sign Up</title>
        @else

            @php
            $userPosition = Auth::user()->position; // Get the user's position/role
            @endphp

            @if($userPosition === 'admin')
                <title>Admin</title>
            @else
                <title>{{$userPosition}}</title>
        @endif
    @endif

    <!-- Common CSS for both roles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-h7bwjOBmB8Cj6ep4Srf/tg8bp3un6Tl4wm2jLdBB7fu92pX1J/bqFUpYG2Kg3ggNq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>