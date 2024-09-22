<!-- resources/views/layout.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management System</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="container">
        <h1>Ticket Management System</h1>
        <nav>
            <a href="{{ route('tickets.index') }}">Home</a>
        </nav>
    </div>
</header>

<main class="py-4">
    @yield('content')
</main>

<footer class="text-center py-4">
    <p>&copy; 2024 Ticket Management System</p>
</footer>

<!-- Include Bootstrap JS (Optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
