<?php

namespace Hosomikai\Ezship;

class EzshipApi
{
    /**
     * 網站辨認值.
     *
     * @var array
     */
    public $webParams = [];
    /**
     * 使用者帳號
     *
     * @var string
     */
    protected $appId;

    public function __construct(string $appId = null)
    {
        $this->appId = is_null($appId) ? config('ezship.app_id') : $appId;
    }

    /**
     * 設定 webPara.
     */
    public function withWebParams(array $params): self
    {
        $this->webParams = $params;

        return $this;
    }
}
