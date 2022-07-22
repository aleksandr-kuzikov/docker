<?php
namespace WebDriverAdapter;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeDevToolsDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;

class WebDriverAdapter {

    protected $devTools;
    protected $driver;
    // protected $host;
    // protected $browserArgs; // ['window-size=1920,1080', 'start-maximized']
    
    public function create($host, $browserArgs) {
    
        $options = new ChromeOptions();
        $options->setBinary("/usr/bin/google-chrome");
        $options->addArguments($browserArgs);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $options);

        $this->driver = RemoteWebDriver::create($host, $capabilities);
        
        $this->devTools = new ChromeDevToolsDriver($this->driver);
       
        $this->devTools->execute('Network.enable');
        $canEmulate = $this->devTools->execute('Emulation.canEmulate');
        
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
            'userAgentMetadata' => $uaMetadata
        ];

        // $this->devTools->execute(
        //     'Network.setUserAgentOverride',
        //     $uaParams
        // );

        $this->devTools->execute(
            'Emulation.setUserAgentOverride',
            $uaParams
        );
    }

    public function emulateTouch() {
        $this->devTools->execute(
            'Emulation.setTouchEmulationEnabled',
            true
        );
    }

    public function emulateNoTouch() {
        $this->devTools->execute(
            'Emulation.setTouchEmulationEnabled',
            false
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