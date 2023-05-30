<?php
/**
 * 参数校验示例
 */

namespace App\Constants\Verify\Api;


use Pf\System\Verify\VerifyType;

/**
 * Class Example
 * @package App\Constants\Verify\Api
 * @author fyj
 */
class Example
{

    /**
     * 通过路由自动验证数据
     *
     * @var array
     */
    public static $SETTINGS = [

        //示例
        'test_1' => [
            VerifyType::NECESSARY         => [ //必传参数，只验证是否有该字段
                'params' => "缺少参数机构id",  //错误输出：缺少参数机构id
            ],
            VerifyType::IN_ARRAY          => [ //指定参数 是否是指定数组中的值，不是必选，参数中有该字段才去验证
                'params' => [
                    'array'   =>[0,1],           // 直接数组
                    'err_msg' => "性别参数值错误", // 指定错误提示，不写默认错误为： 参数[params]的值不在正确范围内
                ],
                'params2' => [
                    'array' => 'App\Simayi\Services\CourseService::getArr', //由指定方法返回数组
                    'err_msg' => "性别参数值错误!!",  // 指定错误提示，不写默认错误为： 参数[params2]的值不在正确范围内
                ]
            ],
            VerifyType::LENGTH_LIMIT => [ //字符串长度验证  不是必选，参数中有该字段才去验证
                'params' => [
                    'min'          => 5,     // 最小值，可省略
                    'max'          => 20,    // 最大值 ，可省略
                    'min_err_msg' => "标题不得少于5个字符",     // 指定展示的错误, 不写默认为：参数[%s]过短
                    'max_err_msg' => "标题不得大于20个字符",    // 指定展示的错误   不写默认为：参数[%s]过长
                ],
            ],
            VerifyType::NOT_NULL => [        // 是否为空 ''、null、'  '、[]  不包括 0  包含了验证 VerifyType::NECESSARY 的功能
                'params' => "价格参数不能为空"
            ],
            VerifyType::NUMERIC => [        // 是否是数字类型如 [0,1,-1,1.1,-1.1] 正负数、小数 不是必选
                'params'  => "购买基数必须为数字",  //自定义提示
                "params1",    //使用默认提示：参数[params1]必须为数字
            ],
            VerifyType::DIGITS => [  //验证指定参数是否为 正整数  不是必选
                'params'  => "观看次数必须是正整数", //自定义提示
                'params1'   // 使用默认提示：参数[params1]必须是正整数
            ],
            VerifyType::IS_JSON => [ //验证指定的参数是否为 json 字符串   不是必选
                'params' => "上传数据必选为json 字符串",  //自定义提示
                'params1',   //使用默认提示：参数[params1]的值必须为Json字符串
            ],
            VerifyType::PRICE => [  //验证是否是金额，保留两位小数，0 除外，负数除外。不是必选
                'params'  => "课程定价不是有效金额"
            ]
       ],

    ];


}
