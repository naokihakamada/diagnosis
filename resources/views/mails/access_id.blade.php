{{$urec->name}}様

コミュニケーションスタイル診断をご利用頂きまして誠にありがとうございます。
大村　亮介でございます。

あなたのスタイルは

「{{$style[$urec->my_type]["type"]}} / {{$style[$urec->my_type]["name"]}} / {{$style[$urec->my_type]["kana"]}}」

になります。

あなたのスタイルの詳細や、その他のスタイルに関する情報は

<a href="{{route('user_result', ["alias"=>$urec->alias, "access_id"=>$urec->access_id])}}">診断結果へはこちらから</a>
{{route('user_result', ["alias"=>$urec->alias, "access_id"=>$urec->access_id])}}

へアクセス頂くことで、何度でも確認することができます。

ご自身のスタイルだけでなく、お相手に接するときの注意点も是非ご確認くださいませ。

-----------------------------------
コミュニケーションスタイル診断サイト　www.ecm-training.com

株式会社　アールオージャパン
代表取締役　大村　亮介
Mail: info@ecm-training.com
-----------------------------------

◆このメールは送信専用です。ご返信いただきましても、対応いたしかねます。
