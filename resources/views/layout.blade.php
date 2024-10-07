{{--
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
--}}


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management System</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Dark Mode CSS -->
    <style>
        /* Default Light Mode */
        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #181818 !important; /* Dark background */
            color: #f5f5f5 !important; /* Light text */
        }

        /* Dark Mode for Header, Footer, and Navbar */
        .dark-mode header, .dark-mode .footer, .dark-mode nav {
            background-color: #1c1c1c !important;
            color: #e0e0e0;
        }

        /* Dark Mode for Cards */
        .dark-mode .card {
            background-color: #282828 !important; /* Darker card background */
            color: #f5f5f5 !important; /* Light text */
        }

        /* Dark Mode Buttons */
        .dark-mode .btn {
            background-color: #333 !important;
            color: #f5f5f5 !important;
        }

        /* Dark Mode Inputs and Forms */
        .dark-mode input, .dark-mode select, .dark-mode textarea {
            background-color: #282828 !important;
            color: #f5f5f5 !important;
            border-color: #444 !important;
        }

        /* Dark Mode Links */
        .dark-mode a {
            color: #9f9f9f !important;
        }
        .dark-mode a:hover {
            color: #ffffff !important;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <h1>Ticket Management System</h1>
        <nav>
            <a href="{{ route('tickets.index') }}">Home</a>
        </nav>
    </div>
    <!-- Toggle Dark Mode Switch -->
    <div class="container mt-2">
        <label for="dark-mode-toggle">Enable Dark Mode</label>
        <input type="checkbox" id="dark-mode-toggle">
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

<!-- Dark Mode Toggle Script -->
<script>
    const toggle = document.getElementById('dark-mode-toggle');
    const body = document.body;

    // Check local storage to apply dark mode if previously enabled
    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark-mode');
        toggle.checked = true;
    }

    // Toggle dark mode on and off
    toggle.addEventListener('change', function() {
        if (this.checked) {
            body.classList.add('dark-mode');
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('dark-mode', 'disabled');
        }
    });
</script>
</body>
</html>
