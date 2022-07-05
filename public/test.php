<?php


    switch($_GET['p']){
        case 1:
            echo "<p>Content for this page</p>";
            break;
        case 2:
            echo "<p>More content with some additional <b>strong</b> text, lalala";
            break;
        default:
            echo "<p>Default content</p>";
    }