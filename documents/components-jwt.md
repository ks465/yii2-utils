#JWT Payload
Documentation Edition: 1.1-980226

Class Version: 0.2.1-980226

For checking and debugging generated tokens see:
[JWT Debugger](https://jwt.io/#debugger).
And for creating new keys and JWk see:
[Create new JWK](https://russelldavies.github.io/jwk-creator/)


To generate eligible new secret key shared with the REST server use:
PHP:

```php
$newSecretKey = base64_encode(random_bytes(48));
```

or bash:

```bash
openssl rand -base64 48
```

+ The main and maybe only method in this class is `getJwt` which accepts optional subject of request 
as argument and returns ready-to-send JWT token.
 
```php
$jwt = new \khans\utils\components\JwtPayload();
$token = $jwt->getJwt('Some Subjects')
// string(211) "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoia2V5aGFuIiwiZXhwIjoxNTU3OTkzMzYwLCJuYmYiOjE1NTc5OTMxNjAsImF1ZCI6InBncmFkLmF1dC5hYy5pciIsInN1YiI6IlNvbWUgU3ViamVjdHMifQ.zQltZnVY4Sos4GY6S-EXEWsj3joz4O-oK6GTFHjECyo"
```

All of the elements are configurable through `config` argument at instantiating time:

```php
$jwt = new \khans\utils\components\JwtPayload([
	"aud" => "khan.org",
	"exp" => 1557995763, //better left empty
	"iat" => 0,
	"iss" => "KHanS@khan.org",
	"jti" => "_default_UUID",
	"nbf" => 1557995563, //better left empty
	"role" => "keyhan",
	"sub" => "Some Subjects",
]);
```

+ The only static method for decoding an encrypted string is also `decodeJwt`

```php
vd(JwtPayload::decodeJwt('Some_String'));

// some_file.php:##

stdClass#0
	"$aud" => "khan.org"
	"$exp" => 1557995763
	"$iat" => 0
	"$iss" => "KHanS@khan.org"
	"$jti" => "_default_UUID"
	"$nbf" => 1557995563
	"$role" => "keyhan"
	"$sub" => "Some Subjects"
```