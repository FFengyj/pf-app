<?php

namespace App\Models;

use Pf\System\Core\Mvc\ModelBase;

/**
 * Class ExampleModel
 * @package App\Models
 */
class ExampleModel extends ModelBase
{
    public $user_id;                          //用户id
    public $group_id = 0;                     //用户组id
    public $account = '';                     //账号
    public $updated_at = null;                //更新时间
    public $created_at;                       //创建时间

    public function beforeCreate(): void
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate(): void
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return 'info_example';
    }

    public function jsonSerializeDefault(): void
    {
        $this->json_serialize = [
            'user_id' => $this->user_id,
            'group_id' => $this->group_id,
            'account' => $this->account,
        ];
    }

}
