<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\System\BackStageController;
use App\Repositories\ContactMailRepository as Repository;
use Illuminate\Http\Request;

class AdminContactMailController extends BackStageController
{
    protected $repo;

    public function __construct(Repository $repo)
    {
        parent::__construct();
        $this->repo = $repo;
    }

    public function list(Request $request)
    {
        // 預設取得header, store, delete
        $viewData = $this->initializeViewData($request);

        // 取得列表資料
        $datas = $this->repo->orderBy('sort','asc')->get();

        // 將資料存入回傳變數
        $viewData = array_merge($viewData, compact('datas'));

        return view('back.list.contact_mail', $viewData);
    }

    public function form(Request $request, $id = null)
    {
       // 預設取得header, store
       $viewData = $this->initializeViewData($request, $id);


        // 取得相關資料
        $data = $this->repo->find($id);

        // 將資料存入回傳變數
        $viewData = array_merge($viewData, compact('data'));

        return view('back.form.contact_mail', $viewData);
    }

    public function store(Request $request, $id = null)
    {
        $input = $request->all();
        if ($id) {
            $data = $this->repo->find($id);
            $data->update($input);
        } else {
            $this->repo->create($input);
        }

        return redirect()->back()->with([
            'success' => true,
            'message' => $id ? '修改成功！' : '新增成功！',
            'path' => $this->getPath($request, 3),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $this->repo->delete($id);
        return response(['status' => 200, 'success' => true, 'msg' => '刪除成功']);
    }
}
