<?php

namespace OGF;

class Convert
{
    private $eleMap = [
        0 => '#006633',
        100 => '#107f35',
        200 => '#28993b',
        300 => '#47b247',
        400 => '#7ccc6c',
        500 => '#b2e599',
        600 => '#e5ffcc',
        700 => '#c9e08f',
        800 => '#bbc15d',
        900 => '#a39234',
        1000 => '#845b15',
        1100 => '#662a00',
    ];

    /**
     * Load data from file.
     *
     * @param string $fileName
     * @access public
     * @return array
     */
    public function loadFile($fileName)
    {
        $data = [];
        $fp = fopen($fileName, 'rb');
        while (!feof($fp)) {
            $buffer = fread($fp, 4 * 33);
            $row = unpack("f*", $buffer);
            $data[] = $row;
        }
        fclose($fp);
        return $data;
    }

    /**
     * Process
     *
     * @param array $data
     * @access public
     * @return Convert
     */
    public function process($data)
    {
        $draw = new \ImagickDraw();

        foreach ($data as $rp => $row) {
            foreach ($row as $cp => $point) {
                // Find color.
                $colorIndex = round($point/100)*100;
                if ($colorIndex > 1100) {
                    $colorIndex = 1100;
                }
                $color = $this->eleMap[$colorIndex];
                $draw->setFillColor($color);
                $draw->point($cp-1, $rp-1);
                // Make pixel.
            }
        }
        $this->canvas = new \Imagick();
        $this->canvas->newImage(33, 33, '#ffffff');
        $this->canvas->drawImage($draw);
	$this->canvas->scaleImage(256, 256);
        $this->canvas->setImageFormat("png");
        return $this;
    }

    public function writeFile($fileName)
    {
        $this->canvas->writeImage("7336.png");
    }

    public function writeImage()
    {
        header("Content-Type: image/png");
        echo $this->canvas->getImageBlob();
    }
}
