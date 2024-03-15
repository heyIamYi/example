<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\System\BackStageController;
use App\Repositories\ContactRepository as Repository;
use Illuminate\Http\Request;

class AdminContactController extends BackStageController
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

        // 搜尋條件
        $criteria = [
            'keyword' => $request->input('keyword', ''),
            'is_show' => $request->input('is_show', ''),
            'is_status' => $request->input('is_status', ''),
        ];

        // 取得列表資料
        $datas = $this->repo->getData($criteria);

        // 將資料存入回傳變數
        $viewData = array_merge($viewData, compact('datas'));

        return view('back.list.contact', $viewData);
    }

    public function form(Request $request, $id = null)
    {
        // 預設取得header, store
        $viewData = $this->initializeViewData($request, $id);

        // 取得相關資料
        $data = $this->repo->find($id);

        // 將資料存入回傳變數
        $viewData = array_merge($viewData, compact('data'));

        return view('back.form.contact', $viewData);
    }

    public function store(Request $request, $id = null)
    {
        $data = $this->repo->find($id);
        $data->update($request->all());
        return redirect()->route('list.contact');
    }

    public function destroy(Request $request, $id = null)
    {
        $data = $this->repo->find($id);
        $data->delete();
        return redirect()->route('list.contact');
    }

}
