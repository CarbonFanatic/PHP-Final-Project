<?php

if (isset($_POST['comment'])) {
    $color = $_POST['sel_item_color'];
    $size = $_POST['sel_item_size'];
    $comment = $_POST['iComment'];
    $approval = $_POST['validation'];
    $itemid = $_POST['itemid'];
    $itemName = $_POST['itemName'];
    $uid = $_POST['uid'];

    var_dump($itemName);

    if (empty($color) || empty($size) || empty($comment)) {
        header("Location: ../showitem.php?item_id=" . $itemid . "&msg=emptyfields&iComment=" . $comment);
        exit();
    }
    else{
        $xmldoc = new DomDocument();
        $xmldoc->formatOutput = true;
    }
        if($xml = file_get_contents( 'comment.xml') ) {
            $xmldoc->loadXML($xml,LIBXML_NOBLANKS);

            // find the items tag
            $root = $xmldoc->getElementsByTagName('items')->item(0);

            // create the <item> tag
            $item = $xmldoc->createElement('item');

            // add the item tag before the first element in the <items> tag
            $root->insertBefore( $item, $root->firstChild );

            // create other elements and add it to the <item> tag.
            $idElement = $xmldoc->createElement('id');
            $item->appendChild($idElement);
            $idText = $xmldoc->createTextNode($itemid);
            $idElement->appendChild($idText);

            $usernameElement = $xmldoc->createElement('uid');
            $item->appendChild($usernameElement);
            $usernameText = $xmldoc->createTextNode($uid);
            $usernameElement->appendChild($usernameText);

            $nameElement = $xmldoc->createElement('name');
            $item->appendChild($nameElement);
            $nameText = $xmldoc->createTextNode($itemName);
            $nameElement->appendChild($nameText);

            $approvaElement = $xmldoc->createElement('Approval');
            $item->appendChild($approvaElement);
            $approvalText= $xmldoc->createTextNode($approval);
            $approvaElement->appendChild($approvalText);

            $colorElement = $xmldoc->createElement('color');
            $item->appendChild($colorElement);
            $colorText= $xmldoc->createTextNode($color);
            $colorElement->appendChild($colorText);

            $sizeElement = $xmldoc->createElement('size');
            $item->appendChild($sizeElement);
            $sizeText= $xmldoc->createTextNode($size);
            $sizeElement->appendChild($sizeText);

            $commentElement = $xmldoc->createElement('comment');
            $item->appendChild($commentElement);
            $commentText= $xmldoc->createTextNode($comment);
            $commentElement->appendChild($commentText);

            $xmldoc->save('comment.xml');
            header("Location: ../showitem.php?item_id=" . $itemid . "&msg=commentAdded");
            exit();
        }
}