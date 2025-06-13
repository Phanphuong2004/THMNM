<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Using Inter font */
            background-color: #f3f4f6; /* Light gray background */
        }
        /* Basic styling for product image, adjust as needed with Tailwind classes */
        .product-image {
            max-width: 100px;
            height: auto;
            border-radius: 0.5rem; /* Rounded corners for images */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        /* Override Bootstrap's default button focus outline if needed, or use Tailwind ring utilities */
        .btn:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
    <!-- Font Awesome for icons if needed later -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="min-h-screen">

    <nav class="bg-white shadow-md p-4 flex flex-col md:flex-row items-center justify-between rounded-b-lg">
        <a class="text-xl font-bold text-gray-800 hover:text-blue-600 transition duration-300 mb-2 md:mb-0" href="#">Quản lý sản phẩm</a>
        
        <button class="md:hidden text-gray-700 focus:outline-none" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="navbar-toggler">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

        <div class="hidden md:flex flex-grow justify-end" id="navbarNav">
            <ul class="flex flex-col md:flex-row md:space-x-4 space-y-2 md:space-y-0 mt-4 md:mt-0">
                <li class="nav-item">
                    <a class="nav-link text-gray-700 hover:text-blue-600 font-medium px-3 py-2 rounded-md transition duration-300" href="/bai5/Product/">Danh sách sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gray-700 hover:text-blue-600 font-medium px-3 py-2 rounded-md transition duration-300" href="/bai5/Product/add">Thêm sản phẩm</a>
                </li>
                <li class="nav-item" id="nav-login">
                    <a class="nav-link text-gray-700 hover:text-blue-600 font-medium px-3 py-2 rounded-md transition duration-300" href="/bai5/account/login">Login</a>
                </li>
                <li class="nav-item" id="nav-logout" style="display: none;">
                    <a class="nav-link text-gray-700 hover:text-red-600 font-medium px-3 py-2 rounded-md transition duration-300" href="#" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav> 

    <script>
        // Function to handle user logout
        function logout() {
            // Remove the JWT token from local storage
            localStorage.removeItem('jwtToken');
            // Redirect the user to the login page
            location.href = '/bai5/account/login';
        }

        // Add event listener to handle navigation toggling on small screens
        document.getElementById('navbar-toggler').addEventListener('click', function() {
            const navBarNav = document.getElementById('navbarNav');
            navBarNav.classList.toggle('hidden');
            navBarNav.classList.toggle('flex');
            navBarNav.classList.toggle('flex-col');
        });

        // Event listener to run once the DOM is fully loaded
        document.addEventListener("DOMContentLoaded", function() {
            // Retrieve the JWT token from local storage
            const token = localStorage.getItem('jwtToken');
            const navLogin = document.getElementById('nav-login');
            const navLogout = document.getElementById('nav-logout');

            // Based on token presence, show/hide login/logout links
            if (token) {
                // If token exists, user is logged in: hide Login, show Logout
                navLogin.style.display = 'none';
                navLogout.style.display = 'block';
            } else {
                // If no token, user is logged out: show Login, hide Logout
                navLogin.style.display = 'block';
                navLogout.style.display = 'none';
            }
        });
    </script>

    <div class="container mx-auto mt-4 p-4">
        <!-- Content of the page will go here -->