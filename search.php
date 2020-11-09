<?php

define('ROOT', dirname(__FILE__)); //определяем орневую директорию

function binarySearch($array, $key) { //выносим бинарный поиск в отдельну функцию
        $start = 0; 
	    $end = count($array) - 1; 
	    while ($start <= $end) { 
	    	$middle = floor(($start + $end) / 2); 
	    	$strnatcmp = strnatcmp($array[$middle][0], $key); 
	    	if ($strnatcmp > 0) {
	    		$end = $middle - 1; 
	    	} else if ($strnatcmp < 0) {
	    		$start = $middle + 1; 
	    	} else {
	    		return $array[$middle][1]; //если значение найдено, возвращаем его
	        }
	    }
	return 'undef';//если на проверяемом отрезке его нет, то undef
} 

function searchByKey($file, $findKey) {

	$startBite = 0;
	
	$handle = fopen($file, "r"); //открываем файл для чтения

	while ($string !== '') {  
		$string = file_get_contents($file, FALSE, NULL, $startBite, 4000); //читаем файл по 4000 байт 
		if ($string == '') {
			return $search;
		}
		mb_convert_encoding($string, 'cp1251'); //выставляем кодировку для русских букв

		$explodeString = explode('\x0A', $string); //разбиваем на массив ключ/значение

        for ($i = 0; $i < count($explodeString); $i++) {
		    if (strlen($explodeString[$i+1]) < strlen($explodeString[$i])) {
			  unset($explodeString[$i+1]);
		    }
        }
        $implodeString = implode('\x0A' ,$explodeString) . '\x0A';
        $startBite += strlen($implodeString); //определяем с какого байта начать чтение файла на следующей итерации

        $arr = [];

		foreach ($explodeString as $key => $value) {
			$arr[] = explode('\t', $value); //получаем массив в массиве где ключ и значение разбиты
		}

        $search = binarySearch($arr, $findKey);
        if ($search !== 'undef') {
        	return $search;
        }
    } 
}

$findKey = 'ключ1957'; //искомый ключ
$file = ROOT . '/file.txt'; //файл в котором идет поиск
echo 'значение искомого ключа: ' . searchByKey($file, $findKey);

