<?php
/**
 * Created by PhpStorm.
 * User: hubbard
 * Date: 8/5/16
 * Time: 3:43 PM
 */

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

use common\helpers\Utils;

class Workflow extends WorkflowBase implements Linkable
{

    const STATUS_INITIALIZED = 'initialized';
    const STATUS_PROJECT_DEFINITION = 'projectdefinition';
    const STATUS_APPROVAL = 'approval';
    const STATUS_APPROVE_PUBLISH = 'approvepublish';
    const STATUS_PUBlISH_APP = 'publishapp';
    const STATUS_PUBlISHED = 'published';
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(),[

        ]);
    }
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),[
            [
                ['created','updated'],'default', 'value' => Utils::getDatetime(),
            ],
            [
                'updated', 'default', 'value' => Utils::getDatetime(), 'isEmpty' => function(){
                    // always return true so it get set on every save
                    return true;
                },
            ],
            [
                'build_state', 'in', 'range' => [
                self::STATUS_INITIALIZED,
                self::STATUS_PROJECT_DEFINITION,
                self::STATUS_APPROVAL,
                self::STATUS_APPROVE_PUBLISH,
                self::STATUS_PUBlISH_APP,
                self::STATUS_PUBlISHED,
            ],
            ],
            [
                'build_state', 'default', 'value' => self::STATUS_INITIALIZED,
            ],
            [
                'updated', 'default', 'value' => Utils::getDatetime(), 'isEmpty' => function(){
                    // always return true so it get set on every save
                    return true;
                },
            ],
        ]);
    }

    protected function getNextStep()
    {
        $id = 0;
        switch ($this->build_state) {
            case self::STATUS_PROJECT_DEFINITION:
                $id = 1594;
                break;
            case self::STATUS_APPROVE_PUBLISH:
                $id = 1602;
                break;
        }

        return [
            'id' => $id,
            'name' => $this->build_state,
        ];
    }
    
    protected function getData() {
        $data = [
            'ci_job_id' => $this->job_id,
            'ci_build_id' => $this->build_id,
            'project_name' => $this->project_name,
        ];

//        switch ($this->build_state) {
//            case self::STATUS_APPROVE_PUBLISH:
//                $array['artifacts'] = [
//                    "about" => "https://s3-us-west-2.amazonaws.com/sil-appbuilder-artifacts/staging-dockerCloud-lsdev/jobs/build_scriptureappbuilder_74/1/about.txt",
//                    "apk" => "https://s3-us-west-2.amazonaws.com/sil-appbuilder-artifacts/staging-dockerCloud-lsdev/jobs/build_scriptureappbuilder_74/1/Kuna_Gospels-1.11.1.apk",
//                    "consoleText" => "https://s3-us-west-2.amazonaws.com/sil-appbuilder-artifacts/staging-dockerCloud-lsdev/jobs/build_scriptureappbuilder_74/1/consoleText",
//                    "package_name" => "https://s3-us-west-2.amazonaws.com/sil-appbuilder-artifacts/staging-dockerCloud-lsdev/jobs/build_scriptureappbuilder_74/1/package_name.txt",
//                    "play-listing" => "https://s3-us-west-2.amazonaws.com/sil-appbuilder-artifacts/staging-dockerCloud-lsdev/jobs/build_scriptureappbuilder_74/1/play-listing/index.html",
//                    "version_code" => "https://s3-us-west-2.amazonaws.com/sil-appbuilder-artifacts/staging-dockerCloud-lsdev/jobs/build_scriptureappbuilder_74/1/version_code.txt"
//                ];
//                break;
//        }

        return $data;
    }
    public function fields()
    {
        return [
            'next_step' => function() { return $this->getNextStep(); },
            'data' => function() { return $this->getData(); },
            'created' => function(){
                return Utils::getIso8601($this->created);
            },
            'updated' => function(){
                return Utils::getIso8601($this->updated);
            },
            'build_state' => function() { return 'request_in_progress'; }
        ];
    }

    public function getLinks()
    {
        $links = [];
        if($this->id){
            $links[Link::REL_SELF] = Url::toRoute(['/workflow/'.$this->id], true);
        }
        return $links;
    }

    public static function findById($id)
    {
        return self::findOne(['id' => $id]);
    }

}