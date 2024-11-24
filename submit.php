<?php

$bookName = '';
$bookName = isset($_POST['bookName']) ? htmlspecialchars($_POST['bookName']) : " ";

if (!empty($bookName)) {
   
    $sanitized_book_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $bookName);

    if (isset($_COOKIE[$sanitized_book_name])) {
        echo "Book is not available";
    } else {
        echo "Book is available";
    }
} else {
    echo "Invalid book name";
}
?>
