<?php

namespace App\Http\Controllers\Api\V1\Qmg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qmg;
use App\Models\QmgBolim;
use App\Models\QmgSubjects;
use App\Models\QmgOrders;
use App\Models\QmgBolimOrders;
use App\Helpers\Helper;
use App\Services\V1\Qmg\QmgService;
use App\Http\Resources\V1\MessageResource;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\FailMessageResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QmgController extends Controller
{
    public $qmgService;
    public function __construct(QmgService $qmgService)
    {
        $this->qmgService = $qmgService;
    }

    public function index(Request $request){
        $category = $request->category;

        $bolimder = QmgBolim::IsEnabled()
            ->where(function($query) use ($category) {
                if(!empty($category)){
                    return $query->where('sub_id', $category);
                }
            })
            ->paginate(20)
            ->appends(request()->except('page'));
        $subjects = QmgSubjects::get();


        foreach($bolimder as $bolim)
            $bolim -> lat_title = Helper::translate($bolim->title);

        return CustomerResource::collection([
            'bolimder' => $bolimder,
            'subjects' => $subjects
        ])->additional(['status'=>true]);
    }

    public function show($slug, $id){
        $user = Auth::guard('api')->user();
        $bolim = QmgBolim::findOrFail($id);
        $qmg = Qmg::where('bolim_id', $id)->IsEnabled()->orderBy('synyp')->get();
        $qmgOrder = QmgOrders::where('user_id', $user->id)->where('bolim_id', $id)->get();
        foreach($qmg as $q){
            $q->synyp_text = $this->getClass($q->synyp);
        }
        return CustomerResource::collection([
            'bolim' => $bolim,
            'qmg' => $qmg,
            'qmgOrder' => $qmgOrder
        ])->additional(['status'=>true]);
    }

    public function buy(Request $request){
        $price = $request->price;
        $qmgs = $request->qmgs;
        $bolim_id = $request->bolim_id;
        $bolim_name = $request->bolimname;
        $user = Auth::guard('api')->user();
        $now = Carbon::now();
        if(!empty($qmgs)) {
            if($user->balance >= $price) {
                $bolimOrder = QmgBolimOrders::where('user_id', $user->id)
                    ->where('bolim_id', $bolim_id)
                    ->first();
                if(empty($bolimOrder)){
                    $bolimOrder = QmgBolimOrders::create([
                        'bolim_id' => $bolim_id,
                        'order_id' => time(),
                        'user_id' => $user->id,
                        'bolimname' => $bolim_name,
                        'price' => $price,
                        'success' => 1
                    ]);
                }else{
                    $bolimOrder->update([
                        'price' => ($bolimOrder->price + $price),
                    ]);
                }
                foreach($qmgs as $qmg_id){
                    $qmg = Qmg::findOrFail($qmg_id);
                    $qmgOrder = new QmgOrders();
                    $this->qmgService->save($qmgOrder, $qmg, $bolimOrder);
                }
                $balance = $user->balance - $price;
                $user->update(['balance' => $balance]);

                return CustomerResource::collection(['bolimOrder' => $bolimOrder])->additional(['status' => true, 'balance' => $balance]);
            }
            return new FailMessageResource(__('validation.qmg.not_balance'));
        }
        return new FailMessageResource(__('validation.qmg.not_found'));
    }

    public function my_qmg(Request $request) {
        $user = Auth::guard('api')->user();
        $orders = QmgBolimOrders::where('user_id', $user->id)->with('bolim')->paginate(15);
        foreach($orders as $bolim)
            $bolim['bolim'] -> lat_title = Helper::translate($bolim['bolim']->title);
        return CustomerResource::collection(['qmgs' => $orders])->additional(['status'=>true]);
    }



    protected function getClass($class) {
        switch($class) {
            case 1: return '1-сынып';
            case 2: return '2-сынып';
            case 3: return '3-сынып';
            case 4: return '4-сынып';
            case 5: return '5-сынып';
            case 6: return '6-сынып';
            case 7: return '7-сынып';
            case 8: return '8-сынып';
            case 9: return '9-сынып';
            case 10: return '10-сынып';
            case 11: return '11-сынып';
            case 12: return '';
            case 13: return '10-сынып ҚГБ';
            case 14: return '11-сынып ҚГБ';
            case 15: return '10-сынып ЖМБ';
            case 16: return '11-сынып ЖМБ';
        }
    }


}
