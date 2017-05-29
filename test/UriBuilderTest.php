<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Peertopark\UriBuilder;

/**
 * Description of UriBuilderTest
 *
 * @author hector
 */
class UriBuilderTest extends PHPUnit_Framework_TestCase {
    
    
    
    public function test_init() {
        $builder = UriBuilder::init("https://www.peertopark.com");
        $this->assertNotNull($builder);
    }
    
    public function test_build_http_uri() {
        $uri = UriBuilder::init("https://www.peertopark.com")->build_http_uri();
        $this->assertNotNull($uri);
    }
    
    public function test_build_http_string() {
        $expected = "https://www.peertopark.com";
        $string = UriBuilder::init($expected)->build_http_string();
        $this->assertNotNull($string);
        $this->assertEquals($expected, $string);
    }
    
    public function test_build_http_string_with_query() {
        $expected = "https://www.peertopark.com?returnUrl=https%3A%2F%2Fwww.google.es&key=value";
        $string = UriBuilder::init($expected)->build_http_string();
        $this->assertNotNull($string);
        $this->assertEquals($expected, $string);
    }
    
    public function test_get_components() {
        $components = UriBuilder::init("https://www.peertopark.com/home/show?query=value&key=value")->get_components();
        $this->assertNotNull($components);
    }
    
    
    public function test_get_path() {
        $path = UriBuilder::init("https://www.peertopark.com/home/show?query=value&key=value")->get_path();
        $this->assertNotNull($path);
    }
    
    public function test_get_path_string() {
        $path = UriBuilder::init("https://www.peertopark.com/home/show?query=value&key=value")->get_path_string();
        $this->assertNotNull($path);
        $this->assertEquals("/home/show", $path);
    }
    
    
    public function test_set_path() {
        $path = UriBuilder::init("https://www.peertopark.com?query=value&key=value")->set_path("/home/show")->get_path_string();
        $this->assertNotNull($path);
        $this->assertEquals("/home/show", $path);
    }
    
    public function test_set_path_without_leading_slash() {
        $path = UriBuilder::init("https://www.peertopark.com?query=value&key=value")->set_path("home/show")->get_path_string();
        $this->assertNotNull($path);
        $this->assertEquals("/home/show", $path);
    }
    
    public function test_set_path_with_trailing_slash() {
        $path = UriBuilder::init("https://www.peertopark.com?query=value&key=value")->set_path("/home/show/")->get_path_string();
        $this->assertNotNull($path);
        $this->assertEquals("/home/show", $path);
    }
    
    public function test_get_query() {
        $query = UriBuilder::init("https://www.peertopark.com?returnUrl=https%3A%2F%2Fwww.google.es%3FreturnUrl%3Dhttps%253A%252F%252Fwww.google.es&test=true")->get_query();
        $this->assertNotNull($query);
    }
    
    public function test_get_query_string() {
        $query = UriBuilder::init("https://www.peertopark.com?returnUrl=https%3A%2F%2Fwww.google.es%3FreturnUrl%3Dhttps%253A%252F%252Fwww.google.es&test=true")->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("returnUrl=https://www.google.es?returnUrl=https%253A%252F%252Fwww.google.es&test=true", $query);
    }
    
    public function test_has_query_param() {
        $builder = UriBuilder::init("https://www.peertopark.com/home/show?query=value&key=value");
        $this->assertTrue($builder->has_query_param("query"));
        $this->assertTrue($builder->has_query_param("key"));
        $this->assertFalse($builder->has_query_param("value"));
    }
    
    public function test_get_query_param() {
        $builder = UriBuilder::init("https://www.peertopark.com/home/show?query=value&key=value&returnUrl=https%3A%2F%2Fwww.google.es%3FreturnUrl%3Dhttps%253A%252F%252Fwww.google.es");
        $this->assertEquals("value",$builder->get_query_param("query"));
        $this->assertEquals("value", $builder->get_query_param("key"));
        $this->assertEquals("https://www.google.es?returnUrl=https://www.google.es", $builder->get_query_param("returnUrl"));
        $this->assertNull($builder->get_query_param("value"));
    }
    
