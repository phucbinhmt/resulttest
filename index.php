<?php
set_time_limit(0);
error_reporting(0);

function curl($url, $headers)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

$ua = array(
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246"
);

$url = "https://dantri.com.vn/giao-duc-huong-nghiep/vu-lo-de-thi-sinh-8-thi-sinh-duoc-mom-de-can-xu-ly-the-nao-20230620004656478.htm";

$respone = curl($url, $ua);

// print_r($respone);

$dom = new DOMDocument;
@$dom->loadHTML($respone);
$xpath = new DOMXPath($dom);

$articlePopulars = $xpath->query('//article[contains(@class, "article-item") and @data-content-name="article-popular"]');
$foundPopulars = [];

if ($articlePopulars->length > 0) {
    foreach ($articlePopulars as $articleNode) {
        $title = $xpath->query('./h3/a', $articleNode)->item(0)->nodeValue;
        $thumbnail_image = $xpath->query('./div/a/img', $articleNode)->item(0)->getAttribute('data-src');
        $url = $xpath->query('./h3/a', $articleNode)->item(0)->getAttribute('href');

        $foundPopulars[] = [
            'title' => $title,
            'thumbnail_image' => $thumbnail_image,
            'url' => "https://dantri.com.vn" . $url,
        ];
    }
}

$articleRelateds = $xpath->query('//article[contains(@class, "article-item") and @data-content-name="article-related"]');
$foundRecommends = [];

if ($articleRelateds->length > 0) {
    foreach ($articleRelateds as $articleNode) {
        $title = $xpath->query('./div[@class="article-content"]/h3/a', $articleNode)->item(0)->nodeValue;
        $thumbnail_image = $xpath->query('./div[@class="article-thumb"]/a/img', $articleNode)->item(0)->getAttribute('data-src');
        $url = $xpath->query('./div[@class="article-content"]/h3/a', $articleNode)->item(0)->getAttribute('href');
        $description = $xpath->query('./div[@class="article-content"]/div[@class="article-excerpt"]/a', $articleNode)->item(0)->nodeValue;

        $foundRelateds[] = [
            'title' => $title,
            'description' => $description,
            'thumbnail_image' => $thumbnail_image,
            'url' => "https://dantri.com.vn" . $url,
        ];
    }
}


$articleRecommeds = $xpath->query('//article[contains(@class, "article-item") and @data-content-name="article-recommend"]');
$foundRecommends = [];

if ($articleRecommeds->length > 0) {
    foreach ($articleRecommeds as $articleNode) {
        $title = $xpath->query('./div[@class="article-content"]/h3/a', $articleNode)->item(0)->nodeValue;
        $thumbnail_image = $xpath->query('./div[@class="article-thumb"]/a/img', $articleNode)->item(0)->getAttribute('data-src');
        $url = $xpath->query('./div[@class="article-content"]/h3/a', $articleNode)->item(0)->getAttribute('href');
        $description = $xpath->query('./div[@class="article-content"]/div[@class="article-excerpt"]/a', $articleNode)->item(0)->nodeValue;

        $foundRecommends[] = [
            'title' => $title,
            'description' => $description,
            'thumbnail_image' => $thumbnail_image,
            'url' => "https://dantri.com.vn" . $url,
        ];
    }
}


var_dump($foundPopulars); // Good
var_dump($foundRelateds); // Good
var_dump($foundRecommends); // Chua chay
