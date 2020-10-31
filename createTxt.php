<?php

function createTxt($count) {//функция создания текстового файла требуемой длины
	for ($i=1; $i < $count; $i++) { 
		$text = 'ключ' . $i . '\tзначение' . $i . '\x0A';
		$fp = fopen("file.txt", "a");
		fwrite($fp, $text);
		fclose($fp);
	}
}

createTxt(5000);