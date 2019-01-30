<?php
namespace AppBundle\StandaloneCache;

use Symfony\Component\Cache\Simple\FilesystemCache;


class StandaloneCache
{
	public static $cache=null;
	public static $ttl=900;

	public static function initCache(){
		if(self::$cache===null)
			self::$cache=new FilesystemCache();
	}

	public static function writeInCache($key,$value,$ttl=null){
		StandaloneCache::initCache();

		if($ttl!=null)
			self::$cache->set($key,$value,$ttl);
		else
			self::$cache->set($key,$value,self::$ttl);
	}

	public static function getCache($key){
		StandaloneCache::initCache();

		return self::$cache->get($key,null);
	}

	public static function removeInCache($key){
		StandaloneCache::initCache();

		self::$cache->deleteItem($key);
	}
}