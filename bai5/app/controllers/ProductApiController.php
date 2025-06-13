<?php

require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php'); // Assuming this is needed for category-related operations later

/**
 * ProductApiController
 *
 * Handles API requests related to products, providing endpoints for
 * listing, showing, creating, updating, and deleting products.
 */
class ProductApiController
{
    private $productModel;
    private $db;

    /**
     * Constructor
     *
     * Initializes the database connection and the ProductModel instance.
     */
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    /**
     * GET /products
     *
     * Retrieves and returns a list of all products in JSON format.
     */
    public function index(): void
    {
        header('Content-Type: application/json');
        $products = $this->productModel->getProducts();
        echo json_encode($products);
    }

    /**
     * GET /products/{id}
     *
     * Retrieves and returns a single product by its ID in JSON format.
     *
     * @param int $id The ID of the product to retrieve.
     */
    public function show(int $id): void
    {
        header('Content-Type: application/json');
        $product = $this->productModel->getProductById($id);

        if ($product) {
            http_response_code(200); // OK
            echo json_encode($product);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Sản phẩm không tìm thấy.']);
        }
    }

    /**
     * POST /products
     *
     * Creates a new product from the request body data.
     * Returns success or error messages in JSON format.
     */
    public function store(): void
    {
        header('Content-Type: application/json');
        // Decode JSON input from the request body
        $data = json_decode(file_get_contents("php://input"), true);

        // Extract and null-coalesce input parameters
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? 0.0; // Default to 0.0 for price
        $category_id = $data['category_id'] ?? null;

        // Ensure price and category_id are of correct type before passing to model
        $price = (float) $price;
        $category_id = (int) $category_id;


        $result = $this->productModel->addProduct($name, $description, $price, $category_id);

        if (is_array($result)) { // If validation errors were returned
            http_response_code(400); // Bad Request
            echo json_encode(['errors' => $result]);
        } elseif ($result) { // If product was successfully added
            http_response_code(201); // Created
            echo json_encode(['message' => 'Sản phẩm đã được tạo thành công.']);
        } else { // Generic failure (e.g., database error)
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Không thể tạo sản phẩm. Vui lòng thử lại.']);
        }
    }

    /**
     * PUT /products/{id}
     *
     * Updates an existing product identified by ID with data from the request body.
     * Returns success or error messages in JSON format.
     *
     * @param int $id The ID of the product to update.
     */
    public function update(int $id): void
    {
        header('Content-Type: application/json');
        // Decode JSON input from the request body
        $data = json_decode(file_get_contents("php://input"), true);

        // Extract and null-coalesce input parameters
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? 0.0; // Default to 0.0 for price
        $category_id = $data['category_id'] ?? null;

        // Ensure price and category_id are of correct type before passing to model
        $price = (float) $price;
        $category_id = (int) $category_id;

        // Check if the product exists before attempting to update
        $existingProduct = $this->productModel->getProductById($id);
        if (!$existingProduct) {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Sản phẩm không tìm thấy để cập nhật.']);
            return;
        }

        $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id);

        if ($result) {
            http_response_code(200); // OK
            echo json_encode(['message' => 'Sản phẩm đã được cập nhật thành công.']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Cập nhật sản phẩm thất bại. Vui lòng thử lại.']);
        }
    }

    /**
     * DELETE /products/{id}
     *
     * Deletes a product from the database by its ID.
     * Returns success or error messages in JSON format.
     *
     * @param int $id The ID of the product to delete.
     */
    public function destroy(int $id): void
    {
        header('Content-Type: application/json');

        // Check if the product exists before attempting to delete
        $existingProduct = $this->productModel->getProductById($id);
        if (!$existingProduct) {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Sản phẩm không tìm thấy để xóa.']);
            return;
        }

        $result = $this->productModel->deleteProduct($id);

        if ($result) {
            http_response_code(200); // OK
            echo json_encode(['message' => 'Sản phẩm đã được xóa thành công.']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Xóa sản phẩm thất bại. Vui lòng thử lại.']);
        }
    }
}
?>