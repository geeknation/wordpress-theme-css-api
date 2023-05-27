<?php
function extractLinkWithTagId($html, $tagId) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // Disable error reporting for malformed HTML

    // Load the HTML content
    $dom->loadHTML($html);
    libxml_clear_errors();

    $links = $dom->getElementsByTagName('link');

    // Search for the link tag with the specified id attribute
    foreach ($links as $link) {
        if ($link->hasAttribute('id') && $link->getAttribute('id') === $tagId) {
            return $dom->saveHTML($link);
        }
    }

    return null; // Return null if the link tag is not found
}

$linkTag = extractLinkWithTagId($htmlContent, 'specific-id');
if ($linkTag !== null) {
    echo $linkTag;
} else {
    echo 'Link tag not found.';
}
?>