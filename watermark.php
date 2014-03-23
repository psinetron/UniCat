<?php

/*
 *
 *
 Вызываем:
$watermark = new watermark3();
$img = imagecreatefromjpeg(“image.jpg”);
$water = imagecreatefrompng(“watermark24.png”);
$im=$watermark->create_watermark($img,$water,10);
imagejpeg($im,”result.jpg”);
 */


class watermark3{

    # given two images, return a blended watermarked image
    function create_watermark( $main_img_obj, $watermark_img_obj, $alpha_level = 100 ) {

        $w_src = imagesx($watermark_img_obj);
        $h_src = imagesy($watermark_img_obj);
        $w_dest = imagesx($main_img_obj);
        $h_dest = imagesy($main_img_obj);

        $transfer_x = intval($w_dest/2 - $w_src/2);
        $transfer_y = intval($h_dest/2 - $h_src/2);

        imagecopyresampled($main_img_obj, $watermark_img_obj, $transfer_x, $transfer_y, 0, 0, $w_src, $h_src, $w_src, $h_src);
        return $main_img_obj;
    } # END create_watermark()


} # END watermark API
 ?>