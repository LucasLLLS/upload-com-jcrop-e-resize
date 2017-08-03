<?php

    // include ImageManipulator class
    require_once('ImageManipulator.php');
     
    if ($_FILES['fileToUpload']['error'] > 0) {
        echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
    } else {
        // array of valid extensions
        $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
        // get extension of the uploaded file
        $fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
        // check if file Extension is on the list of allowed ones
        if (in_array($fileExtension, $validExtensions)) {

            $newNamePrefix = time() . '_';
            $manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);

            $width  = $manipulator->getWidth();
            $height = $manipulator->getHeight();

            $imgInitW =  $_POST['imgInitW'];
            $imgCurrW =  $_POST['imgCurrW'];

            $percentBigger = (($imgInitW / $imgCurrW) - 1)*100;

            $cropX = $_POST['x'];
            $cropY = $_POST['y'];
            $cropW = $_POST['w'];
            $cropH = $_POST['h'];


            $x1 = $cropX + (($cropX*$percentBigger)/100);
            $x2 = $cropX + $cropW + ((($cropX  +$cropW)*$percentBigger)/100);
            $y1 = $cropY + (($cropY*$percentBigger)/100);;
            $y2 = $cropY + $cropH + ((($cropY + $cropH)*$percentBigger)/100);;
     
            // center cropping to 200x130
            $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
            // saving file to uploads folder
            $manipulator->save(PATH_UPLOADS . $newNamePrefix . $_FILES['fileToUpload']['name']);
            
            echo 'Done ...';
        } else {
            echo 'You must upload an image...';
        }
    }