<?php

// Require necessary configuration and model files.
// These files provide database connection, product/category data handling, and JWT utilities.
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php'); // Note: CategoryModel is required but not directly used in this controller's methods.
require_once('app/utils/JWTHandler.php');

/**
 * ProductApiController Class
 *
 * Handles API requests related to product management.
 * Provides endpoints for retrieving, adding, updating, and deleting products.
 * Includes JWT-based authentication for certain actions.
 */
class ProductApiController
{
    /**
     * @var ProductModel $productModel Instance of ProductModel for database operations related to products.
     */
    private $productModel;

    /**
     * @var PDO $db Database connection instance.
     */
    private $db;

    /**
     * @var JWTHandler $jwtHandler Instance of JWTHandler for token authentication.
     */
    private $jwtHandler;

    /**
     * Constructor for ProductApiController.
     * Initializes database connection, ProductModel, and JWTHandler.
     */
    public function __construct()
    {
        // Establish database connection.
        $this->db = (new Database())->getConnection();
        // Initialize ProductModel with the database connection.
        $this->productModel = new ProductModel($this->db);
        // Initialize JWTHandler for authentication.
        $this->jwtHandler = new JWTHandler();
    }

    /**
     * Authenticates the user based on a JWT provided in the Authorization header.
     *
     * @return bool True if authentication is successful, false otherwise.
     */
    private function authenticate()
    {
        // Get all request headers. Note: apache_request_headers() might not work on all server setups (e.g., Nginx without specific configuration).
        // For broader compatibility, consider using $_SERVER['HTTP_AUTHORIZATION'] directly if headers are passed that way.
        $headers = apache_request_headers();

        // Check if the Authorization header is set.
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            // Split the header value to extract the JWT token.
            // Expected format: "Bearer <JWT>"
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null; // Get the second part (the token itself), default to null if not found.

            // If a JWT is present, attempt to decode and verify it.
            if ($jwt) {
                $decoded = $this->jwtHandler->decode($jwt);
                // If decoding is successful (token is valid and not expired), return true.
                return $decoded ? true : false;
            }
        }
        // If no Authorization header or no valid JWT, return false.
        return false;
    }

    /**
     * Retrieves a list of products. Requires authentication.
     *
     * Responds with JSON data containing product information.
     */
    public function index()
    {
        // Check if the user is authenticated.
        if ($this->authenticate()) {
            // Set content type to JSON.
            header('Content-Type: application/json');
            // Fetch all products from the database.
            $products = $this->productModel->getProducts();
            // Encode products as JSON and echo the response.
            echo json_encode($products);
        } else {
            // If not authenticated, return a 401 Unauthorized response.
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
        }
    }

    /**
     * Retrieves detailed information for a single product by its ID.
     * Does NOT require authentication (as per current code).
     *
     * @param int $id The ID of the product to retrieve.
     * Responds with JSON data for the product or a 404 if not found.
     */
    public function show($id)
    {
        // Set content type to JSON.
        header('Content-Type: application/json');
        // Fetch product by ID from the database.
        $product = $this->productModel->getProductById($id);

        // Check if the product was found.
        if ($product) {
            echo json_encode($product); // Return product data.
        } else {
            // If product not found, return a 404 Not Found response.
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }

    /**
     * Adds a new product to the database.
     * Does NOT require authentication (as per current code).
     *
     * Reads product data from the request body.
     * Responds with success message or validation errors.
     */
    public function store()
    {
        // Set content type to JSON.
        header('Content-Type: application/json');
        // Decode JSON data from the request body.
        $data = json_decode(file_get_contents("php://input"), true);

        // Extract product details from the decoded data.
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $category_id = $data['category_id'] ?? null;
        // Note: 'image' field is passed as null in addProduct.
        $result = $this->productModel->addProduct($name, $description, $price, $category_id, null);

        // Check the result of the add operation.
        if (is_array($result)) {
            // If result is an array, it indicates validation errors.
            http_response_code(400); // 400 Bad Request
            echo json_encode(['errors' => $result]);
        } else {
            // If successful, return a 201 Created response.
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        }
    }

    /**
     * Updates an existing product by its ID.
     * Does NOT require authentication (as per current code).
     *
     * Reads updated product data from the request body.
     * @param int $id The ID of the product to update.
     * Responds with success message or failure indication.
     */
    public function update($id)
    {
        // Set content type to JSON.
        header('Content-Type: application/json');
        // Decode JSON data from the request body.
        $data = json_decode(file_get_contents("php://input"), true);

        // Extract updated product details from the decoded data.
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $category_id = $data['category_id'] ?? null;
        // Note: 'image' field is passed as null in updateProduct.
        $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, null);

        // Check the result of the update operation.
        if ($result) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            // If update fails, return a 400 Bad Request response.
            http_response_code(400);
            echo json_encode(['message' => 'Product update failed']);
        }
    }

    /**
     * Deletes a product by its ID.
     * Does NOT require authentication (as per current code).
     *
     * @param int $id The ID of the product to delete.
     * Responds with success message or failure indication.
     */
    public function destroy($id)
    {
        // Set content type to JSON.
        header('Content-Type: application/json');
        // Attempt to delete the product from the database.
        $result = $this->productModel->deleteProduct($id);

        // Check the result of the delete operation.
        if ($result) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            // If deletion fails, return a 400 Bad Request response.
            http_response_code(400);
            echo json_encode(['message' => 'Product deletion failed']);
        }
    }
}
?>