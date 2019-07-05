<?php


namespace khans\utils\components\workflow;

use \raoul2000\workflow\base\{Workflow, Status};
use \khans\utils\components\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Class KHanWorkflowHelper offers helper function for managing workflow definitions
 *
 * @package KHanS\Utils
 * @version 0.2.1-980330
 * @since   1.0
 */
class KHanWorkflowHelper extends \raoul2000\workflow\helpers\WorkflowHelper
{

    /**
     * Check the workflow for preset requirements:
     * metadata for the workflow contains email and description
     * each status contains transition, label, metadata
     * each metadata contains actor, email, description
     *
     * @param Workflow $workflowArray
     *
     * @return array result and messages
     */
    public static function checkWorkflowStructure(Workflow $workflowArray) {
        $result = ['result' => true, 'messages' => []];

        if (is_null($workflowArray->getMetadata('email'))) {
            $result['result'] = false;
            $result['messages']['workflow'][] = 'Email is not defined.';
        }
        if ($workflowArray->getMetadata('description', false) === false) {
            $result['result'] = false;
            $result['messages']['workflow'][] = 'Description is not defined.';
        }

        foreach ($workflowArray->getAllStatuses() as $id => $status) {
            /* @var $status Status */
            if (empty($status->transitions)) {
                $result['result'] = false;
                $result['messages'][$id][] = 'Transitions are not defined.';
            }
            if ($status->getMetadata('description', false) === false) {
                $result['result'] = false;
                $result['messages'][$id][] = 'Description is not defined.';
            }

            if ($status->getMetadata('actor', false) === false) {
                $result['result'] = false;
                $result['messages'][$id][] = 'Actor is not defined.';
            }

            if (is_null($status->getMetadata('email', null))) {
                $result['result'] = false;
                $result['messages'][$id][] = 'Email is not defined.';
            }

            if (is_null($status->getMetadata('class', null))) {
                $result['result'] = false;
                $result['messages'][$id][] = 'Class is not defined.';
            }
            if (is_null($status->getMetadata('icon', null))) {
                $result['result'] = false;
                $result['messages'][$id][] = 'Icon is not defined.';
            }
            if (is_null($status->getMetadata('action', null))) {
                $result['result'] = false;
                $result['messages'][$id][] = 'Action --although optional-- is not defined.';
            }
        }

        return $result;
    }

    /**
     * Extract source path of workflow files from the application component
     *
     * @return string
     */
    public static function getWorkflowSource() {
        return ArrayHelper::getValue(\Yii::$app->components['workflowSource'], 'definitionLoader.path', null);
    }

    /**
     * Read list of defined workflow from the given directory
     *
     * @param string $sourceDir Alias of the file containing the defintion files
     * @return array
     */
    public static function getSourcesFiles($sourceDir) {
        $files = array_diff(scandir(\yii\helpers\Url::to($sourceDir)), ['..', '.']);
        array_walk($files, function (&$item) {
            $item = str_replace('.php', '', $item);
        });
        return $files;
    }

    /**
     * Get list of definitions and titles in a form suitable for select element
     *
     * @return array
     */
    public static function getSourcesTitles() {
        $source = KHanWorkflowHelper::getWorkflowSource();
        $files = KHanWorkflowHelper::getSourcesFiles($source);

        $titles = [];

        foreach ($files as $file) {
            $def = require \yii\helpers\Url::to($source) . '/' . $file . '.php';

            $titles[$file] = ArrayHelper::getValue($def, 'metadata.description', '--') . ' <small class="text-info">(' . $file . ')</small>';
        }
        return $titles;
    }

    /**
     * Check the definition for the workflow and given status for email definition.
     * If email config is set for workflow and email is not false for status it should send.
     *
     * @param Status $status
     * @return boolean
     */
    public static function shouldSendEmail(Status $status){
        $workflowEmail = $status->getWorkflow()->getMetadata('email');
        if (is_null($workflowEmail) or $workflowEmail === FALSE) {
            return FALSE;
        }

        return $status->getMetadata('email', false) !== false;
    }

    /**
     * Get default template for the email of the given workflow
     *
     * @param Workflow $workflowArray
     * @return string
     */
    public static function getDefaultMailTemplate(Workflow $workflowArray) {
        $workflowEmail = $workflowArray->getMetadata('email');
        if (is_null($workflowEmail) or $workflowEmail === FALSE) {
            return 'فرستادن ایمیل برای این گردش کار خاموش است.';
        }
        if($workflowEmail === true){
            return 'متن پیش‌فرض تعریف نشده است.';
        }
        return $workflowEmail;
    }
    /**
     * Extract body text of the email --if it is present.
     *
     * @param Status $status
     * @return NULL|string Body text of the email
     */
    public static function getEmailTemplate(Status $status) {
        if(false === KHanWorkflowHelper::shouldSendEmail($status)){
            //either workflow or status has not email
            return null;
        }
        //workflow has email enabled
        $text = $status->getMetadata('email', null);
        if(is_bool($text)){
            $text = $status->getWorkflow()->getMetadata('email');
            if(is_bool($text)){
                return $status->getMetadata('description',$status->getLabel());
            }
            return $text;
        }elseif(is_string($text)){
            return $text;
        }
    }

    public static function getAllowedStatusesByRole(Status $status) {
        if(is_null($status->getMetadata('actor'))){
            var_dump($status);
            return true;
        }
        //if Status->actor is in user roles...
        return true;
    }
}
