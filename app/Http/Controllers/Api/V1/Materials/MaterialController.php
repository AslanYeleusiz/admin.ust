<?php

namespace App\Http\Controllers\Api\V1\Materials;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Services\V1\Material\MaterialCertificateGenerateService;
//use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\V1\Material\MaterialZharialauRequest;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialSubject;
use App\Models\MaterialDirection;
use App\Models\MaterialClass;
use App\Models\MaterialSolds;
use App\Models\Marapattau;
use App\Models\AlgisXat;
use App\Models\Kurmet;
use App\Models\Payment;
use App\Models\User;
use App\Helpers\Helper;
use App\Helpers\Date;
use Carbon\Carbon;

class MaterialController extends Controller
{
    public $service;
    public function __construct(MaterialCertificateGenerateService $service)
    {
        $this->service = $service;
    }

    public function materials(Request $request) {
        $title     = $request->title;
        $subject   = $request->subject;
        $direction = $request->direction;
        $class     = $request->class;
        $sell      = $request->sell;

        $materials = Material::select(['id', 'title', 'description', 'zhanr', 'zhanr2', 'zhanr3', 'raw', 'date', 'chec', 'sell', 'author', 'work', 'view', 'download', 'likes', 'zhinak'])
            ->when($title, fn($query) => $query->where('title', 'like', "%$title%"))
            ->where(
                function ($query) use ( $subject, $direction, $class, $sell) {
                    if ($subject && $subject != 'barlyk_pander') {
                        $subject = MaterialSubject::where('lat_name','=', $subject)->first();
                        if ($subject)
                            $query->where('zhanr', 'like', "%$subject->name%");
                    }
                    if ($direction && $direction != 'barlik_materialdar') {
                        $direction = MaterialDirection::where('lat_name', $direction)->first();
                        if ($direction)
                            $query->where('zhanr2', 'like', "%$direction->name%");
                    }
                    if ($class && $class != 'barlik_siniptar') {
                        $class = MaterialClass::where('lat_name', $class)->first();
                        if ($class)
                            $query->where('zhanr3', 'like', "%$class->name%");
                    }
                    if($sell) {
                        switch($sell){
                            case 1: {$query->where('sell',0); break;}
                            case 2: {$query->where('sell','>',0); break;}
                            case 3: {$query->where('zhinak',1); break;}
                        }
                    }
                }
            )
            ->notDeletes()
            ->latest('id')
            ->paginate(20)
            ->appends(request()->except('page'));

        foreach ($materials as $material) {
            $material->date = Date::dmYKZ($material->date);
            $material->lat_title = Helper::translate($material->title);
        }
        $count_materials = $materials->total();
        $COUNT = Material::count();

        $data = [
            'count_materials' => $count_materials,
            'COUNT'           => $COUNT,
            'materials'       => $materials
        ];

        return response($data);
    }

    public function show($slug,$id){
        $material = Material::with(['user', 'isPurchased'])->findOrFail($id);
        $material->increment('view');
        $material->lat_title = Helper::translate($material->title);
        $material->date = Date::dmYKZ($material->date);
        if(!empty($material->isPurchased)) $isPurchased = 1;
        else $isPurchased = 0;
        $authors_materials = Material::where('user_id', $material->user_id)->take(3)->get();
        $others = Material::when($material->zhanr, fn($query) => $query->where('zhanr', 'like', "%$material->zhanr%"))
            ->when($material->zhanr2, fn($query) => $query->where('zhanr2', 'like', "%$material->zhanr2%"))
            ->when($material->zhanr3, fn($query) => $query->where('zhanr3', 'like', "%$material->zhanr3%"))
        ->take(5)->get();
        foreach ($others as $other) {
            $other->date = Date::dmYKZ($other->date);
            $other->lat_title = Helper::translate($other->title);
        }
        foreach ($authors_materials as $author_material) {
            $author_material->date = Date::dmYKZ($author_material->date);
            $author_material->lat_title = Helper::translate($author_material->title);
        }
        return response()->json([
            'material' => $material,
            'authors_materials' => $authors_materials,
            'others' => $others,
            'isPurchased' => $isPurchased,
        ]);
    }

    public function download($id){
        $material = Material::findOrFail($id);
        $material->increment('download');
        return Storage::download('materials/'.$material->raw.'/files/'.$material->filename);
    }

