<?php

include 'dessin.php';

$words = file('mots.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$tentatives = 8;
$letterstried = [];
$wordtofind = $words[array_rand($words)];
$wordsplitted = str_split($wordtofind);
$lettersfound = array_fill(0, count($wordsplitted), '_');

echo $titre . "\n\n";
while (1) 
{
    echo dessinPendu($tentatives);
    echo implode(' ', $lettersfound) . "\n";

    $letter = readline("Enter a letter : ");
    $letter = trim($letter);
    $letter = strtoupper($letter);

    if (mb_strlen($letter) != 1 || !ctype_alpha($letter)) {
        echo "Error: you need to enter a letter. (one letter)\n";
    }

    if (in_array($letter, $letterstried)) {
        echo "Error: you already tried this letter.\n";
    }

    if (in_array($letter, $wordsplitted)) 
    {
        foreach ($wordsplitted as $index => $wordletter) 
            if ($wordletter === $letter) 
                $lettersfound[$index] = $letter;

        if ($lettersfound === $wordsplitted) {
            echo "Congratulation, you found the word : ".$wordtofind."\n";
            echo $coeur;
            break;
        }
    } 
    else 
    {
        $tentatives--;
        if ($tentatives === 0) 
        {
            echo dessinPendu($tentatives);
            echo "Best luck next time, the word was : ".$wordtofind.".\n";
            break;
        }
        else
            echo "No luck! the letter you entered is not in the word. You have ".$tentatives." tentatives left.\n";
    }
    $letterstried[] = $letter;
}