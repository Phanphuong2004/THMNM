<?php

require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/utils/JWTHandler.php');

/**
 * AccountController Class
 *
 * Handles user account-related operations such as registration, login, and logout.
 * Interacts with AccountModel for database operations and JWTHandler for token management.
 */
class AccountController
{
    /**
     * @var AccountModel $accountModel Instance of AccountModel for database operations related to accounts.
     */
    private $accountModel;

    /**
     * @var PDO $db Database connection instance.
     */
    private $db;

    /**
     * @var JWTHandler $jwtHandler Instance of JWTHandler for token authentication.
     */
    private $jwtHandler;

    /**
     * Constructor for AccountController.
     * Initializes database connection, AccountModel, and JWTHandler.
     */
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    /**
     * Displays the user registration form.
     */
    function register()
    {
        include_once 'app/views/account/register.php';
    }

    /**
     * Displays the user login form.
     */
    public function login()
    {
        include_once 'app/views/account/login.php';
    }

    /**
     * Saves a new user account after form submission.
     * Handles form validation and redirects based on success or failure.
     */
    function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            // Basic server-side validation
            if (empty($username)) {
                $errors['username'] = "Vui long nhap userName!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui long nhap fullName!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui long nhap password!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mat khau va xac nhan chua dung";
            }

            // Check if username is already registered
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tai khoan nay da co nguoi dang ky!";
            }

            // If there are validation errors, re-display the registration form with errors.
            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                // Hash the password before saving for security.
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $password);

                // Redirect based on the save operation result.
                if ($result) {
                    header('Location: /bai5/account/login');
                }
            }
        }
    }

    /**
     * Logs out the current user by destroying session variables.
     * Redirects to the product list page.
     */
    function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /bai5/product');
    }

    /**
     * Authenticates user credentials via API.
     * If successful, returns a JWT token. Otherwise, returns an unauthorized message.
     */
    public function checkLogin()
    {
        header('Content-Type: application/json');
        // Decode JSON data from the request body.
        $data = json_decode(file_get_contents("php://input"), true);

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        // Attempt to retrieve the account by username.
        $user = $this->accountModel->getAccountByUserName($username);

        // Verify user and password.
        if ($user && password_verify($password, $user->password)) {
            // If credentials are valid, encode user data into a JWT.
            $token = $this->jwtHandler->encode(['id' => $user->id, 'username' => $user->username]);
            echo json_encode(['token' => $token]);
        } else {
            // If invalid credentials, return a 401 Unauthorized response.
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }
}