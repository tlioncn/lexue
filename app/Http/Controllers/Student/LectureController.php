<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course\Lecture;
use App\Models\Course\Order;

class LectureController extends Controller
{
    private $student;

    /**
     * LectureController constructor.
     */
    public function __construct()
    {
        $this->student = authUser();
    }

    public function index()
    {
        $lectures = Lecture::orderByLatest()->with('teacher')->get();

        return $this->frontView('lectures.index', compact('lectures'));
    }

    public function show($id)
    {
        $lecture = Lecture::find($id);

        return $this->frontView('wechat.lectures.show', compact('lecture'));
    }

    public function book($lectureId)
    {
        $lecture = Lecture::find($lectureId);

        try {
            $orderId = \DB::transaction(function() use ($lecture) {
                $student = authUser();

                /*
                 * create order
                 */
                $order = new Order();
                $order->student_id = $student->id;
                $order->teacher_id = $lecture->teacher->id;
                $order->lecture_id = $lecture->id;
                $order->is_lecture = 1; // @TODO 考虑删除
                $order->total = $lecture->price;
                $order->paid = 1; // @TODO 支付API对接完毕后删除此处
                $order->save();

                return $order->id;
            });
        } catch (\Exception $e) {
            $this->handleException($e);
            flash()->error('系统错误，请稍等片刻');
            return back();
        }

        // @TODO 增加支付成功后的Job
        //$this->dispatch(new HandleLecturesPurchased($orderId));
        flash()->success('课程添加成功');

        return $this->frontRedirect('m.students::orders.index');
    }
}
