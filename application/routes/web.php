<?php

use Illuminate\Support\Facades\Route; 

use PageParser\BrowserMobConnector;
use PageParser\ChromeRemoteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/info', function () {
    echo "<script src='mycustom'></script>";
    echo "<script src='mycustom2'></script>";
    echo "<pre>";

    echo "<br>HTTP_USER_AGENT :";
    if ($_SERVER['HTTP_USER_AGENT'])
        var_dump($_SERVER['HTTP_USER_AGENT']);

    echo "<br>HTTP_CLIENT_IP :";
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        var_dump($_SERVER['HTTP_CLIENT_IP']);

    echo "<br>HTTP_X_FORWARDED_FOR :";
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        var_dump($_SERVER['HTTP_X_FORWARDED_FOR']);
        
    echo "<br>HTTP_X_REAL_IP :";
    if (!empty($_SERVER['HTTP_X_REAL_IP']))
        var_dump($_SERVER['HTTP_X_REAL_IP']);

    echo "<br>REMOTE_ADDR :";
    if (!empty($_SERVER['REMOTE_ADDR']))
        var_dump($_SERVER['REMOTE_ADDR']);

    echo "<br>HTTP_ACCEPT_LANGUAGE :";
    if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        var_dump($_SERVER['HTTP_ACCEPT_LANGUAGE']);

    echo "</pre>";

    echo "<br><span id='js-lang'></span>";
    echo "<br><span id='js-platform'></span>";
    echo "<br><span id='js-uad-platform'></span>";
    echo "<br><span id='js-uad-mobile'></span>";
    echo "<br><span id='js-ua'></span>";
    echo "<br><span id='js-geo'></span>";


    echo "<script>document.getElementById('js-lang').innerHTML = window.navigator.language</script>";
    echo "<script>document.getElementById('js-platform').innerHTML = window.navigator.platform</script>";
    echo "<script>document.getElementById('js-uad-platform').innerHTML = window.navigator.userAgentData.platform</script>";
    echo "<script>document.getElementById('js-uad-mobile').innerHTML = window.navigator.userAgentData.mobile == true ? 'true' : 'false'</script>";
    echo "<script>document.getElementById('js-ua').innerHTML = window.navigator.userAgent</script>";

    echo "<script>navigator.geolocation.getCurrentPosition((pos) => {document.getElementById('js-geo').innerHTML = pos.coords.latitude})</script>";
});

/**
 * ip India
 * 103.241.182.97:80
 * 182.72.203.253:80
 * 116.203.72.47:8118
 * 125.22.61.92:80
 */


