# Strapi Rich Text Renderer

## Description
A PHP utility for rendering Strapi rich text fields into HTML.

## Usage
To use the Strapi Rich Text Renderer in your PHP project, include the `StrapiUtils.php` file and call the `renderRichText` method with the rich text JSON data.

### Example Code

```php
<?php
require_once 'path/to/StrapiUtils.php';

// Example response from Strapi
$strapiResponse = [
    'data' => [
        'your_rich_text_block_field_name' => [
            // Your rich text JSON data here
        ]
    ]
];

echo \\path\\to\\StrapiUtils::renderRichText($strapiResponse['data']['your_rich_text_block_field_name']);
?>
```

## Example JSON Structure

This is an example of how the JSON data might look when returned from Strapi:

```json
[
    {
        "type": "heading",
        "level": 2,
        "children": [
            {
                "type": "text",
                "text": "Hello World!",
                "bold": true
            }
        ]
    },
    {
        "type": "paragraph",
        "children": [
            {
                "type": "text",
                "text": "This is a sample paragraph."
            }
        ]
    },
    {
        "type": "image",
        "image": {
            "url": "https://example.com/image.jpg",
            "alternativeText": "An example image"
        }
    }
]
```

## Functions

### `renderRichText(array $nodes): string`
Converts an array of rich text nodes into HTML.

#### Parameters:
- **array $nodes**: An array of nodes representing rich text content.

#### Returns:
- **string**: The rendered HTML output.

### `applyModifiers(string $text, array $node): string`
Applies text modifiers such as bold, italic, underline, strikethrough, and code to the given text.

#### Parameters:
- **string $text**: The text to which modifiers will be applied.
- **array $node**: The node containing the modifier flags (bold, italic, etc.).

#### Returns:
- **string**: The modified text wrapped with appropriate HTML tags.

### `extractPlainText(array $nodes): string`
Extracts plain text from rich text nodes, ignoring any formatting or HTML tags.

#### Parameters:
- **array $nodes**: The rich text nodes from which plain text will be extracted.

#### Returns:
- **string**: The plain text extracted from the rich text nodes.

## Contributing
Contributions are welcome! If you have suggestions for improvements or find bugs, please open an issue or submit a pull request.

### Steps to Contribute
1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/AmazingFeature`).
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4. Push to the branch (`git push origin feature/AmazingFeature`).
5. Open a pull request.

## License
Distributed under the MIT License.

## Contact
wheezyturbo - [Website](https://portfolio-beige-three-33.vercel.app/contact)

Project Link: [https://github.com/wheezyturbo/php-strapi-utils](https://github.com/wheezyturbo/php-strapi-utils)
