<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_config;
    
    public function getConfig($index = null)
    {
        if (empty($this->_config)) {
            $application = Zend_Registry::get('application');
            $this->_config = $application->getOptions();
        }
        
        return ($this->_config == null || !isset($this->_config[$index])) ? $this->_config 
                                                                          : $this->_config[$index];
    }
    
    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
        ));
        
        $autoloader->suppressNotFoundWarnings(false);
        $autoloader->setFallbackAutoloader(true);
        
        return $autoloader;
    }
    
    protected function _initView()
    {
        $controller = Zend_Controller_Front::getInstance();
    }
    
    protected function _initSession()
    {
        Zend_Session::start();
    }
    
    protected function _initDoctrineConnection()
    {
        //$this->bootstrap('doctrine');
    }
    
    protected function _initZendDb()
    {
        $config = $this->getConfig();
        
        $db = Zend_Db::factory ($config->db->adapter, $config->db->config->toArray ());
        Zend_Db_Table::setDefaultAdapter($db);
        #$db->getConnection ()->exec ( "SET NAMES utf8" );
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $db->setProfiler(true);
        Zend_Registry::set('db', $db);
    }
    
    protected function _initCache()
    {
        $frontendOptions = array('lifetime' => 7200,'automatic_serialization' => true);
        $backendOptions = array('cache_dir' => AP . '/data/cache/');
        $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        Zend_Registry::set('cache', $cache);
    }
    
    protected function _initLocale()
    {
        $locale = new Zend_Locale ('en_US');
        Zend_Registry::set('locale', $locale);
    }
}
