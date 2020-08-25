<?php
if(isset($_GET['status'])){

    if($_GET['status']=='Deny'){
        $xml= simplexml_load_file("comment.xml");

        foreach ($xml as $item){
            if($item->comment== $_GET['comment'])
            $item->Approval="Dennied";
}
        $xmlOutput = $xml->asXML();
        file_put_contents('comment.xml',$xmlOutput);
    }
    if($_GET['status']=='Approve'){
        $xml= simplexml_load_file("comment.xml");

        foreach ($xml as $item){
            if($item->comment== $_GET['comment'])
                $item->Approval="Approved";
        }
        $xmlOutput = $xml->asXML();
        file_put_contents('comment.xml',$xmlOutput);
    }



}

?>