<?php
DEFINE('JFILEBROWSER_PATH', sfConfig::get('sf_jfilebrowser_path', sfConfig::get('sf_upload_dir') . '/jfilebrowser'));

class jfilebrowser {

    const PATH = JFILEBROWSER_PATH;
    
    public static function directoryList()
    {
        $directorios = array();
        $dirs = mdImageFileGallery::getCategories(array('path' => self::PATH, 'order' => 'desc', 'absolute' => true));
        foreach($dirs as $directorio){
            $data = new stdClass();
            $data->name = $directorio;
            $data->cant = jfilebrowser::getCantFiles($directorio);
            $directorios[] = $data;
            unset ($data);
        }
        return $directorios;
    }

    public static function getCantFiles($category)
    {
        $total = 0;
        $handle = opendir(self::PATH . DIRECTORY_SEPARATOR . $category);
        if ($handle)
        {
            while (false !== ($file = readdir($handle)))
            {
                if ($file != "." && $file != ".." && $file != ".svn" && $file != ".depdblock" && $file != ".channels" && $file != ".depdb" && $file != ".filemap" && $file != ".registry" && $file != ".lock")
                {
                    $total++;
                }
            }
            closedir($handle);
        }
        return $total;
    }

    public static function getFiles($category)
    {
        $path = self::PATH . DIRECTORY_SEPARATOR . $category;
        return mdImageFileGallery::getImagesByDate(array('path' => $path, 'order' => 'desc', 'absolute' => true));
    }

    public static function createDirectory($directory)
    {
        if(file_exists(self::PATH . DIRECTORY_SEPARATOR . $directory))
        {
            throw new Exception('Directory already exist', 101);
        }

        return MdFileHandler::checkDirectory(self::PATH . DIRECTORY_SEPARATOR . $directory);
    }

    public static function deleteDirectory($directory)
    {
        if(!file_exists(self::PATH . DIRECTORY_SEPARATOR . $directory))
        {
            throw new Exception('Directory not exist', 102);
        }
        $files = self::getFiles($directory);
        foreach($files as $file)
        {
            MdFileHandler::delete($file->getName(), self::PATH . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR);
        }
        if (!@rmdir(self::PATH . DIRECTORY_SEPARATOR . $directory))
        {
        	throw new Exception('directory can not delete');
        }
    }

    public static function deleteFile($directory, $filename)
    {
        if(!file_exists(self::PATH . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $file))
        {
            throw new Exception('File not exist', 103);
        }

        MdFileHandler::delete($filename, self::PATH . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR);
    }

    public static function find($directory, $name)
    {
        $mdImageFiles = MdFileHandler::getList(self::PATH . DIRECTORY_SEPARATOR . $directory);
        foreach($mdImageFiles as $mdImageFile)
        {
            if($mdImageFile->getName() == $name)
            {
                return $mdImageFile;
            }
        }
        throw new Exception('file not exist', 104);
    }

}