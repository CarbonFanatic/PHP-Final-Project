<?php
$shipping=array("Standard" => 9.99, "Expedited" => 19.99);

function writeToFile($item_id,$discount){
    $filename= __DIR__ . '/discountTXT.txt';
if(readMyFile()!= "File is Empty") {
    if (array_key_exists($item_id, readMyFile())) {
        echo "<h2>Item already entered</h2>";
    } else {
        $fhandle = fopen($filename, 'a',);
        fwrite($fhandle, $item_id . "," . $discount . "\n");
        fclose($fhandle);
        header("location: http://localhost/store/AdminPage.php");
    }
}
    else{
        $fhandle = fopen($filename, 'a',);
        fwrite($fhandle, $item_id . "," . $discount . "\n");
        fclose($fhandle);
        header("location: http://localhost/store/AdminPage.php");
    }




}
function readMyFile()
{
    $filename= __DIR__ . '/discountTXT.txt';
    try {
        if(!is_file($filename))
            file_put_contents($filename,"");
        if ($testing = fopen($filename, "r")) {
            $file_lines = file($filename);

            if($file_lines== null){
              return "File is Empty";
                exit;
            }
else{
                foreach ($file_lines as $line) {
                        $temp[] = (explode(",", $line));
                    }
                    foreach ($temp as $x => $value) {
                        $discount[$value[0]] = $value[1];
                    }

         fclose($testing);
        return $discount;}
        exit();
        } else {
            throw new Exception('file not found.');
        }

    } catch (Exception $e) {
        echo "Sorry," . $e->getMessage();

    }
}
function clearfile(){
    $filename= __DIR__ . '/discountTXT.txt';
    file_put_contents("$filename", "");
}
?>