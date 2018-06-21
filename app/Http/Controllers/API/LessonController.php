<?php

namespace C2Y\Http\Controllers\API;

use C2Y\Http\Controllers\API\APIController;
use C2Y\Http\Requests\StoreLessonRequest;
use C2Y\Http\Controllers\Controller;
use Illuminate\Http\Request;
use C2Y\Lesson;
use C2Y\LessonImage;
use C2Y\LessonFile;
use C2Y\LessonReference;
use C2Y\Owner;
use C2Y\Http\Controllers\ImageController;

class LessonController extends Controller
{
    private $results_per_page = 6;

    private function source ($model) {
        $str = str_ireplace('www.', '', $model->link);
        $str = explode('.', $str)[0];
        $str = str_ireplace('http://', '', $str);
        return ucfirst(str_ireplace('https://', '', $str));
    }

    /**
    * @api {get} /api/lesson All
    * @apiName allLessons
    * @apiDescription Request all lessons information
    * @apiGroup Lesson
    *
    * @apiSampleRequest http://localhost:8000/api/lesson

    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Object[]} data.lessons List of lessons.
    * @apiSuccess {Number} data.lessons.id ID of the created lesson.
    * @apiSuccess {String} data.lessons.name  Name of the Lesson.
    * @apiSuccess {String} data.lessons.description  Description of the Lesson.
    * @apiSuccess {String} data.lessons.created_at  Creation date of the Lesson.
    * @apiSuccess {String} data.lessons.updated_at  Update of the Lesson.
    */
    public function index(Request $request)
    {
        $params = $request->all();
        isset($params['page']) ? 0 : $params['page'] = 0;
        $all = Lesson::show($params, $this->results_per_page);
        foreach ($all as $k => $val)
            $all[$k]->source = $this->source($val);
        $ret = ['lessons' => $all, 'total' => count($all) ? $all[0]->count : 0, 'pages' => count($all) ? ceil($all[0]->count/$this->results_per_page): 0 ];

        return APIController::success($ret);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
    * @api {post} /api/lesson Create
    * @apiName createLesson
    * @apiDescription Create a lesson
    * @apiGroup Lesson
    *
    * @apiSampleRequest http://localhost:8000/api/lesson
    *
    * @apiParam {String} name  Name of the Lesson.
    * @apiParam {String} [description]  Optional description of the Lesson.
    * @apiParam {String} [link]  Optional link of the Lesson.
    * @apiParamExample {json} Request-Example:
    * {
    *   "name": "Brincando com cores"
    *   "description": "Nesta atividade você deve selecionar as cores exibidas durante o jogo para..."
    *   "link": "http://scratch.io/brincando-com-cores"
    * }
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Number} data.id ID of the created lesson.
    */
    public function store(StoreLessonRequest $request)
    {
        $info = $request->all();     
        
        //$info['photo'] = ImageController::upload($request->get('photo'));
        
        $base64 = substr($info['photo'],strpos($info['photo'], ",")+1);
        $type = substr($info['photo'],strpos($info['photo'], "/")+1,(strpos($info['photo'], ";") - strpos($info['photo'], "/"))-1);
        
        $info['photo'] = $base64;
        $info['photoType'] = $type;

        $info['age_min'] = $info['age_range'][0];
        $info['age_max'] = $info['age_range'][1];

        $lesson = Lesson::create($info);
        
        if(isset($info['references']))
        {
            foreach ($info['references'] as $ref)
            {
               $reff = new LessonReference();
               $reff->description = $ref['description'];
               $reff->link = $ref['link'];

               $lesson->lesson_references()->save($reff);
            }
        }

        if(isset($info['images']))
        {
            foreach ($info['images'] as $photo)
            {   
                $image = new LessonImage();                
                $image->name = $photo['name'];
                $image->type = $photo['type'];
                $image->file = $photo['strBlob'];                

                $lesson->lesson_images()->save($image);
            }
        }

        if(isset($info['files']))
        {
            foreach ($info['files'] as $arq)
            {   
                $file = new LessonFile();                
                $file->name = $arq['name'];
                $file->type = $arq['type'];
                $file->file = $arq['strBlob'];                

                $lesson->lesson_files()->save($file);
            }
        }

        if($info['owner'] == 'false')
        {
            foreach ($info['owners'] as $owner)
            {   
                if($owner['id'] == "-1" && $owner['name'] != "")
                {
                    $newOwner = new Owner();
                    $newOwner->name = $owner['name'];
                    $newOwner->email = $owner['email'];
                    $newOwner->save();

                    $lesson->owners()->attach($newOwner->id);                    
                }
                else
                {
                    $lesson->owners()->attach($owner['id']);   
                }
            }
        }
        
        if (isset($info['pc_components']))
        {
            foreach ($info['pc_components'] as $pc_component)
            {
               $lesson->pc_components()->attach($pc_component['id']);
            }
        }
        
        if (isset($info['bncc_components']))
        {
            foreach ($info['bncc_components'] as $bncc_component)
            {
               $lesson->bncc_components()->attach($bncc_component['id']);
            }
        }

        return APIController::success(['id' => $lesson->id ]);
    }

