<?php

declare(strict_types=1);

use PhpStrike\models\Users;
use PhpStrike\models\Adverts;
use PhpStrike\models\Settings;
use PhpStrike\models\Categories;
use celionatti\Bolt\Helpers\Utils\StringUtils;
use celionatti\Bolt\Authentication\BoltAuthentication;

/**
 * Title: PhpStrike Framework
 * Author: Celio Natti
 * Year: 2023
 */

function isLoggedIn()
{
    return BoltAuthentication::currentUser();
}

function getSingleData($data, $dataKey)
{
    if ($data && isset($data->$dataKey)) {
        return $data->$dataKey;
    } else {
        return null;
    }
}

function getCombinedData($data, ...$dataKeys)
{
    if ($data) {
        $combinedData = '';

        foreach ($dataKeys as $dataKey) {
            if (isset($data->$dataKey)) {
                $combinedData .= $data->$dataKey . ' ';
            } else {
                return null; // Return null if any of the keys is not set.
            }
        }

        return trim($combinedData); // Remove trailing space and return the combined data.
    } else {
        return null;
    }
}

// Function to generate an HTML string based on user verification status
function statusVerification($status)
{
    $statusStyles = [
        'publish' => ['color' => 'green', 'weight' => 700],
        1 => ['color' => 'green', 'weight' => 700, 'label' => 'Verified'],
        'true' => ['color' => 'green', 'weight' => 700, 'label' => 'True'],
        'draft' => ['color' => 'orange', 'weight' => 700],
        'deleted' => ['color' => 'orange', 'weight' => 700],
        0 => ['color' => 'tomato', 'weight' => 700, 'label' => 'Not Verified'],
        'false' => ['color' => 'tomato', 'weight' => 700, 'label' => 'False'],
        'pending' => ['color' => 'orange', 'weight' => 700],
        'completed' => ['color' => 'green', 'weight' => 700],
        'low' => ['color' => 'blue', 'weight' => 700],
        'medium' => ['color' => 'orange', 'weight' => 700],
        'high' => ['color' => 'tomato', 'weight' => 700],
        'active' => ['color' => 'green', 'weight' => 700],
        'disabled' => ['color' => 'tomato', 'weight' => 700],
        'disable' => ['color' => 'tomato', 'weight' => 700],
        'inactive' => ['color' => 'tomato', 'weight' => 700],
        'failed' => ['color' => 'tomato', 'weight' => 700],
        'open' => ['color' => 'green', 'weight' => 700],
        'closed' => ['color' => 'tomato', 'weight' => 700],
        'expired' => ['color' => 'teal', 'weight' => 700],
        'suspended' => ['color' => 'orange', 'weight' => 700],
        'none' => ['color' => 'crimson', 'weight' => 700],
        'unread' => ['color' => 'teal', 'weight' => 700],
        'read' => ['color' => 'green', 'weight' => 700],
        'archive' => ['color' => 'tomato', 'weight' => 700],
        'spam' => ['color' => 'lime', 'weight' => 700],
        'important' => ['color' => 'crimson', 'weight' => 700],
        'banner' => ['color' => 'crimson', 'weight' => 700],
    ];

    if (array_key_exists($status, $statusStyles)) {
        $style = $statusStyles[$status];
        $label = $style['label'] ?? $status;
        return "<span style=\"color: {$style['color']}; font-weight: {$style['weight']}; text-transform: capitalize;\">{$label}</span>";
    } else {
        return '<span style="color: crimson; font-weight: 700; text-transform: capitalize;">Unknown Status</span>';
    }
}

