<?php
namespace PageParser;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeDevToolsDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ChromeRemoteController {

    protected $devTools;
    protected $driver;
    protected $options;
    protected $capabilities;
    protected $canEmulate;
    
    public function create($host, $browserArgs, $proxy) {
        $this->options = new ChromeOptions();
        $this->options->setBinary("/usr/bin/google-chrome");
        $this->options->addArguments($browserArgs);

        $this->capabilities = DesiredCapabilities::chrome();  

        $this->capabilities->setCapability(WebDriverCapabilityType::PROXY, [
            'proxyType' => 'manual',
            'httpProxy' => $proxy,
            'sslProxy'  => $proxy
        ]);
        $this->capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $this->options);

        $this->driver = RemoteWebDriver::create($host, $this->capabilities);
        
        $this->devTools = new ChromeDevToolsDriver($this->driver);
       
        $this->devTools->execute('Network.enable');
        $this->canEmulate = $this->devTools->execute('Emulation.canEmulate');
        
    }

    public function quit() {
        $this->driver->quit();
    }

    public function emulateGeo($latitude, $longitude, $accuracy = 1) {
        $this->devTools->execute(
            'Emulation.setGeolocationOverride', 
            [
                'latitude'  => $latitude,
                'longitude' => $longitude,
                'accuracy'  => $accuracy,
            ]
        );
    }

    public function clearGeo() {
        $this->devTools->execute(
            'Emulation.clearGeolocationOverride'
        );
    }

    public function emulateUa($userAgent, $acceptLanguage, $platform, $uaMetadata = '') {
        $uaParams = [
            'userAgent'         => $userAgent,
            'acceptLanguage'    => $acceptLanguage,
            'platform'          => $platform,
            // 'userAgentMetadata' => $uaMetadata
        ];

        $this->devTools->execute(
            'Network.setUserAgentOverride',
            $uaParams
        );

        $this->devTools->execute(
            'Emulation.setUserAgentOverride',
            $uaParams
        );
    }

    public function emulateTouch() {
        $this->devTools->execute(
            'Emulation.setTouchEmulationEnabled',
            [ 'enabled' => true ]
        );
    }

    public function emulateNoTouch() {
        $this->devTools->execute(
            'Emulation.setTouchEmulationEnabled',
            [ 'enabled' => false ]
        );
    }

    public function emulateDeviceMetrics($width, $height, $isMobile) {
        $this->devTools->execute(
            'Emulation.setDeviceMetricsOverride',
            [
                'width'             => $width,
                'height'            => $height,
                'deviceScaleFactor' => 0,
                'mobile'            => $isMobile
            ]
        );
    }

    public function clearDeviceMetrics() {
        $this->devTools->execute(
            'Emulation.clearDeviceMetricsOverride'
        );
    }

    public function setHeaders($headers) {
        $this->devTools->execute(
            'Network.setExtraHTTPHeaders', 
            [
                'headers' => (object)$headers
            ]);
    }

    public function skipAlert() {
        try {
            $this->driver->wait(10, 500)->until(
                WebDriverExpectedCondition::alertIsPresent()
            );
    
            $this->driver->switchTo()->alert()->accept();
        } catch (\Exception $e) {}
    }

    public function waitMetaRefresh() {

    } 

    public function canEmulate() {
        return $this->canEmulate;
    }

    public function getPage($url) {
        $this->driver->get($url);
    }

    public function createFullScreenshot($path) {
        $this->driver->takeScreenshot($path);
    }

    
    public function __destruct() {
        if ($this->driver) 
            $this->quit();
    }
}