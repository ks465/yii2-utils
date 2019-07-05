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
 * @version 0.2.1-980226
 * @since   1.0
 */
class JwtPayload extends BaseObject
{
    /**
     * Maximum allowed time shift between client and server
     */
    const TIME_SHIFT_ALLOWED = 10;
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
    private static $key = 'TFhSjkVAwv-mPSwoh3s2KMIWqz4QUZQq_5uXjB5YLg5rouy68i_ESDbU0Mm9NjpM';
    /**
     * @var string Database Role to access data
     */
    public $role = 'keyhan';
    /**
     * @var string (Audience) Claim in JWT definition
     */
    public $aud = 'khan.org';
    /**
     * @var int (Expiration Time) Claim in JWT definition
     */
    public $exp;
    /**
     * @var int (Not Before) Claim in JWT definition
     */
    public $nbf;
    /**
     * @var string (Subject) Claim in JWT definition
     */
    public $sub = '';
    /**
     * @var integer (Issued At) Claim
     */
    public $iat = 0;
    /**
     * @var string (JWT ID) Claim
     */
    public $jti = '_default_UUID';
    /**
     * @var string (Issuer) Claim
     */
    public $iss = 'KHanS@khan.org';

    /**
     * Set default values for the JWT and this classes
     */
    public function init()
    {
        JWT::$leeway = 5;

        if(empty($this->exp)){
            $this->exp = time() + self::TIME_SHIFT_ALLOWED;
        }
        if(empty($this->nbf)){
            $this->nbf = time() - self::TIME_SHIFT_ALLOWED;
        }
//        $this->payLoad->iat = time();

    }

    /**
     * Decode a generated token to see the payload inside.
     * This is mostly used for testing.
     *
     * @param string $jwt Previously generated JWT token
     *
     * @return object payload in the token
     */
    public static function decodeJwt($jwt)
    {
        return JWT::decode($jwt, JwtPayload::$key, ['HS256']);
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
        //main parts
        $payLoad->role = $this->role;
        $payLoad->exp = $this->exp;
        $payLoad->nbf = $this->nbf;
        $payLoad->aud = $this->aud;
        $payLoad->sub = $this->sub;
        //optional parts
        $payLoad->iat = $this->iat;
        $payLoad->jti = $this->jti;
        $payLoad->iss = $this->iss;

        return JWT::encode($payLoad, JwtPayload::$key);
    }
}