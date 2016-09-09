<?php

class Comparer
{

    const
        WIDTH = 320,
        HEIGHT = 240;

    public $Images = array();

    public function __construct($Image1, $Image2)
    {
        if (is_array($Image1))
        {
            $this->Images = $Image1;
            $this->mainImage = $Image1[0];
        }
        else
        {
            $this->Images = array($Image1);
            $this->mainImage = $Image1;
        }

        foreach ($this->Images as $key => $Image)
        {
            if (is_string($Image))
                $this->Images[$key] = array($Image, $this->_openImage($Image));
            else
                throw new Exception('Bad arguments.', self::BAD_ARGS);
        }
    }

    private function _openImage($Image)
    {
        $obj = new Imagick($Image);
        $d = $obj->getImageGeometry();
        $w = $d['width'];
        $h = $d['height'];
        if ($w != self::WIDTH || $h != self::HEIGHT)
            $obj->cropImage(self::WIDTH, self::HEIGHT, 0, 0);
        return $obj;print_r($obj);
    }

    private function _getDiff($Image1, $Image2)
    {
        $res = $Image1->compareImages($Image2, Imagick::METRIC_MEANSQUAREERROR);
        $diff = round($res[1]*1000);
        return $diff;print_r ($diff);
    }

    public function Compare()
    {
        $count = count($this->Images);

        if ($count > 1)
        {
            foreach ($this->Images as $key => $value)
            {
                if ($key > 0)
                {
                    $this->Images[$key][] = $this->_getDiff($this->Images[0][1], $this->Images[$key][1]);
                }
            }
        }
    }

}

