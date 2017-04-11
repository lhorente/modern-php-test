<?php
namespace lhorente\Utils;

class UriUtil{
	private $fragments = array();
	
	public function __construct(){
		$this->generateFragments();
	}
	
	private function getFullUrl(){
		$uri = $_SERVER['REQUEST_URI'];
		 
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		 
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		 
		$query = $_SERVER['QUERY_STRING'];
		
		return $url;
	}
	
	private function generateFragments(){
		$uri = str_replace(BASE_URL,'',$this->getFullUrl());
		
		if ($uri){
			$fragments = explode('/',$uri);
			if ($fragments){
				$this->fragments = $fragments;
			}
		}
	}

	Public function getController(){
		if ($this->fragments && is_array($this->fragments) && isset($this->fragments[0])){
			return ucfirst($this->fragments[0]).'Controller';
		}
		return false;
	}
	
	Public function getAction(){
		if ($this->fragments && is_array($this->fragments) && isset($this->fragments[1])){
			return $this->fragments[1];
		}
		return false;
	}
	
	Public function getId(){
		if ($this->fragments && is_array($this->fragments) && isset($this->fragments[2])){
			return $this->fragments[2];
		}
		return false;
	}
}