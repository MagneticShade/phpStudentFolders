<?php
error_reporting(E_ALL);

$file=fopen("pupiles.txt","r");
$names=[];

while($line=fgets($file)){
    $words=explode(' ',$line);
    $lastName=$words[0];

    if(!empty($words[2])){
        $initials=mb_substr($words[1],0,1). '.' . mb_substr($words[2],0,1);
    }
    else{
        $initials=mb_substr($words[1],0,1);
    }

    array_push($names,$lastName . $initials);

}
foreach($names as $name){
    $path="/userDir/". $name;
    if(!file_exists($path)&&!is_dir($path)){
        mkdir($path);
    }
    else{
        echo "Папка $name уже сущестевует" ;
    }
}

$fileContent = file_get_contents('task.txt');

$tasks=preg_split('/Вариант \d+/',$fileContent,-1,PREG_SPLIT_NO_EMPTY);

foreach($tasks as $key=>$task){
    $filename='вариант_' . ($key+1) . 'txt';
    $file = fopen(__DIR__ . '/tasks/' .$filename, w);

    fwrite($file,$trim($task));

    fclose($file);
}

$userDir = 'userDir';
$tasksDir = 'tasks';

$userFolders = scandir($userDir);

$userFolders = array_diff($userFolders,['.','..']);

$taskFiles = scandir($tasksDir);

$taskFiles = array_diff($taskFiles,['.','..']);

$usedTasks = [];

foreach($userFolders as $userFolder){
    $userFolderPath = $userDir. '/' . $userFolder;

    if(is_dir($userFolderPath)){
        $files = glob($userFolderPath . '/*');

        if($files !== false && count($files)>0){
            foreach($files as $file){
                if(is_file($file)){
                    unlink($file);
                }
            }
        }
    }
}


?>