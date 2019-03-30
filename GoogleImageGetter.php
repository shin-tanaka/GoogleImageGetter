<?php

class GoogleImageGetter{

	function __construct(){}

	/**
	 * URLで与えられた画像を指定したフォルダーに保存する。
	 * フォルダーを指定する際は末尾に/[スラッシュ]を入れること。
	 * URLに拡張子がない場合でもMIMEから判断して拡張子を自動的に付加する。
	 * フォルダ名はadler32を用いて自動的に8文字の名前が付く
	 *
	 * @param string $url
	 * @param string $saveFolder
	 *
	 */
	public function saveFile($url, $saveFolder){
		$url = rawurldecode($url);
		$type = getimagesize($url)['mime'];
		$format = preg_replace('/image\//u', '', $type);
		if(strcmp($format, 'jpeg') == 0){
			$format = 'jpg';
		}
		$img = file_get_contents($url);
		file_put_contents($saveFolder . hash('adler32', $url, false).'.'.$format, $img);
	}

	/**
	 * 与えられたキーワードをGoogle画像検索で調べ、
	 * 結果100枚の画像URLを配列に格納して返す
	 * ユーザーエージェント偽装に関して参考にしたサイト↓
	 * @link <http://xirasaya.com/?m=detail&hid=320>
	 *
	 * @param  string $word
	 * @return array  $imgUrls[1]
	 *
	 */
	public function scrapingImage($word){
		$word = preg_replace('/[ 　]/u', '+', $word);
		$serchUrl = "https://www.google.co.jp/search?tbm=isch&gs_l=img&q=" . $word;

		/* =====MEMO=====
		 * │これをつけると200万画素(2MP)以上の画像のみになる
		 * ↓後ろの2mpの他に4,6と画素数を指定できる
		 * &tbs=isz:lt,islt:2mp
		 */

		/* ユーザーエージェントを偽装してHTTP GETリクエストを送信、HTMLファイルを取得する
		 * ここではOPERAのものを使用
		 */
		$context = stream_context_create([
			'http' => [
				'method' => 'GET',
				'header' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36 OPR/58.0.3135.107'
			]
		]);

		//HTMLファイルを取得し、改行を排除
		$html = file_get_contents($serchUrl, false, $context);
		$html = str_replace(["\r\n", "\r", "\n"], '', $html);

		//"ou":のあとの画像ファイルURLを抽出する
		$pattern = '/\"ou\":\"(.*?)\",/u';
		preg_match_all($pattern, $html, $imgUrls);

		return $imgUrls[1];
	}

}