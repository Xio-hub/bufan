<?php

namespace App\Http\Controllers\Api\v1;

use App\Org\Page;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseOutline;
use App\Http\Controllers\Controller;
use App\Models\CourseConfig;

class CourseController extends Controller
{
    public function background(Course $course)
    {
        $data = $course->select('background as url')->first();
        return response()->json($data);
    }

    public function getCourseDetail(Course $course)
    {
        $data = $course->where('id', 'title', 'info', 'teacher_info', 'price')->first();
        return response()->json($data);
    }

    public function getOutlines(Request $request, CourseOutline $course_outline)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 8) ?? 50;
        $data = $course_outline->select('id','title')
                            ->offset($offset)
                            ->limit($limit)
                            ->get()
                            ->toArray();

        $total =  $course_outline->count();

        $page = new Page($total, $limit);
        return response()->json(['data' => $data, 'meta' => ['total_count' => $total, 'next' => $page->getNext(), 'previous' => $page->getPrev()]]);
    }

    public function getAllOutlines(CourseOutline $course_outline)
    {
        $data = $course_outline->select('id','title')->get()->toArray();
        return response()->json($data);
    }

    public function getOutlineDetail(Request $request, CourseOutline $course_outline)
    {
        $id = $request->id;
        $data = $course_outline->select('id', 'title', 'content')->where(['id' => $id])->first();

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

    public function checkUserIsBought()
    {
        $data = ['status' => true];
        return response()->json($data);
    }
}
