<?php

use khans\utils\components\JwtPayload;

$this->title = 'JWT Token';
$this->params['breadcrumbs'][] = ['label' => 'List of Demo Pages', 'url' => ['/demos']];
$this->params['breadcrumbs'][] = ['label' => 'Components Demo Pages', 'url' => ['/demos/components']];
$this->params['breadcrumbs'][] = $this->title;


$jwt = new JwtPayload();
$token = $jwt->getJwt('Some Subjects');
?>
    <p class="ltr">$jwt = new \khans\utils\components\JwtPayload();</p>
<?php
vd($jwt);
?>
    <p class="ltr">$token = $jwt->getJwt('Some Subjects')</p>
<?php
vd($token);
?>
    <p class="ltr">JwtPayload::decodeJwt($token)</p>
<?php
vd(JwtPayload::decodeJwt($token));