<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 14-5-25
 * Time: 下午5:45.
 */
namespace Common\models;

use Arsenals\Core\Abstracts\Model;

/**
 * 上传文件模型.
 */
class Upload extends Model
{
    public function addImage(array $meta)
    {
        return $this->save($meta);
    }

    public function getFileBySig($sig)
    {
        return $this->load(['file_sig' => $sig]);
    }

    public function getAllImages($p)
    {
        if (is_null($p) || !is_numeric($p)) {
            $p = 1;
        }

        return [
            'data'  => $this->find([], '', $p),
            'page'  => $this->getPageCounts(),
            'total' => $this->getPageRecordCounts(),
        ];
    }
}
