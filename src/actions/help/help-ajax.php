<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 7/21/16
 * Time: 5:01 PM
 */

/* @var $this yii\web\View */
/* @var string $page URL of the requested help file */
/* @var string $helpFile FQN of the requested help file */

/* @var array|false $hint if help file not found details of the request */

use yii\helpers\Markdown;

?>
<div>
    <?= Markdown::process(file_get_contents($helpFile), 'gfm'); ?>

    <?php if ($hint !== false): ?>
        <div class="alert alert-info ltr">
            <h3>Request Data:</h3>
            <p>Referrer: <strong><?= $hint['referer'] ?></strong></p>
            <p>Requested Help Page: <strong><?= $hint['page'] ?></strong></p>
            <p>Shown Help File: <strong><?= $hint['file'] ?></strong></p>
        </div>
    <?php endif; ?>
</div>
