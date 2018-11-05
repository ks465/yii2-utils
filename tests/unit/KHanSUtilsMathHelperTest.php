<?php

class KHanSUtilsMathHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testDefaultFloorBy()
    {
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::floorBy(-0.2))->equals(-0.5);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::floorBy(0.2))->equals(0);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::floorBy(0.49))->equals(0);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::floorBy(0.5))->equals(0.5);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::floorBy(0.50))->equals(0.5);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::floorBy(0.7))->equals(0.5);
    }

    public function testDefaultCeilBy()
    {
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::ceilBy(-0.2))->equals(0);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::ceilBy(0.2))->equals(0.5);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::ceilBy(0.49))->equals(0.5);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::ceilBy(0.5))->equals(0.5);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::ceilBy(0.50))->equals(0.5);
        expect('Default step = 0.5', KHanS\Utils\components\MathHelper::ceilBy(0.7))->equals(1.0);
    }

    public function testStepedFloorBy()
    {
        $step = 0.75;

        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(-0.2, $step))->equals(-0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(0.2, $step))->equals(0);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(0.49, $step))->equals(0);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(0.5, $step))->equals(0);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(0.50, $step))->equals(0);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(0.7, $step))->equals(0);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(0.75, $step))->equals(0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(1.45, $step))->equals(0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(1.5, $step))->equals(1.5);
        expect("Step = $step", KHanS\Utils\components\MathHelper::floorBy(1.55, $step))->equals(1.5);
    }

    public function testStepedCeilBy()
    {
        $step = 0.75;

        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(-0.2, $step))->equals(0);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(0.2, $step))->equals(0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(0.49, $step))->equals(0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(0.5, $step))->equals(0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(0.50, $step))->equals(0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(0.7, $step))->equals(0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(0.75, $step))->equals(0.75);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(1.45, $step))->equals(1.5);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(1.5, $step))->equals(1.5);
        expect("Step = $step", KHanS\Utils\components\MathHelper::ceilBy(1.55, $step))->equals(2.25);
    }
}