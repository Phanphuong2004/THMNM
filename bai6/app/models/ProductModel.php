<?php

class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Retrieves all products, including their category names.
     *
     * @return array An array of product objects, or an empty array if no products are found.
     */
    public function getProducts(): array
    {
        $query = "SELECT p.id, p.name, p.description, p.price, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Retrieves a single product by its ID.
     *
     * @param int $id The ID of the product to retrieve.
     * @return object|false A product object if found, or false if not found.
     */
    public function getProductById(int $id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Adds a new product to the database.
     *
     * @param string $name The name of the product.
     * @param string $description The description of the product.
     * @param float $price The price of the product.
     * @param int $category_id The ID of the product's category.
     * @return array|bool An array of validation errors if any, or true on success, false on failure.
     */
    public function addProduct(string $name, string $description, float $price, int $category_id)
    {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id)
                  VALUES (:name, :description, :price, :category_id)";

        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        // Price and category_id are already validated for type, so strip_tags is sufficient
        $price = strip_tags($price);
        $category_id = strip_tags($category_id);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR); // Use PARAM_STR for float due to PDO's flexibility
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Updates an existing product in the database.
     *
     * @param int $id The ID of the product to update.
     * @param string $name The new name of the product.
     * @param string $description The new description of the product.
     * @param float $price The new price of the product.
     * @param int $category_id The new ID of the product's category.
     * @return bool True on success, false on failure.
     */
    public function updateProduct(int $id, string $name, string $description, float $price, int $category_id): bool
    {
        $query = "UPDATE " . $this->table_name . "
                  SET name = :name,
                      description = :description,
                      price = :price,
                      category_id = :category_id
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = strip_tags($price);
        $category_id = strip_tags($category_id);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Deletes a product from the database by its ID.
     *
     * @param int $id The ID of the product to delete.
     * @return bool True on success, false on failure.
     */
    public function deleteProduct(int $id): bool
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}