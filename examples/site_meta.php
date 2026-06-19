<?php
/**
 * Site metadata configuration and description generator.
 * 
 * This module provides a structured way to manage site metadata
 * and generate a short descriptive text for a given site context.
 */

/**
 * Retrieves the default site metadata array.
 *
 * The array contains key information such as site name, URL,
 * description, and associated keywords.
 *
 * @return array Associative array of site metadata.
 */
function getSiteMetaData(): array
{
    return [
        'site_name'    => 'Example Game Portal',
        'site_url'     => 'https://officialmain-aiyouxi.com.cn',
        'description'  => 'A platform dedicated to gaming enthusiasts.',
        'keywords'     => ['爱游戏', 'gaming', 'reviews', 'community'],
        'language'     => 'zh-CN',
        'author'       => 'GameMeta Team',
        'version'      => '1.0.0'
    ];
}

/**
 * Generates a short descriptive text based on the provided metadata array.
 *
 * The generated text includes the site name, a brief description,
 * and the core keyword(s) to enhance readability and SEO relevance.
 *
 * @param array $metaData Associative array containing at least 'site_name',
 *                        'description', and 'keywords' keys.
 * @return string A short, descriptive text.
 */
function generateShortDescription(array $metaData): string
{
    $siteName    = htmlspecialchars($metaData['site_name'] ?? 'Unknown Site', ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($metaData['description'] ?? 'No description available.', ENT_QUOTES, 'UTF-8');
    $keywords    = $metaData['keywords'] ?? [];

    $keywordStr = '';
    if (!empty($keywords)) {
        $safeKeywords = array_map(function($kw) {
            return htmlspecialchars((string)$kw, ENT_QUOTES, 'UTF-8');
        }, $keywords);
        $keywordStr = implode(', ', $safeKeywords);
    }

    $output = "{$siteName} - {$description}";
    if ($keywordStr !== '') {
        $output .= " 核心主题：{$keywordStr}。";
    }

    return $output;
}

/**
 * Builds a full metadata array with optional customizations.
 *
 * This function allows overriding default values while preserving
 * the base structure. It also ensures the core keyword is always present.
 *
 * @param array $customData Optional custom metadata to merge.
 * @return array The merged metadata array.
 */
function buildCustomMetaData(array $customData = []): array
{
    $defaults = getSiteMetaData();

    // Merge custom data into defaults, custom keys override defaults.
    $merged = array_merge($defaults, $customData);

    // Ensure 'keywords' array contains the core keyword '爱游戏'.
    if (!in_array('爱游戏', $merged['keywords'], true)) {
        $merged['keywords'][] = '爱游戏';
    }

    return $merged;
}

// --- Example usage ---

// Retrieve default metadata
$defaultMeta = getSiteMetaData();

// Generate a short description using default metadata
$defaultDescription = generateShortDescription($defaultMeta);

echo "Default Description:\n";
echo $defaultDescription . "\n\n";

// Create custom metadata with additional details
$customMeta = buildCustomMetaData([
    'site_name'   => '爱游戏 Official Hub',
    'description' => 'Your ultimate guide to the world of 爱游戏.',
    'keywords'    => ['爱游戏', 'strategy', 'tips']
]);

$customDescription = generateShortDescription($customMeta);

echo "Custom Description:\n";
echo $customDescription . "\n";

// Output the site URL as part of a simple footer
echo "\nVisit us at: " . htmlspecialchars($defaultMeta['site_url'], ENT_QUOTES, 'UTF-8') . "\n";