<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use khans\utils\widgets\menu\OverlayMenu;
use kartik\spinner\SpinnerAsset;

SpinnerAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta name="author" content="Keyhan Sedaghat">
        <meta name="author" content="mailto:keyhansedaghat@netscape.net">
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <div id="spinner-frame" style="position: fixed; margin-top: 250px; width: 100%;">
                <div id="spinner-span" style="width: 10%;" class="center-block text-center"></div>
            </div>
            <?php
            NavBar::begin([
                'brandLabel' => 'KHanS Utils Demo Pages',
                'brandUrl'   => Yii::$app->homeUrl,
                'options'    => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],

                    '<li>' . Html::a('راهنما', '#', [
                'title' => 'راهنمای به کارگیری این صفحه',
                'onclick' => "
$('#modalHelp').modal('show');
$.ajax({
    type: 'POST',
    cache: false,
    url: '" . Url::to([
            'help',
            'action' => $this->context->action->id,
        ]) . "',
    success: function(response) {
        $('#modalHelp .modal-body').html(response);
    },
});
return false;
",
            ]) . '</li>',
                   '<li>' .
                    OverlayMenu::widget([
    'title'      => 'General Menu',
    'label'      => 'منوی سریع',
    'tag'        => 'a',
    'csvFileUrl' => '@khan/demos/data/sample-menu.csv',
    'options'    => ['class' => 'btn btn-link'],
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
]) . '</li>',

                    Yii::$app->user->isGuest ? (
                            ['label' => 'Login', 'url' => ['/site/login']]
                            ) : (
                            '<li>'
                            . Html::beginForm(['/system/auth/logout'], 'post')
                            . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->username . ')',
                                    ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>'
                            )
                ],
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
<?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; Demo Pages of KHanS-Utils <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
   <?php
    Modal::begin([
        'size'        => Modal::SIZE_LARGE,
        'closeButton' => ['label' => 'ببند', 'class' => 'btn btn-success pull-left'],
        'id'          => 'modalHelp',
        'header'      => '<h4><small>راهنما:</small> <mark>' . $this->title . '</mark></h4>',
        'footer'      => '<p>&nbsp;' .
        '<span class="pull-left">' . Yii::getVersion() . '</span>' .
        '</p>',
    ]);
    Modal::end();
    ?>
