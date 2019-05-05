<?php


namespace khans\utils\demos\data;


use khans\utils\models\KHanIdentity;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 *
 * @property mixed $actionHistory
 */
class KHanModel extends \khans\utils\models\KHanModel
{
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('test');
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function behaviors(): array
    {
        \nhkey\arh\managers\DBManager::$db = 'test';

        return [
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'blameable' => [
                'class'              => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'history'   => [
                'class'          => \nhkey\arh\ActiveRecordHistoryBehavior::class,
                'ignoreFields'   => ['created_at', 'created_by', 'updated_at', 'updated_by'],
                'managerOptions' => [
                    'tableName' => 'sys_history_database',
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     *
     * @param integer $ownerID requested Id
     *
     * @return KHanIdentity
     */
    protected function getResponsibleUser(int $ownerID = null): ?KHanIdentity
    {
        return Yii::$app->user->identityClass::findOne(1);
    }

    /**
     * Get list of recorded history for this record
     */
    public function getActionHistory()
    {
        return $this->hasMany(SysHistoryDatabase::class, ['field_id' => 'id'])
            ->andWhere(['table' => static::tableName()]);
    }
}