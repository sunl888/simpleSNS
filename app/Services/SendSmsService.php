<?php

namespace App\Services;


use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use App\Exceptions\SendSmsFailException;

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

        $result = $client->execute($sendSms);

        if ($result->Code !== 'OK') {
            throw new SendSmsFailException($result->Message);
        }
        return response()->isOk();
    }

}