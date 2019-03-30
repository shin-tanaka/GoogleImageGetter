# GoogleImageGetter
Download Images from Google Image Search by web scraping.

Google画像検索の結果を上位100件分※取得するスクリプトです  
Webスクレイピングによって取得しているため、GoogleSearchAPIは使っていません  
どうやらGoogleの規約には引っかかるらしいです 

### 特徴
* Webスクレイピングを用いているのでAPIを使わずに済みます
* Twitterなどの拡張子が特殊だったり、拡張子がないファイルでも自動的に拡張子をセットします(jpg, png, gifに対応)
* Google画像検索では画像を直接開くことができなくなっていますが、このスクリプトでは元ファイルを直接ダウンロードしています

※下記の理由により、理論上は100件ですが、実際には80～90件程度の取得率になります
※PHPの環境設定でOpenSSHを設定して置かないとhttpsアドレスからのダウンロードはできません
※日本語ドメインではエラーが発生しダウンロードできません

