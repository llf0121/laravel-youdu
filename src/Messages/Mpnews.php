<?php

namespace Huangdijia\Youdu\Messages;

class Mpnews extends Message
{
    protected $toUser;
    protected $toDept;
    protected $mpnews;

    /**
     * 图文消息
     *
     * @param string $toUser 接收成员帐号列表。多个接收者用竖线分隔，最多支持1000个
     * @param string $toDept 接收部门id列表。多个接收者用竖线分隔，最多支持100个
     * @param \Huangdijia\Youdu\Messages\Items\Mpnews $mpnews 消息内容，支持表情，最长不超过600个字符，超出部分将自动截取
     */
    public function __construct($toUser = '', $toDept = '', \Huangdijia\Youdu\Messages\Items\Mpnews $mpnews)
    {
        $this->toUser = $toUser;
        $this->toDept = $toDept;
        $this->mpnews = $mpnews;
    }

    public function toArray()
    {
        return [
            "toUser"  => $this->toUser,
            "toDept"  => $this->toDept,
            "msgType" => "mpnews", // 消息类型，这里固定为：mpnews
            "mpnews"  => $this->mpnews->toArray(),
        ];
    }
}
