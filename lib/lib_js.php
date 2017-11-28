<?php
if (!defined('proverka')) {
    die();
};
function rand_string (
 
        $length = 15, # Желаемая длина строки
        $repeat = false, # Разрешить повторение символов
        $UpperCase = true, # Использовать большие буквы - Используйте только boolean тип при вызове!
        $LowerCase = true, # Использовать маленькие буквы - Используйте только boolean тип при вызове!
        $Symbols = true, # Использовать символы - Используйте только boolean тип при вызове!
        $SymbolsList__ = '0123456789_+=?,.', # Символы
        $UpperCaseList = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', # Большие буквы
        $LowerCaseList = 'abcdefghijklmnopqrstuvwxyz' # Маленькие буквы
 
) {
 
if ($UpperCase) {
 
        $UpperCase = $UpperCaseList;
 
}
 
if ($LowerCase) {
 
        $LowerCase = $LowerCaseList;
 
}
 
if ($Symbols) {
 
        $Symbols = $SymbolsList__;
}
 
unset ($UpperCaseList, $LowerCaseList, $SymbolsList__);
 
        /* Объединяет большие и маленькие буквы с символами в одну строку, случайно определяя очерёдность их в ней. */
 
        switch (rand(0, 5)) {
       
                case 0:
                        $All = $UpperCase. $LowerCase . $Symbols;
                case 1:
                        $All = $UpperCase. $Symbols . $LowerCase;
                case 2:
                        $All = $Symbols . $LowerCase .$UpperCase;
                case 3:
                        $All = $Symbols . $UpperCase . $LowerCase;
                case 4:
                        $All = $LowerCase .$Symbols . $UpperCase;
                case 5:
                        $All = $LowerCase . $UpperCase . $Symbols;
                       
        }
       
unset ($UpperCase, $LowerCase, $Symbols);
               
        $totalLength = strlen($All) - 1;
       
        if (!$repeat) {
       
                $totalLength++;
       
                if($length > $totalLength) {
               
                #       echo "Error while generating the string: the maximum length is exceeded ($length instead of $totalLength characters)";
                        return false;
 
                }
               
                $totalLength--;
 
                while ($i++ < $length) {
               
                        $Current = $All{rand(0, $totalLength--)};
                        $All = str_replace($Current, '', $All);
                        $string .= $Current;
                       
                }
               
        } else {
       
                while ($i++ < $length) {
               
                        $string .= $All{rand(0, $totalLength)};
                       
                }
                    }
 
                unset ($All, $i, $length, $totalLength, $repeat);
                return $string;
       
};

?>