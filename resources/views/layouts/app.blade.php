<!DOCTYPE html>
<html>
<head>
    <title>Laravel Livewire CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body>
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts

    <script>
        window.livewire.on('postStore', () => {
            $('#formModal').modal('hide');
        });

        Livewire.on('closeModal', () => {
            $('#formModal').modal('hide');
        });

        window.addEventListener('show-form', event => {
            $('#formModal').modal('show');
        });

        window.addEventListener('hide-form', event => {
            $('#formModal').modal('hide');
        });
    </script>
</body>
</html>
