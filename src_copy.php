<?php

/**
 * ディレクトリをコピーする
 *
 * @param  string $dir     コピー元ディレクトリ
 * @param  string $new_dir コピー先ディレクトリ
 * @return void
 */
function copy_dir($dir, $new_dir)
{
    $dir     = rtrim($dir, '/').'/';
    $new_dir = rtrim($new_dir, '/').'/';

    // コピー元ディレクトリが存在すればコピーを行う
    if (is_dir($dir)) {
        // コピー先ディレクトリが存在しなければ作成する
        if (!is_dir($new_dir)) {
//          echo 'フォルダーを作成する:'.$new_dir.PHP_EOL;
            mkdir($new_dir, '775');
            chmod($new_dir, '775');
        }

        // ディレクトリを開く
        if ($handle = opendir($dir)) {
            // ディレクトリ内のファイルを取得する
            while (false !== ($file = readdir($handle))) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                // 下の階層にディレクトリが存在する場合は再帰処理を行う
                if (is_dir($dir.$file)) {
                    copy_dir($dir.$file, $new_dir.$file);
                } else {
                      echo "元:".$dir.$file .PHP_EOL;
                      echo "先:".$new_dir.$file.PHP_EOL;
                      echo "--".PHP_EOL;
                      copy($dir.$file, $new_dir.$file);
                }
            }
            closedir($handle);
        }
    }
}

echo "ソースを上書きコピーします".PHP_EOL;
copy_dir('weight_src', getcwd());

