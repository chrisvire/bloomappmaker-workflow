<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "workflow".
 *
 * @property integer $id
 * @property string $project_name
 * @property string $app_definition_id
 * @property string $build_state
 * @property integer $job_id
 * @property integer $build_id
 * @property integer $release_id
 * @property string $data
 * @property string $created
 * @property string $updated
 */
class WorkflowBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workflow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'build_id', 'release_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['project_name', 'app_definition_id', 'build_state', 'data'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_name' => Yii::t('app', 'Project Name'),
            'app_definition_id' => Yii::t('app', 'App Definition ID'),
            'build_state' => Yii::t('app', 'Build State'),
            'job_id' => Yii::t('app', 'Job ID'),
            'build_id' => Yii::t('app', 'Build ID'),
            'release_id' => Yii::t('app', 'Release ID'),
            'data' => Yii::t('app', 'Data'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
}