    public function test_set_raw_query() {
        $builder = UriBuilder::init("https://www.peertopark.com/home/show?query=value")->set_raw_query("key=value");
        $query = $builder->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("key=value", $query);
        $this->assertEquals("https://www.peertopark.com/home/show?key=value", $builder->build_http_string());
    }
    
    public function test_set_query_array() {
        $array = ["key" => "value", "another" => "anothervalue"];
        $builder = UriBuilder::init("https://www.peertopark.com/home/show?query=value")->set_query_array($array);
        $query = $builder->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("key=value&another=anothervalue", $query);
        $this->assertEquals("https://www.peertopark.com/home/show?key=value&another=anothervalue", $builder->build_http_string());
    }
    
    public function test_set_query_param() {
        $builder = UriBuilder::init("https://www.peertopark.com/home/show?query=value")->set_query_param("key", "value");
        $query = $builder->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("key=value", $query);
        $this->assertEquals("https://www.peertopark.com/home/show?key=value", $builder->build_http_string());
    }
    
    public function test_append_raw_query() {
        $builder = UriBuilder::init("https://www.peertopark.com/home/show?query=value")->append_query_raw("key=value");
        $query = $builder->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("query=value&key=value", $query);
        $this->assertEquals("https://www.peertopark.com/home/show?query=value&key=value", $builder->build_http_string());
    }
    
    
    public function test_append_query_array() {
        $array = ["key" => "value", "another" => "anothervalue"];
        $builder = UriBuilder::init("https://www.peertopark.com/home/show?query=value")->append_query_array($array);
        $query = $builder->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("query=value&key=value&another=anothervalue", $query);
        $this->assertEquals("https://www.peertopark.com/home/show?query=value&key=value&another=anothervalue", $builder->build_http_string());
    }
    
    public function test_append_query_param() {
        $builder = UriBuilder::init("https://www.peertopark.com/home/show?query=value")->append_query_param("key", "value");
        $query = $builder->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("query=value&key=value", $query);
        $this->assertEquals("https://www.peertopark.com/home/show?query=value&key=value", $builder->build_http_string());
    }
    
    public function test_set_raw_query_contains_url() {
        $builder = UriBuilder::init("https://www.peertopark.com")->set_raw_query("returnUrl=https%3A%2F%2Fwww.google.es");
        $query = $builder->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("returnUrl=https://www.google.es", $query);
        $this->assertEquals("https://www.peertopark.com?returnUrl=https://www.google.es", $builder->build_http_string());
    }
    
    public function test_set_query_param_is_url() {
        $builder = UriBuilder::init("https://www.peertopark.com")->set_query_param("url", "https://www.peertopark.com");
        $query = $builder->get_query_string();
        $this->assertNotNull($query);
        $this->assertEquals("url=https://www.peertopark.com", $query);
        $this->assertEquals("https://www.peertopark.com?url=https://www.peertopark.com", $builder->build_http_string());
    }
    
    public function test_build_tree() {
        $builder = UriBuilder::init("https://www.peertopark.com")->set_query_param("url", "child")->append_query_param("return", "https://www.peertopark.com");
        $childUrl = $builder->build_http_string();
        $this->assertNotNull($childUrl);
        $this->assertEquals("https://www.peertopark.com?url=child&return=https://www.peertopark.com", $childUrl);
        
        $parentUrl = $builder->set_query_param("url", "parent")->append_query_param("return", $childUrl)->build_http_string();
        $this->assertNotNull($parentUrl);
        $this->assertEquals("https://www.peertopark.com?url=parent&return=https://www.peertopark.com?url=child%26return=https://www.peertopark.com", $parentUrl);
        
        $this->assertEquals("parent", $builder->get_query_param("url"));
        $this->assertEquals("https://www.peertopark.com?url=child&return=https://www.peertopark.com", $builder->get_query_param("return"));
    }
    
    
}
