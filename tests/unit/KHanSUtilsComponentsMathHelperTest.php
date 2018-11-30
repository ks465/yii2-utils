<?php

use khans\utils\components\MathHelper;

class KHanSUtilsComponentsMathHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testFloorByDefaultStep()
    {
        expect('default -1.00', MathHelper::floorBy(-1.00))->equals(-1.0);
        expect('default -0.90', MathHelper::floorBy(-0.90))->equals(-1.0);
        expect('default -0.50', MathHelper::floorBy(-0.50))->equals(-0.5);
        expect('default -0.50', MathHelper::floorBy(-0.35))->equals(-0.5);
        expect('default -0.35', MathHelper::floorBy(-0.01))->equals(-0.5);

        expect('default 0.00', MathHelper::floorBy(0.00))->equals(0.0);
        expect('default 0.05', MathHelper::floorBy(0.05))->equals(0.0);
        expect('default 0.45', MathHelper::floorBy(0.45))->equals(0.0);

        expect('default 0.50', MathHelper::floorBy(0.50))->equals(0.5);
        expect('default 0.55', MathHelper::floorBy(0.55))->equals(0.5);
        expect('default 0.95', MathHelper::floorBy(0.95))->equals(0.5);

        expect('default 1.00', MathHelper::floorBy(1.00))->equals(1.0);
        expect('default 1.45', MathHelper::floorBy(1.45))->equals(1.0);

        expect('default 1.50', MathHelper::floorBy(1.50))->equals(1.5);

        expect('default 15.40', MathHelper::floorBy(15.40))->equals(15.0);
    }

    public function testFloorBy0_2Step()
    {
        $step = 0.2;
        expect('default -1.00', MathHelper::floorBy(-1.00, $step))->equals(-1.0);
        expect('default -0.90', MathHelper::floorBy(-0.90, $step))->equals(-1.0);
        expect('default -0.50', MathHelper::floorBy(-0.50, $step))->equals(-0.6);
        expect('default -0.50', MathHelper::floorBy(-0.35, $step))->equals(-0.4);
        expect('default -0.35', MathHelper::floorBy(-0.01, $step))->equals(-0.2);

        expect('default 0.00', MathHelper::floorBy(0.00, $step))->equals(0.0);
        expect('default 0.05', MathHelper::floorBy(0.05, $step))->equals(0.0);
        expect('default 0.45', MathHelper::floorBy(0.45, $step))->equals(0.4);

        expect('default 0.50', MathHelper::floorBy(0.50, $step))->equals(0.4);
        expect('default 0.55', MathHelper::floorBy(0.55, $step))->equals(0.4);
        expect('default 0.95', MathHelper::floorBy(0.95, $step))->equals(0.8);

        expect('default 1.00', MathHelper::floorBy(1.00, $step))->equals(1.0);
        expect('default 1.45', MathHelper::floorBy(1.45, $step))->equals(1.4);

        expect('default 1.50', MathHelper::floorBy(1.50, $step))->equals(1.4);

        expect('default 15.40', MathHelper::floorBy(15.40, $step))->equals(15.4);
    }

    public function testFloorBy0_75Step()
    {
        $step = 0.75;
        expect('default -1.00', MathHelper::floorBy(-1.00, $step))->equals(-1.5);
        expect('default -0.90', MathHelper::floorBy(-0.90, $step))->equals(-1.5);
        expect('default -0.50', MathHelper::floorBy(-0.50, $step))->equals(-0.75);
        expect('default -0.50', MathHelper::floorBy(-0.35, $step))->equals(-0.75);
        expect('default -0.35', MathHelper::floorBy(-0.01, $step))->equals(-0.75);

        expect('default 0.00', MathHelper::floorBy(0.00, $step))->equals(0.0);
        expect('default 0.05', MathHelper::floorBy(0.05, $step))->equals(0.0);
        expect('default 0.45', MathHelper::floorBy(0.45, $step))->equals(0.0);

        expect('default 0.50', MathHelper::floorBy(0.50, $step))->equals(0.0);
        expect('default 0.55', MathHelper::floorBy(0.55, $step))->equals(0.0);
        expect('default 0.95', MathHelper::floorBy(0.95, $step))->equals(0.75);

        expect('default 1.00', MathHelper::floorBy(1.00, $step))->equals(0.75);
        expect('default 1.45', MathHelper::floorBy(1.45, $step))->equals(0.75);

        expect('default 1.50', MathHelper::floorBy(1.50, $step))->equals(1.5);

        expect('default 15.40', MathHelper::floorBy(15.40, $step))->equals(15.0);
    }

    public function testFloorBy1_0Step()
    {
        $step = 1.0;
        expect('default -1.00', MathHelper::floorBy(-1.00, $step))->equals(-1.0);
        expect('default -0.90', MathHelper::floorBy(-0.90, $step))->equals(-1.0);
        expect('default -0.50', MathHelper::floorBy(-0.50, $step))->equals(-1.0);
        expect('default -0.50', MathHelper::floorBy(-0.35, $step))->equals(-1.0);
        expect('default -0.35', MathHelper::floorBy(-0.01, $step))->equals(-1.0);

        expect('default 0.00', MathHelper::floorBy(0.00, $step))->equals(0.0);
        expect('default 0.05', MathHelper::floorBy(0.05, $step))->equals(0.0);
        expect('default 0.45', MathHelper::floorBy(0.45, $step))->equals(0.0);

        expect('default 0.50', MathHelper::floorBy(0.50, $step))->equals(0.0);
        expect('default 0.55', MathHelper::floorBy(0.55, $step))->equals(0.0);
        expect('default 0.95', MathHelper::floorBy(0.95, $step))->equals(0.0);

        expect('default 1.00', MathHelper::floorBy(1.00, $step))->equals(1.0);
        expect('default 1.45', MathHelper::floorBy(1.45, $step))->equals(1.0);

        expect('default 1.50', MathHelper::floorBy(1.50, $step))->equals(1.0);

        expect('default 15.40', MathHelper::floorBy(15.40, $step))->equals(15.0);
    }

    public function testFloorBy1_3Step()
    {
        $step = 1.3;
        expect('default -1.00', MathHelper::floorBy(-1.00, $step))->equals(-1.3);
        expect('default -0.90', MathHelper::floorBy(-0.90, $step))->equals(-1.3);
        expect('default -0.50', MathHelper::floorBy(-0.50, $step))->equals(-1.3);
        expect('default -0.50', MathHelper::floorBy(-0.35, $step))->equals(-1.3);
        expect('default -0.35', MathHelper::floorBy(-0.01, $step))->equals(-1.3);

        expect('default 0.00', MathHelper::floorBy(0.00, $step))->equals(0.0);
        expect('default 0.05', MathHelper::floorBy(0.05, $step))->equals(0.0);
        expect('default 0.45', MathHelper::floorBy(0.45, $step))->equals(0.0);

        expect('default 0.50', MathHelper::floorBy(0.50, $step))->equals(0.0);
        expect('default 0.55', MathHelper::floorBy(0.55, $step))->equals(0.0);
        expect('default 0.95', MathHelper::floorBy(0.95, $step))->equals(0.0);

        expect('default 1.00', MathHelper::floorBy(1.00, $step))->equals(0.0);
        expect('default 1.45', MathHelper::floorBy(1.45, $step))->equals(1.3);

        expect('default 1.50', MathHelper::floorBy(1.50, $step))->equals(1.3);

        expect('default 15.40', MathHelper::floorBy(15.40, $step))->equals(14.3);
    }
    public function testCeilByDefaultStep()
    {
        expect('default -1.00', MathHelper::ceilBy(-1.00))->equals(-1.0);
        expect('default -0.90', MathHelper::ceilBy(-0.90))->equals(-0.5);
        expect('default -0.50', MathHelper::ceilBy(-0.50))->equals(-0.5);
        expect('default -0.50', MathHelper::ceilBy(-0.35))->equals(-0.0);
        expect('default -0.35', MathHelper::ceilBy(-0.01))->equals(-0.0);

        expect('default 0.00', MathHelper::ceilBy(0.00))->equals(0.0);
        expect('default 0.05', MathHelper::ceilBy(0.05))->equals(0.5);
        expect('default 0.45', MathHelper::ceilBy(0.45))->equals(0.5);

        expect('default 0.50', MathHelper::ceilBy(0.50))->equals(0.5);
        expect('default 0.55', MathHelper::ceilBy(0.55))->equals(1.0);
        expect('default 0.95', MathHelper::ceilBy(0.95))->equals(1.0);

        expect('default 1.00', MathHelper::ceilBy(1.00))->equals(1.0);
        expect('default 1.45', MathHelper::ceilBy(1.45))->equals(1.5);

        expect('default 1.50', MathHelper::ceilBy(1.50))->equals(1.5);

        expect('default 15.40', MathHelper::ceilBy(15.40))->equals(15.5);
    }

    public function testCeilBy0_2Step()
    {
        $step = 0.2;
        expect('default -1.00', MathHelper::ceilBy(-1.00, $step))->equals(-1.0);
        expect('default -0.90', MathHelper::ceilBy(-0.90, $step))->equals(-0.8);
        expect('default -0.50', MathHelper::ceilBy(-0.50, $step))->equals(-0.4);
        expect('default -0.50', MathHelper::ceilBy(-0.35, $step))->equals(-0.2);
        expect('default -0.35', MathHelper::ceilBy(-0.01, $step))->equals(0.0);

        expect('default 0.00', MathHelper::ceilBy(0.00, $step))->equals(0.0);
        expect('default 0.05', MathHelper::ceilBy(0.05, $step))->equals(0.2);
        expect('default 0.45', MathHelper::ceilBy(0.45, $step))->equals(0.6);

        expect('default 0.50', MathHelper::ceilBy(0.50, $step))->equals(0.6);
        expect('default 0.55', MathHelper::ceilBy(0.55, $step))->equals(0.6);
        expect('default 0.95', MathHelper::ceilBy(0.95, $step))->equals(1.0);

        expect('default 1.00', MathHelper::ceilBy(1.00, $step))->equals(1.0);
        expect('default 1.45', MathHelper::ceilBy(1.45, $step))->equals(1.6);

        expect('default 1.50', MathHelper::ceilBy(1.50, $step))->equals(1.6);

        expect('default 15.40', MathHelper::ceilBy(15.40, $step))->equals(15.4);
    }

    public function testCeilBy0_75Step()
    {
        $step = 0.75;
        expect('default -1.00', MathHelper::ceilBy(-1.00, $step))->equals(-0.75);
        expect('default -0.90', MathHelper::ceilBy(-0.90, $step))->equals(-0.75);
        expect('default -0.50', MathHelper::ceilBy(-0.50, $step))->equals(0.0);
        expect('default -0.50', MathHelper::ceilBy(-0.35, $step))->equals(0.0);
        expect('default -0.35', MathHelper::ceilBy(-0.01, $step))->equals(0.0);

        expect('default 0.00', MathHelper::ceilBy(0.00, $step))->equals(0.0);
        expect('default 0.05', MathHelper::ceilBy(0.05, $step))->equals(0.75);
        expect('default 0.45', MathHelper::ceilBy(0.45, $step))->equals(0.75);

        expect('default 0.50', MathHelper::ceilBy(0.50, $step))->equals(0.75);
        expect('default 0.55', MathHelper::ceilBy(0.55, $step))->equals(0.75);
        expect('default 0.95', MathHelper::ceilBy(0.95, $step))->equals(1.5);

        expect('default 1.00', MathHelper::ceilBy(1.00, $step))->equals(1.5);
        expect('default 1.45', MathHelper::ceilBy(1.45, $step))->equals(1.5);

        expect('default 1.50', MathHelper::ceilBy(1.50, $step))->equals(1.5);

        expect('default 15.40', MathHelper::ceilBy(15.40, $step))->equals(15.75);
    }

    public function testCeilBy1_0Step()
    {
        $step = 1.0;
        expect('default -1.00', MathHelper::ceilBy(-1.00, $step))->equals(-1.0);
        expect('default -0.90', MathHelper::ceilBy(-0.90, $step))->equals(0.0);
        expect('default -0.50', MathHelper::ceilBy(-0.50, $step))->equals(0.0);
        expect('default -0.50', MathHelper::ceilBy(-0.35, $step))->equals(0.0);
        expect('default -0.35', MathHelper::ceilBy(-0.01, $step))->equals(0.0);

        expect('default 0.00', MathHelper::ceilBy(0.00, $step))->equals(0.0);
        expect('default 0.05', MathHelper::ceilBy(0.05, $step))->equals(1.0);
        expect('default 0.45', MathHelper::ceilBy(0.45, $step))->equals(1.0);

        expect('default 0.50', MathHelper::ceilBy(0.50, $step))->equals(1.0);
        expect('default 0.55', MathHelper::ceilBy(0.55, $step))->equals(1.0);
        expect('default 0.95', MathHelper::ceilBy(0.95, $step))->equals(1.0);

        expect('default 1.00', MathHelper::ceilBy(1.00, $step))->equals(1.0);
        expect('default 1.45', MathHelper::ceilBy(1.45, $step))->equals(2.0);

        expect('default 1.50', MathHelper::ceilBy(1.50, $step))->equals(2.0);

        expect('default 15.40', MathHelper::ceilBy(15.40, $step))->equals(16.0);
    }

    public function testCeilBy1_3Step()
    {
        $step = 1.3;
        expect('default -1.00', MathHelper::ceilBy(-1.00, $step))->equals(0.0);
        expect('default -0.90', MathHelper::ceilBy(-0.90, $step))->equals(0.0);
        expect('default -0.50', MathHelper::ceilBy(-0.50, $step))->equals(0.0);
        expect('default -0.50', MathHelper::ceilBy(-0.35, $step))->equals(0.0);
        expect('default -0.35', MathHelper::ceilBy(-0.01, $step))->equals(0.0);

        expect('default 0.00', MathHelper::ceilBy(0.00, $step))->equals(0.0);
        expect('default 0.05', MathHelper::ceilBy(0.05, $step))->equals(1.3);
        expect('default 0.45', MathHelper::ceilBy(0.45, $step))->equals(1.3);

        expect('default 0.50', MathHelper::ceilBy(0.50, $step))->equals(1.3);
        expect('default 0.55', MathHelper::ceilBy(0.55, $step))->equals(1.3);
        expect('default 0.95', MathHelper::ceilBy(0.95, $step))->equals(1.3);

        expect('default 1.00', MathHelper::ceilBy(1.00, $step))->equals(1.3);
        expect('default 1.45', MathHelper::ceilBy(1.45, $step))->equals(2.6);

        expect('default 1.50', MathHelper::ceilBy(1.50, $step))->equals(2.6);

        expect('default 15.40', MathHelper::ceilBy(15.40, $step))->equals(15.6);
    }
}
