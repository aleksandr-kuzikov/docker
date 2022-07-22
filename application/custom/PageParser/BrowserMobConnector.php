<?php
namespace PageParser;

class BrowserMobConnector {
    protected $port;
    protected $harList = [];

    public function start() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "browsermob-proxy:8080/proxy");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        
        $proxy = 'socks5://192.168.8.1:5000';
        // $proxy = 'socks5://172.25.48.1:5000';
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query([
            // 'httpProxy' => 'browsermob-proxy:8138',
            'httpProxy' => $proxy,
            // 'sslProxy' => 'localhost:5000'
            // 'bindAddress'       => 'http://browsermob-proxy:8138',
            // 'serverBindAddress' => '127.0.0.1',
            'useEcc'            => 'true',
            'trustAllServers'   => 'true'       
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch); 

        // var_dump($output);
        // exit(0);
        $outputObj = json_decode($output);
        $this->port = $outputObj->port;

        return $this->port;
    }

    public function getPort() {
        return $this->port;
    }

    public function setupHar($pageRefName = 'Foo') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "browsermob-proxy:8080/proxy/"  . $this->port . "/har");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query([
            'captureHeaders'        => 'true',
            // 'captureCookies'        => 'true',
            // 'captureContent'        => 'true',
            // 'captureBinaryContent'  => 'true',
            'initialPageRef'        => $pageRefName
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch); 

        if ($output)
            $this->harList[] = $output;
    }

    public function setupPageRef($pageRefName = '') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "browsermob-proxy:8080/proxy/"  . $this->port . "/har/pageRef");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        if ($pageRefName !== '')
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(['pageRef' => $pageRefName]));
        curl_exec($ch);
        curl_close($ch); 
    }

    public function getHar() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "browsermob-proxy:8080/proxy/"  . $this->port . "/har");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch); 

        return $output;
    }

    public function setupProxy() {

    }

    public function getHarList() {
        return $this->harList;
    }

    public function stop() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "browsermob-proxy:8080/proxy/" . $this->port);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_exec($ch);
        curl_close($ch); 
    }

}