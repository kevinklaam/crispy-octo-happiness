<?php
//header('Content-Type: text/javascript; charset=UTF-8');

$imageFolder = 'img/';
$imageTypes = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG}';

$url='https://api.github.com/repos/kevinklaam/imagegallery/git/trees/main?format=json';
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT,'kevinklaam');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);

$json = json_decode($result, true);

$result2 = [];
array_walk_recursive($json, function($value, $key) use(&$result2) {
    if ($key === 'path') {
        $result2[] = 'https://raw.githubusercontent.com/kevinklaam/imagegallery/main/' . $value;
    }
});

//var_dump($result2);

# Create images array
//$images = glob($imageFolder . $imageTypes, GLOB_BRACE);
//var_dump($images);

# Generate the HTML output
writehtml('<ul class="content">');
foreach ($result2 as $image) {

    # Get the name of the image, stripped from image folder path and file type extension
    $name = 'Image name: ' . substr($image, strlen($imageFolder), strpos($image, '.') - strlen($imageFolder));

    # Begin adding
    writehtml('<li class="content-li">');
    writehtml('<div class="content-img" onclick=this.classList.toggle("zoom");><a name="' . $image . '" href="#' . $image . '">');
    writehtml('<img src="' . $image . '" alt="' . $name . '" title="' . $name . '">');
    writehtml('</a></div>');
    writehtml('<div class="content-label">' . $name . '</div>');
    writehtml('</li>');
}
writehtml('</ul>');

writehtml('<link rel="stylesheet" type="text/css" href="content.css">');

# Helper Function 
function writehtml($html) {
    echo "document.write('" . $html . "');\n";
}

?>