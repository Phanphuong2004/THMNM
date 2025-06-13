<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Using Inter font */
        }
        /* Gradient background for the section */
        .gradient-custom {
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
        }
        /* Custom modal styling */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            width: 400px;
            text-align: center;
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <!-- PHP include for header, assuming it's still needed for PHP backend -->
    <?php include 'app/views/shares/header.php'; ?>

    <section class="gradient-custom w-full h-screen flex items-center justify-center py-5">
        <div class="container mx-auto px-4">
            <div class="flex justify-center items-center h-full">
                <div class="w-full max-w-md">
                    <div class="bg-gray-800 text-white rounded-xl shadow-lg p-8 sm:p-10 md:p-12">
                        <form id="login-form">
                            <div class="mb-8 mt-4 pb-4">
                                <h2 class="font-bold text-3xl text-uppercase mb-4">Login</h2>
                                <p class="text-white-50 mb-8">Please enter your login and password!</p>

                                <div class="relative form-outline form-white mb-6">
                                    <input type="text" name="username" id="username" class="form-control form-control-lg bg-transparent border border-gray-400 text-white rounded-md w-full py-3 px-4 leading-tight focus:outline-none focus:border-blue-500" required />
                                    <label class="absolute left-4 -top-3 text-white-50 text-sm bg-gray-800 px-1 transition-all duration-200" for="username">UserName</label>
                                </div>

                                <div class="relative form-outline form-white mb-6">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg bg-transparent border border-gray-400 text-white rounded-md w-full py-3 px-4 leading-tight focus:outline-none focus:border-blue-500" required />
                                    <label class="absolute left-4 -top-3 text-white-50 text-sm bg-gray-800 px-1 transition-all duration-200" for="password">Password</label>
                                </div>

                                <p class="text-sm mb-6 pb-2"><a class="text-blue-300 hover:underline" href="#">Forgot password?</a></p>

                                <button class="btn btn-outline-light btn-lg px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md transition duration-300 ease-in-out shadow-md" type="submit">Login</button>

                                <div class="flex justify-center text-center mt-6 pt-2 space-x-4">
                                    <a href="#!" class="text-white hover:text-blue-300 transition duration-300"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white hover:text-blue-300 transition duration-300"><i class="fab fa-twitter fa-lg"></i></a>
                                    <a href="#!" class="text-white hover:text-blue-300 transition duration-300"><i class="fab fa-google fa-lg"></i></a>
                                </div>
                            </div>

                            <div>
                                <p class="mb-0">Don't have an account? <a href="/bai5/account/register" class="text-blue-300 font-bold hover:underline">Sign Up</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom Modal for Alerts -->
    <div id="custom-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <p id="modal-message" class="text-lg text-gray-800 mb-6"></p>
            <button id="modal-ok-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out shadow-md">
                OK
            </button>
        </div>
    </div>

    <!-- PHP include for footer, assuming it's still needed for PHP backend -->
    <?php include 'app/views/shares/footer.php'; ?>

    <script>
        // Function to show the custom modal
        function showCustomModal(message, callback) {
            const modal = document.getElementById('custom-modal');
            const messageElement = document.getElementById('modal-message');
            const okBtn = document.getElementById('modal-ok-btn');

            messageElement.textContent = message;
            modal.classList.remove('hidden');

            okBtn.onclick = () => {
                modal.classList.add('hidden');
                if (callback) callback();
            };
        }

        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);
            const jsonData = {};
            // Convert form data to JSON object
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            // Send login request to the API endpoint
            fetch('/bai5/account/checkLogin', {
                    method: 'POST', // Use POST method for login
                    headers: {
                        'Content-Type': 'application/json' // Specify JSON content type
                    },
                    body: JSON.stringify(jsonData) // Send data as JSON string
                })
                .then(response => {
                    // Check if the response is OK (status 200)
                    if (!response.ok) {
                        // If not OK, parse as JSON and throw error
                        return response.json().then(err => { throw new Error(err.message || 'Login failed'); });
                    }
                    return response.json(); // Parse JSON response
                })
                .then(data => {
                    // If a token is received, login is successful
                    if (data.token) {
                        localStorage.setItem('jwtToken', data.token); // Store JWT token in local storage
                        showCustomModal('Đăng nhập thành công!', () => {
                            location.href = '/bai5/Product'; // Redirect to product page
                        });
                    } else {
                        // This else block might be redundant if the catch block handles all non-ok responses
                        showCustomModal('Đăng nhập thất bại: Không nhận được token.', () => {});
                    }
                })
                .catch(error => {
                    // Handle any errors during the fetch operation or from the API response
                    console.error('Login error:', error);
                    showCustomModal('Đăng nhập thất bại: ' + error.message, () => {});
                });
        });

        // Basic styling for form labels to float above inputs
        document.querySelectorAll('.form-outline input, .form-outline textarea').forEach(input => {
            const label = input.nextElementSibling;
            if (label && label.tagName === 'LABEL') {
                input.addEventListener('focus', () => {
                    label.classList.add('-top-3', 'text-sm');
                    label.classList.remove('top-1/2', '-translate-y-1/2');
                });
                input.addEventListener('blur', () => {
                    if (input.value === '') {
                        label.classList.remove('-top-3', 'text-sm');
                        label.classList.add('top-1/2', '-translate-y-1/2');
                    }
                });
                // Initial check for pre-filled inputs
                if (input.value !== '') {
                    label.classList.add('-top-3', 'text-sm');
                    label.classList.remove('top-1/2', '-translate-y-1/2');
                } else {
                    label.classList.add('top-1/2', '-translate-y-1/2');
                }
            }
        });
    </script>
</body>
</html>