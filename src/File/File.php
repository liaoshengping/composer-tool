<?php


namespace Liaosp\Tool\File;


class File {
    /**
     * 文件夹大小
     * @param $path
     * @return int
     */
    public function size_dir($path) {
        $size = 0;
        $handle = opendir($path);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..')
                continue;
            $_path = $path . '/' . $item;
            if (is_file($_path))
                $size += filesize($_path);
            if (is_dir($_path))
                $size += self::size_dir($_path);
        }
        closedir($handle);
        return $size;
    }
    /**
     * 复制文件夹
     * @param $source
     * @param $dest
     */
    public function copy_dir($source, $dest) {
        if (!file_exists($dest))
            mkdir($dest);
        $handle = opendir($source);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..')
                continue;
            $_source = $source . '/' . $item;
            $_dest = $dest . '/' . $item;
            if (is_file($_source))
                copy($_source, $_dest);
            if (is_dir($_source))
                self::copy_dir($_source, $_dest);
        }
        closedir($handle);
    }
    /**
     * 删除文件夹
     * @param $path
     * @return bool
     */
    public function rm_dirs($path) {
        if(is_file($path)){
            unlink($path);
            return TRUE;
        } else if(!is_dir($path)){
            return FALSE;
        }
        $handle = opendir($path);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..')
                continue;
            $_path = $path . '/' . $item;
            if (is_file($_path))
                unlink($_path);
            if (is_dir($_path))
                self::rm_dirs($_path);
        }
        closedir($handle);
        return rmdir($path);
    }
    /**
     * @param $oldname 必需。规定要重命名的文件或目录。
     * @param $newname 必需。规定文件或目录的新名称。
     * @param $context 可选。规定文件句柄的环境。
     */
    public function re_name($oldname, $newname, $context) {
        return rename($oldname, $newname, $context);
    }

    /**
     * 直接执行拷贝
     *
     * @param type $source 源文件夹
     * @param type $dest 目标文件夹
     * @return boolean 是否成功
     */
    public function copy_all($source,$dest){
        if(is_file($source)){
            // 如果是文件就直接拷贝
            return copy($source, $dest);
        } else if(is_dir ($source)){
            return self::copy_dir($source, $dest);
        }
        return false;
    }
    /**
     * 获取目录下的所有文件
     * @param string $dir 文件夹路径
     * @return type
     */
    public function deep_scan_dir($dir) {
        $fileArr = array();
        $dirArr = array();
        $dir = rtrim($dir, '//');
        if (is_dir($dir)) {
            $dirHandle = opendir($dir);
            while (false !== ($fileName = readdir($dirHandle))) {
                $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
                if (is_file($subFile)) {
                    $fileArr[] = $subFile;
                } elseif (is_dir($subFile) && str_replace('.', '', $fileName) != '') {
                    $dirArr[] = $subFile;
                    $arr = self::deep_scan_dir($subFile);
                    $dirArr = array_merge($dirArr, $arr['dir']);
                    $fileArr = array_merge($fileArr, $arr['file']);
                }
            }
            closedir($dirHandle);
        }
        return array(
            'dir' => $dirArr,
            'file' => $fileArr
        );
    }

    /**
     * 获取文件后缀名
     *      该操作会将获取到的文件名转化为小写
     * @param string $file_name 文件名
     * @return string 后缀名
     */
    public function get_file_extension($file_name = ''){
        return strtolower(substr(strrchr($file_name, '.'), 1));
    }
}
