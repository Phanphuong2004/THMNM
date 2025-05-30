<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="text-center" style="color: #FF8C00;">Giỏ hàng</h1>

    <?php if (!empty($cart)): ?>
        <ul class="list-group">
            <?php foreach ($cart as $id => $item): ?>
                <li class="list-group-item shadow-sm mb-3" style="border-left: 5px solid #FF8C00;">
                    <h2 style="color: #FF8C00;"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <?php if ($item['image']): ?>
                        <img src="/bai3/<?php echo $item['image']; ?>" alt="Product Image" style="max-width: 100px; border-radius: 5px; margin-bottom: 10px;">
                    <?php endif; ?>
                    <p style="color: #E65100;"><strong>Giá:</strong> <?php echo htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8'); ?> VND</p>
                    <p style="color: #E65100;"><strong>Số lượng:</strong> <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-center text-muted">Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>

    <div class="d-flex justify-content-center mt-4">
        <a href="/bai3/Product" class="btn btn-lg mx-2" style="background-color: #FF8C00; border-color: #FF8C00; color: white;">
            <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
        </a>
        <a href="/bai3/Product/checkout" class="btn btn-lg mx-2" style="background-color: #FF8C00; border-color: #FF8C00; color: white;">
            <i class="fas fa-money-check-alt"></i> Thanh Toán
        </a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">