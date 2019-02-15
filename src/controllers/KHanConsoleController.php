<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 12/5/16
 * Time: 12:23 PM
 */


namespace khans\utils\controllers;


use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class KHanWebController offers common behavior for console controllers
 *
 * @package khans\utils\controllers
 * @version 0.2.0-971030
 * @since 1.0
 */
class KHanConsoleController extends Controller
{
    /**
     * Send eMail to the Admin about events in the console.
     *
     * @param string $subject context of the email.
     * @param string $content details of the event.
     *
     * @return bool result of sending email
     */
    protected function mailToAdmin($subject, $content): bool
    {
        return \Yii::$app->mailer
            ->compose()
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->setTo(\Yii::$app->params['adminEmail'])
            ->setSubject($subject)
            ->setTextBody($content)
            ->send();
    }

//    /**
//     * Clear mail subdirectory in th runtime data
//     *
//     * @param string $mailSubDir a subdirectory in the runtime holding usage specific mails
//     *
//     * @return int Exit code showing the status. 0 means no error.
//     */
//    public function actionClearMails($mailSubDir): int
//    {
//        $targetPath = '@runtime/mail/' . $mailSubDir;
//
//        return $this->clearPath($targetPath);
//    }

    /**
     * Clear logs subdirectory in th runtime data
     *
     * @param string $logsSubDir a subdirectory in the runtime logs containing logs for a specific controller
     *
     * @return int Exit code showing the status. 0 means no error.
     */
    public function actionClearLogs($logsSubDir): int
    {
        $targetPath = '@runtime/logs/' . $logsSubDir;

        return $this->clearPath($targetPath);
    }

    /**
     * Clear data --usually runtime files-- from the given directory
     *
     * @param string $targetPath path or alias to the directory to clear data
     *
     * @return int Exit code showing the status. 0 means no error.
     */
    private function clearPath(string $targetPath): int
    {
        $glob = \Yii::getAlias($targetPath) . '/*';
        foreach (glob($glob) as $filename) {
            if (!unlink($filename)) {
                return ExitCode::OSERR;
            }
        }

        return ExitCode::OK;
    }
}