    public function popular(){
        $materials = Material::select(['id', 'title', 'description', 'zhanr', 'zhanr2', 'zhanr3', 'date', 'chec', 'sell', 'author', 'work', 'view', 'download', 'likes', 'zhinak'])
            ->whereBetween('date',[Carbon::now()->subDays(7),Carbon::now()])
            ->notDeletes()
            ->orderBy('download', 'desc')
            ->orderBy('date','desc')
            ->limit(5)
            ->get();

        foreach ($materials as $material) {
            $material->date = Date::dmYKZ($material->date);
            $material->lat_title = Helper::translate($material->title);
        }

        return $materials;
    }

    public function store(Request $request)
    {
        if($request->file()){
            $uploadedFile = $request->file('file');
            $ext = $uploadedFile->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file_doc = 'materials/'.$ext.'/files/'.$filename;
            Storage::disk('public')->putFileAs(
                'materials/'.$ext.'/files/',
                $uploadedFile,
                $filename
            );
            return response()->json([
                'file_doc' => $file_doc,
                'raw' => $ext,
                'filename' => $filename
            ]);
        }else{
            $user = Auth::guard('api')->user();
            $this->validator($request->all())->validate();
            if($request->zhinak)
                if($user->balance < 3000)
                    throw ValidationException::withMessages([
                        'balance_none' => true,
                    ]);
            $user->balance = $user->balance - 3000;
            $user->save();
            Material::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'description' => $request->description,
                'zhanr' => $request->zhanr,
                'zhanr2' => $request->zhanr2,
                'zhanr3' => $request->zhanr3,
                'file_doc' => $request->file_doc,
                'raw' => $request->raw,
                'filename' => $request->filename,
                'date' => Carbon::now(),
                'date_edit' => Carbon::now(),
                'author' => $request->author,
                'work' => $request->work,
                'sell' => $request->sell,
                'zhetekshi' => $request->zhetekshi ?? '',
                'zhinak' => $request->zhinak,
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function destroyFile(Request $request)
    {
        $filename = $request->filename;
        $file_doc = $request->file_doc;
        $material = Material::where('filename',$filename)->first();
        if(empty($material)){
            Storage::disk('public')->delete($file_doc);
            return response()->json(['status'=>200]);
        }
        return response()->json(['status'=>404]);
    }

    public function getMaterialCategories(){
        $subjects   = MaterialSubject::all()->toArray();
        $directions = MaterialDirection::all()->toArray();
        $classes    = MaterialClass::all()->toArray();

        $data['subjects']   = $subjects;
        $data['directions'] = $directions;
        $data['classes']    = $classes;

        return $data;
    }

    public function user_materials($id) {
        $user = User::findOrFail($id);
        $materials = Material::where('user_id', $id)->paginate(20);
        foreach($materials as $material){
            $material->lat_title = Helper::translate($material->title);
            $material->date = Date::dmYKZ($material->date);
        }
        return response()->json([
            'materials' => $materials,
            'user' => $user
        ]);
    }

    public function purchase(Request $request, $id) {
        $user = auth()->guard('api')->user();
        $material = Material::findOrFail($id);
        if($user->balance >= $request->sell){
            $balance = $user->balance - $request->sell;
            $user->update([
                'balance' => $balance,
            ]);
            MaterialSolds::create([
                'user_id' => $user->id,
                'doc_id' => $material->id,
                'skidka' => 30,
                'sell' => $request->sell,
            ]);
            Payment::create([
                'user_id' => $user->id,
                'date' => time(),
                'sum' => $request->sell,
                'perevod_type' => 1,
                'type' => 'Материал сатып алынды',
                'kaldy' => $user->balance,
                'minus' => 1,
            ]);
            $material_user = User::findOrFail($material->user_id);
            $material_user->balance += $request->sell;
            $material_user->save();
            return response()->json([
                'purchase' => true,
            ]);
        }
        return response()->json([
            'purchase' => false,
        ]);
    }

    public function getCertificate($id) {
        $material = Material::with('marapat')->findOrFail($id);
        if($material->marapat){
            if(file_exists(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$material->marapat['puth'])){
                return response()->download(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$material->marapat['puth']);
            }
            else{
                $certificateName = $this->service->getSertificate($id, 1);
                Marapattau::find($material->marapat['id'])->update([
                    'puth' => $certificateName
                ]);
            }
        }
        else {
            $now = Carbon::now();
            $marapat = new Marapattau();
            $marapat->user_id = $material->user_id;
            $marapat->title_file = $material->title;
            $marapat->ser_id = $material->id;
            $marapat->ser_fio = $material->author;
            $marapat->info = $material->work;
            $marapat->date = $now;
            $marapat->oplata = 1;
            $marapat->certtype = 1;
            $certificateName = $this->service->getSertificate($id, 1);
            $marapat->puth = $certificateName;
            $marapat->save();
        }
        return response()->download(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$certificateName);
    }

    public function buyAlgys($id) {
        $user = auth()->guard('api')->user();
        $material = Material::with('algys')->findOrFail($id);
        if(!$material->algys){
            if($user->balance < 1500)
                throw ValidationException::withMessages([
                    'balance' => [__('errors.no_balance')]
                ]);

            $user->balance -= 1500;
            $user->save();
            $certificateName = $this->service->getAlgys($id, 1);
            $now = Carbon::now();
            $algis = new AlgisXat();
            $algis->puth = $certificateName;
            $algis->user_id = $material->user_id;
            $algis->title_file = $material->title;
            $algis->ser_id = $material->id;
            $algis->ser_fio = $material->author;
            $algis->info = $material->work;
            $algis->date = $now;
            $algis->oplata = 1;
            $algis->certtype = 0;
            $algis->success = 1;
            $algis->save();

            return response()->json([
                'ser_id' => $algis->id,
                'balance' => $user->balance,
            ]);
        }
        throw ValidationException::withMessages([
            'has_material' => [__('error.file.is_had')]
        ]);

    }



    public function getAlgys($id) {
        $material = Material::with('algys')->findOrFail($id);
        if(!$material->algys){
            throw ValidationException::withMessages([
                'error' => [__('errors.internal_server_error')]
            ]);
        }
        if(file_exists(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$material->algys['puth'])){
            return response()->download(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$material->algys['puth']);
        }
        else{
            $certificateName = $this->service->getAlgys($id, 1);
            AlgisXat::find($material->algys['id'])->update([
                'puth' => $certificateName
            ]);
            return response()->download(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$certificateName);
        }
    }

    public function buyKurmet($id) {
        $user = auth()->guard('api')->user();
        $material = Material::with('kurmet')->findOrFail($id);
        if(!$material->kurmet){
            if($user->balance < 2000)
                throw ValidationException::withMessages([
                    'balance' => [__('errors.no_balance')]
                ]);


            $certificateName = $this->service->getKurmet($id, 1);
            $now = Carbon::now();
            $kurmet = new Kurmet();
            $kurmet->puth = $certificateName;
            $kurmet->user_id = $material->user_id;
            $kurmet->title_file = $material->title;
            $kurmet->ser_id = $material->id;
            $kurmet->ser_fio = $material->author;
            $kurmet->info = $material->work;
            $kurmet->date = $now;
            $kurmet->certtype = 0;
            $kurmet->success = 1;
            $kurmet->kurmet = 0;
            $kurmet->save();
            $user->balance -= 2000;
            $user->save();

            return response()->json([
                'ser_id' => $kurmet->id,
                'balance' => $user->balance,
            ]);
        }
        throw ValidationException::withMessages([
            'has_material' => [__('error.file.is_had')]
        ]);
    }


    public function getKurmet($id) {
        $material = Material::with('kurmet')->findOrFail($id);
        if(!$material->kurmet){
            throw ValidationException::withMessages([
                'error' => [__('errors.internal_server_error')]
            ]);
        }
        if(file_exists(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$material->kurmet['puth'])){
            return response()->download(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$material->kurmet['puth']);
        }
        else{
            $certificateName = $this->service->getKurmet($id, 1);
            Kurmet::find($material->kurmet['id'])->update([
                'puth' => $certificateName
            ]);
            return response()->download(Storage::disk('public')->path(Material::CERTIFICATE_PATH)."/".$certificateName);
        }
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
            'file_doc' => ['required'],
            'work' => ['required', 'string'],
            'zhanr' => 'required',
            'zhanr2' => 'required',
            'zhanr3' => 'required'
        ], $messages);
    }




}
