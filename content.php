<?php
header('Content-Type: text/javascript; charset=UTF-8');

$imageFolder = 'img/';
$imageTypes = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG}';

# Create images array
$images = glob($imageFolder . $imageTypes, GLOB_BRACE);

# Generate the HTML output
writehtml('<ul class="content">');
foreach ($images as $image) {

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
