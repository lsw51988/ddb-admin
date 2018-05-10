<?php
/**
 * Created by PhpStorm.
 * User: lsw
 * Date: 18-4-18
 * Time: 下午11:43
 */

namespace Ddb\Service\File;


use Ddb\Service\BaseService;
use League\Flysystem\Config;

class Manager extends BaseService
{

    public function getConfig()
    {
        return new Config();
    }

    /**
     * @param $filePath
     * @param $fileContent
     * @return array|bool|false
     */
    public function saveFile($filePath, $fileContent, $prams = [])
    {
        $config = $this->getConfig();
        foreach ($prams as $k => $v) {
            $config->set($k, $v);
        }
        return di("filesystem")->write($filePath, $fileContent, $config);
    }

    public function deleteFile($filePath)
    {
        return di("filesystem")->delete($filePath);
    }

}