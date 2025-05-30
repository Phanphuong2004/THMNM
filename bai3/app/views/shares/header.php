<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale.1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-light {
            background-color: #FFB6C1 !important; /* Màu hồng nhạt cho navbar */
        }
        .navbar-brand {
            color: #FF69B4 !important; /* Màu hồng đậm cho brand */
        }
        .nav-link {
            color: #FF69B4 !important;
        }
        .nav-link:hover {
            color: #FF1493 !important; /* Màu hồng đậm hơn khi hover */
        }
        .btn-primary {
            background-color: #FF69B4 !important;
            border-color: #FF69B4 !important;
            color: white !important;
        }
        .btn-primary:hover {
            background-color: #FF1493 !important;
            border-color: #FF1493 !important;
        }
        .btn-success {
            background-color: #FF69B4 !important;
            border-color: #FF69B4 !important;
            color: white !important;
        }
        .btn-success:hover {
            background-color: #FF1493 !important;
            border-color: #FF1493 !important;
        }
        /* Thêm các tùy chỉnh màu khác nếu cần */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/bai3/Product/">Danh sách sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/bai3/Product/add">Thêm sản phẩm</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>