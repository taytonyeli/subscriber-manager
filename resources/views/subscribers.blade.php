<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Subscriber Manager | Home</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased">
        <main class="container mx-auto p-4">
            <h1 class="text-center text-2xl">
                Welcome to Your Dashboard
            </h1>
            <table id="subscribers-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Subscribe Date</th>
                    <th>Subscribe Time</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Subscribe Date</th>
                    <th>Subscribe Time</th>
                </tr>
            </tfoot>
        </table>
        </main>




        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
        <script src="{{ asset('js/subscribe.js') }}"></script>
    </body>
</html>
