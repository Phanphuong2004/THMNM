<?php include 'app/views/shares/header.php'; ?>
<h1>Sửa sản phẩm</h1>
<form id="edit-product-form">
    <input type="hidden" id="id" name="id">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <!-- Các danh mục sẽ được tải từ API và hiển thị tại đây -->
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
<a href="/bai5/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
<?php include 'app/views/shares/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy productId từ biến PHP đã được inject vào
        const productId = <?= $editId ?>;

        // Tải thông tin sản phẩm hiện tại để điền vào form
        fetch(`/bai5/api/product/${productId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description;
                document.getElementById('price').value = data.price;
                // Sau khi tải danh mục, mới chọn danh mục hiện tại của sản phẩm
                // document.getElementById('category_id').value = data.category_id; // Sẽ đặt sau khi danh mục được tải
            })
            .catch(error => console.error('Lỗi khi tải thông tin sản phẩm:', error));

        // Tải danh sách danh mục để điền vào dropdown
        fetch('/bai5/api/category')
            .then(response => response.json())
            .then(categories => {
                const categorySelect = document.getElementById('category_id');
                // Xóa các option cũ nếu có
                categorySelect.innerHTML = '';
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });

                // Sau khi danh mục đã tải, tải lại thông tin sản phẩm để chọn đúng category_id
                fetch(`/bai5/api/product/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('category_id').value = data.category_id;
                    })
                    .catch(error => console.error('Lỗi khi tải lại thông tin sản phẩm để chọn danh mục:', error));
            })
            .catch(error => console.error('Lỗi khi tải danh mục:', error));


        // Xử lý sự kiện gửi form
        document.getElementById('edit-product-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi gửi form mặc định

            const formData = new FormData(this);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            // Gửi dữ liệu cập nhật lên API
            fetch(`/bai5/api/product/${jsonData.id}`, {
                    method: 'PUT', // Sử dụng phương thức PUT để cập nhật
                    headers: {
                        'Content-Type': 'application/json' // Đặt Content-Type là JSON
                    },
                    body: JSON.stringify(jsonData) // Chuyển đổi dữ liệu thành chuỗi JSON
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Product updated successfully') {
                        // Chuyển hướng về trang danh sách sản phẩm nếu cập nhật thành công
                        location.href = '/bai5/Product';
                    } else {
                        // Hiển thị thông báo lỗi nếu cập nhật thất bại
                        alert('Cập nhật sản phẩm thất bại');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi cập nhật sản phẩm:', error);
                    alert('Đã xảy ra lỗi khi cập nhật sản phẩm.');
                });
        });
    });
</script>