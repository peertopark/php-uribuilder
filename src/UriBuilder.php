<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Peertopark;

use League\Uri\Parser;
use League\Uri\Schemes\Http;
use League\Uri\Components\Path;
use League\Uri\Components\Query;

/**
 * Description of UriBuilder
 *
 * @author hector
 */
class UriBuilder {

    /**
     *
     * @var array() 
     */
    private $components;

    /**
     * 
     * @param string $uri Initial Uri
     */
    public function __construct($uri = NULL) {
        if (is_null($uri)) {
            $this->components = [];
        } else {
            $parser = new Parser();
            $this->components = $parser($uri);
        }
    }

    public static function init($uri = NULL) {
        return new UriBuilder($uri);
    }

    /**
     * 
     * @return Http
     */
    public function build_http_uri() {
        return Http::createFromComponents($this->components);
    }

    /**
     * 
     * @return string
     */
    public function build_http_string() {
        return (string) $this->build_http_uri();
    }

    /**
     * Get UriBuilder components
     * @return array()
     */
    public function get_components() {
        return $this->components;
    }

    protected function get_component($component) {
        return $this->components[$component];
    }

    protected function set_component($component, $value) {
        return $this->components[$component] = $value;
    }

    /**
     * Set Uri Path
     * @param string $path
     * @return UriBuilder
     */
    public function set_path($path = NULL) {
        $pathComponent = new Path($path);
        $this->set_component(URI_PATH, $pathComponent->withLeadingSlash()->withoutTrailingSlash()->getUriComponent());
        return $this;
    }

    /**
     * Get Path 
     * @return Path
     */
    public function get_path() {
        return new Path($this->get_component(URI_PATH));
    }

    /**
     * Get Path String 
     * @return string
     */
    public function get_path_string() {
        return (string) $this->get_path();
    }

    /**
     * Get Query
     * @return Query
     */
    public function get_query() {
        return new Query($this->get_component(URI_QUERY));
    }

    /**
     * Get Query String 
     * @return string
     */
    public function get_query_string() {
        return (string) $this->get_query();
    }

    /**
     * Get Query param value
     * @param string $param
     * @return string
     */
    public function get_query_param($param) {
        return $this->get_query()->getParam($param);
    }

    /**
     * 
     * @param string $param
     * @return boolean
     */
    public function has_query_param($param) {
        return $this->get_query()->hasPair($param);
    }

    /**
     * 
     * @param Query $query
     * @return $this
     */
    protected function set_query($query) {
        if (isset($query)) {
            $this->set_component(URI_QUERY, $query->getContent());
        }
        return $this;
    }

    /**
     * 
     * @param string $raw_query
     * @return UriBuilder
     */
    public function set_raw_query($raw_query = NULL) {
        $queryComponent = new Query($raw_query);
        return $this->set_query($queryComponent);
    }

    public function set_query_array($query_array) {
        foreach ($query_array as $key => $value) {
            
        }
        $query = Query::createFromPairs($query_array);
        return $this->set_query($query);
    }

    public function set_query_param($param, $value) {
        $query_array = [$param => $value];
        return $this->set_query_array($query_array);
    }
   

    public function append_query_raw($raw_query = NULL) {
        $queryComponent = new Query($raw_query);
        return $this->append_query($queryComponent);
    }

    protected function append_query($queryComponent) {
        if (isset($queryComponent)) {
            $updatedQueryComponent = $this->get_query()->append($queryComponent);
            return $this->set_query($updatedQueryComponent);
        } else {
            return $this;
        }
    }
    
    public function append_query_array($query_array) {
        $queryComponent = Query::createFromPairs($query_array);
        return $this->append_query($queryComponent);
    }
    
    public function append_query_param($param, $value) {
        $query_array = [$param => $value];
        return $this->append_query_array($query_array);
    }

}
