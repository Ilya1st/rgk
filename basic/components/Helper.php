<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.08.2016
 * Time: 12:48
 */

namespace app\components;


use yii\base\Exception;

class Helper
{
    /**
     * Ищет наследников заданного класса
     * @param $fullClassName - польностью квалифицированное имя класса, наследников которого мы ищем
     * @return array - массив полностью квалифицированных имен классов
     */
    public static function getClassInheritance($fullClassName){
        $path = \Yii::$app->basePath;
        $fqcns = [];

        $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $path = $phpFile->getRealPath();
            if(strpos($path,'\models\\')===false) continue;
            $content = file_get_contents($path);
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0]) {
                    $index += 2; // Skip class keyword and whitespace
                    try{
                        $fqcns[] = $namespace.'\\'.$tokens[$index][1];
                    }
                    catch(\Exception $e){}
                }
            }
        }

        $result=[];
        foreach( $fqcns as $class ){
            if( is_subclass_of( $class, $fullClassName ) )
                array_push($result,$class);
        }
        return $result;
    }
}