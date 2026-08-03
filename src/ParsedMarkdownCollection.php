<?php

namespace Tempest\Markdown;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Traversable;
use Countable;

/**
 * @implements IteratorAggregate<int, \Tempest\Markdown\ParsedMarkdown>
 * @implements ArrayAccess<int|string, \Tempest\Markdown\ParsedMarkdown>
 */
final class ParsedMarkdownCollection implements IteratorAggregate, ArrayAccess, Countable
{
    /** @var list<ParsedMarkdown> */
    private array $chunks = [];

    /** @var array<string, int> */
    private array $byName = [];

    public function __construct(array $chunks = [])
    {
        foreach ($chunks as $chunk) {
            $this->add($chunk);
        }
    }

    public function add(ParsedMarkdown $chunk): self
    {
        $index = count($this->chunks);
        $this->chunks[$index] = $chunk;

        if ($chunk->name !== null) {
            $this->byName[$chunk->name] = $index;
        }

        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->chunks);
    }

    public function offsetExists(mixed $offset): bool
    {
        return is_string($offset) ? isset($this->byName[$offset]) : isset($this->chunks[$offset]);
    }

    public function offsetGet(mixed $offset): ?ParsedMarkdown
    {
        if (is_string($offset)) {
            return isset($this->byName[$offset]) ? $this->chunks[$this->byName[$offset]] : null;
        }

        return $this->chunks[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->add($value);
    }

    public function offsetUnset(mixed $offset): void
    {
        // unsupported for this collection (ToDo?)
    }

    public function count(): int
    {
        return count($this->chunks);
    }
}