Route::get('/parse-chrome', function () {
    set_time_limit(600);
    $indiaConf = [
        'name'          => 'India',
        'short_name'    => 'IN',
        'accept_langs'  => 'en-US, en;q=0.9, hi;q=0.8, gu;q=0.7, *;q=0.5',
        'browser_lang'  => 'en-US',
        'coords'        => [
            'latitude'  => 12.89968,
            'longitude' => 80.22087,
            'accuracy'  => 1,
        ],
        'ip'            => '157.46.64.140',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $usaConf = [
        'name'          => 'United States',
        'short_name'    => 'US',
        'accept_langs'  => 'en-US, en-GB;q=0.9 *;q=0.5',
        'browser_lang'  => 'en-US',
        'coords'        => [
            'latitude'  => 34.0522,
            'longitude' => -118.244,
            'accuracy'  => 1,
        ],
        'ip'            => '100.41.134.90',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $germanyConf = [
        'name'          => 'Germany',
        'short_name'    => 'DE',
        'accept_langs'  => 'de, de-CH;q=0.9, de-AT;q=0.9, de-LI;q=0.9, de-LU;q=0.9, da;q=0.8, en-US;q=0.7, en-GB;q=0.7 *;q=0.5',
        'browser_lang'  => 'de',
        'coords'        => [
            'latitude'  => 48.8000,
            'longitude' => 8.3333,
            'accuracy'  => 1,
        ],
        'ip'            => '103.197.11.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $japanConf = [
        'name'          => 'Japan',
        'short_name'    => 'JP',
        'accept_langs'  => 'ja, en-US;q=0.9, en-GB;q=0.8 *;q=0.5',
        'browser_lang'  => 'en-US',
        'coords'        => [
            'latitude'  => 35.6895,
            'longitude' => 139.6917,
            'accuracy'  => 1,
        ],
        'ip'            => '1.115.255.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $koreaConf = [
        'name'          => 'Korea',
        'short_name'    => 'KR',
        'accept_langs'  => 'ko, en-US;q=0.9, en-GB;q=0.8 *;q=0.5',
        'browser_lang'  => 'en-US',
        'coords'        => [
            'latitude'  => 37.6425,
            'longitude' => 126.7115,
            'accuracy'  => 1,
        ],
        'ip'            => '1.11.255.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $canadaConf = [
        'name'          => 'Canada',
        'short_name'    => 'CA',
        'accept_langs'  => 'en-CA, en-US;q=0.9, fr-ca;q=0.8, en-GB;q=0.7 *;q=0.5',
        'browser_lang'  => 'en-US',
        'coords'        => [
            'latitude'  => 43.4254,
            'longitude' => -80.5112,
            'accuracy'  => 1,
        ],
        'ip'            => '100.43.127.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $malaysiaConf = [
        'name'          => 'Malaysia',
        'short_name'    => 'MY',
        'accept_langs'  => 'en-US, en;q=0.9, ms;q=0.8, *;q=0.5',
        'browser_lang'  => 'en-US',
        'coords'        => [
            'latitude'  => 3.13687,
            'longitude' => 101.694,
            'accuracy'  => 1,
        ],
        'ip'            => '1.32.127.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $polandConf = [
        'name'          => 'Poland',
        'short_name'    => 'PL',
        'accept_langs'  => 'pl, en;q=0.9, *;q=0.5',
        'browser_lang'  => 'pl',
        'coords'        => [
            'latitude'  => 50.3480,
            'longitude' => 18.9328,
            'accuracy'  => 1,
        ],
        'ip'            => '103.203.87.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $thailandConf = [
        'name'          => 'Thailand',
        'short_name'    => 'TH',
        'accept_langs'  => 'en-US, en;q=0.9, th;q=0.8, *;q=0.5',
        'browser_lang'  => 'en-US',
        'coords'        => [
            'latitude'  => 7.0084,
            'longitude' => 100.4767,
            'accuracy'  => 1,
        ],
        'ip'            => '1.0.255.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $pakistanConf = [
        'name'          => 'Pakistan',
        'short_name'    => 'PK',
        'accept_langs'  => 'en, en-US;q=0.9, *;q=0.5',
        'browser_lang'  => 'en',
        'coords'        => [
            'latitude'  => 33.7215,
            'longitude' => 73.0433,
            'accuracy'  => 1,
        ],
        'ip'            => '101.50.93.115',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $vietNamConf = [
        'name'          => 'Viet Nam',
        'short_name'    => 'VN',
        'accept_langs'  => 'vi, en;q=0.9, *;q=0.5',
        'browser_lang'  => 'vi',
        'coords'        => [
            'latitude'  => 21.0443,
            'longitude' => 106.0132,
            'accuracy'  => 1,
        ],
        'ip'            => '1.55.255.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $turkeyConf = [
        'name'          => 'Turkey',
        'short_name'    => 'TR',
        'accept_langs'  => 'tr, en;q=0.9, *;q=0.5',
        'browser_lang'  => 'tr',
        'coords'        => [
            'latitude'  => 41.0138,
            'longitude' => 28.9497,
            'accuracy'  => 1,
        ],
        'ip'            => '104.237.228.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $indonesiaConf = [
        'name'          => 'Indonesia',
        'short_name'    => 'ID',
        'accept_langs'  => 'in, en;q=0.9, *;q=0.5',
        'browser_lang'  => 'in',
        'coords'        => [
            'latitude'  => -6.2349,
            'longitude' => 106.9896,
            'accuracy'  => 1,
        ],
        'ip'            => '101.128.127.255',
        'proxy'         => [
            'http'  => '',
            'https' => ''
        ]
    ];
    
    $device = [
        'device'    => 'Mobile',
        'os'        => 'Android',
        'ua'        => 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Mobile Safari/537.36',
        'isMobile'  => true,
        'width'     => 360,
        'height'    => 740
    ];
    
    $iptest = [
        'name'              => 'iptest',
        'configurations'    => [
            [
                'device'    => $device,
                'location'  => $indiaConf,
                'url'       => 'https://2ip.ru/'
            ]
        ]
    ];

    $PRO3 = [
        'name'              => 'PRO-3',
        'configurations'    => [
            [
                'device'    => $device,
                'location'  => $indiaConf,
                'url'       => 'https://track.profitableredirect.com/3e230a19-2203-422b-a35b-b0ed46d763c5?campaign_id=1234&creative_id=234&sub=0.1&click_id=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ]
        ]
    ];
    
    $PRO4 = [
        'name'              => 'PRO-4',
        'configurations'    => [
            [
                'device'    => $device,
                'location'  => $usaConf,
                'url'       => 'https://data-shield-app.net/8T3Hdv3p?external_id=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA&source=US'
            ],
            [
                'device'    => $device,
                'location'  => $germanyConf,
                'url'       => 'https://data-shield-app.net/GtZy9d6X?external_id=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA&source=DE'
            ],
            [
                'device'    => $device,
                'location'  => $japanConf,
                'url'       => 'https://data-shield-app.net/3GqM8QJY?external_id=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA&source=JP'
            ],
            [
                'device'    => $device,
                'location'  => $koreaConf,
                'url'       => 'https://data-shield-app.net/x6m4j1BC?external_id=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA&source=KR'
            ],
            [
                'device'    => $device,
                'location'  => $canadaConf,
                'url'       => 'https://data-shield-app.net/jTNPKTXd?external_id=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA&source=CA'
            ]
        ]
    ];
    
    $PRO2 = [
        'name'              => 'PRO-2',
        'configurations'    => [
            [
                'device'    => $device,
                'location'  => $malaysiaConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=MY&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ],
            [
                'device'    => $device,
                'location'  => $koreaConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=KR&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ],
            [
                'device'    => $device,
                'location'  => $polandConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=PL&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ],
            [
                'device'    => $device,
                'location'  => $thailandConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=TH&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ],
            [
                'device'    => $device,
                'location'  => $pakistanConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=PK&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ],
            [
                'device'    => $device,
                'location'  => $indiaConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=IN&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ],
            [
                'device'    => $device,
                'location'  => $vietNamConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=VN&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ],
            [
                'device'    => $device,
                'location'  => $turkeyConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=TR&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ],
            [
                'device'    => $device,
                'location'  => $indonesiaConf,
                'url'       => 'https://www.kzjs4rtk.com/4C2WD7/PS824/?source_id=ID&sub1=Ab6t0GKD4UwAVEjIGFiZt3B_BJfeYZIAAAAAAAAAAAAAAAAAAAAAAA'
            ]
        ]
    ];

    // test($PRO2);
    test($PRO3);
    // test($PRO4);
    // test($iptest);

    return "done";

});


function test($testData) {
    $dir = './tests';
    $testDir = $dir . '/' . $testData['name'];

    if(!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    if(!is_dir($testDir)) {
        mkdir($testDir, 0777, true);
    } else {
        $testDir = $testDir . '_' . date("Y-m-d_H-i-s");
        mkdir($testDir, 0777, true);
    }

    foreach($testData['configurations'] as ['device' => $device, 'location' => $location, 'url' => $url]) {
        // $url = 'https://www.tutu.ru/spb/rasp.php?st1=20600&st2=6702';
        $url = 'https://2ip.ru';
        $confDir = $testDir . '/' . $location['name'];

        if(!is_dir($confDir)) {
            mkdir($confDir, 0777, true);
        }

        $browsermob = new BrowserMobConnector();
        $proxyport = $browsermob->start();
        $browsermob->setupHar($location['name'] . '_' . $url);

        var_dump($proxyport);

        $driver = new ChromeRemoteController();
        $driver->create(
            'http://selenium-chrome:4444/', 
            [
                'lang=' . $location['browser_lang'], 
                'window-size=' . $device['width'] . ',' . $device['height'], 
                'start-maximized',
                'ignore-certificate-errors',
                // 'allow-running-insecure-content'
            ],
            "http://browsermob-proxy:8113"
        );
        $driver->emulateTouch();
        $driver->emulateDeviceMetrics($device['width'], $device['height'], $device['isMobile']);
        $driver->emulateUa(
            $device['ua'],
            $location['accept_langs'],
            $device['os']
        );
        
        $driver->setHeaders([
            'X-Forwarded-For'   => $location['ip'],
            'Client-Ip'         => $location['ip'],
            'X-Real-Ip'         => $location['ip']
        ]);

        $driver->emulateGeo($location['coords']['latitude'], $location['coords']['longitude']);


        $driver->getPage($url);
        // $driver->skipAlert();

        $driver->createFullScreenshot($confDir . '/screenshot.png');
        $driver->quit();

        $fileData = "Country: " . $location['name'] . "\n";
        $fileData .= "Accept-Languages: " . $location['accept_langs'] . "\n";
        $fileData .= "IP headers: " . $location['ip'] . "\n";
        $fileData .= "OS: " . $device['os'] . "\n";
        $fileData .= "UA: " . $device['ua'] . "\n";
        $fileData .= "Request URL: " . $url . "\n\n";

        $har = $browsermob->getHar();
        file_put_contents($confDir . '/output.har', $har);

        echo "<pre>";
        $result = json_decode($har);
        // var_dump($result);
        echo "</pre>";
        $browsermob->stop();

        $redirectsData = "Redirects: \n";

        foreach($result->log->entries as $entry) {
            try {
                $status = $entry->response->status;
                if ($status >= 300 && $status < 400)
                    $redirectsData .= sprintf("%d %s From: %s To: %s \n", $status, $entry->response->statusText, $entry->request->url, $entry->response->redirectURL);
                
                if  ($status == 200 && $entry->request->method == 'GET') {
                    $file_name = parse_url($entry->request->url, PHP_URL_PATH);
                    $pathinfo = pathinfo($file_name);
                    $dir = $confDir . $pathinfo['dirname'];
                    if(!is_dir($dir)) 
                        mkdir($dir, 0777, true);
                    if (file_put_contents($dir . '/' . $pathinfo['basename'], file_get_contents($entry->request->url)))
                    {
                        echo "File downloaded successfully " . $file_name . ' -- ' . $entry->request->url . "<br><br>";
                    }
                    else
                    {
                        echo "File downloading failed. " . $entry->request->url . "<br><br>";
                    }
                }
            } catch (\Exception $e) {}
        }

        $fileData .= $redirectsData;

        file_put_contents($confDir . '/data.txt', $fileData);
    }
}
