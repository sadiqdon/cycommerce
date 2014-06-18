<?php

class HttpRequest extends CHttpRequest
{

    private $_ipAddress;

    public function init()
    {
        parent::init();
    }
	
	public function getUserHost()
	{
	   $host = null;
	   // Check if the value is set
	   if (isset($_SERVER['HTTP_HOST']))
	   {
		  $host = $_SERVER['HTTP_HOST'];
	   }
	   elseif(isset($_SERVER['REMOTE_HOST'])){
			$host = $_SERVER['REMOTE_HOST'];
	   }
	   // If HOST header is missing, we're possibly dealing with Apache's mod_proxy
	   elseif (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
	   {
		  if (strpos($_SERVER['HTTP_X_FORWARDED_HOST'], ',') !== FALSE)
		  {
			 $hostNames = explode(',', $_SERVER['HTTP_X_FORWARDED_HOST']);
			 $host = array_shift($hostNames);
		  }
		  else
		  {
			 $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
		  }
	   }
	   return $host;
	}

    public function getUserHostAddress()
    {
        if($this->_ipAddress !== null)
                        return $this->_ipAddress;
            
                if (isset($_SERVER['REMOTE_ADDR']) AND isset($_SERVER['HTTP_CLIENT_IP']))
                        $this->_ipAddress = $_SERVER['HTTP_CLIENT_IP'];
                elseif (isset($_SERVER['REMOTE_ADDR']))
                        $this->_ipAddress = $_SERVER['REMOTE_ADDR'];
                elseif(isset($_SERVER['HTTP_CLIENT_IP']))
                        $this->_ipAddress = $_SERVER['HTTP_CLIENT_IP'];
                elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                        $this->_ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

                if ($this->_ipAddress === FALSE)
                {
                        $this->_ipAddress = '0.0.0.0';
                        return $this->_ipAddress;
                }

                if (strpos($this->_ipAddress, ',') !== FALSE)
                {
                        $x = explode(',', $this->_ipAddress);
                        $this->_ipAddress = trim(end($x));
                }
        
                if (!$this->isValidIp($this->_ipAddress))
                        $this->_ipAddress = '0.0.0.0';
                return $this->_ipAddress;
    }

    public function isValidIp($ip)
    {
        $ipSegments = explode('.', $ip);
                
        if (count($ipSegments) != 4)
                        return false;

                if ($ipSegments[0][0] == '0')
                        return false;

                foreach ($ipSegments as $segment)
                {
                        if ($segment=='' OR preg_match("/[^0-9]/", $segment) OR $segment > 255 OR strlen($segment) > 3)
                                return false;
                }
                return true;
    }
        
}