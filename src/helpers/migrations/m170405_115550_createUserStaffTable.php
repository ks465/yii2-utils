<?php

use KHanS\Utils\helpers\KHanMigration;
use yii\db\Schema;

//require_once 'KHanMigration.php';

/**
 * Create `user_staff` table for list of staff users and create the admin user
 */
class m170405_115550_createUserStaffTable extends KHanMigration
{
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_dept_staff_grade', $this->staffGradesTable);

        $this->dropForeignKey('fk_staff_dept_department', $this->staffDepartmentsTable);
//        $this->dropForeignKey('fk_depts_staff_department', $this->staffDepartmentsTable);

        $this->dropTable($this->staffDepartmentsTable);
        $this->dropTable($this->staffGradesTable);

        $this->dropTable($this->staffUserTable);
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createStaffTable();
        $this->createGradesTable();
        $this->createDepartmentsTable();
    }

    private function createStaffTable()
    {
        $this->createTable($this->staffUserTable, [
            'id'                   => $this->primaryKey(),
            'name'                 => $this->string(64)->notNull()->comment('نام'),
            'family'               => $this->string(128)->notNull()->comment('نام خانوادگی'),
            'username'             => $this->string(64)->notNull()->unique()->comment('شناسه کاربری'),
            'email'                => $this->string(64)->notNull()->unique()->comment('نشانی الکترونیکی'),
            'grade'                => $this->string(64)->comment('مقطع(های) مجاز') . ' COLLATE latin1_general_ci',
            'auth_key'             => $this->string(40)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status'               => $this->smallInteger()->notNull()->defaultValue(UserStaff::STATUS_ACTIVE)->comment('وضعیت کاربر'),
            'last_visit_time'      => Schema::TYPE_TIMESTAMP,
            'create_time'          => $this->timestamp()->notNull(),
            'update_time'          => $this->timestamp(),
            'delete_time'          => $this->timestamp(),
        ], $this->tableOptions);

        $this->createIndex('Staff_status_ix', $this->staffUserTable, 'status');
        $this->createIndex('Staff_user_ix', $this->staffUserTable, 'username');

        // Creates the default admin user
        $adminUser = new UserStaff();

        echo 'Please type the admin user info: ' . PHP_EOL;
        $this->readStdinUser('Email (e.g. admin@mydomain.com)', $adminUser, 'email');
        $this->readStdinUser('Type Username', $adminUser, 'username', $adminUser->email);
        $this->readStdinUser('Type Password', $adminUser, 'password', 'admin');

        $this->readStdinUser('Type Name', $adminUser, 'name', 'Admin');
        $this->readStdinUser('Type Family', $adminUser, 'family', 'AdminPur');

        if (!$adminUser->save()) {
            throw new \yii\console\Exception('Error when creating admin user.');
        }
        echo 'User created successfully.' . PHP_EOL;
    }

    /**
     * Read data from StdIn and create admin user
     *
     * @param           $prompt
     * @param UserStaff $model
     * @param           $field
     * @param string    $default
     *
     * @return string
     */
    private function readStdinUser($prompt, UserStaff $model, $field, $default = '')
    {
        while (!isset($input) || !$model->validate([$field])) {
            echo $prompt . (($default) ? " [$default]" : '') . ': ';
            $input = (trim(fgets(STDIN)));
            if (empty($input) && !empty($default)) {
                $input = $default;
            }
            $model->$field = $input;
        }

        return $input;
    }

    private function createGradesTable()
    {
        $fields = [
            'staff_id' => $this->Integer()->comment('نام همکار'),
            'degree'   => $this->latinChar(5)->notNull()->comment('مقطع(های) تحصیلی مجاز'),
        ];
        $this->createTableWithLoggers($this->staffGradesTable, $fields, $this->comment('مقطعهای تحصیلی مجاز همکاران'));

        $this->addPrimaryKey('StaffGrade_pk', $this->staffGradesTable, ['staff_id', 'degree']);

        $this->addForeignKey('fk_dept_staff_grade', $this->staffGradesTable, 'staff_id',
            $this->staffUserTable, 'id',
            'RESTRICT', 'RESTRICT');
    }

    private function createDepartmentsTable()
    {
        $fields = [
            'staff_id'      => $this->Integer()->comment('نام همکار'),
            'department_id' => $this->tinyInteger(4)->unsigned()->notNull()->comment('نام دانشکده'),
        ];
        $this->createTableWithLoggers($this->staffDepartmentsTable, $fields, $this->comment('رابطه همکاران با دانشکده'));

        $this->addPrimaryKey('StaffDept_pk', $this->staffDepartmentsTable, ['staff_id', 'department_id']);
        $this->addForeignKey('fk_staff_dept_department', $this->staffDepartmentsTable, 'staff_id',
            $this->staffUserTable, 'id', 'RESTRICT', 'RESTRICT');

    }
}
