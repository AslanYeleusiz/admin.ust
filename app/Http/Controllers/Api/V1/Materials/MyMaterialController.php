<?php

namespace App\Http\Controllers\Api\V1\Materials;

use App\Helpers\Helper;
use App\Helpers\Date;
use App\Http\Controllers\Controller;
use App\Models\Balance;
//use App\Models\Competition\CompetitionOrder;
use App\Models\Material;
use App\Models\MaterialCertificateHonor;
use App\Models\MaterialCertificateThankLetter;
use App\Services\V1\MaterialCertificateGenerateService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;

class MyMaterialController extends Controller
{
    public function myMaterials(Request $request): \Illuminate\Http\JsonResponse
    {
        $type   =   $request->type;
        $user   =   Auth::guard('api')->user();
        $materials = Material::where('user_id', $user->id)
            ->where(
                function($query) use ($type) {
                    if($type == 2) $query->where('zhinak', 1);
                }
            )
            ->notDeletes()
            ->with(['algys', 'kurmet'])
            ->orderBy('date_edit','desc')
            ->paginate(10);


        foreach ($materials as $material) {
            $material->date = Date::dmYKZ($material->date);
            $material->lat_title = Helper::translate($material->title);
        }


        $data = [
            'count_materials' => $materials->total(),
            'COUNT'           => Material::count(),
            'materials'       => $materials,
        ];
        return $this->sendResponse($data);
    }

    public function getCertificate($id)
    {
        $material = Material::with('user')->findOrFail($id);

        $certificateName = MaterialCertificateGenerateService::getCertificate($material);
        return response()->download(Storage::disk('public')->path(Material::CERTIFICATE_PATH . '/'. $certificateName));
    }

    public function show($slug, $id): \Illuminate\Http\JsonResponse
    {
        $material = Material::select(['id', 'title', 'description', 'filename', 'zhanr', 'zhanr2', 'zhanr3', 'author', 'work', 'zhetekshi', 'sell'])->findOrFail($id);
        $material->lat_title = Helper::translate($material->title);
        return response()->json($material);
    }

    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validator($request->all())->validate();
            Material::where('user_id',auth()->user()->id)->findOrFail($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'zhanr' => $request->zhanr,
                'zhanr2' => $request->zhanr2,
                'zhanr3' => $request->zhanr3,
                'date_edit' => Carbon::now(),
                'author' => $request->author,
                'work' => $request->work,
                'sell' => $request->sell,
                'zhetekshi' => $request->zhetekshi ?? '',
            ]);
        return response()->json(['status'=>200]);
    }

    public function delete($id, Request $request): \Illuminate\Http\JsonResponse
    {
        Material::with('user')->findOrFail($id)->update([
            'deleteorder' => 1,
            'deleteordertext' => $request->deleteordertext,
        ]);
        return response()->json(['status'=>200]);

    }

    public function updateLeading($materialId, Request $request, MessageBag $messageBag): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'leading' => 'required|string|min:5|max:255'
        ]);

        $leading = $request->input('leading');
        $material = Material::find($materialId);

        if (!empty($material)) {
            $material->update(['leading' => $leading]);
            return $this->sendResponse(true);
        }
        $messageBag->add('msg','Материал табылмады!');
        return $this->sendError($messageBag);
    }

    public function payForCertificate($id, Request $request, MessageBag $messageBag): \Illuminate\Http\JsonResponse
    {
        $certificate = $request->input('certificate');
        $type        = $request->input('type');
        $userId      = Auth::guard('api')->user()->id;

        $user        = User::find($userId);

        if($type == 1){
            $paidCertificate = MaterialCertificateThankLetter::where('material_id', $certificate['material_id'])
                ->where('user_id', $userId)
                ->first();
            $price = 500;
            $user->certificate_thank_letters = $user->certificate_thank_letters++;
            $user->update(['certificate_thank_letters' => $user->certificate_thank_letters++]);
        } else {
            $paidCertificate = MaterialCertificateHonor::where('material_id', $certificate['material_id'])->first();
            $price = 1000;
            $user->update(['certificate_honors' => $user->certificate_honors++]);
        }
        $balance = Balance::where('user_id', $userId)->first();
        if($balance){
            if($balance->sum >= $price){
                $balance->sum = $balance->sum - $price;
                if($balance->save()){
                    if($type == 1){
                        $cntCertificateThankLetters = $user->certificate_thank_letters;
                        if($cntCertificateThankLetters >= 10 && $cntCertificateThankLetters % 10 == 0){
                            $balance = Balance::where('user_id',$user->id)->first();
                            $balance->sum = $balance->sum + 1000;
                            $balance->save();
                        }
                    }else{
                        $cntCertificateHonors = $user->certificate_honors;
                        if($cntCertificateHonors >= 10 && $cntCertificateHonors % 10 == 0){
                            $balance = Balance::where('user_id', $user->id)->first();
                            $balance->sum = $balance->sum + 2000;
                            $balance->save();
                        }
                    }
                    $paidCertificate->success = '1';
                    if($paidCertificate->save()){
                        return $this->sendResponse(true);
                    }

                    $messageBag->add('msg','Сіздің төлеміңіз сәттіз аяқталды. Кейінірек қайталап көріңіз!');
                    return $this->sendError($messageBag);
                }
                $messageBag->add('msg','Сіздің төлеміңіз сәттіз аяқталды. Кейінірек қайталап көріңіз!');
                return $this->sendError($messageBag);
            }
            $messageBag->add('msg','Шотыңыздағы қаражат жеткіліксіз.!');
            return $this->sendError($messageBag);
        }
        $messageBag->add('msg','Шотыңыздағы табылмады. Редакциямен байланыып көріңіз.');
        return $this->sendError($messageBag);
    }


    protected function validator(array $data)
    {
        $messages = array(
            'required' => 'Бұл жол толтырылуы керек.',
            'string' => 'Бұл жол тармақ болуы керек.',
            'max' => 'Бұл жол шектік :max таңбадан асып кетті.'
        );
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'work' => ['required', 'string'],
        ], $messages);
    }
}
