<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Subscriber Manager | Home</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased">
        <main class="container mx-auto p-4">
            <h1 class="text-center text-2xl">
                Welcome to MailerLite Subscriber Manager
            </h1>
            <form method="POST" action="/" class="mx-auto w-1/2">
                @isset($api_errors)
                    <div class="alert alert-error shadow-lg">Invalid API Key</div>
                @endisset
                <div class="mt-3">
                    <label for="apiKey" class="display-block w-full"
                        >Enter Your Mailer Lite API Key:</label
                    >
                    <textarea
                        id="apiKey"
                        class="display-block w-full ring-2 ring-black"
                        name="apiKey"
                        rows="5"
                    ></textarea>
                </div>
                <button
                    id="validate-submit"
                    type="submit"
                    class="mt-3 w-full rounded-full py-1 px-4 text-center text-black ring-2 ring-black"
                >
                    Validate
                </button>
            </form>
        </main>
    </body>
</html>
