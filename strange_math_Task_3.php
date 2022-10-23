<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strange Math</title>
</head>
<body>
	<div align="center">
    <h2>Strange Math</h2>
    <form method="post">
        <p>Введите максимальное число символов:</p>
        <p><input type="number" size="5" name="max_numbers" value="11"></p>
        <p>Введите число для поиска его позиции:</p>
        <p><input type="number" size="5" name="search_number" value="2"></p>
        <input type="submit" value="Отправить">
  </form>
  <br>

<?php
/**
 * Принимаем n и m из HTML формы. Проверяем на корректность
 */
if (!empty($_POST)):
	$n = (int) $_POST['max_numbers'];
	$k = (int) $_POST['search_number'];

	if ($n <= 0) {
		exit("Некорректное множество");
	}
	if ($k <= 0) {
		exit("Некорректное число для поиска");
	}

	if ($k > $n) {
		exit('Нет такого числа для поиска');
	}

/**
 * Описываем функцию сравнения строк, поскольку встроенная в PHP strcmp работает по-разному на
 * разных версиях интерпретатора
 */

	function strcompare($num1, $num2) {
		if ($num1 > $num2):
			return 1;
		elseif ($num1 < $num2):
			return -1;
		else:
			return 0;
		endif;
	}

/**
 * Описываем функцию, в которой сравниваем числа посимвольно.
 * В случае, если символы совпадают, сравниваем по длине.
 */

	function strange_math($num1, $num2) {
		$i = 0;
		while ((($i < strlen($num1)) && $i < strlen($num2))):
			if (strcompare($num1[$i], $num2[$i]) == -1):
				return false;
			elseif (strcompare($num1[$i], $num2[$i]) == 1):
				return true;
			endif;
			$i++;
		endwhile;
		if (strlen($num1) > strlen($num2)):
			return true;
		else:
			return false;
		endif;
	}

/**
 * Объявляем массив и заполняем его рядом натуральных чисел от 1 до k.
 * Сразу приводим его элементы к строковому типу, чтобы иметь возможность посимвольно сравнивать элементы
 */

	$array = [];
	for ($i = 1; $i <= $n; $i++) {
		$array[$i] = (string) $i;
	}

/**
 * Реализация сортировки выбором
 */

	for ($step = 1; $step <= $n; $step++):
		$min = $step;
		for ($j = $min + 1; $j <= $n; $j++):
			if (strange_math($array[$j], $array[$min]) == false):
				$min = $j;
			endif;
		endfor;
		$tmp = $array[$step];
		$array[$step] = $array[$min];
		$array[$min] = $tmp;
	endfor;
/**
 * Выводим отсортированный массив, приводя его элементы обратно к целочисленному типу
 */
	for ($i = 1; $i <= $n; $i++):
		$array[$i] = (int) $array[$i];
		echo $array[$i], ' ';
	endfor;
	echo "<br> Элемент $k находится на позиции " . array_search($k, $array);
endif;
?>
</div>
</body>
</html>
