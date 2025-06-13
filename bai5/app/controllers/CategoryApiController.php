<?php

require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

/**
 * CategoryApiController
 *
 * Handles API requests related to product categories, providing an endpoint for
 * listing categories.
 */
class CategoryApiController
{
    private $categoryModel;
    private $db;

    /**
     * Constructor
     *
     * Initializes the database connection and the CategoryModel instance.
     */
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    /**
     * GET /categories
     *
     * Retrieves and returns a list of all product categories in JSON format.
     */
    public function index(): void
    {
        header('Content-Type: application/json');
        $categories = $this->categoryModel->getCategories();
        http_response_code(200); // OK
        echo json_encode($categories);
    }
}
?>