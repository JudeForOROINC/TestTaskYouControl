<?php

//Тестовое задание:

//Написать программу, которая осуществляет поиск дубликатов файлов.
//На вход подаётся путь, по которому должен осуществляться поиск.
//
//На выходе - текстовый файл, в котором будут указаны все дубликаты, по 1 пути на строку.
//
//Будет оценено затраченное время, качество кода, производительность программы, отказоустойчивость.
//
//Пожалуйста, при выполнении замерте потраченное на выполнение время.
//
//
//С уважением.
//Игорь
//
//
//10 vby - xntybt b fyfkbp/
//
//1) Под дубликатами понимаем файлы, которые идентичны по содержанию, размеру и названию. но могут отличаться по дате.
//2) Т.к. время на реализацию указанно до 1 дня , делаем вывод, что не нужно решение с какими-то сверх алгоритмами - простейшее.
//3) для первичной выборки проверим хеши. на выходе получаем перечень файлов с параметрами: путь, размер, хеш,
//4) сортируем полученный индекс для получения дублей (запрос)
//5) для страховки от коллизий перепрогоняем файл (дубль)  по каждой группе, где совпали имя файла, хеш, размер.
//6) если совпадения не выстрелили - выходим.
////
////
////

if (!$argv[0]) {
    die ("This program may run CLI mode only.");

}
if (empty($argv[1])) {
    print "No arguments found! please set path to Folder to find doubles" . PHP_EOL; die;
}

$path = $argv[1];

if(! check_path($path)){
    die("Not normal folder path given!");
}

process_path($path);


function check_path($path){
    return is_dir($path);
}

/**
 * @param $path string Folder to searching doubles;
 * Main controller - search for doubless and print result;
 */
function process_path($path){
    if (check_path($path)){
        global $files;
        $files = array();
        global $results;
        $results = array();
        treescan($path);
        SearchDoubles();
        unset($files);
        $res = implode(PHP_EOL,array_keys($results));
        print $res;
    };
}

/**
 * @param $path string Path to a folder to search
 * recurce searching. Warring! may be stackoverflow on deep tree! to protect may limited call stack size.
 */
function treeScan($path)
{
    if (check_path($path)) {
        $dir = @scandir($path);
        foreach ($dir as $dirname) {
            if ( ($dirname == '.' ) or ($dirname == '..') ) continue;
            if (check_path($path.DIRECTORY_SEPARATOR.$dirname)){
                treeScan($path.DIRECTORY_SEPARATOR.$dirname);//bad desigion. may be stack overflow.
            } else {
                add_file($path.DIRECTORY_SEPARATOR.$dirname);
            }
        }
    }
}

/**
 * @param $path string path to file
 * The idea is to sort files in some order. the doubles must have the same size first of all;
 */
function add_file($path){
    global $files;
    $size = @filesize($path);
    $key = $size;
    $files[$key][] = $path;
};

/**
 * Searching for doubles in global array $files
 * then put data to global array results;
 */
function SearchDoubles(){
    global $files;
    global $results;

    foreach ($files as $size => $filearray){
        if (count($filearray)<2) continue;
        while ($filearray) {
            $file = array_pop($filearray);
            foreach ( $filearray as $curfile) {
                if (is_really_double($file,$curfile)) {
                    $results[$file] = 1;
                    $results[$curfile] = 1;
                }
            }
        }
    }
}


function is_really_double($file1,$file2,$buffer_long = 8192)
{
    if(! $f1 = @fopen($file1,'rb')){
        return false;
    };
    if(! $f2 = @fopen($file2,'rb')){
        fclose($f1);
        return false;
    };

    while ( ! feof($f1)){
        if (false !==( $buf = @fread($f1, $buffer_long) ) ) {
            if (false !==( $buf2 = @fread($f2, $buffer_long) )) {
                if ( $buf === $buf2) {
                    continue;
                }
            }

        };
        fclose($f1);
        fclose($f2);
        return false;
    }
    fclose($f1);
    fclose($f2);
    //print "doubles = $file1 + $file2";
    return true;
}

