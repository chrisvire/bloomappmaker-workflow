<?php

use yii\db\Schema;
use yii\db\Migration;

class m160805_192852_create_workflow_table extends Migration
{
    public function up()
    {
        $this->createTable('{{workflow}}', [
            'id' => Schema::TYPE_PK,
            'project_name'=> Schema::TYPE_STRING ,
            'app_definition_id'=> Schema::TYPE_STRING ,
            'build_state'=> Schema::TYPE_STRING,
            'job_id'=> Schema::TYPE_INTEGER,
            'build_id'=> Schema::TYPE_INTEGER,
            'release_id'=> Schema::TYPE_INTEGER,
            'data'=> Schema::TYPE_STRING,

            'created' => 'datetime null',
            'updated' => 'datetime null',
        ],"ENGINE=InnoDB DEFAULT CHARSET=utf8");

    }

    public function down()
    {
        $this->dropTable("{{workflow}}");
    }
}
