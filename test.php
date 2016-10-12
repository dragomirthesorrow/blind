<?php
                $pattern="/\'(.+)\'/";
                $lines2 = file('/var/www/html/configs/path.config');
                preg_match($pattern, $lines2['2'],$matches_path);
                $path=$matches_path['1'];
                $video_storage=$path;
                $pt='/\/var\/www\/html\//';
                $g=preg_replace($pt, '',$path);
                echo $video_storage.'2';
                echo $path;
                echo '0'.$g.'0';