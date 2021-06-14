<?php

namespace Hosomikai\Ezship\Contracts;

interface EzshipResponseContract extends EzshipApiCode
{
    /**
     * 是否成功
     */
    public function isSuccess(): bool;

    /**
     * 是否失敗.
     */
    public function fails(): bool;

    /**
     * 取得api狀態訊息.
     */
    public function getMessage(): ?string;

    /**
     * 取得自訂網站參數.
     */
    public function getWebPara(): ?array;
}
