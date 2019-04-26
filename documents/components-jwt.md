#JWT Payload
Documentation Edition: 1.0-980206
Class Version: 0.1.1-980101

For checking and debugging generated tokens see:
[JWT Debugger](https://jwt.io/#debugger).
And for creating new keys and JWk see:
[Create new JWK](https://russelldavies.github.io/jwk-creator/)

The main and maybe only method in this class is `getJwt` which accepts optional subject of request 
as argument and returns ready-to-send JWT token. 