<?php

class SmsTest extends TestCase
{
    protected $service;

    public function setUp()
    {
        parent::setUp();
        Session::start();

        $this->smsFactory = new \SMSApi\Api\SmsFactory($this->proxy(), $this->client());
    }

    public function testSend()
    {
        $dateSend = time() + 86400;

        $action = $this->smsFactory->actionSend();

        $result =
            $action
                ->setText("test [%1%] message")
                ->setTo($this->getNumberTest())
                ->SetParam(0, 'asd')
                ->setDateSent($dateSend)
                ->setNotifyUrl('http://example.com')
                ->execute();

        echo "SmsSend:\n";

        $this->renderStatusResponse($result);

        $ids = $this->collectIds($result);

        $this->assertCount(1, $ids);
        $this->assertEquals(0, $this->countErrors($result));

        return $ids;
    }
}
