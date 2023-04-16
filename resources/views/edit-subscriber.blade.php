<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Subscriber Manager | Edit Subscriber</title>

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
        <h1 class="text-center text-2xl">Edit a subscriber</h1>
      </header>
      <form method="POST" action="/edit-subscriber/{{$id}}" class="mx-auto w-1/2">
        <div class="mt-3">
          <label for="email" class="w-full">Email:</label>
          <input
            readonly
            type="email"
            value="{{$email}}"
            name="email"
            id="email"
            class="w-full py-1 px-4 text-sm ring-1 ring-black"
          />
        </div>

        <div class="mt-3">
          <label for="name" class="w-full mt-3">Name:</label>
          <input
            type="text"
            name="name"
            value="{{$name}}"
            id="name"
            class="w-full py-1 px-4 text-sm ring-1 ring-black"
          />
        </div>

        <div class="mt-3">
          <label for="country" class="w-full mt-3">Country:</label>
          <input
            type="text"
            name="country"
            value="{{$country}}"
            id="country"
            class="w-full py-1 px-4 text-sm ring-1 ring-black"
          />
        </div>

        <button
          id="validate-submit"
          type="submit"
          class="mt-6 w-full rounded-sm py-1 px-4 text-center text-black ring-1 ring-black bg-blue-400"
        >
          Save
        </button>
      </form>
    </main>

    <!-- Scripts -->
    <script
      src="https://code.jquery.com/jquery-3.6.4.min.js"
      integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="{{ asset('js/subscribe.js') }}"></script>
  </body>
</html>
