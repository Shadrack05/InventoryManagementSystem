<!DOCTYPE html>
    <html :class="{ 'theme-dark': dark }" lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>Inventory360 Dashboard</title>
          <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
          />
          <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
          />
          <meta name="csrf-token" content="{{ csrf_token() }}">
        </head>
<body>
    <div id="app">
        <dashboard csrf-token="{{ csrf_token() }}"></dashboard>
    </div>

    <!-- Include the compiled JavaScript -->
    @vite('resources/js/app.js')
</body>
</html>
