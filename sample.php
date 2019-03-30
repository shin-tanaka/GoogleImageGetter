<?php

require_once("./GoogleImageGetter.php");

/**
 * $path で指定したフォルダに
 * $word で検索した結果の画像を保存するスクリプトです。
 * 現段階ではフォルダは自動生成されないので注意
 */

$gig = new GoogleImageGetter();

$path = './[any folder]/';
$word = "[any keyword]";

//画像のURLを取得する
$urls = $gig->scrapingImage($word);

//画像をダウンロードする
foreach ($urls as $url) {
	$gig->saveFile($url, $filePath);
}
