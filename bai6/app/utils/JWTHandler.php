<?php

// Require the autoloader for Composer dependencies.
// This is essential for loading the Firebase\JWT namespace.
require_once 'vendor/autoload.php';

// Import the necessary classes from the Firebase\JWT namespace.
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

/**
 * JWTHandler Class
 *
 * This class provides methods for encoding and decoding JSON Web Tokens (JWTs).
 * It uses a predefined secret key for signing and verifying tokens.
 */
class JWTHandler
{
    /**
     * @var string The secret key used for signing and verifying JWTs.
     */
    private $secret_key;

    /**
     * Constructor for the JWTHandler.
     * Initializes the secret key.
     */
    public function __construct()
    {
        // Set your secret key here. It should be a strong, unique, and securely stored string.
        $this->secret_key = "HUTECH"; // IMPORTANT: Replace with your actual strong secret key!
    }

    /**
     * Encodes data into a JSON Web Token (JWT).
     *
     * The token includes:
     * - 'iat': Issued at time (current timestamp).
     * - 'exp': Expiration time (1 hour from issued time).
     * - 'data': The actual data to be stored in the token.
     *
     * @param array $data The data to be encoded into the JWT payload.
     * @return string The encoded JWT string.
     */
    public function encode($data)
    {
        $issuedAt = time(); // Get the current timestamp (issued at)
        $expirationTime = $issuedAt + 3600; // JWT valid for 1 hour (3600 seconds) from the issued time

        // Define the payload for the JWT.
        $payload = array(
            'iat'  => $issuedAt,         // Issued at timestamp
            'exp'  => $expirationTime,   // Expiration timestamp
            'data' => $data              // Custom data
        );

        // Encode the payload using the secret key and HS256 algorithm.
        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    /**
     * Decodes a JSON Web Token (JWT).
     *
     * Verifies the token's signature and expiration.
     *
     * @param string $jwt The JWT string to be decoded.
     * @return array|null The decoded data from the JWT, or null if decoding fails (e.g., invalid signature, expired token).
     */
    public function decode($jwt)
    {
        try {
            // Decode the JWT using the secret key and HS256 algorithm.
            // The Key object is required for JWT::decode in newer versions of firebase/php-jwt.
            $decoded = JWT::decode($jwt, new Key($this->secret_key, 'HS256'));

            // Cast the decoded data object to an array and return it.
            return (array) $decoded->data;
        } catch (Exception $e) {
            // Catch any exceptions (e.g., signature verification failed, token expired).
            // In a real application, you might log the error for debugging purposes.
            // error_log("JWT decoding error: " . $e->getMessage());
            return null; // Return null to indicate decoding failure.
        }
    }
}

?>