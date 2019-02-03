function urlParser ($url) {
    $urlObj = parse_url($url); // url string to array

    // the array we're going to fill and return:
    $parsedData = [
        'scheme' => $urlObj['scheme'],
        'host'   => $urlObj['host']
    ];

    if ($urlObj['host']) {
        $hostObj = explode('.', $urlObj['host']);

        if ($hostObj[0] === 'www') {
            array_shift($hostObj);
            $parsedData['subdomain'] = 'www';
        }

        $parsedData['domain'] = implode('.', $hostObj);
        $parsedData['ltd'] = end($hostObj);

        if (count($hostObj) > 2) {
            array_shift($hostObj);
            $parsedData['sld'] = implode('.', $hostObj);
        }
    }

    if ($urlObj['path']) {
        $parsedData['path'] = $urlObj['path'];
    }

    if ($urlObj['query']) {
        $parsedData['query'] = $urlObj['query'];

        $queryObj = explode('&', $urlObj['query']);

        if (count($queryObj) > 0) {
            $parsedQuery = [];

            for ($i = 0; $i < count($queryObj); $i++) {
                $queryParam = explode('=', $queryObj[$i]);
                $key = $queryParam[0];
                $value = $queryParam[1];

                $parsedQuery[$key] = $value;
            }

            $parsedData['parsedQuery'] = $parsedQuery;
        }
    }

    if ($urlObj['fragment']) {
        $parsedData['fragment'] = $urlObj['fragment'];
    }

    return $parsedData;
}


$inputUrl = $argv[1];
echo var_dump(urlParser($inputUrl));
