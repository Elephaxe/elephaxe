<?php

namespace Elephaxe\Tools;

/**
 * Parse PHP doc to extract some data
 */
class DocParser
{
    const TAG_VAR = '@var';

    /**
     * Returns all tags found in PHP doc
     *
     * @param  string $docblock
     *
     * @return array
     */
    public static function getTags($docblock)
    {
        $matches = array();

        $docblock = is_string($docblock) ? $docblock : null;
        $tags = [];
        
        if ($docblock) {
            preg_match_all('/\*\s+(@[a-z-]+)([^@]*)\n/', $docblock, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                if (!isset($tags[$match[1]])) {
                    $tags[$match[1]] = array();
                }

                $tagValue = $match[2];
                $tagValue = str_replace(array("\n", "\r\n", PHP_EOL), "\n", $tagValue);

                // Remove the delimiters of the docblock itself at the start of each line, if any.
                $tagValue = preg_replace('/\n\s+\*\s*/', ' ', $tagValue);

                // Collapse multiple spaces, just like HTML does.
                $tagValue = preg_replace('/\s\s+/', ' ', $tagValue);

                $tags[$match[1]][] = trim($tagValue);
            }
        }

        return $tags;
    }

    /**
     * Get the value of the @var type
     *
     * @param  string $docComment
     *
     * @return string|null
     */
    public static function getVarType($docComment)
    {
        $tags = self::getTags($docComment);

        return isset($tags[self::TAG_VAR]) ? $tags[self::TAG_VAR][0] : null;
    }
}
