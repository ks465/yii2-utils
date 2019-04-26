<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 23/03/19
 * Time: 16:25
 */


namespace khans\utils\components;


use Firebase\JWT\JWT;
use yii\base\BaseObject;

/**
 * Class JwtPayload handles JWT authentication token creation for connecting to a JWT-enabled REST server --like
 * PostgREST.
 *
 * @package app\components
 * @version 0.1.1-980101
 * @since   1.0
 */
class JwtPayload extends BaseObject
{
    /**
     * Maximum allowed time shift between client and server
     */
    const TIME_SHIFT_ALLOWED = 100;
    /**
     * @var string Secret key shared with the REST server
     * Use
     *
     * ```php
     * $newSecretKey = base64_encode(random_bytes(48));
     * ```
     *
     * or
     *
     * ```bash
     * openssl rand -base64 48
     * ```
     *
     * to generate eligible new secret key
     */
    private $key = 'TFhSjkVAwv-mPSwoh3s2KMIWqz4QUZQq_5uXjB5YLg5rouy68i_ESDbU0Mm9NjpM';
    /**
     * @var string Database Role to access data
     */
    public $role = 'keyhan';
    /**
     * @var string (Audience) Claim in JWT definition
     */
    public $aud = 'pgrad.aut.ac.ir';
    /**
     * @var int (Expiration Time) Claim in JWT definition
     */
    public $exp = 0;
    /**
     * @var int (Not Before) Claim in JWT definition
     */
    public $nbf = 0;
    /**
     * @var string (Subject) Claim in JWT definition
     */
    public $sub = '';

    /**
     * Set default values for the JWT and this classes
     */
    public function init()
    {
        JWT::$leeway = 5;

        $this->exp = time() + self::TIME_SHIFT_ALLOWED;
        $this->nbf = time() - self::TIME_SHIFT_ALLOWED;
//        $this->payLoad->iat = time(); //(Issued At) Claim
//        $this->payLoad->jti = 'UUID'; //(JWT ID) Claim
//        $this->payLoad->iss = "example.org"; //(Issuer) Claim
    }

    /**
     * Decode a generated token to see the payload inside.
     * This is mostly used for testing.
     *
     * @param string $jwt Previously generated JWT token
     *
     * @return object payload in the token
     */
    public function decodeJwt($jwt)
    {
        return JWT::decode($jwt, $this->key, ['HS256']);
    }

    /**
     * Set the current valid JWT at the time of request
     *
     * @param string $payloadSubject subject of the current request
     *
     * @return string Created JWT token ready to send
     */
    public function getJwt($payloadSubject = '')
    {
        $this->sub = $payloadSubject;

        $payLoad = new \stdClass;
        $payLoad->role = $this->role;
        $payLoad->exp = $this->exp;
        $payLoad->nbf = $this->nbf;
        $payLoad->aud = $this->aud;
        $payLoad->sub = $this->sub;

        return JWT::encode($payLoad, $this->key);
    }
}