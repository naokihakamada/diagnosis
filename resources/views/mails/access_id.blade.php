{{$urec->name}}　様<br />
<br />
コミュニケーションスタイル診断をご利用頂きまして誠にありがとうございます。<br />
<br />
あなたのスタイルは・・・<br />
<br />
<b style="font-size:1.5em">「{{$style[$urec->my_type]["type"]}} / {{$style[$urec->my_type]["name"]}} / {{$style[$urec->my_type]["kana"]}}」</b><br />
<br />
となります。<br />
<br />
あなたのコミュニケーションスタイルの詳細や、その他のスタイルの特徴、接し方、相性などは、以下URLよりご確認ください。<br />
<a href="{{route('user_result', ["alias"=>$urec->alias, "access_id"=>$urec->access_id])}}">{{route('user_result', ["alias"=>$urec->alias, "access_id"=>$urec->access_id])}}</a><br />
<br />
※アクセス頂くことで、何度でも確認することができます。<br />
<br />
-------------------------------------------------------<br />
運営者：株式会社　アールオージャパン<br />
http://www.rojapan.com<br />
-------------------------------------------------------<br />
