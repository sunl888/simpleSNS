<?php

namespace App\Services;


use App\Exceptions\SendSmsFailException;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;

class SendSmsService
{

    private $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param string|array $phoneNumbers 短信接收号码列表
     * @param array $templateParam 短信模板变量替换JSON串
     * @param string $signName 短信签名
     * @param string $templateCode 短信模板ID
     * @param string|null $outId 外部流水扩展字段,假如模板中存在变量需要替换则为必填项
     * @throws SendSmsFailException
     */
    public function send($phoneNumbers, $templateParam, $signName, $templateCode, $outId = null)
    {
        $client = new Client($this->config);
        $sendSms = new SendSms();
        $sendSms->setPhoneNumbers($phoneNumbers);
        $sendSms->setSignName($signName);
        $sendSms->setTemplateCode($templateCode);
        $sendSms->setTemplateParam($templateParam);
        $sendSms->setOutId($outId);

        //    阿里云短信服务接口触发天级流控Permits:10，这是个阿里云返回来的错误信息。
        //    错误原因是因为短信发送有默认的频率限制：
        //    限制如下：
        //    短信验证码 ：使用同一个签名，对同一个手机号码发送短信验证码，支持1条/分钟，5条/小时 ，累计10条/天。
        //    短信通知： 使用同一个签名和同一个短信模板ID，对同一个手机号码发送短信通知，支持50条/日
        $result = $client->execute($sendSms);

        if ($result->Code !== 'OK') {
            throw new SendSmsFailException($result->Message);
        }
        return response()->json(['message' => '验证码发送成功', 'code' => 200]);
    }
}