<?php
use khans\utils\components\JwtPayload;

class khansutilscomponentsJwtPayloadTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $jwt;
    private $time;

    protected function _before()
    {
        $this->jwt = (new JwtPayload())->getJwt('_subject_');
        $this->time = time();
    }

    protected function _after()
    {
    }

    // tests
    public function testDecodeLegitimate()
    {
        $data = (array)JwtPayload::decodeJwt($this->jwt);
        expect($data['aud'])->equals('khan.org');
        expect($data['role'])->equals('keyhan');
        expect($data['sub'])->equals('_subject_');
        expect($data['exp'])->greaterOrEquals($this->time);
        expect($data['nbf'])->lessOrEquals($this->time + 100);
    }

    public function testDecodeIllegitimate()
    {
        try {
            $data = (array)JwtPayload::decodeJwt('Some_Wrong Text');
            expect('Could not See the Expected Exception.', true)->false();
        } catch (Exception $e) {
        }
    }

    public function testCreateToken() {
        $jwt = new \khans\utils\components\JwtPayload();
        expect($jwt->getJwt('_subject_'))->equals($this->jwt);
    }
}