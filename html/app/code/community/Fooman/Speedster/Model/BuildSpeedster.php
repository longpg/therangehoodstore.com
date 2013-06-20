<?php

/**
 * Extend Minify_Build so it returns the last modified timestamp only
 * Called from Magento
 * app/code/community/Fooman/Speedster/Block/Page/Html/Head.php
 *
 */
set_include_path( BP.DS.'lib'.DS.'minify'. PS . get_include_path());
require_once 'minify'.DS.'Minify'.DS.'Build.php';

class Fooman_Speedster_Model_BuildSpeedster extends Minify_Build {
	/**
     * Create a build object
     *
     * @param array $sources array of Minify_Source objects and/or file paths
     *
     * @return null
     */
    public function __construct($sources, $base = BP)
    {
        $max = 0;
        foreach ((array)$sources as $source) {
            if ($source instanceof Minify_Source) {
                $max = max($max, $source->lastModified);
            } elseif (is_string($source)) {
                if (0 === strpos($source, '//')) {
                    $source = $base . substr($source, 1);
                }
                if (is_file($source)) {

                    $max = max($max, filemtime($source));
                }
            }
        }
        $this->lastModified = $max;
        return $this;
    }


    /**
     * Get last modified
     * @param null
     * @return string
     */
        public function getLastModified() {
            if (0 === stripos(PHP_OS, 'win')) {
                require_once 'Minify.php';
                Minify::setDocRoot(); // we may be on IIS
            }
            return $this->lastModified;
        }
    }