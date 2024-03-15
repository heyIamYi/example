<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FileUploadValidationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->file()) {
            $allowedTypes = ['jpg', 'jpeg', 'gif', 'bmp', 'png', 'svg', 'webp', 'avif', 'pdf', 'ppt', 'pptx', 'pps', 'doc', 'docx', 'zip', 'rar', 'txt', 'xls', 'xlsx', 'odt', 'ods', 'log',
            ];
            // 檔案類型
            $allowedMimeType = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'application/pdf',
                'text/plain',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'svg' => 'image/svg+xml',
            ];
            foreach ($request->file() as $file) {

                // 如果$file是陣列，代表是多檔上傳
                if (is_array($file)) {
                    foreach ($file as $f) {
                        if (!in_array($f->getClientOriginalExtension(), $allowedTypes)) {
                            Log::info('上傳不允許的檔案資訊', [
                                'time' => Carbon::now(),
                                'ip' => $request->ip(),
                                'url' => $request->fullUrl(),
                                'fileName' => $f->getClientOriginalName(),
                                'mime' => $f->getMimeType(),
                            ]);
                            return redirect()->back()->with('message', '不允許上傳這種文件類型');
                        }

                        if (!in_array($f->getMimeType(), $allowedMimeType)) {

                            Log::info('上傳不允許的檔案資訊', [
                                'time' => Carbon::now(),
                                'ip' => $request->ip(),
                                'url' => $request->fullUrl(),
                                'fileName' => $f->getClientOriginalName(),
                                'mime' => $f->getMimeType(),
                            ]);
                            return redirect()->back()->with('message', '不允許上傳這種文件類型');
                        }
                    }
                }

                if (!is_array($file) && !in_array($file->getClientOriginalExtension(), $allowedTypes)) {
                    Log::info('上傳不允許的檔案資訊', [
                        'time' => Carbon::now(),
                        'ip' => $request->ip(),
                        'url' => $request->fullUrl(),
                        'fileName' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType(),
                    ]);
                    return redirect()->back()->with('message', '不允許上傳這種文件類型');
                }

                if (!is_array($file) && !in_array($file->getMimeType(), $allowedMimeType)) {

                    Log::info('上傳不允許的檔案資訊', [
                        'time' => Carbon::now(),
                        'ip' => $request->ip(),
                        'url' => $request->fullUrl(),
                        'fileName' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType(),
                    ]);
                    return redirect()->back()->with('message', '不允許上傳這種文件類型');
                }
            }
        }
        return $next($request);

    }
}
