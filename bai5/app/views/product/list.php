<?php include 'app/views/shares/header.php'; ?>
<h1>Danh sách sản phẩm</h1>
<a href="/bai5/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
<ul class="list-group" id="product-list">
    <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
</ul>
<?php include 'app/views/shares/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/bai5/api/product')
            .then(response => response.json())
            .then(data => {
                const productList = document.getElementById('product-list');
                data.forEach(product => {
                    const productItem = document.createElement('li');
                    productItem.className = 'list-group-item';
                    productItem.innerHTML = `
                        <h2><a href="/bai5/Product/show/${product.id}">${product.name}</a></h2>
                        <p>${product.description}</p>
                        <p>Giá: ${product.price} VND</p>
                        <p>Danh mục: ${product.category_name}</p>
                        <a href="/bai5/Product/edit/${product.id}" class="btn btnwarning">Sửa</a>
                        <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Xóa</button>
                    `;
                    productList.appendChild(productItem);
                });
            });
    });

    function deleteProduct(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch(`/bai5/api/product/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Product deleted successfully') {
                        location.reload();
                    } else {
                        alert('Xóa sản phẩm thất bại');
                    }
                });
        }
    }
</script>