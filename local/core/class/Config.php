<?php
class Config {
    protected static $__instance;
    function __construct() {
        $this->config = $this->parseConfig();
    }
    public function parseConfig() {
        $jsonPath = $this->MakeConfigPath();
        if(file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            return json_decode($json, true);
        }
        return array();
    }
    public function MakeConfigPath() {
        return __DIR__."/../../../config.json";
    }
    public function getValue($key) {
        if(array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        return NULL;
    }

}
