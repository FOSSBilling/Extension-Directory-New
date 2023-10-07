<?php

namespace ExtensionDirectory;

class Tools
{
    /** 
     * @return array<string> 
     */
    public static function getFileList(string $dir, ?string $extension = null, ?bool $returnPath = false)
    {
        $dir = new \RecursiveDirectoryIterator($dir);
        $iterator = new \RecursiveIteratorIterator($dir);
        $files = array();
        foreach ($iterator as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == $extension || $extension == null) {
                $files[] = ($returnPath) ? $file->getPathname() : $file->getFilename();
            }
        }

        return $files;
    }
}
