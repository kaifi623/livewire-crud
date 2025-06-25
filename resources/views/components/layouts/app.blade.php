
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Checking</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
     @livewireStyles
</head>
<body>


     {{-- @livewire('post-search-list', ["search" => '', "updatesQueryString" => ['search']]) --}}
     @livewire('fetch-posts')
     @livewireScripts

</body>
</html>
