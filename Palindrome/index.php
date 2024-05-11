<?php

function IsPalindrome($word)
{
    if(str_word_count($word) > 1)
        return -1;

    $len = strlen($word);
    for ($i = 0; $i < $len / 2; $i++) {
        if ($word[$i] != $word[$len - 1 - $i]) {
            return false;
        }
    }
    return true;
}

$word = readline("Enter a word: ");
$result = IsPalindrome($word);
if ($result < 0)
    echo "Error: too much words entered. (only 1 word is authorized)";
else
    echo $word . " is". ($result ? " " : " NOT ") ."a palindrome\n";
?>