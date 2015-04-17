<?php

namespace Ingewikkeld\WrapperBundle\Proxy;

class Sf1ContextProxy
{
    private $kernel, $legacyPath, $app, $env, $debug, $version;

    public function __construct($kernel, $legacyPath, $app, $env, $debug, $version)
    {
        $this->kernel     = $kernel;
        $this->legacyPath = $legacyPath;
        $this->app        = $app;
        $this->env        = $env;
        $this->debug      = $debug;
        $this->version    = $version;
    }

    public function getContext()
    {
        if (!class_exists('sfContext') || !\sfContext::getInstance()) {
            $this->initialiseSf1Context();
        }

        return \sfContext::getInstance();
    }

    protected function setConstants()
    {
        define('SF_ROOT_DIR',    $this->kernel->getRootDir().'/'.$this->legacyPath);
        define('SF_APP',         $this->app);
        define('SF_ENVIRONMENT', $this->env);
        define('SF_DEBUG',       $this->debug);
        define('SF_VERSION',     $this->version);
    }

    protected function initialiseSf1Context()
    {
        $this->setConstants();

        if (SF_VERSION === 1.0) {
            require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
        } elseif (SF_VERSION === 1.3 || SF_VERSION === 1.4) {
            require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'ProjectConfiguration.class.php');
            
            $configuration = \ProjectConfiguration::getApplicationConfiguration(SF_APP, $this->kernel->getEnvironment(), false);
            \sfContext::createInstance($configuration);
        } else {
            throw new \RuntimeException("Legacy version of symfony 1 not supported: " . $version);
        }
    }
}
