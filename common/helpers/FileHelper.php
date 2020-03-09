<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2019/12/05
 * Time: 16:45
 */

namespace common\helpers;

/**
 * File system helper.
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class FileHelper extends \yii\helpers\FileHelper
{
    /**
     * Creates a new directory.
     *
     * This method is similar to the PHP `mkdir()` function except that
     * it uses `chmod()` to set the permission of the created directory
     * in order to avoid the impact of the `umask` setting.
     *
     * @param string $path path of the directory to be created.
     * @param int $mode the permission to be set for the created directory.
     * @param bool $recursive whether to create parent directories if they do not exist.
     * @return bool whether the directory is created successfully
     * @throws \yii\base\Exception if the directory could not be created (i.e. php error due to parallel changes)
     */
    public static function createDirectory($path, $mode = 0775, $recursive = true)
    {
        if (is_dir($path)) {
            return true;
        }
        $parentDir = dirname($path);
        // recurse if parent dir does not exist and we are not at the root of the file system.
        if ($recursive && !is_dir($parentDir) && $parentDir !== $path) {
            static::createDirectory($parentDir, $mode, true);
        }
        try {
            if (!mkdir($path, $mode)) {
                return false;
            }
        } catch (\Exception $e) {
            if (!is_dir($path)) {// https://github.com/yiisoft/yii2/issues/9288
                throw new \yii\base\Exception("Failed to create directory \"$path\": " . $e->getMessage(), $e->getCode(), $e);
            }
        }
        try {
            // return chmod($path, $mode);
            @chmod($path, $mode);
            return true;
        } catch (\Exception $e) {
            throw new \yii\base\Exception("Failed to change permissions for directory \"$path\": " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}