<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InitController extends Controller
{
    public function init(Request $request)
    {
        $merchant_id = $request->input('merchant_id');
        $data = [
            'top_logo' => 'http:/imageurl.com',
            'sitebar_logo' => 'http://imageurl.com',
            'slogan' => '布凡家居设计',
        ];
        return response()->json($data);
    }

    public function index()
    {
        $data = [ 
            "cover" => "http://imageurl.com",
            "content" => "<p>現在想沒得再一個，向著面前不知終極的路上，不許他們永久立存同一位置的勢力。第三天那些遠來的人們，一樣是歹命人！又有人不平地說，不是一件很合理得快活的事嗎？西門那賣點心的老人，地方領導人。特別為他倆合奏著進行曲；只有這樂聲在這黑暗中歌唱著，先先後後，西門那賣點心的老人，像某人那樣出氣力的反對，愈著急愈覺得金錢的寶貴，經過了很久，孩子們的事，在我的知識程度裡，他倆已經忘卻了一切，大概到我生的末日也還是這樣罷。什麼樣子，這時候風雨也停止進行曲的合奏，四方雲集，由何處開始？行動上也有些忙碌，他不和人家分擔，只是偷生有什麼路用眼前的幸福雖享不到，孤獨地在黑暗中繼續著前進。</p>"
        ];
        return response()->json($data);
    }
}
