<?php include 'app/views/shares/header.php'; ?>
<h1>Danh sách sản phẩm</h1>
<a href="/bai5/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
<ul class="list-group" id="product-list">
    <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
</ul>
<?php include 'app/views/shares/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const token = localStorage.getItem('jwtToken');
        if (!token) {
            alert('Vui lòng đăng nhập');
            location.href = '/bai5/account/login'; // Điều hướng đến trang đăng nhập
            return;
        }

        fetch('/bai5/api/product', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token // Gửi JWT token trong header Authorization
                }
            })
            .then(response => {
                // Kiểm tra nếu phản hồi không thành công (ví dụ: 401 Unauthorized)
                if (!response.ok) {
                    if (response.status === 401) {
                        alert('Phiên đăng nhập đã hết hạn hoặc không hợp lệ. Vui lòng đăng nhập lại.');
                        localStorage.removeItem('jwtToken'); // Xóa token cũ
                        location.href = '/bai5/account/login'; // Điều hướng về trang đăng nhập
                    }
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const productList = document.getElementById('product-list');
                // Xóa bất kỳ nội dung placeholder nào
                productList.innerHTML = ''; 

                if (data.length === 0) {
                    productList.innerHTML = '<li class="list-group-item">Chưa có sản phẩm nào.</li>';
                } else {
                    data.forEach(product => {
                        const productItem = document.createElement('li');
                        productItem.className = 'list-group-item d-flex justify-content-between align-items-center'; // Thêm flexbox cho căn chỉnh tốt hơn
                        productItem.innerHTML = `
                            <div>
                                <h2><a href="/bai5/Product/show/${product.id}">${product.name}</a></h2>
                                <p>${product.description}</p>
                                <p>Giá: ${product.price} VND</p>
                                <p>Danh mục: ${product.category_name}</p>
                            </div>
                            <div>
                                <a href="/bai5/Product/edit/${product.id}" class="btn btn-warning mr-2">Sửa</a>
                                <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Xóa</button>
                            </div>
                        `;
                        productList.appendChild(productItem);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                const productList = document.getElementById('product-list');
                productList.innerHTML = '<li class="list-group-item text-danger">Không thể tải danh sách sản phẩm. Vui lòng thử lại sau.</li>';
            });
    });

    function deleteProduct(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            const token = localStorage.getItem('jwtToken');
            if (!token) {
                alert('Vui lòng đăng nhập để thực hiện thao tác này.');
                location.href = '/bai5/account/login';
                return;
            }

            fetch(`/bai5/api/product/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token // Gửi JWT token khi xóa
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            alert('Phiên đăng nhập đã hết hạn hoặc không hợp lệ. Vui lòng đăng nhập lại.');
                            localStorage.removeItem('jwtToken');
                            location.href = '/bai5/account/login';
                        }
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message === 'Product deleted successfully') {
                        alert('Xóa sản phẩm thành công!');
                        location.reload(); // Tải lại trang để cập nhật danh sách
                    } else {
                        alert('Xóa sản phẩm thất bại: ' + (data.message || 'Lỗi không xác định'));
                    }
                })
                .catch(error => {
                    console.error('Error deleting product:', error);
                    alert('Đã xảy ra lỗi khi xóa sản phẩm: ' + error.message);
                });
        }
    }
</script>