<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="text-center text-purple mb-4">Thanh toán</h1>

    <form method="POST" action="/bai4/Product/processCheckout">
        <div class="form-group">
            <label for="name" class="text-purple">Họ tên:</label>
            <input type="text" id="name" name="name" class="form-control" required style="border-color: #9C27B0;">
        </div>
        <div class="form-group">
            <label for="phone" class="text-purple">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" class="form-control" required style="border-color: #9C27B0;">
        </div>
        <div class="form-group">
            <label for="address" class="text-purple">Địa chỉ:</label>
            <textarea id="address" name="address" class="form-control" required style="border-color: #9C27B0;"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color: #9C27B0; border-color: #9C27B0;">
            <i class="fas fa-check-circle"></i> Thanh toán
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="/bai4/Product/cart" class="btn btn-outline-secondary mt-2" style="color: #9C27B0; border-color: #9C27B0;">
            <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
        </a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .text-purple {
        color: #9C27B0 !important; /* Màu tím chủ đạo */
    }
    .btn-outline-secondary:hover {
        background-color: #9C27B0 !important;
        color: white !important;
    }
</style>