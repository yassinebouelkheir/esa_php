<?php
first_step:
$first_params = readline("Enter the first digit : ");
if (!is_numeric($first_params)) 
    goto first_step;

second_step:
$second_params = readline("Enter the second digit : ");
if (!is_numeric($second_params))
    goto second_step;

third_step:
$op = readline("Select the operation to execute (+ - / *) : ");
switch ($op) {
    case "+":
        $result = ($first_params + $second_params);
        break;
    case "-":
        $result = ($first_params - $second_params);
        break;
    case "*":
        $result = ($first_params * $second_params);
        break;
    case "/":
        if ($second_params == 0) 
        {
            echo "The result is : NaN (division by 0 is not allowed)\n";
            echo "Try again.\n\n";
            goto first_step;
        }
        else
            $result = ($first_params / $second_params);
        break;
    default:
        echo "The selected operation is invalid.\n";
        goto third_step;
}
echo "The result is : " . number_format($result, 2, '.', '') . "\n\n";
?>