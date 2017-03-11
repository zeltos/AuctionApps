<?php

/**
 *
 */
class Frontend
{
  public function getBaseUrl() {
   $currentPath = $_SERVER['PHP_SELF'];
   $pathInfo = pathinfo($currentPath);
   $hostName = $_SERVER['HTTP_HOST'];
   $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
   return $protocol.$hostName.$pathInfo['dirname']."/";
  }

  public function getMediaUrl() {
    return $this->getBaseUrl().'media/';
  }

}

$frontend = new Frontend();



?>
