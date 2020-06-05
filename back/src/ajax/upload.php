<?php
 if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
    chdir('../../..');
    $rep = getcwd();
    if(!is_dir($rep ."/uploads") )
    {
        mkdir($rep ."/uploads");
    }
    // move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/' . $_FILES['file']['name']);

    
    move_uploaded_file( $_FILES["file"]["tmp_name"], $rep  ."/uploads/" . $_FILES["file"]["name"]);

   //  move_uploaded_file( $_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] ."/uploads/" . $_FILES["file"]["name"]);
    
}