    /**
    * @api {get} /api/lesson/:id Retrieve
    * @apiName showLesson
    * @apiDescription Request lesson information for the given ID
    * @apiGroup Lesson
    *
    * @apiSampleRequest http://localhost:8000/api/lesson/2
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Object} data.lesson Finded lesson.
    * @apiSuccess {Number} data.lesson.id ID of the Lesson.
    * @apiSuccess {String} data.lesson.name  Name of the Lesson.
    * @apiSuccess {String} data.lesson.description  Description of the Lesson.
    * @apiSuccess {String} data.lesson.created_at  Creation date of the Lesson.
    * @apiSuccess {String} data.lesson.updated_at  Update of the Lesson.
    */
    public function show(Request $request, $id)
    {
        $lesson = Lesson::get($id, $request);

        if (!$lesson)
            return APIController::error('Lesson not found');
        $lesson->source = $this->source($lesson);

        return APIController::success(['lesson' => $lesson]);
    }

    public function complete(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        $lesson->completeds()->attach($request->user);
        return APIController::success(['success' => $lesson]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
    * @api {put} /api/lesson/:id Update
    * @apiName updateLesson
    * @apiDescription Update a lesson with ID equals :id
    * @apiGroup Lesson
    *
    * @apiSampleRequest http://localhost:8000/api/lesson/3
    *
    * @apiParam {String} name  Name of the Lesson.
    * @apiParam {String} [description]  Optional description of the Lesson.
    * @apiParam {String} [link]  Optional link of the Lesson.
    * @apiParamExample {json} Request-Example:
    * {
    *   "name": "Brincando com cores",
    *   "description": "Nesta atividade você deve selecionar as cores exibidas durante o jogo para...",
    *   "link": "http://scratch.io/brincando-com-cores"
    * }
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Number} data.id ID of the updated lesson.
    */
    public function update(Request $request, $id)
    {
        //novas informações
        $newLesson = $request->all();
        
        //informações do banco
        $lessonBD = Lesson::find($id);

        //tratamento da imagem perfil da atividade caso tenha sido alterada        
        if(strpos($newLesson['photo'], "data:") == 0)
        {
            $base64 = substr($newLesson['photo'],strpos($newLesson['photo'], ",")+1);
            $type = substr($newLesson['photo'],strpos($newLesson['photo'], "/")+1,(strpos($newLesson['photo'], ";") - strpos($newLesson['photo'], "/"))-1);
            
            $newLesson['photo'] = $base64;
            $newLesson['photoType'] = $type;
        }

        //preenchendo a versão do banco com a versão da tela        
        $lessonBD->fill($newLesson);
        
        //ajustando a idade
        $lessonBD->age_min = $newLesson['age_range'][0];
        $lessonBD->age_max = $newLesson['age_range'][1];

        //salvando os dados basicos
        $lessonBD->save();

        //tratativa para PC
        $pcs = array();
        if(count($newLesson['pc_components']) > 0)
        { 
            foreach ($newLesson['pc_components'] as $pc) 
            {
                $pcs[] = $pc['id'];
            }
        }        
        $lessonBD->pc_components()->sync($pcs);
        
        //tratativa para BNCC
        $bnccs = array();
        if(count($newLesson['bncc_components']) > 0)
        { 
            foreach ($newLesson['bncc_components'] as $bncc) 
            {
                $bnccs[] = $bncc['id'];
            }
        } 
        $lessonBD->bncc_components()->sync($bnccs);
        
        //tratativa para autores        
        //associa os ja existentes e cria os novos
        if($lessonBD->owner == "true")
        {
            if(count($lessonBD->owners) > 0)
            {
                $lessonBD->owners()->sync([]);
            }
        }      
        else if( count($newLesson['owners']) > 0)
        {            
            $addOwn = array();
            $createOwn = array(); 

            foreach ($newLesson['owners'] as $owner) 
            {              
                if(!$lessonBD->owners->find($owner['id']))
                {
                    if($owner['id'] != "-1")
                    {
                        $addOwn[] = $owner['id'];
                    }
                    else
                    {
                        $createOwn[] = $owner;
                    }
                }
                else
                {
                    $addOwn[] = $owner['id'];
                }
            }

            foreach ($createOwn as $owner)
            {   
                if($owner['id'] == "-1" && $owner['name'] != "")
                {
                    $newOwner = new Owner();
                    $newOwner->name = $owner['name'];
                    $newOwner->email = $owner['email'];
                    $newOwner->save();

                    $addOwn[] = $newOwner->id;                    
                }
            }

            $lessonBD->owners()->sync($addOwn);
        }

        //tratativa para referencias
        $refExist = array();
        foreach ($newLesson['references'] as $ref)
        {
            if(!array_key_exists("created_at", $ref))
            {
                if($ref['description'] != "")
                {
                    $reff = new LessonReference();
                    $reff->description = $ref['description'];
                    $reff->link = $ref['link'];

                    $lessonBD->lesson_references()->save($reff);

                    $refExist[] = $reff->id;
                }
            }
            else
            {
                $refExist[] = $ref['id'];
            }
        }
        LessonReference::where('lesson_id',$lessonBD->id)->whereNotIn('id',$refExist)->delete();

        //tratativa para imagens        
        //insere as novas imagens e depois apaga tudo que não estava na tela
        $imgExist = array();
        foreach ($newLesson['images'] as $photo)
        {
            if(!array_key_exists("created_at", $photo))
            {
                $image = new LessonImage();                
                $image->name = $photo['name'];
                $image->type = $photo['type'];
                $image->file = $photo['strBlob'];

                $lessonBD->lesson_images()->save($image);

                $imgExist[] = $image->id;
            }
            else
            {
                $imgExist[] = $photo['id'];
            }
        }
        LessonImage::where('lesson_id',$lessonBD->id)->whereNotIn('id',$imgExist)->delete();

        //tratativa para arquivos        
        //insere as novos arquivos e depois apaga tudo que não estava na tela
        $fileExist = array();
        foreach ($newLesson['files'] as $arq)
        {
            if(!array_key_exists("created_at", $arq))
            {
                $file = new LessonFile();                
                $file->name = $arq['name'];
                $file->type = $arq['type'];
                $file->file = $arq['strBlob'];                

                $lessonBD->lesson_files()->save($file);

                $fileExist[] = $file->id;
            }
            else
            {
                $fileExist[] = $arq['id'];
            }
        }
        LessonFile::where('lesson_id',$lessonBD->id)->whereNotIn('id',$fileExist)->delete();

        try 
        {
            return APIController::success(['id' => $id]);
        }
        catch (Exception $e) 
        {
            return APIController::error($e->getMessage());
        }
    }

    /**
    * @api {delete} /api/lesson/:id Delete
    * @apiName deleteLesson
    * @apiDescription Delete a lesson with ID equals :id
    * @apiGroup Lesson
    *
    * @apiSampleRequest http://localhost:8000/api/lesson/3
    *
    * @apiSuccess {Object} data List of data.
    * @apiSuccess {Number} data.id ID of the updated lesson.
    */
    public function destroy($id)
    {
        try {
            Lesson::destroy($id);
            return APIController::success(['id' => $id]);
        } catch (Exception $e) {
            return APIController::error($e->getMessage());
        }
    }
}