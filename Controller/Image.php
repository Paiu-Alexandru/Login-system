<?php
namespace Controller;
class Image{

    public function squareImage($original_file_name, $cropped_file_name, $max_width, $max_height, $filtered_extensioin)
    {
        if (file_exists($original_file_name)) {
            //$original_name this is a resource image resource with this we put a image in tmp_name in computer an we can access pixels from there
            

            if ($filtered_extensioin ==  "jpeg") {
                    $original_name = @ImageCreateFromJpeg($original_file_name);
                    if (!$original_name)
                    {
                        $original_name= imagecreatefromstring(file_get_contents($original_file_name));
                    }
            }
            if ($filtered_extensioin ==  "png") {
                $original_name = imagecreatefrompng($original_file_name);# code...
            }
            

            //get x=width from original image
            $original_width = imagesx($original_name);
            //get y=height from original image
            $original_height = imagesy($original_name);


            //calculate reduction from image
            if($original_height > $original_width){
                //make width equal to max width
                $ratio =  $max_width / $original_width;
                $new_width = $max_width;
                //in this case height will be reduced
                $new_height = $original_height * $ratio;

            }else {
                //we do the opposite
                $ratio =  $max_height / $original_height;
                $new_height = $max_height;
                //in this case width will be reduced
                $new_width = $original_width * $ratio;
            }
            //ceate a destination image
            $new_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_image, $original_name, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
            //destroy image resource
            imagedestroy($original_name);

            //create new resorces image
            if ($new_height > $new_width) {
                $diff = ($new_height - $new_width);
                $y = round($diff / 2);
                $x = 0;
            }else {
                $diff = ($new_width - $new_height);
                $x = round($diff / 2);
                $y = 0;
            }
            $new_cropped_image = imagecreatetruecolor($max_width, $max_height);
            imagecopyresampled($new_cropped_image, $new_image, 0, 0, $x, $y, $max_width, $max_height, $max_width, $max_height);
            imagedestroy($new_image);
            
            imagejpeg($new_cropped_image,$cropped_file_name,90);//1-st image resource/ second param-destination file(where to save)/ third:param is quality max100
            imagedestroy($new_cropped_image);
        }
        
         
    }
}

        //must have activeted GdImage 
        //imagecopyresampled($dst_image, $src_image, int $dst_x, int $dst_y, int $src_x,int $src_y, int $dst_width, int $dst_height, int $src_width, int $src_height): bool
        //imagecopyresampled(); 