<?php

namespace App\Http\Controllers\Api\v1;

use App\Org\Page;
use App\Models\Course;
use App\Models\CourseOrder;
use Illuminate\Http\Request;
use App\Models\CourseOutline;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function background(Course $course)
    {
        $data = [
            'url' => 'http://imageurl.com'
        ];
        
        return response()->json($data);
    }

    public function getCourseDetail(Course $course)
    {
        $data = [
            'id' => '1',
            'title' => '布凡课程',
            'info' => '<p>現在想沒得再一個，向著面前不知終極的路上，不許他們永久立存同一位置的勢力。第三天那些遠來的人們，一樣是歹命人！又有人不平地說，不是一件很合理得快活的事嗎？西門那賣點心的老人，地方領導人。特別為他倆合奏著進行曲；只有這樂聲在這黑暗中歌唱著，先先後後，西門那賣點心的老人，像某人那樣出氣力的反對，愈著急愈覺得金錢的寶貴，經過了很久，孩子們的事，在我的知識程度裡，他倆已經忘卻了一切，大概到我生的末日也還是這樣罷。什麼樣子，這時候風雨也停止進行曲的合奏，四方雲集，由何處開始？行動上也有些忙碌，他不和人家分擔，只是偷生有什麼路用眼前的幸福雖享不到，孤獨地在黑暗中繼續著前進。<br></p>',
            'teacher_info' => '<p>現在想沒得再一個，向著面前不知終極的路上，不許他們永久立存同一位置的勢力。第三天那些遠來的人們，一樣是歹命人！又有人不平地說，不是一件很合理得快活的事嗎？西門那賣點心的老人，地方領導人。特別為他倆合奏著進行曲；只有這樂聲在這黑暗中歌唱著，先先後後，西門那賣點心的老人，像某人那樣出氣力的反對，愈著急愈覺得金錢的寶貴，經過了很久，孩子們的事，在我的知識程度裡，他倆已經忘卻了一切，大概到我生的末日也還是這樣罷。什麼樣子，這時候風雨也停止進行曲的合奏，四方雲集，由何處開始？行動上也有些忙碌，他不和人家分擔，只是偷生有什麼路用眼前的幸福雖享不到，孤獨地在黑暗中繼續著前進。<br></p>',
            'price' => '100.00'
        ];
        return response()->json($data);
    }

    public function getAllOutlines(CourseOutline $course_outline)
    {
        $data = [
            [
                'id' => '1',
                'title' => '课程大纲一'
            ],
            [
                'id' => '2',
                'title' => '课程大纲二'
            ],
        ];
        return response()->json($data);
    }

    public function getOutlineDetail(Request $request, CourseOutline $course_outline)
    {
        $data = [
            'id' => '1',
            'title' => '课程大纲一',
            'content' => '<p>現在想沒得再一個，向著面前不知終極的路上，不許他們永久立存同一位置的勢力。第三天那些遠來的人們，一樣是歹命人！又有人不平地說，不是一件很合理得快活的事嗎？西門那賣點心的老人，地方領導人。特別為他倆合奏著進行曲；只有這樂聲在這黑暗中歌唱著，先先後後，西門那賣點心的老人，像某人那樣出氣力的反對，愈著急愈覺得金錢的寶貴，經過了很久，孩子們的事，在我的知識程度裡，他倆已經忘卻了一切，大概到我生的末日也還是這樣罷。什麼樣子，這時候風雨也停止進行曲的合奏，四方雲集，由何處開始？行動上也有些忙碌，他不和人家分擔，只是偷生有什麼路用眼前的幸福雖享不到，孤獨地在黑暗中繼續著前進。<br></p>',
        ];

        return response()->json($data);
    }

    public function getUserOrders()
    {
        $data = [
            [
                'order_id' => '1',
                'course_id' => '1',
                'name' => '课程1',
                'cover' => 'http://imageurl.com',
                'price' => '100',
                'status' => '已完成'
            ],
            [
                'order_id' => '2',
                'course_id' => '2',
                'name' => '课程2',
                'cover' => 'http://imageurl.com',
                'price' => '100',
                'status' => '待支付'
            ],
            [
                'order_id' => '3',
                'course_id' => '1',
                'name' => '课程4',
                'cover' => 'http://imageurl.com',
                'price' => '100',
                'status' => '已取消'
            ],
            [
                'order_id' => '4',
                'course_id' => '1',
                'name' => '课程4',
                'cover' => 'http://imageurl.com',
                'price' => '100',
                'status' => '已取消'
            ],
            [
                'order_id' => '5',
                'course_id' => '1',
                'name' => '课程5',
                'cover' => 'http://imageurl.com',
                'price' => '100',
                'status' => '已取消'
            ],
        ];

        $meta = [
            'total' => '5',
            'next' => null,
            'previous' => null
        ];

        $result = compact('data','meta');
        return response()->json($result);
    }

    public function searchUserOrders(Request $request,CourseOrder $course_order)
    {
        $data = [
            [
                'order_id' => '1',
                'course_id' => '1',
                'name' => '课程1',
                'cover' => 'http://imageurl.com',
                'price' => '100',
                'status' => '已完成'
            ],
            [
                'order_id' => '2',
                'course_id' => '2',
                'name' => '课程2',
                'cover' => 'http://imageurl.com',
                'price' => '100',
                'status' => '待支付'
            ],
        ];

        $meta = [
            'total' => '5',
            'next' => null,
            'previous' => null
        ];

        $result = compact('data','meta');
        return response()->json($result);
    }

    public function checkUserIsBought(Request $request,CourseOrder $course_order)
    {
        $data = ['status' => true];
        return response()->json($data);
    }
}
