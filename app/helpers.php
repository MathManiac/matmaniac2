<?php

function questionIdentifierFromChain()
{
    $identifiers = [];
    foreach (session('chain.list') as $question)
        $identifiers[] = $question['type'];
    return implode('_', $identifiers);
}