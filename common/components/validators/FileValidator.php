<?php
/**
 * Created by PhpStorm.
 * User: Qiang Wang
 * Date: 2019/12/20
 * Time: 14:28
 */

namespace common\components\validators;

use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * FileValidator verifies if an attribute is receiving a valid uploaded file.
 *
 * Note that you should enable `fileinfo` PHP extension.
 *
 * @property int $sizeLimit The size limit for uploaded files. This property is read-only.
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
class FileValidator extends \yii\validators\FileValidator
{
    /**
     * Checks if given uploaded file have correct type (extension) according current validator settings.
     * @param UploadedFile $file
     * @return bool
     * @throws InvalidConfigException when the `fileinfo` PHP extension is not installed and `$checkExtension` is `false`.
     */
    protected function validateExtension($file)
    {
        $extension = mb_strtolower($file->extension, 'UTF-8');

        if ($this->checkExtensionByMimeType) {
            $mimeType = FileHelper::getMimeType($file->tempName, null, false);
            if ($mimeType === null) {
                return false;
            }

            $extensionsByMimeType = FileHelper::getExtensionsByMimeType($mimeType);

            if (!in_array($extension, $extensionsByMimeType, true)) {
                // MS Office 2007 扩展(docx、xlsx)，其 MIME 类型为 application/zip 的特殊处理
                $msMimeTypes = ['application/zip'];
                $msExtensions = ['docx', 'xlsx'];
                if (!(in_array($mimeType, $msMimeTypes) && in_array($extension, $msExtensions)))
                {
                    return false;
                }
            }
        }

        if (!in_array($extension, $this->extensions, true)) {
            return false;
        }

        return true;
    }
}