<?php

define('ROOT', dirname(__FILE__)); //определяем орневую директорию

function searchByKey($file, $findKey) {
	$handle = fopen($file, "r"); //открываем файл для чтения
	while (!feof($handle)) {  
		$string = fgets($handle, 4000); // читаем данные по 4000 байт
		mb_convert_encoding($string, 'cp1251'); //выставляем кодировку для русских букв
		$explodeString = explode('\x0A', $string); //разбиваем на массив ключ/значение
		array_pop($explodeString); // \x0A с конца
		foreach ($explodeString as $key => $value) {
			$arr[] = explode('\t', $value); //получаем массив в массиве где ключ и значение разбиты
		}
	}
	$start = 0; 
	$end = count($arr) - 1; //задаем начальное и конечное значения
	while ($start <= $end) { //сам алгоритм бинарного поиска
		$middle = floor(($start + $end) / 2); //определяем середину и округляем
		$strnatcmp = strnatcmp($arr[$middle][0], $findKey); //сравниваем полученное с искомым
		if ($strnatcmp > 0) {
			$end = $middle - 1; //присваиваем к конечному значению
		} else if ($strnatcmp < 0) {
			$start = $middle + 1; //присваиваем к начальному
		} else {
			return $arr[$middle][1]; //возвращаем значение по ключу
		}
	}
	return 'undef'; //если значение не найдено
}

$findKey = 'ключ1234'; //искомый ключ
$file = ROOT . '/file.txt'; //файл в котором идет поиск
echo 'значение искомого ключа: ' . searchByKey($file, $findKey);