function userRoleType($type)
{
    $typeStyles = [
        'admin' => ['color' => 'teal', 'weight' => 700, 'label' => 'Admin'],
        'user' => ['color' => 'tomato', 'weight' => 700, 'label' => 'User'],
        'guest' => ['color' => 'lightblue', 'weight' => 700, 'label' => 'Guest'],
        'editor' => ['color' => 'green', 'weight' => 700, 'label' => 'Editor'],
        'manager' => ['color' => 'orange', 'weight' => 700, 'label' => 'Manager'],
    ];

    if (array_key_exists($type, $typeStyles)) {
        $style = $typeStyles[$type];
        $label = $style['label'] ?? $type;
        return "<span style=\"color: {$style['color']}; font-weight: {$style['weight']}; text-transform: capitalize;\">{$label}</span>";
    } else {
        return '<span style="color: red; font-weight: 700; text-transform: capitalize;">Unknown Type</span>';
    }
}

function displayDate($timestamp)
{
    return date("g:i a T. F j, Y", strtotime($timestamp));
}

function user()
{
    return BoltAuthentication::currentUser() ?? null;
}

function getArticleUser($user_id)
{
    $users = new Users();

    return $users->findOne(['user_id' => $user_id]);
}

function displayTags($string)
{
    $array = explode(',', $string);

    foreach ($array as $value) {
        $tag = slugString(StringUtils::toLowerCase($value));
        echo "<a href='/article-tags/$tag'>$value</a>";
    }
}

function currentTime()
{
    return time();
}

function extractUniqueWords($data)
{
    $uniqueWords = [];

    foreach ($data as $item) {
        $tags = explode(', ', $item->tags);
        $uniqueWords = array_merge($uniqueWords, $tags);
    }

    return array_unique($uniqueWords);
}

function setting(string $name, bool $removeHtmlTags = false)
{
    $settings = new Settings();
    $setting = $settings->getSetting($name);

    $value = $setting->value ?? "";

    if ($removeHtmlTags) {
        // Decode HTML entities and then remove HTML tags
        $value = strip_tags(htmlspecialchars_decode($value));
    }

    return $value;
}

function getAds($priority = "low")
{
    $adverts = new Adverts();
    $ads = $adverts->getAdvertsByPriority($priority);

    if ($ads) {
        foreach ($ads as $ad) {
?>
            <div class='promotion'>
                <a href="<?= $ad->ads_link ?? "#" ?>">
                    <img src='<?= get_image($ad->advert_img) ?>' class='img-fluid w-100 shadow'>
                </a>
            </div>
        <?php
        }
    }
}

function getAdsBanner()
{
    $adverts = new Adverts();
    $ads = $adverts->getAdvertsBanner();

    // Check if $ads is not empty and is an object
    if ($ads && is_object($ads)) {
        ?>
        <div class='container-fluid'>
            <div class='ads-box'>
                <a href="<?= $ads->ads_link ?? "#" ?>">
                    <img src='<?= get_image($ads->advert_img) ?>' class='img-fluid'>
                </a>
            </div>
        </div>
<?php
    }
}

function slugString($text)
{
    // Replace spaces with underscores
    $slug = str_replace(' ', '_', $text);

    // Replace dashes with underscores
    $slug = str_replace('-', '_', $slug);

    // Remove special characters except underscores
    $slug = preg_replace('/[^A-Za-z0-9_]/', '', $slug);

    // Convert to lowercase
    $slug = strtolower($slug);

    return $slug;
}

function reverseSlug($slug)
{
    // Replace underscores with spaces
    $text = str_replace('_', ' ', $slug);

    // Convert to title case
    $text = ucwords($text);

    // Remove dashes
    $text = str_replace('-', ' ', $text);

    return $text;
}

function generateToken($length = 7)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';

    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $token;
}

function generateMetaTitle($title)
{
    $websiteName = "Natti Nation"; // Replace with your actual website name
    $metaTitle = $title . ' | ' . $websiteName;

    // Truncate meta title if it exceeds recommended length (50-60 characters)
    if (mb_strlen($metaTitle) > 60) {
        $metaTitle = mb_substr($metaTitle, 0, 57) . '...'; // Truncate and add "..." at the end
    }

    return $metaTitle;
}

