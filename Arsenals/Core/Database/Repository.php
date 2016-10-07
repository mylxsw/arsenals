<?php

namespace Arsenals\Core\Database;

/**
 * 数据仓库操作接口.
 *
 * @author 管宜尧<mylxsw@126.com>
 */
interface Repository
{
    public function query($sql, $bind = false);

    public function execute($sql, $bind = false);
}
