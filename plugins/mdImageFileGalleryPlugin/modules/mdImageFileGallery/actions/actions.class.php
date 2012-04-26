<?php

/**
 * mdImageFileGallery actions.
 *
 * @package    lacasadepaseos
 * @subpackage mdImageFileGallery
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdImageFileGalleryActions extends sfActions
{
    /**
    * Executes index action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
        $this->category = $request->getParameter('cat');

        $images = mdImageFileGallery::getImagesByDate(array('path'=>$this->category, 'order'=>'desc', 'absolute'=>false));

        $this->pager = new mdArrayPager(null, sfConfig::get('app_mdImageFileGallery_list_pagerSize',30));
        $this->pager->setResultArray($images);
        $this->pager->setPage($this->getRequestParameter('page',1));
        $this->pager->init();

        $this->partialExists = mdBasicFunction::partialExists($this->category);
    }

    public function executeAdmin(sfWebRequest $request){
        $this->categories = mdImageFileGallery::getCategories();
    }

    public function executeUploader(sfWebRequest $request){
        $this->category = $request->getParameter('category', '');
        $this->setLayout(ProjectConfiguration::getActive()->getTemplateDir('mdImageFileGallery', 'clean.php').'/clean');
    }

    public function executeUploadBasicContent(sfWebRequest $request){
        try
        {
            $url = $this->upload($_FILES, $request->getParameter('category'), $request->getParameter('h'), $request->getParameter('w'));
            sfConfig::set('sf_web_debug', false);
            $this->setLayout ( false );
            return $this->renderText( "<script>parent.endUpload('" . $request->getParameter('category') . "');</script>");

        }catch(Exception $e){

            echo $e->getMessage();

        }

    }

    public function executeUploadGallery(sfWebRequest $request){
        try
        {
            $url = $this->upload($_FILES, $request->getParameter('category'), $request->getParameter('h', 70), $request->getParameter('w', 70));
            sfConfig::set('sf_web_debug', false);
            $this->setLayout ( false );
            return $this->renderText($url);

        } catch (Exception $e){

            echo $e->getMessage();

        }
    }

    private function upload($FILES, $category, $h, $w)
    {
        try {
            $path = MdFileHandler::checkPathFormat(mdImageFileGallery::PATH . '/'. $category);
            $file_name = MdFileHandler::upload($FILES, $path);
            $image = new mdImageFile($path . $file_name);
            return mdWebImage::getUrl($image, array('width' => $w, 'height' => $h));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function executeUpdateImageAlbum(sfWebRequest $request){
        $images = mdImageFileGallery::getImagesByDate(array('path'=>$request->getParameter('category'),'absolute'=>false));
        $images_content = $this->getPartial('album_content', array('category'=>$request->getParameter('category'), 'images'=>$images));
        return $this->renderText(json_encode($images_content));
    }

    public function executeDelete(sfWebRequest $request){
        $fileHash = $request->getParameter('file');
        $mdImage = new mdImageFile(base64_decode($fileHash));
        mdFileHandler::delete($mdImage->getName(), $mdImage->getPath());
        return $this->renderText('ok');
    }
    
    public function executeDownload(sfWebRequest $request)
    {
      $fileHash = $request->getParameter('file');
      $mdImage = base64_decode($fileHash);
      $info = pathinfo($mdImage);
      $this->output_file($mdImage, $info["basename"], $info["extension"]);
      return $this->renderText("");
    }
    
    function output_file($file, $name, $mime_type='') {
        /*
          This function takes a path to a file to output ($file),
          the filename that the browser will see ($name) and
          the MIME type of the file ($mime_type, optional).

          If you want to do something on download abort/finish,
          register_shutdown_function('function_name');
         */
        print_r($file);
        if (!is_readable($file))
            die('File not found or inaccessible!');

        $size = filesize($file);
        $name = rawurldecode($name);

        /* Figure out the MIME type (if not specified) */
        $known_mime_types = array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "php" => "text/plain"
        );

        if ($mime_type == '') {
            $file_extension = strtolower(substr(strrchr($file, "."), 1));
            if (array_key_exists($file_extension, $known_mime_types)) {
                $mime_type = $known_mime_types[$file_extension];
            } else {
                $mime_type = "application/force-download";
            };
        };

        @ob_end_clean(); //turn off output buffering to decrease cpu usage
        // required for IE, otherwise Content-Disposition may be ignored
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');

        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        /* The three lines below basically make the
          download non-cacheable */
        header("Cache-control: private");
        header('Pragma: private');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        // multipart-download and download resuming support
        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        /* output the file itself */
        $chunksize = 1 * (1024 * 1024); //you may want to change this
        $bytes_send = 0;
        if ($file = fopen($file, 'r')) {
            if (isset($_SERVER['HTTP_RANGE']))
                fseek($file, $range);

            while (!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                print($buffer); //echo($buffer); // is also possible
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
            die('Error - can not open file.');

        die();
    }    
}