function extractTextFromHTML($content)
{
    // Create a DOMDocument object
    $dom = new DOMDocument();
    // Load the HTML content into the DOMDocument
    @$dom->loadHTML($content);

    // Initialize an empty array to store extracted text
    $extractedText = [];

    // Get all <p> elements within the DOMDocument
    $paragraphs = $dom->getElementsByTagName('p');

    // Loop through each <p> element
    foreach ($paragraphs as $paragraph) {
        // Extract text from each <p> element and remove HTML tags and special characters
        $text = strip_tags($paragraph->nodeValue);
        // Add the extracted text to the array
        $extractedText[] = $text;
    }

    // Join the extracted text array elements into a single string with line breaks
    $finalText = implode("\n\n", $extractedText);

    // Return the final extracted text
    return $finalText;
}

function generateMetaDescription($content, $maxLength = 160)
{
    // Extract text from HTML content using the previously defined function
    $extractedText = extractTextFromHTML($content);

    // Remove line breaks and extra spaces for better readability
    $cleanedText = preg_replace('/\s+/', ' ', $extractedText);
    $cleanedText = trim($cleanedText);

    // If the cleaned text length is less than or equal to the max length, return it directly
    if (mb_strlen($cleanedText) <= $maxLength) {
        return $cleanedText;
    }

    // Find the last space before the max length to ensure a complete word is included
    $lastSpaceIndex = mb_strrpos($cleanedText, ' ', $maxLength - mb_strlen($cleanedText));

    // Extract the meta description ensuring a complete word before the ellipsis
    $metaDescription = mb_substr($cleanedText, 0, $lastSpaceIndex);

    // Add ellipsis to indicate continuation
    $metaDescription .= '...';

    // Return the trimmed text as the meta description
    return $metaDescription;
}

function generateKeywords($content)
{
    // Remove HTML tags and excess whitespace
    $cleanContent = preg_replace('/\s+/', ' ', strip_tags($content));

    // Convert content to lowercase and split into words
    $words = preg_split('/\s+/', strtolower($cleanContent));

    // Remove common and stop words
    $stopWords = array('a', 'an', 'the', 'and', 'or', 'is', 'are', 'in', 'on', 'at', 'for', 'with', 'to', 'from');
    $filteredWords = array_diff($words, $stopWords);

    // Calculate word frequency
    $wordFreq = array_count_values($filteredWords);

    // Sort words by frequency in descending order
    arsort($wordFreq);

    // Limit keywords to a certain count (e.g., top 5)
    $keywords = array_keys(array_slice($wordFreq, 0, 5)); // Adjust the number as needed

    // Convert keywords array to comma-separated string
    $keywordsString = implode(', ', $keywords);

    return $keywordsString;
}

function categoriesNav()
{
    $categories = new Categories();
    $navLists = $categories->getNavbarCategories();
    $checkNavLists = [];

    // Build an array of menu items
    $menuItems = [];

    foreach ($navLists as $category) {
        $parentNavs = $categories->getCategoryParent($category->child);

        if (!empty($parentNavs)) {
            foreach ($parentNavs as $parentNav) {
                $menuItems[$parentNav->category_id]['parent'] = $parentNav;
                $menuItems[$parentNav->category_id]['children'] = $categories->getCategoryChildren($category->child);
            }
        } elseif (!in_array($category->category_id, $checkNavLists)) {
            $menuItems[$category->category_id]['parent'] = $category;
        }
    }

    // Output the HTML
    foreach ($menuItems as $categoryId => $menuItem) {
        if (isset($menuItem['parent'])) {
            echo '<li class="' . (!isset($menuItem['children']) ? "" : "menu-item-has-children") . '">';
            echo '<a href="'. URL_ROOT . "categories/{$categoryId}" .'">' . $menuItem['parent']->category . '</a>';
            if (isset($menuItem['children'])) {
                echo '<ul class="sub-menu">';
                foreach ($menuItem['children'] as $childList) {
                    echo '<li><a href="'. URL_ROOT . "categories/{$childList->category_id}" .'">' . $childList->category . '</a></li>';
                }
                echo '</ul>';
            }
            echo '</li>';
        }
    }
}
