<?php
 
namespace App\Core\Services;


use App\Core\Interfaces\PersonnelInterface;
use App\Core\BaseClasses\BaseService;
use File;


class PersonnelService extends BaseService{



    protected $personnel_repo;



    public function __construct(PersonnelInterface $personnel_repo){

        $this->personnel_repo = $personnel_repo;
        parent::__construct();

    }



    public function fetch($request){

        $personnels = $this->personnel_repo->fetch($request);
        $request->flash();
        return view('dashboard.personnel.index')->with('personnels', $personnels);

    }



    public function store($request){

        $img_location = "";

        if(!is_null($request->file('avatar'))){
            $filename = $this->__dataType::fileFilterReservedChar($request->lastname .'-'. $this->str->random(8), '.jpg');
            $request->file('avatar')->storeAs('PERSONNELS', $filename);
            $img_location = 'PERSONNELS/'. $filename;
        }

        $personnel = $this->personnel_repo->store($request, $img_location);

        $this->event->fire('personnel.store');
        return redirect()->back();

    }



    public function edit($slug){

        $personnel = $this->personnel_repo->findbySlug($slug);
        return view('dashboard.personnel.edit')->with('personnel', $personnel);

    }



    public function update($request, $slug){

        $personnel = $this->personnel_repo->findbySlug($slug);
        
        $new_filename = $this->__dataType::fileFilterReservedChar($request->lastname .'-'. $this->str->random(8), '.jpg');
        $old_file_location = $personnel->avatar_location;
        $new_file_location = 'PERSONNELS/'. $new_filename;

        $img_location = $old_file_location;

        // if doc_file has value
        if(!is_null($request->file('avatar'))){

            if ($this->storage->disk('local')->exists($old_file_location)) {
                $this->storage->disk('local')->delete($old_file_location);
            }
            
            $request->file('avatar')->storeAs('PERSONNELS', $new_filename);
            $img_location = $new_file_location;

        // if lastname has change
        }elseif($request->lastname != $personnel->lastname && $this->storage->disk('local')->exists($old_file_location)){
            $this->storage->disk('local')->move($old_file_location, $new_file_location);
            $img_location = $new_file_location;
        }

        $personnel = $this->personnel_repo->update($request, $slug, $img_location);
        $this->event->fire('personnel.update', $personnel);
        return redirect()->route('dashboard.personnel.index');

    }



    public function destroy($slug){

        $personnel = $this->personnel_repo->findbySlug($slug);

        if(!is_null($personnel->avatar_location)){
            if ($this->storage->disk('local')->exists($personnel->avatar_location)) {
                $this->storage->disk('local')->delete($personnel->avatar_location);
            }
        }

        $personnel = $this->personnel_repo->destroy($slug);
        $this->event->fire('personnel.destroy', $personnel);
        return redirect()->back();

    }




    public function viewAvatar($slug){

        $personnel = $this->personnel_repo->findBySlug($slug);

        if(!empty($personnel->avatar_location)){

            $path = $this->__static->archive_dir() .'/'. $personnel->avatar_location;

            if (!File::exists($path)) { return "Cannot Detect File!"; }

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = response()->make($file, 200);
            $response->header("Content-Type", $type);

            return $response;

        }

        return "Cannot Detect File!";;
        

    }






}