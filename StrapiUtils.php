<?php
namespace PHPStrapi;

/**
 * Class StrapiUtils
 *
 * A utility class for rendering rich text from Strapi's rich text JSON format into HTML.
 *
 * @author rubyciide (GitHub)
 */
class StrapiUtils
{
    /**
     * Render rich text nodes into HTML.
     *
     * @param array $nodes An array of rich text nodes to render.
     * @return string The rendered HTML output.
     */
    public static function renderRichText(array $nodes): string
    {
        $html = '';

        foreach ($nodes as $node) {
            $type = $node['type'] ?? null;
            $children = $node['children'] ?? [];

            switch ($type) {
                case 'paragraph':
                    $html .= '<p>' . self::renderRichText($children) . '</p>';
                    break;

                case 'quote':
                    $html .= '<blockquote>' . self::renderRichText($children) . '</blockquote>';
                    break;

                case 'code':
                    $html .= '<pre><code>' . htmlspecialchars(self::extractPlainText($children)) . '</code></pre>';
                    break;

                case 'heading':
                    $level = $node['level'] ?? 1;
                    $html .= "<h{$level}>" . self::renderRichText($children) . "</h{$level}>";
                    break;

                case 'link':
                    $url = htmlspecialchars($node['url'] ?? '#');
                    $html .= '<a href="' . $url . '">' . self::renderRichText($children) . '</a>';
                    break;

                case 'list':
                    $tag = ($node['format'] === 'ordered') ? 'ol' : 'ul';
                    $html .= "<{$tag}>" . self::renderRichText($children) . "</{$tag}>";
                    break;

                case 'list-item':
                    $html .= '<li>' . self::renderRichText($children) . '</li>';
                    break;

                case 'image':
                    $image = $node['image'] ?? [];
                    $src = htmlspecialchars($image['url'] ?? '');
                    $alt = htmlspecialchars($image['alternativeText'] ?? '');
                    $html .= '<img src="' . $src . '" alt="' . $alt . '" />';
                    break;

                case 'text':
                    $html .= self::applyModifiers(htmlspecialchars($node['text']), $node);
                    break;

                default:
                    // Handle unknown node types gracefully
                    break;
            }
        }

        return $html;
    }

    /**
     * Apply formatting modifiers to text based on node properties.
     *
     * @param string $text The text to apply modifiers to.
     * @param array  $node The node containing modifier information.
     * @return string The modified text with applied HTML tags.
     */
    private static function applyModifiers(string $text, array $node): string
    {
        // Define modifiers for text formatting
        $modifiers = [
            'bold' => '<strong>%s</strong>',
            'italic' => '<em>%s</em>',
            'underline' => '<u>%s</u>',
            'strikethrough' => '<del>%s</del>',
            'code' => '<code>%s</code>',
        ];

        foreach ($modifiers as $key => $template) {
            if (!empty($node[$key])) {
                // Apply the modifier if it exists in the node
                $text = sprintf($template, $text);
            }
        }

        return $text;
    }

    /**
     * Extract plain text from an array of nodes.
     *
     * @param array $nodes An array of nodes to extract text from.
     * @return string The extracted plain text.
     */
    private static function extractPlainText(array $nodes): string
    {
        $text = '';
        foreach ($nodes as $node) {
            if ($node['type'] === 'text') {
                // Append the text content
                $text .= $node['text'];
            } elseif ($node['type'] === 'link') {
                // Recursively extract text from link children
                $text .= self::extractPlainText($node['children'] ?? []);
            }
        }

        return $text;
    }
}
?>
