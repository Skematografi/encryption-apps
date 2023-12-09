<?php

namespace App;

class AppHelper
{
    public static function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            return true;
        }

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }

        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }

        rmdir($dirPath);

        return true;
    }
}
