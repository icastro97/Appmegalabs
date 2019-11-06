<?php

if (isset($_FILES['files']) && !empty($_FILES['files'])) {
    var_dump($_POST['transfer']);
    $no_files = count($_FILES["files"]['name']);
    for ($i = 0; $i < $no_files; $i++) {
        if ($_FILES["files"]["error"][$i] > 0) {
            echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
        } else {
            if (file_exists('pruebaImagenes/' . $_FILES["files"]["name"][$i])) {
                echo 'File already exists : pruebaImagenes/' . $_FILES["files"]["name"][$i].'<br>';
                
            } else {
                move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'pruebaImagenes/' . $_FILES["files"]["name"][$i]);
                //echo 'File successfully uploaded : pruebaImagenes/' . $_FILES["files"]["name"][$i] . '<br> ';
                
                foreach($_FILES as $row)
                {
                    var_dump($row['name']);
                }
                
            }
        }
    }
} else {
    echo 'Please choose at least one file';
}
    
/* 
 * End of script
 */