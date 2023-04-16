<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Subscriber Manager | Home</title>

    <!-- Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"
    />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
  </head>
  <body class="antialiased">
    <main class="container mx-auto p-4">
      <header class="mb-10">
        <h1 class="text-center text-2xl">View all Subscribers</h1>
      </header>
      <div>
        <a
          class="mt-3 w-full rounded-sm py-1 px-4 text-center text-sm ring-1 ring-black"
          href="/create-subscriber"
        >
          + Create Subscriber
        </a>
        <div class="mt-3 p-4 border-2 border-gray-500 drop-shadow-xl overflow-y-scroll">
          <table id="subscribers-table" class="display">
            <thead>
              <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Country</th>
                <th>Subscribe Date</th>
                <th>Subscribe Time</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </main>

    <!-- Scripts -->
    <script
      src="https://code.jquery.com/jquery-3.6.4.min.js"
      integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="{{ asset('js/pages/subscribe.js') }}"></script>
  </body>
</html>
