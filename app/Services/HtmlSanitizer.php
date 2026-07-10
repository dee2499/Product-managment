<?php

declare(strict_types=1);

namespace App\Services;

use DOMDocument;
use DOMElement;

class HtmlSanitizer
{
    /**
     * Sanitize a given rich text string.
     */
    public function sanitize(string $html): string
    {
        if (empty($html)) {
            return '';
        }

        $dom = new DOMDocument;
        libxml_use_internal_errors(true);

        // Load HTML wrapped in a container with UTF-8 encoding
        $dom->loadHTML('<?xml encoding="utf-8" ?><div>'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // 1. Remove dangerous tags
        $dangerousTags = ['script', 'iframe', 'object', 'embed', 'applet', 'link', 'style', 'form', 'button', 'input', 'textarea', 'select'];
        foreach ($dangerousTags as $tag) {
            $elements = $dom->getElementsByTagName($tag);
            while ($elements->length > 0) {
                $element = $elements->item(0);
                if ($element !== null && $element->parentNode !== null) {
                    $element->parentNode->removeChild($element);
                }
            }
        }

        // 2. Remove dangerous attributes recursively
        if ($dom->documentElement !== null) {
            $this->sanitizeNode($dom->documentElement);
        }

        // Save and cleanup wrapper div
        $cleanHtml = $dom->saveHTML($dom->documentElement) ?: '';
        if (str_starts_with($cleanHtml, '<div>') && str_ends_with($cleanHtml, '</div>')) {
            $cleanHtml = substr($cleanHtml, 5, -6);
        }

        return trim($cleanHtml);
    }

    /**
     * Recursively remove event handlers and javascript: URIs.
     */
    private function sanitizeNode(DOMElement $element): void
    {
        $attributesToRemove = [];

        foreach ($element->attributes as $attribute) {
            $name = strtolower($attribute->name);
            $value = strtolower($attribute->value);

            // Remove event handlers (onclick, onload, onerror, etc.)
            if (str_starts_with($name, 'on')) {
                $attributesToRemove[] = $attribute->name;
            }

            // Remove javascript:, vbscript:, data: links
            if ($name === 'href' || $name === 'src' || $name === 'action') {
                if (str_starts_with($value, 'javascript:') || str_starts_with($value, 'vbscript:') || str_starts_with($value, 'data:')) {
                    $attributesToRemove[] = $attribute->name;
                }
            }
        }

        foreach ($attributesToRemove as $attrName) {
            $element->removeAttribute($attrName);
        }

        foreach ($element->childNodes as $child) {
            if ($child instanceof DOMElement) {
                $this->sanitizeNode($child);
            }
        }
    }
}
