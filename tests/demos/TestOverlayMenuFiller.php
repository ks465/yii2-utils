<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 12/10/18
 * Time: 09:45
 */


namespace khans\utils\tests\demos;

use khans\utils\widgets\menu\OverlayMenu;
use khans\utils\widgets\menu\OverlayMenuFiller;

/**
 * Class TestOverlayMenuFiller load demo files for the overlay menu of the yii2-utils package
 *
 * @package khans\utils\tests\demos
 * @version 0.1.0-970915
 * @since   1.0
 */
class TestOverlayMenuFiller extends BaseTester
{
    public function testFiller()
    {
        $this->writeHeader('$menu = new OverlayMenuFiller([ \'csvFileUrl\' => \'@khan/tests/demos/sample-menu.csv\', ]);');

        $menu = new OverlayMenuFiller([
            'csvFileUrl' => '@khan/tests/demos/sample-menu.csv',
        ]);

        vd($menu);
    }

    public function testOverlayMenu()
    {
        $this->writeHeader('<pre class="ltr">echo OverlayMenu::widget([
                \'title\'      => \'منوی همگانی\',
                \'label\'      => \'منوی همگانی سامانه‌ها\',
                \'tag\'        => \'button\',
                \'csvFileUrl\' => \'@khan/tests/demos/sample-menu.csv\',
                \'options\'    => [\'class\' => \'btn btn-danger\'],
                \'tabs\'       => [
                    \'general\' => [
                        \'id\'    => \'general\',
                        \'title\' => \'همگانی\',
                        \'icon\'  => \'heart\',
                        \'admin\' => false,
                    ],
                    \'others\'  => [
                        \'id\'    => \'others\',
                        \'title\' => \'سایر\',
                        \'icon\'  => \'user\',
                        \'admin\' => false,
                    ],
                    \'management\'  => [
                        \'id\'    => \'management\',
                        \'title\' => \'مدیریت\',
                        \'icon\'  => \'alert\',
                        \'admin\' => true,
                    ],
                ],
            ]);</pre>');

        /** @noinspection PhpUnhandledExceptionInspection */
        echo OverlayMenu::widget([
            'title'      => 'General Menu',
            'label'      => 'This Is the Output',
            'tag'        => 'button',
            'csvFileUrl' => '@khan/tests/demos/sample-menu.csv',
            'options'    => ['class' => 'btn btn-danger'],
            'tabs'       => [
                'general'    => [
                    'id'    => 'general',
                    'title' => 'General',
                    'icon'  => 'heart',
                    'admin' => false,
                ],
                'others'     => [
                    'id'    => 'others',
                    'title' => 'Others',
                    'icon'  => 'user',
                    'admin' => false,
                ],
                'management' => [
                    'id'    => 'management',
                    'title' => 'Manager',
                    'icon'  => 'alert',
                    'admin' => true,
                ],
            ],
        ]);
    }
}
