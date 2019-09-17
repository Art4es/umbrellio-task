<?php


namespace Art4es\strategies;


use Art4es\file\IFile;

class SubstringSearchingStrategy implements IStrategy
{
    private $needle;

    public function __construct(string $needle)
    {
        $this->needle = $needle;
    }

    public function search(IFile $file)
    {
        $haystack = $file->open();
        $result = [];
        $lineNumber = 1;
        while (($line = fgets($haystack)) !== false) {
            $matches = $this->searchInLine($haystack);
            foreach ($matches as $match) {
                $result[] = ['line' => $lineNumber, 'position' => $match];
            }
            $lineNumber++;
        }
        $file->close();
        return $result;
    }

    private function searchInLine($line, $result = [], $offset = 0): array
    {
        while ($matchPosition = strpos($line, $this->needle, $offset) !== false || $offset > strlen($line) - 1) {
            array_push($result, $matchPosition);
            return $this->searchInLine($line, $result, ++$matchPosition);
        }
        return $result;
    }
}