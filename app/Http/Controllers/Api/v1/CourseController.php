<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function background()
    {
        $data = [
            'url' => 'http://imageurl.com'
        ];

        return response()->json($data);
    }

    public function getIntroduct()
    {
        $data = [
            'content' => 'rich text editor content'
        ];
        return response()->json($data);
    }

    public function list()
    {
        $data = [
            [
                'id' => '1',
                'name' => '课程1',
                'cover' => 'http://imageurl.com',
                'price' => '100',
            ],
            [
                'id' => '2',
                'name' => '课程2',
                'cover' => 'http://imageurl.com',
                'price' => '100',
            ],
            [
                'id' => '3',
                'name' => '课程4',
                'cover' => 'http://imageurl.com',
                'price' => '100',
            ],
            [
                'id' => '4',
                'name' => '课程4',
                'cover' => 'http://imageurl.com',
                'price' => '100',
            ],
            [
                'id' => '5',
                'name' => '课程5',
                'cover' => 'http://imageurl.com',
                'price' => '100',
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

    public function searchUserOrders()
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

    public function detail()
    {
        $data = [
            'id' => '1',
            'title' => '课程名称1',
            'content' => '课程内容，富文本提供'
        ];

        return response()->json($data);
    }

    public function checkUserIsBought()
    {
        $data = ['status' => true];
        return response()->json($data);
    }
}
