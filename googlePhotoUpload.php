<?php
    $userid = 'bhautikng143@gmail.com';

    // build feed URL
    $feedURL = "http://picasaweb.google.com/data/feed/api/user/$userid?kind=album";

    // read feed into SimpleXML object
    $sxml = simplexml_load_file($feedURL);

    // get album names and number of photos in each
    echo "<ul>";
    foreach ($sxml->entry as $entry) {
      $title = $entry->title;
      $gphoto = $entry->children('http://schemas.google.com/photos/2007');
      $numphotos = $gphoto->numphotos;
      echo "<li>$title - $numphotos photo(s)</li>\n";
    }
    echo "</ul>";
    ?>
