@extends('back.template.template')

@section('main')
    <div class="rightbox" style="padding-bottom: 15px;">
        <div class="form-page">
            <div class="title">
                <h1 class="title">
                    {{ $data->title }}{{ $header }}
                </h1>
            </div>
            {{-- <div class="search">
                <a href="{{ $createLink }}" class="add-button" style="margin:5px;">
                    新增資料
                </a>
            </div> --}}
            <div class="edit-list">
                <table>
                    <thead>
                        <tr>
                            <th class="title ps-2" scope="col" colspan="2" width="140">關鍵字</th>
                            <th class="title w-100 " scope="col" colspan="6">&nbsp;</th>
                        </tr>
                    </thead>
                </table>
                <form action="/WebAdmin/meta/{{$data->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <table>
                        <tbody>
                            <tr>
                                <td>標題</td>
                                <td>{{$data->title}}</td>
                            </tr>
                            <tr>
                                <td>Page title</td>
                                <td>
                                    <input type="text" name="page_title" id="page_title" value="{{ $data->page_title }}">
                                </td>
                            </tr>

                            <tr>
                                <td>Keywords</td>
                                <td>
                                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{$data->meta_keywords}}">
                                </td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>
                                    <input type="text" name="meta_description" id="meta_description" value="{{$data->meta_description}}">
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>Page script</td>
                                <td>
                                    <input type="text" name="page_script" id="page_script" value="{{$data->page_script}}">
                                </td>
                            </tr> --}}
                            <tr class="last-tr">
                                <td></td>
                                <td><input class="sub2" type="submit" value="送出表單" onclick="showSuccessEditAlert()"></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
