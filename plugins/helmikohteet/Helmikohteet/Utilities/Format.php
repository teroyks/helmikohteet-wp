<?php

/**
 * Helper methods for formatting the template data.
 */

namespace Helmikohteet\Utilities;

/**
 * Template data formatter.
 */
class Format
{
    /**
     * Wraps paragraphs in <p> tags.
     *
     * @param $desc
     *
     * @return string
     */
    public function description($desc): string
    {
        $p = fn($text) => "<p>$text</p>\n";

        $paragraphs = array_map(
            $p,
            explode("\n", $desc)
        );

        return implode("\n", $paragraphs);
    }

    /**
     * Formats a float for display.
     *
     * @param $val
     *
     * @return string Float as a localized string, or original value is non-numeric
     */
    public function float($val): string
    {
        return is_numeric($val) ? number_format($val, 2, ',', ' ') : $val;
    }

    /**
     * Builds a data table row
     *
     * @param        $label
     * @param        $value
     * @param string $suffix Optional suffix added after the value
     *
     * @return string Table row with label and value columns
     */
    public function tr($label, $value, $suffix = ''): string
    {
        if (!$value) {
            return '';
        }

        return <<<EOF
            <div class="helmik-details-grid-row">
              <div class="helmik-details-label">$label</div>
              <div class="helmik-details-property">$value$suffix</div>
            </div>
            EOF;
    }
}
